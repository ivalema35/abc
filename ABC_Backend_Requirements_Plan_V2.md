# Project "ABC" — Backend Requirements & Development Plan
# **Final Version 2.0**

> **Prepared by:** AI Senior Laravel Architect & Technical Product Manager  
> **Source:** Original PRD v1.0 + Full Blade UI Architecture Analysis (reverse-engineered from all 40+ Blade views)  
> **Last Updated:** April 2026  
> **Status:** AUTHORITATIVE — supersedes all previous versions

---

## ⚠️ V2.0 Change Summary (What Changed from V1.0)

| Area | V1.0 (Wrong) | V2.0 (Correct) |
|---|---|---|
| Form submission | Mixed — some assumed full-page POST | **100% AJAX** across every form |
| `name` attributes | Assumed present | **Missing from all add-forms** — must be added by backend dev |
| Image upload | Each module handles its own | **Single shared `UploadController`** |
| Dog lifecycle tables | Separate `dog_received`, `dog_process`, etc. as primary tables | **Single `caught_dogs` central table** + audit log pivots |
| Vehicles table | `number_plate`, no login fields | `vehicle_number`, `login_id`, `login_password` |
| Hospital table | `catching_net_qty` mismatch | `net_quantity` (UI-confirmed column name) |
| ARV Staff | No web login fields | `has_web_login`, `web_email`, `web_password` |
| Medicare | Treated as an `arv_records` flag only | **Standalone `medicare` CRUD table** |
| Bills table | Missing entirely | **Full `bills` table** with all financial columns |
| Settings table | Two-row pattern with `type` column | **Single-row upsert** with `bd_*` and `sms_*` prefixed columns |
| Pipeline list-views | Implied different controllers querying different tables | **All are filtered `GET` views of `caught_dogs.status`** |

---

## 1. Project Overview & Scope

**"ABC" (Animal Birth Control)** is an end-to-end stray-dog welfare management platform built for NGOs, municipalities, and animal hospitals — operated under the banner of **"Goal Foundation"**.

The system manages the complete lifecycle of a stray dog from the moment it is caught on the street through sterilisation/vaccination at a hospital, all the way to release back into its territory (R4R) or to an owner — with full audit trails at every stage.

### 1.1 Core Functional Domains

| Domain | What it manages |
|---|---|
| **Infrastructure Setup** | Cities, NGOs, Hospitals, Doctors, Vehicles |
| **Project Management** | Projects that bind City + NGO + Hospital + Vehicle into an operational unit |
| **Staff Management** | ARV Field Staff, Catching Staff, Doctors |
| **Dog Lifecycle Pipeline** | Caught → Received → In-Process → Observation → R4R → Complete / Expired / Rejected |
| **Medical & Billing** | ARV (Anti-Rabies Vaccination), Medicare (standalone), Medicine Inventory, Bill Master, Bills |
| **Reporting** | Daily Running Sheet, Project Summary, Completed Operations, Today's Catch List |
| **Access Control** | Roles (Admin / Manager / Viewer), Granular Permissions per module (Spatie) |
| **System Settings** | Org Basic Details + SMS Gateway Configuration |

### 1.2 Key Business Rules

1. A **Project** is the central operational unit — it links one City, one NGO, one Hospital, and one or more Vehicles. A project has login credentials (Contact number + 4-digit PIN) to allow client-side access.
2. Each project exposes configurable **client permissions** — catching / receive / process / observation / R4R / complete / reject details can each be shown or hidden, and can be displayed as a count or a full list.
3. A dog's **tag number** is unique and is the primary tracking identifier throughout its entire lifecycle.
4. A dog enters the system at **Catch** stage. Hospital staff **Receives** it, moves it to **In-Process** (pre-operation), then **Observation** (post-op monitoring), then **R4R** (Ready for Release). From R4R it can be **Released**, returned to **Owner**, marked **Expired** (died), or **Rejected**.
5. **ARV** (Anti-Rabies Vaccination) is a parallel, independent track for dogs that need vaccination without surgery. **Medicare** is a separate administrative category managed in its own CRUD table.
6. **RFID** tags are used; each hospital is assigned a numeric tag-number range (`tag_number_start` → `tag_number_end`).
7. The system supports an SMS gateway for event-based notifications.
8. **All pipeline list-views** (Received, Process, Observation, R4R, Completed, Rejected, Expired) are simply filtered `GET` reads of the single `caught_dogs` table by the `status` column. There is no fragmented pipeline data.

---

## 2. Environment & Stack

| Item | Version / Package |
|---|---|
| **PHP** | ^8.1 |
| **Laravel Framework** | ^10.10 |
| **Laravel Sanctum** | ^3.3 |
| **Laravel Tinker** | ^2.8 |
| **GuzzleHTTP** | ^7.2 |
| **Frontend Theme** | Sneat Bootstrap 5 Admin PRO (`admin-assets/`) |
| **JS Libraries** | jQuery, DataTables (BS5), ApexCharts, Flatpickr, Dropzone.js, Perfect Scrollbar |
| **Icon Sets** | Boxicons, Font Awesome 6, Flag Icons |
| **Build Tool** | Vite |
| **Test DB (local)** | Laragon / MySQL |

### Packages to Add

```bash
composer require spatie/laravel-permission       # Role & Permission management
composer require intervention/image              # Image resizing on upload
composer require maatwebsite/excel               # Excel exports
composer require barryvdh/laravel-dompdf         # PDF reports
composer require laravel/fortify                 # Auth scaffolding
```

> **Rule:** Do NOT alter the existing Blade frontend HTML, CSS, or JS. All new backend logic must wire into the existing `.blade.php` views without renaming any HTML `id`, CSS class, modal ID, or DataTable ID.

---

## 3. Global Architectural Rules *(New in V2.0)*

These rules apply to **every module** without exception.

### 3.1 — 100% AJAX Forms (No Full-Page Reloads)

Every form submission (create, update, delete, filter) must return a JSON response. There are no full-page redirects for data mutations.

**Standard JSON response contract — all endpoints must follow this:**
```json
// Success
{ "success": true, "message": "City added successfully.", "data": { ... } }

// Validation failure → HTTP 422
{ "success": false, "message": "Validation failed.", "errors": { "field": ["error text"] } }

// Server error → HTTP 500
{ "success": false, "message": "An unexpected error occurred." }
```

The existing JavaScript reads `response.success` to show/hide modals and refresh DataTables. **This contract must never change.**

### 3.2 — Fix Missing `name` Attributes on Blade Inputs

The frontend developer omitted `name` attributes from every input in all "add" pages (hospital, NGO, vehicle, doctor, ARV staff, catching staff, project, ARV dog). Without `name`, `request()->all()` will return an empty array.

**Rule for backend developer:** When wiring any Blade form, add a matching `name` attribute to every `<input>`, `<select>`, and `<textarea>`. Match the `name` exactly to the column name in the migration.

Example fix:
```html
<!-- Before (frontend as-is) -->
<input type="text" id="cityTitle" class="form-control" placeholder="Enter city title" required />

<!-- After (backend developer adds name) -->
<input type="text" id="cityTitle" name="city_name" class="form-control" placeholder="Enter city title" required />
```

The `id` attribute must **never** be changed — it is used by the existing modal JavaScript.

### 3.3 — Global Dropzone Image Upload (Shared Endpoint)

All image-carrying forms across the entire application use Dropzone.js. Dropzone uploads the file independently to a single shared endpoint and injects the returned path into a hidden input field (e.g., `#cityImage`, `#hospitalImage`, `#staffImage`).

**Single shared upload route:**
```
POST /upload/image  →  UploadController@storeImage
```

**Response:**
```json
{ "success": true, "path": "uploads/cities/1680000000_image.jpg" }
```

**Controller:**
```php
// app/Http/Controllers/Admin/UploadController.php
public function storeImage(Request $request): JsonResponse
{
    $request->validate(['file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096']);
    $folder = $request->input('folder', 'general'); // e.g. 'cities', 'dogs', 'staff'
    $path = $request->file('file')->store("uploads/{$folder}", 'public');
    return response()->json(['success' => true, 'path' => $path]);
}
```

Dropzone sends the folder context as a hidden form field. The hidden input (e.g., `#cityImage`) receives the `path` on success. The main form then submits this path string as a regular text field.

**Storage directories:**
```
storage/app/public/
├── uploads/
│   ├── cities/
│   ├── hospitals/
│   ├── ngos/
│   ├── vehicles/
│   ├── doctors/
│   ├── arv_staff/
│   ├── catching_staff/
│   ├── dogs/
│   ├── arv/
│   └── settings/
```

Run `php artisan storage:link` once to symlink `public/storage`.

---

## 4. Database Schema & Relationships

### 4.1 Access Control Tables

#### `roles`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | auto-increment |
| name | varchar(100) | unique — `Admin`, `Manager`, `Viewer` |
| status | enum('active','inactive') | default `active` |
| created_at / updated_at | timestamp | |

#### `permissions`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| name | varchar(100) | unique slug, e.g. `project.add` |
| module | varchar(100) | grouping, e.g. `project`, `user`, `report` |
| created_at / updated_at | timestamp | |

#### `role_has_permissions` *(Spatie standard pivot)*
| Column | Type |
|---|---|
| permission_id | bigint UNSIGNED FK |
| role_id | bigint UNSIGNED FK |

#### `users`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| name | varchar(255) | NOT NULL |
| email | varchar(255) | unique, NOT NULL |
| password | varchar(255) | hashed |
| is_active | tinyint(1) | default 1 |
| remember_token | varchar(100) | nullable |
| created_at / updated_at | timestamp | |

> Spatie manages role assignment via `model_has_roles` and `model_has_permissions` pivot tables — do not create these manually.

---

### 4.2 System Table

#### `settings` *(Single-row upsert — always `id = 1`)*
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | always 1 |
| bd_title | varchar(255) | nullable — org title |
| bd_logo | varchar(500) | nullable — file path |
| bd_email | varchar(255) | nullable |
| bd_contact | varchar(20) | nullable |
| bd_address | text | nullable |
| bd_location | varchar(255) | nullable |
| bd_support_mail | varchar(255) | nullable |
| sms_meta | varchar(255) | nullable — SMS sender ID |
| sms_logo | varchar(500) | nullable |
| sms_email | varchar(255) | nullable |
| sms_contact | varchar(20) | nullable |
| sms_address | text | nullable |
| sms_location | varchar(255) | nullable |
| updated_at | timestamp | |

> No `created_at`. Seeder creates the single row on `php artisan db:seed`. All settings updates are `updateOrCreate(['id' => 1], [...])`.

---

### 4.3 Master Data Tables

#### `cities`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| city_name | varchar(255) | NOT NULL |
| image | varchar(500) | **nullable** — Dropzone upload path |
| created_at / updated_at | timestamp | |

#### `ngos`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| city_id | bigint UNSIGNED FK → cities | NOT NULL |
| name | varchar(255) | NOT NULL |
| contact | varchar(20) | NOT NULL |
| email | varchar(255) | nullable |
| address | text | nullable |
| image | varchar(500) | **nullable** — Dropzone upload path |
| created_at / updated_at | timestamp | |

#### `hospitals`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| city_id | bigint UNSIGNED FK → cities | NOT NULL |
| name | varchar(255) | NOT NULL |
| contact | varchar(20) | NOT NULL |
| login_pin | varchar(10) | nullable — hospital portal PIN |
| email | varchar(255) | nullable |
| address | text | nullable |
| tag_number_start | varchar(50) | nullable — RFID range start |
| tag_number_end | varchar(50) | nullable — RFID range end |
| net_quantity | int UNSIGNED | nullable — catching net stock |
| image | varchar(500) | **nullable** — Dropzone upload path |
| created_at / updated_at | timestamp | |

> Column is `net_quantity` (not `catching_net_qty` from V1.0) — confirmed from UI input `id="netQuantity"`.

#### `doctors`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| city_id | bigint UNSIGNED FK → cities | NOT NULL |
| name | varchar(255) | NOT NULL |
| contact | varchar(20) | NOT NULL |
| email | varchar(255) | nullable |
| address | text | nullable |
| image | varchar(500) | **nullable** — Dropzone upload path |
| created_at / updated_at | timestamp | |

#### `vehicles`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| city_id | bigint UNSIGNED FK → cities | NOT NULL |
| vehicle_number | varchar(20) | NOT NULL — was `number_plate` in V1.0 |
| login_id | varchar(100) | NOT NULL, unique — vehicle app login |
| login_password | varchar(255) | NOT NULL — hashed |
| image | varchar(500) | **nullable** — Dropzone upload path |
| created_at / updated_at | timestamp | |

#### `medicines`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| name | varchar(255) | NOT NULL |
| unit | varchar(50) | NOT NULL — e.g. `Tablet`, `IM`, `SC` |
| dose | varchar(100) | NOT NULL — e.g. `500mg`, `10mg/ml` |
| created_at / updated_at | timestamp | |

#### `medicare` *(Standalone CRUD table — New in V2.0)*
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| name | varchar(255) | NOT NULL — e.g. `Wound Dressing`, `Rabies Prophylaxis` |
| created_at / updated_at | timestamp | |

> Medicare is its own independent lookup table managed via `#medicareModal`. It is NOT just a boolean flag on ARV records — it is a named category.

#### `bill_masters`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| name | varchar(255) | NOT NULL — e.g. `Consultation Fee`, `Vaccination Charge` |
| created_at / updated_at | timestamp | |

---

### 4.4 Staff Tables

#### `arv_staff`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| city_id | bigint UNSIGNED FK → cities | NOT NULL |
| name | varchar(255) | NOT NULL |
| login_id | varchar(100) | NOT NULL, unique — mobile app login |
| login_password | varchar(255) | NOT NULL, hashed — 4-digit PIN |
| has_web_login | tinyint(1) | NOT NULL, default 0 — **New in V2.0** |
| web_email | varchar(255) | nullable, unique — **New in V2.0** |
| web_password | varchar(255) | nullable, hashed — **New in V2.0** |
| image | varchar(500) | **nullable** — Dropzone upload path |
| created_at / updated_at | timestamp | |

> `web_email` / `web_password` are only populated when `has_web_login = 1` (the `#webLoginCheck` checkbox). Conditional validation: `required_if:has_web_login,1`.

#### `catching_staff`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| city_id | bigint UNSIGNED FK → cities | NOT NULL |
| name | varchar(255) | NOT NULL |
| contact | varchar(20) | NOT NULL |
| email | varchar(255) | nullable |
| address | varchar(500) | nullable |
| image | varchar(500) | **nullable** — Dropzone upload path |
| created_at / updated_at | timestamp | |

---

### 4.5 Project Tables

#### `projects`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| ngo_id | bigint UNSIGNED FK → ngos | NOT NULL |
| city_id | bigint UNSIGNED FK → cities | NOT NULL |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| vehicle_id | bigint UNSIGNED FK → vehicles | NOT NULL |
| name | varchar(255) | NOT NULL |
| rfid_enabled | tinyint(1) | NOT NULL, default 0 |
| contact | varchar(20) | NOT NULL — client portal login |
| pin | varchar(4) | NOT NULL — 4-digit PIN (hashed or plain — confirm with client) |
| arv_months | int UNSIGNED | nullable, default 6 — months between ARV doses |
| catch_visibility | enum('visible','hidden') | default 'visible' |
| catch_type | enum('count','list') | default 'list' |
| receive_visibility | enum('visible','hidden') | default 'visible' |
| receive_type | enum('count','list') | default 'count' |
| process_visibility | enum('visible','hidden') | default 'visible' |
| process_type | enum('count','list') | default 'count' |
| observation_visibility | enum('visible','hidden') | default 'visible' |
| observation_type | enum('count','list') | default 'count' |
| r4r_visibility | enum('visible','hidden') | default 'visible' |
| r4r_type | enum('count','list') | default 'count' |
| complete_visibility | enum('visible','hidden') | default 'visible' |
| complete_type | enum('count','list') | default 'list' |
| reject_visibility | enum('visible','hidden') | default 'visible' |
| reject_type | enum('count','list') | default 'count' |
| created_at / updated_at | timestamp | |

> Client permissions (14 radio-group values) are stored **directly on the projects row** — no separate `project_client_permissions` table is needed. The UI confirmed all permissions belong to a single project record.

> The `vehicle_id` direct FK on `projects` replaced the `project_vehicle` pivot from V1.0, as the UI shows a single vehicle selector per project.

---

### 4.6 Dog Lifecycle — Central State-Machine Table

#### `caught_dogs` *(The single source of truth for all dog lifecycle data)*

This table stores every dog record from the moment of capture. The `status` column acts as the state machine that drives the entire pipeline. All pipeline list-views are simply `WHERE status = ?` queries on this table.

| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| project_id | bigint UNSIGNED FK → projects | NOT NULL |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| vehicle_id | bigint UNSIGNED FK → vehicles | nullable |
| catching_staff_id | bigint UNSIGNED FK → catching_staff | nullable |
| doctor_id | bigint UNSIGNED FK → doctors | nullable — assigned on Receive |
| tag_number | varchar(50) | NOT NULL, unique — RFID/physical tag |
| rfid | varchar(100) | nullable |
| gender | enum('male','female','unknown') | NOT NULL |
| dog_type | varchar(50) | nullable — e.g. `street`, `pet` |
| color | varchar(50) | nullable |
| stage | varchar(20) | nullable — `puppy`, `adult` |
| dob | date | nullable |
| street | varchar(255) | nullable |
| owner_name | varchar(255) | nullable |
| address | text | nullable |
| address2 | text | nullable |
| image | varchar(500) | nullable |
| **status** | **enum('caught','received','in_process','observation','r4r','complete','rejected','expired')** | **NOT NULL, default 'caught'** |
| caught_at | timestamp | nullable — when dog was caught |
| received_at | timestamp | nullable — when hospital received it |
| created_at / updated_at | timestamp | |

**Pipeline status-to-view mapping:**

| `status` value | UI List View | Route |
|---|---|---|
| `caught` | Catched Dog List | `GET /catched-dog-list` |
| `received` | Received Dog List | `GET /manage-received-dog-list` |
| `in_process` | Process Dog List | `GET /manage-process-dog-list` |
| `observation` | Observation Dog List | `GET /manage-observation-dog-list` |
| `r4r` | R4R Dog List | `GET /manage-r4r-dog-list` |
| `complete` | Completed Operation List | `GET /manage-completed-operation-dog-list` |
| `rejected` | Rejected Dog List | `GET /rejected-dog-list` |
| `expired` | Expired / Dispose Pending | `GET /expired-dog-list` |

**Legal state transitions (enforced by `DogPipelineService`):**
```
caught        → received        (via Receive Modal: doctor_id + received_at)
caught        → rejected        (at receive stage)
received      → in_process      (via Process action)
received      → rejected        (at process stage)
in_process    → observation     (post-operation)
observation   → r4r             (cleared for release)
observation   → expired         (dog died post-op)
r4r           → complete        (released or returned to owner)
r4r           → expired         (dog died pre-release)
```

**Important:** No state can skip stages. Any attempt to set a status that skips the sequence must be rejected with HTTP 422.

---

### 4.7 Dog Lifecycle — Audit Log Tables

These tables do NOT replace `caught_dogs`. They are **append-only audit logs** used for reporting (e.g., the "Event Timeline" shown in view pages, the Daily Running Sheet medicine columns).

#### `dog_operations` *(Surgical operation record — linked when dog moves to in_process)*
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| caught_dog_id | bigint UNSIGNED FK → caught_dogs | NOT NULL |
| doctor_id | bigint UNSIGNED FK → doctors | NOT NULL |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| operation_date | date | NOT NULL |
| body_weight | decimal(5,2) | nullable — shown in Daily Running Sheet |
| notes | text | nullable |
| created_at / updated_at | timestamp | |

#### `dog_operation_medicines` *(Pivot — medicines used in an operation)*
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| dog_operation_id | bigint UNSIGNED FK → dog_operations | NOT NULL |
| medicine_id | bigint UNSIGNED FK → medicines | NOT NULL |
| dose_given | varchar(100) | nullable |
| quantity | decimal(8,2) | nullable |

#### `dog_stage_logs` *(Audit trail for every status transition)*
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| caught_dog_id | bigint UNSIGNED FK → caught_dogs | NOT NULL |
| from_status | varchar(20) | nullable — null for initial `caught` entry |
| to_status | varchar(20) | NOT NULL |
| performed_by | bigint UNSIGNED FK → users | NOT NULL |
| reason | text | nullable — required for `rejected`/`expired` |
| notes | text | nullable |
| created_at | timestamp | NOT NULL — immutable log |

> `dog_stage_logs` replaces the fragmented `dog_received`, `dog_process`, `dog_observations`, `dog_r4r`, `dog_rejections` tables from V1.0. Every state change writes one row here.

---

### 4.8 ARV Table

#### `arv_dogs` *(Parallel, independent vaccination track)*
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| project_id | bigint UNSIGNED FK → projects | NOT NULL |
| sub_project_id | bigint UNSIGNED FK → projects | nullable |
| hospital_id | bigint UNSIGNED FK → hospitals | NOT NULL |
| arv_staff_id | bigint UNSIGNED FK → arv_staff | NOT NULL |
| vaccinator_id | bigint UNSIGNED FK → doctors | nullable |
| rfid | varchar(100) | nullable |
| arv_checked | tinyint(1) | default 1 |
| arv_date | date | NOT NULL |
| color | varchar(50) | NOT NULL |
| has_medicare | tinyint(1) | default 0 |
| note | text | nullable |
| address | varchar(500) | nullable |
| address2 | varchar(500) | nullable |
| dob | date | nullable |
| stage | varchar(20) | NOT NULL — e.g. `puppy`, `adult` |
| gender | enum('male','female','unknown') | NOT NULL |
| dog_type | varchar(50) | NOT NULL |
| image | varchar(500) | nullable |
| created_at / updated_at | timestamp | |

---

### 4.9 Billing Tables *(New in V2.0)*

#### `bills`
| Column | Type | Notes |
|---|---|---|
| id | bigint UNSIGNED PK | |
| project_id | bigint UNSIGNED FK → projects | NOT NULL |
| bill_number | varchar(100) | NOT NULL |
| bill_date | date | NOT NULL |
| start_date | date | NOT NULL |
| end_date | date | NOT NULL, must be ≥ start_date |
| bill_type | varchar(100) | NOT NULL — from bill_masters |
| dog_count | int UNSIGNED | NOT NULL |
| rate_per_dog | decimal(10,2) | NOT NULL |
| total_amount | decimal(12,2) | NOT NULL — server-calculated: dog_count × rate_per_dog |
| old_bill_type | varchar(100) | nullable |
| old_dog_count | int UNSIGNED | nullable |
| old_rate_per_dog | decimal(10,2) | nullable |
| old_total_amount | decimal(12,2) | nullable — server-calculated |
| tds_amount | decimal(10,2) | nullable, default 0 |
| other_deduction | decimal(10,2) | nullable, default 0 |
| other_deduction_details | text | nullable |
| created_at / updated_at | timestamp | |

> **Security rule:** Never trust `totalAmount` or `oldTotalAmount` from the client. Always recompute `total_amount = dog_count * rate_per_dog` on the server before saving.

---

### 4.10 Relationships Summary

```
cities              1──∞  ngos
cities              1──∞  hospitals
cities              1──∞  vehicles
cities              1──∞  arv_staff
cities              1──∞  catching_staff
cities              1──∞  doctors
hospitals           1──∞  doctors
hospitals           1──∞  arv_staff
hospitals           1──∞  catching_staff
hospitals           1──∞  vehicles
ngos                1──∞  projects
cities              1──∞  projects
hospitals           1──∞  projects
vehicles            1──∞  projects
projects            1──∞  caught_dogs
projects            1──∞  arv_dogs
projects            1──∞  bills
caught_dogs         ∞──1  doctors             (assigned on receive)
caught_dogs         ∞──1  catching_staff
caught_dogs         ∞──1  vehicles
caught_dogs         1──∞  dog_operations
caught_dogs         1──∞  dog_stage_logs
dog_operations      ∞──∞  medicines           (dog_operation_medicines pivot)
arv_dogs            ∞──1  hospitals
arv_dogs            ∞──1  projects
arv_dogs            ∞──1  arv_staff
arv_dogs            ∞──1  doctors             (vaccinator)
roles               ∞──∞  permissions         (role_has_permissions — Spatie)
users               ∞──∞  roles               (model_has_roles — Spatie)
```

---

## 5. Phase-Wise Development Plan

---

### ✅ Phase 1 — Foundation

> **Goal:** Stable, authenticated shell with upload infrastructure. Everything in Phase 2+ depends on this.

---

#### 1.1 Module: Authentication

**Controllers & Routes**
```
GET   /login                → AuthController@showLogin
POST  /login                → AuthController@login           (returns JSON)
POST  /logout               → AuthController@logout
GET   /forgot-password      → ForgotPasswordController@show
POST  /reset-password       → ResetPasswordController@reset
```

**Business Logic**
- Validate `email` + `password` via `Auth::attempt()`.
- On success return JSON `{ success: true, redirect: '/dashboard' }` — JS handles the redirect.
- On failure return HTTP 422 with `{ success: false, message: 'Invalid credentials.' }`.
- Convert `resources/views/admin/Auth/login.html` → `login.blade.php`. Add `@csrf`. Wire form to `POST /login`.
- Protect all routes under `Route::middleware(['auth'])`.

---

#### 1.2 Module: Global Image Upload *(New in V2.0)*

**Controller & Route**
```
POST /upload/image  →  UploadController@storeImage
```

**Business Logic**
- Accept `file` (image) and optional `folder` parameter.
- Validate: `required|image|mimes:jpeg,png,jpg,gif,webp|max:4096`.
- Store using `$request->file('file')->store("uploads/{$folder}", 'public')`.
- Return `{ success: true, path: "uploads/cities/filename.jpg" }`.
- This endpoint is called by Dropzone.js on every image-carrying form. The returned `path` is injected into the form's hidden field before final submission.
- Run `php artisan storage:link` in deployment.

**Target Blade Wiring**
- Configure each Dropzone instance's `url` option to `"{{ route('upload.image') }}"` with a `folder` hidden param.

---

#### 1.3 Module: Role & Permission System

**Package Setup**
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

**Controllers & Routes**
```
GET    /roles                           → RoleController@index
POST   /roles                           → RoleController@store         (AJAX)
PUT    /roles/{id}                      → RoleController@update         (AJAX)
DELETE /roles/{id}                      → RoleController@destroy        (AJAX)

GET    /permissions                     → PermissionController@index
POST   /permissions                     → PermissionController@store    (AJAX)
PUT    /permissions/{id}                → PermissionController@update   (AJAX)
DELETE /permissions/{id}                → PermissionController@destroy  (AJAX)
```

**Business Logic**
- `store`: Validate `name` unique, `status`. Create Role. Sync submitted permission checkboxes via Spatie `syncPermissions()`.
- Checkbox IDs follow the pattern `perm-{module}-{action}` (e.g., `perm-user-view`, `perm-project-add`). Map these to Spatie permission slugs.
- `destroy`: Block deletion if any users are assigned to the role.
- Seed three default roles: **Admin** (all permissions), **Manager** (operational modules), **Viewer** (read-only).
- DataTable: `#manage-role-table`. Modal: `#roleModal`. Button: `#add-role-btn`. None of these IDs change.

**Target Blade Views**
- `admin/role&permission/role.blade.php`
- `admin/role&permission/permissions.blade.php`

---

#### 1.4 Module: Dashboard

**Controllers & Routes**
```
GET /dashboard  →  DashboardController@index
```

**Business Logic**
- Pass aggregated counts to view: `$cities`, `$ngos`, `$hospitals`, `$vehicles`, `$projects`, `$todayCaught`, `$todayOperated`, `$todayReleased`.
- Replace all static magic numbers in `dashboard.blade.php` with `{{ $variable }}`.

---

#### 1.5 Module: Settings

**Controllers & Routes**
```
GET  /settings           →  SettingController@index
POST /settings/basic     →  SettingController@saveBasic   (AJAX)
POST /settings/sms       →  SettingController@saveSms     (AJAX)
```

**Business Logic**
- Both forms have correct `name` attributes (`bd_*`, `sms_*`) — no name-attribute fix needed here.
- `saveBasic`: `updateOrCreate(['id' => 1], $validatedData)`. Handle `bd_logo` file upload via `UploadController` logic (or call shared service). Store path in `bd_logo`.
- `saveSms`: Same pattern for `sms_*` columns on the same row.
- Share `$appSettings = Setting::first()` with all views via `AppServiceProvider` or a `ViewComposer`.
- Two separate `<form>` elements on the same page (`#formBasicDetails`, `#formSmsDetails`) → two separate AJAX calls, two separate success toasts.

**Target Blade Views**
- `admin/settings/settings.blade.php`

---

### ✅ Phase 2 — Core Master Data

> **Goal:** Build all independent lookup tables. No module here has dependencies on Phase 3+.

---

#### 2.1 Module: City Management

**Controllers & Routes**
```
GET    /manage-city        →  CityController@index
POST   /manage-city        →  CityController@store    (AJAX — modal #cityForm)
PUT    /manage-city/{id}   →  CityController@update   (AJAX — same modal #cityForm)
DELETE /manage-city/{id}   →  CityController@destroy  (AJAX)
GET    /api/cities         →  CityController@apiList  (JSON for all dropdowns)
```

**Business Logic**
- `store`: Validate `city_name` required, unique. Accept `image` path string (already uploaded by Dropzone). Create city. Return JSON with new city row data.
- `update`: Pre-fill `#cityTitle` (and `#cityId` hidden) when Edit icon is clicked via a `GET /manage-city/{id}` data fetch. `#cityModalTitle` text changes to "Edit City" via JS.
- `destroy`: Block if city has NGOs, hospitals, or projects. Return 422 with explanation.
- `apiList`: Return `[{id, city_name}]` — consumed by every dropdown across the app.
- DataTable: `#manage-city-table`. Modal: `#cityModal`. Button: `#add-city-btn`.

**Field `name` mapping to add to Blade:**
```
#cityId     → name="id"        (hidden)
#cityTitle  → name="city_name"
#cityImage  → name="image"     (hidden)
```

---

#### 2.2 Module: NGO Management

**Controllers & Routes**
```
GET    /manage-ngo        →  NgoController@index
GET    /add-ngo           →  NgoController@create
POST   /add-ngo           →  NgoController@store    (AJAX)
GET    /manage-ngo/{id}   →  NgoController@show
PUT    /manage-ngo/{id}   →  NgoController@update   (AJAX)
DELETE /manage-ngo/{id}   →  NgoController@destroy  (AJAX)
```

**Business Logic**
- `store`: Validate `name`, `contact`, `city_id` (exists), optional `email` and `address`. Accept `image` path string.
- `destroy`: Block if NGO is linked to active projects.

**Field `name` mapping to add to Blade:**
```
#ngoName    → name="name"
#ngoContact → name="contact"
#ngoEmail   → name="email"
#ngoCity    → name="city_id"
#ngoAddress → name="address"
#ngoImage   → name="image"
```

---

#### 2.3 Module: Hospital Management

**Controllers & Routes**
```
GET    /manage-hospital        →  HospitalController@index
GET    /add-hospital           →  HospitalController@create
POST   /add-hospital           →  HospitalController@store    (AJAX)
GET    /manage-hospital/{id}   →  HospitalController@show
PUT    /manage-hospital/{id}   →  HospitalController@update   (AJAX)
DELETE /manage-hospital/{id}   →  HospitalController@destroy  (AJAX)
GET    /api/hospitals          →  HospitalController@apiList  (JSON, optional ?city_id=)
```

**Business Logic**
- `store`: Validate `name`, `contact`, `city_id`. Validate `tag_number_start` ≤ `tag_number_end` numerically. Check no overlapping tag ranges within the same city.
- `apiList`: Accepts optional `?city_id=` query param — used by vehicle, doctor, and staff dropdowns to filter by city.
- Quick-add modal `#cityModal` with `#cityNameInput` — calls `POST /api/cities` (or `/manage-city`) on save, refreshes `#hospitalCity` dropdown.

**Field `name` mapping to add to Blade:**
```
#hospitalName    → name="name"
#hospitalContact → name="contact"
#hospitalPin     → name="login_pin"
#hospitalEmail   → name="email"
#hospitalAddress → name="address"
#tagNumberStart  → name="tag_number_start"
#tagNumberEnd    → name="tag_number_end"
#netQuantity     → name="net_quantity"
#hospitalCity    → name="city_id"
#hospitalImage   → name="image"
```

---

#### 2.4 Module: Doctor Management

**Controllers & Routes**
```
GET    /manage-doctor        →  DoctorController@index
GET    /add-doctor           →  DoctorController@create
POST   /add-doctor           →  DoctorController@store    (AJAX)
GET    /manage-doctor/{id}   →  DoctorController@show
PUT    /manage-doctor/{id}   →  DoctorController@update   (AJAX)
DELETE /manage-doctor/{id}   →  DoctorController@destroy  (AJAX)
GET    /api/doctors          →  DoctorController@apiList  (JSON, optional ?hospital_id=)
```

**Business Logic**
- `store`: Validate `name`, `contact`, `hospital_id`, `city_id`. Accept `image` path.
- Inline `#hospitalModal` (button `id="openHospitalModalBtn"`) calls Hospital store. Inline `#cityModal` calls City store.

**Field `name` mapping to add to Blade:**
```
#doctorHospital → name="hospital_id"
#doctorName     → name="name"
#doctorContact  → name="contact"
#doctorEmail    → name="email"
#doctorCity     → name="city_id"
#doctorAddress  → name="address"
#doctorImage    → name="image"
```

---

#### 2.5 Module: Vehicle Management

**Controllers & Routes**
```
GET    /manage-vehicle        →  VehicleController@index
GET    /add-vehicle           →  VehicleController@create
POST   /add-vehicle           →  VehicleController@store    (AJAX)
PUT    /manage-vehicle/{id}   →  VehicleController@update   (AJAX)
DELETE /manage-vehicle/{id}   →  VehicleController@destroy  (AJAX)
GET    /api/vehicles          →  VehicleController@apiList  (JSON, optional ?hospital_id=)
```

**Business Logic**
- `store`: Validate `vehicle_number` unique, `login_id` unique, `login_password` min:4. Hash `login_password` before storing. Accept `image` path.
- `destroy`: Block if vehicle is the primary vehicle on any active project.

**Field `name` mapping to add to Blade:**
```
#vehicleHospital  → name="hospital_id"
#vehicleCity      → name="city_id"
#vehiclePlate     → name="vehicle_number"
#vehicleLoginId   → name="login_id"
#vehicleLoginPass → name="login_password"
#vehicleImage     → name="image"
```

---

#### 2.6 Module: Medicine Management

**Controllers & Routes**
```
GET    /manage-medicine        →  MedicineController@index
POST   /manage-medicine        →  MedicineController@store    (AJAX — modal #addMedicineModal)
PUT    /manage-medicine/{id}   →  MedicineController@update   (AJAX — modal #editMedicineModal)
DELETE /manage-medicine/{id}   →  MedicineController@destroy  (AJAX)
GET    /api/medicines          →  MedicineController@apiList
```

**Business Logic**
- Add/Edit both validated: `name` unique, `unit` required, `dose` required.
- Edit buttons carry no `data-*` on the current UI — a `GET /manage-medicine/{id}` fetch call populates `#editMedicineModal` fields before showing it.
- DataTable: `#manage-medicine-table`. Modals: `#addMedicineModal`, `#editMedicineModal`.

---

#### 2.7 Module: Medicare Management *(Standalone CRUD — New in V2.0)*

**Controllers & Routes**
```
GET    /manage-medicare        →  MedicareController@index
POST   /manage-medicare        →  MedicareController@store    (AJAX — modal #medicareModal)
PUT    /manage-medicare/{id}   →  MedicareController@update   (AJAX — same modal)
DELETE /manage-medicare/{id}   →  MedicareController@destroy  (AJAX)
GET    /api/medicare           →  MedicareController@apiList
```

**Business Logic**
- `store` / `update`: Validate `name` required, unique. `#medicareId` hidden field determines add vs. edit mode.
- DataTable: `#manage-medicare-table`. Modal: `#medicareModal`. Button: `#add-medicare-btn`.

**Field `name` mapping to add to Blade:**
```
#medicareId   → name="id"    (hidden)
#medicareName → name="name"
```

---

#### 2.8 Module: Bill Master

**Controllers & Routes**
```
GET    /manage-bill-master        →  BillMasterController@index
POST   /manage-bill-master        →  BillMasterController@store    (AJAX — modal #addBillMasterModal)
PUT    /manage-bill-master/{id}   →  BillMasterController@update   (AJAX — modal #editBillMasterModal)
DELETE /manage-bill-master/{id}   →  BillMasterController@destroy  (AJAX)
GET    /api/bill-masters          →  BillMasterController@apiList
```

**Business Logic**
- Edit buttons carry `data-id` and `data-name` attributes. JS populates `#editBillMasterName` from `data-name` before opening modal. Wire a `PUT` call via JS on save.
- `apiList`: Returns `[{id, name}]` for the Bill form's bill-type dropdowns.
- DataTable: `#manage-bill-master-table`.

---

#### 2.9 Module: ARV Staff Management

**Controllers & Routes**
```
GET    /manage-arv-staff        →  ArvStaffController@index
GET    /add-arv-staff           →  ArvStaffController@create
POST   /add-arv-staff           →  ArvStaffController@store    (AJAX)
PUT    /manage-arv-staff/{id}   →  ArvStaffController@update   (AJAX)
DELETE /manage-arv-staff/{id}   →  ArvStaffController@destroy  (AJAX)
GET    /api/arv-staff           →  ArvStaffController@apiList  (JSON, optional ?hospital_id=)
```

**Business Logic**
- `store`: Validate `hospital_id`, `city_id`, `name`, `login_id` unique, `login_password` min:4. Hash `login_password`.
- Conditional web-login validation: if `has_web_login = 1`, validate `web_email` required|email|unique and `web_password` required|min:8. Hash both.
- `#webLoginCheck` checkbox toggle is already handled in JS — it shows/hides `#webEmail` and `#webPass` fields. Backend validates conditionally.
- DataTable: `#manage-arv-staff-table`. Note: UI shows "PIN" column which maps to `login_password`.

**Field `name` mapping to add to Blade:**
```
#arvHospital    → name="hospital_id"
#arvCity        → name="city_id"
#arvName        → name="name"
#arvLoginId     → name="login_id"
#arvLoginPass   → name="login_password"
#webLoginCheck  → name="has_web_login"   value="1"
#webEmail       → name="web_email"
#webPass        → name="web_password"
#arvImage       → name="image"
```

---

#### 2.10 Module: Catching Staff Management

**Controllers & Routes**
```
GET    /manage-catching-staff        →  CatchingStaffController@index
GET    /add-catching-staff           →  CatchingStaffController@create
POST   /add-catching-staff           →  CatchingStaffController@store    (AJAX)
PUT    /manage-catching-staff/{id}   →  CatchingStaffController@update   (AJAX)
DELETE /manage-catching-staff/{id}   →  CatchingStaffController@destroy  (AJAX)
GET    /view-dog-catcher/{id}        →  CatchingStaffController@show
GET    /api/catching-staff           →  CatchingStaffController@apiList  (JSON, optional ?hospital_id=)
```

**Business Logic**
- `store`: Validate `hospital_id`, `city_id`, `name`, `contact` required. Accept `image` path.
- `#hospitalModal` on this page is the **full 8-field hospital form** (name, contact, email, city, tag start, tag end, net qty, address). This is the most complete inline modal in the app — wire it to `POST /add-hospital`.

**Field `name` mapping to add to Blade:**
```
#staffHospital  → name="hospital_id"
#staffName      → name="name"
#staffCity      → name="city_id"
#staffContact   → name="contact"
#staffEmail     → name="email"
#staffaddress   → name="address"
#staffImage     → name="image"
```

---

### ✅ Phase 3 — Transactional & Operational Modules

> **Goal:** Build all modules that create or consume `caught_dogs` and `arv_dogs` records. These are the operational heart of the application.

---

#### 3.1 Module: Project Management

**Controllers & Routes**
```
GET    /manage-project           →  ProjectController@index
GET    /add-project              →  ProjectController@create
POST   /add-project              →  ProjectController@store            (AJAX)
GET    /view-project/{id}        →  ProjectController@show
GET    /edit-project/{id}        →  ProjectController@edit
PUT    /edit-project/{id}        →  ProjectController@update           (AJAX)
PUT    /project/{id}/login       →  ProjectController@updateLogin      (AJAX)
PUT    /project/{id}/permissions →  ProjectController@updatePermissions (AJAX)
DELETE /manage-project/{id}      →  ProjectController@destroy          (AJAX)
```

**Business Logic**
- `store`:
  1. Validate `name`, `ngo_id`, `city_id`, `hospital_id`, `vehicle_id`, `rfid_enabled`, `contact`, `pin` (digits:4).
  2. Create `projects` record including all 14 permission columns (defaults applied if not submitted).
  3. Hash or store PIN as per client decision (document here once confirmed).
  4. Return JSON with full project data. JS triggers `.login-details-card.is-visible` class toggle to reveal the login details section.
- `updateLogin`: Update `contact`, `pin`, `arv_months` on the project row.
- `updatePermissions`: Update all 14 `*_visibility` / `*_type` columns from the radio-button payload.
- **Inline quick-add modals:** `#ngoModal` → `POST /add-ngo`, `#cityModal` → `POST /manage-city`, `#hospitalModal` (3-field lite) → `POST /add-hospital`, `#vehicleModal` → `POST /add-vehicle`. Each modal's save button calls the respective API, receives the new entity JSON, and appends it to the parent `<select>` before auto-selecting it.
- DataTable: `#manage-project-table`.

**Field `name` mapping to add to Blade:**
```
#projectName  → name="name"
#ngoField     → name="ngo_id"
#cityField    → name="city_id"
#hospitalField → name="hospital_id"
#vehicleField  → name="vehicle_id"
#rfidStatus    → name="rfid_enabled"
#contactNo     → name="contact"
#pinCode       → name="pin"
(permissions section)
name="catching_visibility"  (radio group — already has name attr)
name="catching_type"
... (all 14 radio names are already set in the HTML)
```

---

#### 3.2 Module: Dog Catching (Catch Entry)

**Controllers & Routes**
```
GET    /manage-dog-catcher        →  DogCatcherController@index
GET    /add-dog-catcher           →  DogCatcherController@create
POST   /add-dog-catcher           →  DogCatcherController@store     (AJAX)
GET    /catched-dog-list          →  DogCatcherController@catchedList
GET    /view-catching-staff/{id}  →  DogCatcherController@show
PUT    /view-catching-staff/{id}  →  DogCatcherController@update    (AJAX — view_dog_catcher page)
```

**Business Logic**
- `store`:
  1. Validate `project_id`, `hospital_id`, `vehicle_id`, `tag_number` unique, `gender`.
  2. Validate `tag_number` is within the assigned hospital's `tag_number_start`–`tag_number_end` range.
  3. Accept `image` path (Dropzone).
  4. Create `caught_dogs` record with `status = 'caught'`, `caught_at = now()`.
  5. Write initial row to `dog_stage_logs` (`from_status = null`, `to_status = 'caught'`).
- `catchedList` (`#catch-dog-master-table`): Return `caught_dogs` where `status = 'caught'`.
- `show`: The `view_dog_catcher.blade.php` edit form — accepts `tag_number`, `gender`, `street`, `owner_name`, `vehicle_id`, `address`, `address2`, `image` (file upload via `#uploadDogImage`).

---

#### 3.3 Module: Catch Process Hub

**Controllers & Routes**
```
GET /manage-catch-process  →  CatchProcessController@index
```

**Business Logic**
- Query `caught_dogs` grouped by `status`, pass counts as animated metric badge values.
- Each card is a link to its respective list route. No data mutation here.

---

#### 3.4 Module: Dog Pipeline — Receive Modal

The **Receive** action lives on `catched_dog_list.blade.php`. It is not a separate page.

**Controllers & Routes**
```
POST /caught-dogs/{id}/receive  →  CaughtDogController@receive  (AJAX — modal #receiveModal)
```

**Business Logic**
- `receive`:
  1. Validate `doctor_id` (radio selection) and `received_at` (datetime-local, required).
  2. Verify current `caught_dogs.status = 'caught'` (reject with 422 if not).
  3. Update `caught_dogs`: set `doctor_id`, `received_at`, `status = 'received'`.
  4. Write to `dog_stage_logs`: `from = 'caught'`, `to = 'received'`, `performed_by = auth()->id()`.
  5. Return JSON `{ success: true }` → JS removes the row from `#catch-dog-master-table`.

**Modal wiring — DO NOT RENAME:**
- `#receiveModal` — Bootstrap modal
- `#receiveForm` — form element
- `#receiveId` — hidden dog ID
- `#doctor1` — radio input (doctor selection)
- `#receiveDatetime` — datetime-local input
- `#receiveSubmitBtn` — submit

---

#### 3.5 Module: Dog Pipeline — Received Dog List

**Controllers & Routes**
```
GET  /manage-received-dog-list  →  ReceivedDogController@index
POST /caught-dogs/{id}/process  →  CaughtDogController@moveToProcess  (AJAX)
POST /caught-dogs/{id}/reject   →  CaughtDogController@reject          (AJAX)
```

**Business Logic**
- `index`: `caught_dogs` WHERE `status = 'received'` — **filtered query only, nothing more**.
- `moveToProcess`: Validate status = 'received'. Update to `in_process`. Log to `dog_stage_logs`. Create stub `dog_operations` record.
- `reject`: Require `reason`. Update to `rejected`. Log with reason.
- DataTable: `#received-dog-master-table`.

---

#### 3.6 Module: Dog Pipeline — Process Dog List

**Controllers & Routes**
```
GET  /manage-process-dog-list          →  ProcessDogController@index
POST /caught-dogs/{id}/to-observation  →  CaughtDogController@moveToObservation  (AJAX)
POST /caught-dogs/{id}/reject          →  CaughtDogController@reject              (AJAX — reused)
```

**Business Logic**
- `index`: `caught_dogs` WHERE `status = 'in_process'`.
- `moveToObservation`: Validate status = 'in_process'. Update to `observation`. Log to `dog_stage_logs`. Fill `dog_operations` record (body_weight, doctor_id, medicines).
- DataTable: `#process-dog-master-table`.

---

#### 3.7 Module: Dog Pipeline — Observation Dog List

**Controllers & Routes**
```
GET  /manage-observation-dog-list       →  ObservationDogController@index
GET  /view-observation-dog-list/{id}    →  ObservationDogController@show
POST /caught-dogs/{id}/to-r4r           →  CaughtDogController@moveToR4R    (AJAX)
POST /caught-dogs/{id}/expire           →  CaughtDogController@markExpired  (AJAX)
```

**Business Logic**
- `index`: `caught_dogs` WHERE `status = 'observation'`.
- `show`: Full detail view — catch info, operation medicines, event timeline from `dog_stage_logs`.
- `moveToR4R` / `markExpired`: Update status, log to `dog_stage_logs`.
- DataTable: `#observation-dog-master-table`.

---

#### 3.8 Module: Dog Pipeline — R4R Dog List

**Controllers & Routes**
```
GET  /manage-r4r-dog-list            →  R4rDogController@index
GET  /view-r4r-dog/{id}              →  R4rDogController@show
POST /caught-dogs/{id}/complete      →  CaughtDogController@markComplete  (AJAX)
POST /caught-dogs/{id}/expire        →  CaughtDogController@markExpired   (AJAX — reused)
```

**Business Logic**
- `index`: `caught_dogs` WHERE `status = 'r4r'`.
- `markComplete`: Can be called as `released` or `owner` sub-action — both set `status = 'complete'`.
- DataTables: `#r4r-dog-master-table`.

---

#### 3.9 Module: Completed Operation Lists

**Controllers & Routes**
```
GET  /manage-completed-operation-dog-list           →  CompletedOperationController@index
GET  /view-completed-operation-dog-list/{id}        →  CompletedOperationController@show
GET  /completed-operation-list                      →  CompletedOperationListController@index
GET  /complete-list                                 →  CompletedOperationListController@list
GET  /view-completed-operation/{id}                 →  CompletedOperationListController@show
```

**Business Logic**
- All `index` / `list` methods: `caught_dogs` WHERE `status = 'complete'`. Accept `?start_date=&end_date=&project_id=&hospital_id=` filters.
- Join `dog_operations` to supply medicine and doctor columns in the Daily Running Sheet view.
- DataTables: `#completed-operation-dog-table`, `#dog-catcher-table` (complete_list).

---

#### 3.10 Module: Rejected Dog Lists

**Controllers & Routes**
```
GET /rejected-dog-list                        →  RejectedDogController@index
GET /total-rejected-dog-list                  →  RejectedDogController@totalRejected
GET /view-total-rejected-dog-list/{id}        →  RejectedDogController@show
```

**Business Logic**
- `totalRejected`: `caught_dogs` WHERE `status = 'rejected'`. Join `dog_stage_logs` WHERE `to_status = 'rejected'` to show rejection reason and stage.
- DataTables: `#rejected-dog-master-table`, `#total-reject-dog-master-table`.

---

#### 3.11 Module: Expired / Died Dog Lists

**Controllers & Routes**
```
GET /expired-dog-list             →  ExpiredDogController@index
GET /dispose-pending-dog-list     →  ExpiredDogController@disposePending
GET /total-expired-dog-list       →  ExpiredDogController@totalExpired
GET /view-expired-dog-list/{id}   →  ExpiredDogController@show
```

**Business Logic**
- `disposePending`: `caught_dogs` WHERE `status = 'expired'` — awaiting physical disposal confirmation.
- `totalExpired`: All `status = 'expired'` records with date filter.
- DataTables: `#dispose-dog-master-table`, `#total-expired-dog-master-table`.

---

#### 3.12 Module: ARV Dog Management

**Controllers & Routes**
```
GET    /manage-arv         →  ArvController@index
GET    /add-arv            →  ArvController@create
POST   /add-arv            →  ArvController@store    (AJAX)
GET    /manage-arv/{id}    →  ArvController@show
PUT    /manage-arv/{id}    →  ArvController@update   (AJAX)
DELETE /manage-arv/{id}    →  ArvController@destroy  (AJAX)
```

**Business Logic**
- `store`:
  1. Validate all required fields. `has_medicare` boolean. `project_id` required|exists.
  2. Compute dog age server-side from `dob` — do not trust the client-side `dogAge` field.
  3. Accept `image` path from Dropzone.
  4. If `has_medicare = 1`, ensure a valid medicare record exists (separate from the ARV record itself).
  5. Create `arv_dogs` record.
- DataTable: `#manage-arv-table`.

**Field `name` mapping to add to Blade:**
```
#arvImage       → name="image"
#rfid           → name="rfid"
#arvCheck       → name="arv_checked"      value="1"
#arvDate        → name="arv_date"
#arvHospital    → name="hospital_id"
#subProject     → name="sub_project_id"
#arvStaff       → name="arv_staff_id"
#vaccinator     → name="vaccinator_id"
#dogColor       → name="color"
#medicareCheck  → name="has_medicare"     value="1"
#underProject   → name="project_id"
#note           → name="note"
#address        → name="address"
#address2       → name="address2"
#dogDob         → name="dob"
#dogAge         → (readonly — do not submit, ignore on backend)
#dogStage       → name="stage"
#dogGender      → name="gender"
#dogType        → name="dog_type"
```

---

#### 3.13 Module: Today's Catch List

**Controllers & Routes**
```
GET  /today-catch-list        →  TodayCatchController@index
GET  /dog-catching-list       →  TodayCatchController@catchingList
GET  /view-catch/{id}         →  TodayCatchController@show
```

**Business Logic**
- `index`: Hub with filter dropdowns `#projectSelect` and `#hospitalSelect`. Metric cards showing today's catch counts.
- `catchingList`: `caught_dogs` WHERE `DATE(caught_at) = today()` with project/hospital filter. DataTable backend renders `<tbody>`.

---

#### 3.14 Module: Bill Management *(New in V2.0)*

**Controllers & Routes**
```
GET    /manage-bills        →  BillController@index
GET    /add-bill            →  BillController@create
POST   /add-bill            →  BillController@store    (AJAX)
GET    /view-bill/{id}      →  BillController@show
PUT    /bills/{id}          →  BillController@update   (AJAX)
DELETE /bills/{id}          →  BillController@destroy  (AJAX)
```

**Business Logic**
- `store`:
  1. Validate all fields. Enforce `end_date >= start_date`.
  2. **Always recompute** `total_amount = dog_count * rate_per_dog` server-side. Reject the client-submitted `totalAmount`.
  3. Likewise recompute `old_total_amount = old_dog_count * old_rate_per_dog` server-side.
  4. Create `bills` record linked to `project_id`.
- `show`: Render full printable bill view (`view_bill.blade.php`) with project details and payment history table.
- Form ID: `#add-bill-form` (has `enctype="multipart/form-data"` — future file attachment support).

**Field `name` mapping to add to Blade:**
```
#billNo                 → name="bill_number"
#billDate               → name="bill_date"
#startDate              → name="start_date"
#endDate                → name="end_date"
#tdsAmount              → name="tds_amount"
#otherDeduction         → name="other_deduction"
#otherDeductionDetails  → name="other_deduction_details"
#oldBillType            → name="old_bill_type"
#oldDogCount            → name="old_dog_count"
#oldRatePerDog          → name="old_rate_per_dog"
#oldTotalAmount         → (readonly — server-computed, do not submit)
#billType               → name="bill_type"
#dogCount               → name="dog_count"
#ratePerDog             → name="rate_per_dog"
#totalAmount            → (readonly — server-computed, do not submit)
```

---

### ✅ Phase 4 — Reports, Analytics & Advanced Features

> **Goal:** Reporting layer, export capabilities, dashboard live data, and notification system.

---

#### 4.1 Module: Project Summary

**Controllers & Routes**
```
GET /project-summary  →  ProjectSummaryController@index
```

**Business Logic**
- Hub of 4 metric cards from `caught_dogs` WHERE `project_id = ?` (optional filter):
  - Total Caught (all statuses)
  - Complete Operation count (`status = 'complete'`)
  - Total Expired count (`status = 'expired'`)
  - Total Rejected count (`status = 'rejected'`)
- Accept `?project_id=` as optional filter.

---

#### 4.2 Module: Daily Running Sheet

**Controllers & Routes**
```
GET  /daily-running-sheet         →  DailyRunningSheetController@index
GET  /daily-running-sheet/export  →  DailyRunningSheetController@export
```

**Business Logic**
- Accept `?date=&project_id=` filter params (mapped from `#project-search` and `#running-date` UI fields).
- Join `caught_dogs` → `dog_operations` → `dog_operation_medicines` → `medicines`.
- DataTable columns: ID, Tag, Gender, Body Weight, Color, Pre MED, Anaesthetic, Other (medicines split by type).
- DataTable: `#daily-running-table`.
- `export`: PDF via `barryvdh/laravel-dompdf` or Excel via `maatwebsite/excel`.

---

#### 4.3 Module: Dashboard Live Analytics

**Controllers & Routes**
```
GET /api/dashboard/daily-overview       →  DashboardApiController@dailyOverview
GET /api/dashboard/operation-mix        →  DashboardApiController@operationMix
GET /api/dashboard/operational-updates  →  DashboardApiController@operationalUpdates
```

**Business Logic**
- Replace all hardcoded ApexCharts `data` arrays in `dashboard.blade.php` with AJAX calls to these endpoints.
- `dailyOverview`: Last 7 days of `caught`, `complete`, `expired` counts grouped by date.
- `operationMix`: Today's dogs grouped by `status` for the donut chart.
- `operationalUpdates`: Active catch assignments for today's table.

---

#### 4.4 Module: R4R Operation Lists (Sidebar)

**Controllers & Routes**
```
GET  /R4R-operation-list               →  R4rOperationController@index
GET  /view-r4r-operation-list/{id}     →  R4rOperationController@show
```

**Business Logic**
- Sidebar quick-access view of `caught_dogs WHERE status = 'r4r'` — distinct route from the Catch Process hub R4R view but same data.

---

#### 4.5 Module: Notifications & SMS Gateway

**Business Logic**
- Hook Laravel `Notification` system to dog lifecycle events (dog received, moved to R4R, released).
- Use settings table `sms_meta` (sender ID), `sms_contact` (API contact) for the SMS provider via a custom `SmsChannel` driver backed by Guzzle.

---

#### 4.6 Module: Stock / Inventory

**Controllers & Routes**
```
GET   /stocks                    →  StockController@index
POST  /stocks/verify-password    →  StockController@verifyPassword
POST  /stocks                    →  StockController@addStock
PUT   /stocks/{id}/adjust        →  StockController@adjust
```

**Business Logic**
- Stock access is gated by a password modal (`stockAccessModal` with `#stockPassword`) on the dashboard. Store the stock password in `settings` (add a `stock_password` column).
- `verifyPassword`: Validate against `settings.stock_password`. Issue session flag `stock_access = true`.
- Stock is per medicine per hospital with quantity tracking.

---

## 6. `DogPipelineService` — Centralised State Machine

Create `app/Services/DogPipelineService.php`. All status transitions must go through this service — controllers must never update `caught_dogs.status` directly.

```php
// app/Services/DogPipelineService.php

class DogPipelineService
{
    private const LEGAL_TRANSITIONS = [
        'caught'      => ['received', 'rejected'],
        'received'    => ['in_process', 'rejected'],
        'in_process'  => ['observation'],
        'observation' => ['r4r', 'expired'],
        'r4r'         => ['complete', 'expired'],
    ];

    public function transition(CaughtDog $dog, string $toStatus, array $meta = []): void
    {
        $fromStatus = $dog->status;

        if (! in_array($toStatus, self::LEGAL_TRANSITIONS[$fromStatus] ?? [])) {
            throw new \DomainException(
                "Illegal status transition: {$fromStatus} → {$toStatus}"
            );
        }

        DB::transaction(function () use ($dog, $fromStatus, $toStatus, $meta) {
            $dog->update(array_merge(['status' => $toStatus], $meta));

            DogStageLog::create([
                'caught_dog_id' => $dog->id,
                'from_status'   => $fromStatus,
                'to_status'     => $toStatus,
                'performed_by'  => auth()->id(),
                'reason'        => $meta['reason'] ?? null,
                'notes'         => $meta['notes'] ?? null,
            ]);
        });
    }
}
```

HTTP 422 is returned to the client if a `DomainException` is thrown during a transition attempt.

---

## 7. Route File Structure

```php
// routes/web.php

use App\Http\Controllers\Admin\{
    AuthController, UploadController, DashboardController,
    RoleController, PermissionController, SettingController,
    CityController, NgoController, HospitalController,
    DoctorController, VehicleController, MedicineController,
    MedicareController, BillMasterController, BillController,
    ArvStaffController, CatchingStaffController, ProjectController,
    DogCatcherController, CaughtDogController,
    ReceivedDogController, ProcessDogController,
    ObservationDogController, R4rDogController,
    CompletedOperationController, CompletedOperationListController,
    ExpiredDogController, RejectedDogController,
    ArvController, TodayCatchController,
    ProjectSummaryController, DailyRunningSheetController,
    R4rOperationController, DashboardApiController,
    StockController, CatchProcessController
};

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Upload (shared — called by Dropzone on every image form)
    Route::post('/upload/image', [UploadController::class, 'storeImage'])->name('upload.image');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('api/dashboard')->group(function () {
        Route::get('/daily-overview',      [DashboardApiController::class, 'dailyOverview']);
        Route::get('/operation-mix',       [DashboardApiController::class, 'operationMix']);
        Route::get('/operational-updates', [DashboardApiController::class, 'operationalUpdates']);
    });

    // Settings
    Route::get('/settings',        [SettingController::class, 'index']);
    Route::post('/settings/basic', [SettingController::class, 'saveBasic'])->name('settings.basic');
    Route::post('/settings/sms',   [SettingController::class, 'saveSms'])->name('settings.sms');

    // Roles & Permissions
    Route::apiResource('roles',       RoleController::class);
    Route::apiResource('permissions', PermissionController::class);

    // Master Data
    Route::get('/api/cities',        [CityController::class, 'apiList']);
    Route::get('/api/hospitals',     [HospitalController::class, 'apiList']);
    Route::get('/api/vehicles',      [VehicleController::class, 'apiList']);
    Route::get('/api/doctors',       [DoctorController::class, 'apiList']);
    Route::get('/api/arv-staff',     [ArvStaffController::class, 'apiList']);
    Route::get('/api/catching-staff',[CatchingStaffController::class, 'apiList']);
    Route::get('/api/medicines',     [MedicineController::class, 'apiList']);
    Route::get('/api/medicare',      [MedicareController::class, 'apiList']);
    Route::get('/api/bill-masters',  [BillMasterController::class, 'apiList']);

    Route::resource('manage-city',         CityController::class);
    Route::resource('manage-ngo',          NgoController::class);
    Route::resource('add-hospital',        HospitalController::class);
    Route::resource('add-doctor',          DoctorController::class);
    Route::resource('add-vehicle',         VehicleController::class);
    Route::resource('manage-medicine',     MedicineController::class);
    Route::resource('manage-medicare',     MedicareController::class);
    Route::resource('manage-bill-master',  BillMasterController::class);
    Route::resource('add-arv-staff',       ArvStaffController::class);
    Route::resource('add-catching-staff',  CatchingStaffController::class);

    // Projects
    Route::resource('add-project', ProjectController::class);
    Route::put('/project/{id}/login',       [ProjectController::class, 'updateLogin']);
    Route::put('/project/{id}/permissions', [ProjectController::class, 'updatePermissions']);

    // Dog catching + pipeline actions (all on CaughtDogController)
    Route::get('/manage-dog-catcher',        [DogCatcherController::class, 'index']);
    Route::get('/add-dog-catcher',           [DogCatcherController::class, 'create']);
    Route::post('/add-dog-catcher',          [DogCatcherController::class, 'store']);
    Route::get('/catched-dog-list',          [DogCatcherController::class, 'catchedList']);
    Route::get('/view-catching-staff/{id}',  [DogCatcherController::class, 'show']);
    Route::put('/view-catching-staff/{id}',  [DogCatcherController::class, 'update']);

    Route::post('/caught-dogs/{id}/receive',       [CaughtDogController::class, 'receive']);
    Route::post('/caught-dogs/{id}/process',       [CaughtDogController::class, 'moveToProcess']);
    Route::post('/caught-dogs/{id}/to-observation',[CaughtDogController::class, 'moveToObservation']);
    Route::post('/caught-dogs/{id}/to-r4r',        [CaughtDogController::class, 'moveToR4R']);
    Route::post('/caught-dogs/{id}/complete',      [CaughtDogController::class, 'markComplete']);
    Route::post('/caught-dogs/{id}/expire',        [CaughtDogController::class, 'markExpired']);
    Route::post('/caught-dogs/{id}/reject',        [CaughtDogController::class, 'reject']);

    // Pipeline list views (all are filtered reads of caught_dogs)
    Route::get('/manage-catch-process',                         [CatchProcessController::class, 'index']);
    Route::get('/manage-received-dog-list',                     [ReceivedDogController::class, 'index']);
    Route::get('/manage-process-dog-list',                      [ProcessDogController::class, 'index']);
    Route::get('/manage-observation-dog-list',                  [ObservationDogController::class, 'index']);
    Route::get('/view-observation-dog-list/{id}',               [ObservationDogController::class, 'show']);
    Route::get('/manage-r4r-dog-list',                          [R4rDogController::class, 'index']);
    Route::get('/view-r4r-dog/{id}',                            [R4rDogController::class, 'show']);
    Route::get('/manage-completed-operation-dog-list',          [CompletedOperationController::class, 'index']);
    Route::get('/view-completed-operation-dog-list/{id}',       [CompletedOperationController::class, 'show']);
    Route::get('/completed-operation-list',                     [CompletedOperationListController::class, 'index']);
    Route::get('/complete-list',                                [CompletedOperationListController::class, 'list']);
    Route::get('/view-completed-operation/{id}',                [CompletedOperationListController::class, 'show']);
    Route::get('/rejected-dog-list',                            [RejectedDogController::class, 'index']);
    Route::get('/total-rejected-dog-list',                      [RejectedDogController::class, 'totalRejected']);
    Route::get('/view-total-rejected-dog-list/{id}',            [RejectedDogController::class, 'show']);
    Route::get('/expired-dog-list',                             [ExpiredDogController::class, 'index']);
    Route::get('/dispose-pending-dog-list',                     [ExpiredDogController::class, 'disposePending']);
    Route::get('/total-expired-dog-list',                       [ExpiredDogController::class, 'totalExpired']);
    Route::get('/view-expired-dog-list/{id}',                   [ExpiredDogController::class, 'show']);

    // ARV
    Route::resource('manage-arv', ArvController::class);

    // Bills
    Route::resource('add-bill', BillController::class);
    Route::get('/view-bill/{id}', [BillController::class, 'show']);

    // Reporting
    Route::get('/today-catch-list',    [TodayCatchController::class, 'index']);
    Route::get('/dog-catching-list',   [TodayCatchController::class, 'catchingList']);
    Route::get('/view-catch/{id}',     [TodayCatchController::class, 'show']);
    Route::get('/project-summary',     [ProjectSummaryController::class, 'index']);
    Route::get('/daily-running-sheet', [DailyRunningSheetController::class, 'index']);
    Route::get('/daily-running-sheet/export', [DailyRunningSheetController::class, 'export']);
    Route::get('/R4R-operation-list',  [R4rOperationController::class, 'index']);
    Route::get('/view-r4r-operation-list/{id}', [R4rOperationController::class, 'show']);

    // Stocks
    Route::get('/stocks',                  [StockController::class, 'index']);
    Route::post('/stocks/verify-password', [StockController::class, 'verifyPassword']);
    Route::post('/stocks',                 [StockController::class, 'addStock']);
    Route::put('/stocks/{id}/adjust',      [StockController::class, 'adjust']);
});
```

---

## 8. Controller & Model Directory Structure

```
app/Http/Controllers/Admin/
├── AuthController.php
├── UploadController.php                ← NEW in V2.0
├── DashboardController.php
├── DashboardApiController.php
├── RoleController.php
├── PermissionController.php
├── SettingController.php
├── CityController.php
├── NgoController.php
├── HospitalController.php
├── DoctorController.php
├── VehicleController.php
├── MedicineController.php
├── MedicareController.php              ← NEW in V2.0
├── BillMasterController.php
├── BillController.php                  ← NEW in V2.0
├── ArvStaffController.php
├── CatchingStaffController.php
├── ProjectController.php
├── DogCatcherController.php
├── CaughtDogController.php             ← NEW in V2.0 (all pipeline actions)
├── CatchProcessController.php
├── ReceivedDogController.php
├── ProcessDogController.php
├── ObservationDogController.php
├── R4rDogController.php
├── R4rOperationController.php
├── CompletedOperationController.php
├── CompletedOperationListController.php
├── ExpiredDogController.php
├── RejectedDogController.php
├── ArvController.php
├── TodayCatchController.php
├── ProjectSummaryController.php
├── DailyRunningSheetController.php
├── StockController.php
└── ReportController.php

app/Services/
└── DogPipelineService.php              ← NEW in V2.0

app/Models/
├── User.php
├── Setting.php
├── City.php
├── Ngo.php
├── Hospital.php
├── Doctor.php
├── Vehicle.php
├── Medicine.php
├── Medicare.php                        ← NEW in V2.0
├── BillMaster.php
├── Bill.php                            ← NEW in V2.0
├── ArvStaff.php
├── CatchingStaff.php
├── Project.php
├── CaughtDog.php                       ← Replaces DogCatch.php from V1.0
├── DogOperation.php
├── DogOperationMedicine.php
├── DogStageLog.php                     ← NEW in V2.0 (replaces 5 separate log models)
└── ArvDog.php

app/Http/Requests/Admin/
├── StoreCityRequest.php
├── StoreHospitalRequest.php
├── StoreNgoRequest.php
├── StoreVehicleRequest.php
├── StoreDoctorRequest.php
├── StoreMedicineRequest.php
├── StoreMedicareRequest.php
├── StoreBillMasterRequest.php
├── StoreBillRequest.php
├── StoreArvStaffRequest.php
├── StoreCatchingStaffRequest.php
├── StoreProjectRequest.php
├── StoreCaughtDogRequest.php
├── ReceiveDogRequest.php
├── StoreArvDogRequest.php
└── ... (one per store/update action)
```

---

## 9. Migration Execution Order

Respects all foreign key constraints:

```
1.  create_settings_table
2.  create_cities_table
3.  create_ngos_table                        FK: city_id
4.  create_hospitals_table                   FK: city_id
5.  create_doctors_table                     FK: hospital_id, city_id
6.  create_vehicles_table                    FK: city_id, hospital_id
7.  create_medicines_table
8.  create_medicare_table                    ← NEW
9.  create_bill_masters_table
10. create_arv_staff_table                   FK: city_id, hospital_id
11. create_catching_staff_table              FK: city_id, hospital_id
12. create_projects_table                    FK: ngo_id, city_id, hospital_id, vehicle_id
13. create_caught_dogs_table                 FK: project_id, hospital_id, vehicle_id, catching_staff_id, doctor_id
14. create_dog_operations_table              FK: caught_dog_id, doctor_id, hospital_id
15. create_dog_operation_medicines_table     FK: dog_operation_id, medicine_id
16. create_dog_stage_logs_table              FK: caught_dog_id, performed_by (users)
17. create_arv_dogs_table                    FK: project_id, hospital_id, arv_staff_id, vaccinator_id
18. create_bills_table                       FK: project_id
19. create_roles_table                       (Spatie auto-generates — run vendor:publish first)
20. create_permissions_table                 (Spatie)
21. create_model_has_roles_table             (Spatie)
22. create_model_has_permissions_table       (Spatie)
23. create_role_has_permissions_table        (Spatie)
24. add_role_id_to_users_table               FK: roles.id (if using direct FK; or use Spatie model_has_roles)
```

---

## 10. Seeder Plan

```
DatabaseSeeder
├── SettingSeeder           → Seed single row with placeholder org details
├── RoleSeeder              → Admin, Manager, Viewer
├── PermissionSeeder        → All module.action combinations (city.add, city.edit, city.delete, etc.)
├── RolePermissionSeeder    → Assign all permissions to Admin; operational to Manager; read to Viewer
├── AdminUserSeeder         → admin@goalf.org / password from .env APP_ADMIN_PASSWORD
└── CitySeeder              → Sample cities for development (Rajkot, Surat, Ahmedabad, Vadodara)
```

---

## 11. Key Development Rules & Notes

1. **No frontend HTML / CSS / JS changes.** Every Blade view is already structured and styled. The backend developer's sole job is: adding controllers, models, migrations, wiring form `action` attributes, adding `name` attributes to inputs, and adding `@csrf` tokens.

2. **AJAX everywhere.** All form submissions return `{ success, message, data }` JSON. No `redirect()->back()` or `return view(...)` from POST routes.

3. **`name` attributes are missing on add-forms.** Every single "add" page (except Settings) is missing `name` attributes. Adding them is the very first thing to do when wiring any Blade form. The `id` attribute must remain unchanged.

4. **Dropzone.js → shared upload endpoint.** All Dropzone instances call `POST /upload/image`. Never create per-module upload routes.

5. **DataTables — client-side rendering.** All list tables use client-side DataTables. Server renders full `<tbody>` rows. Pass the full collection from the controller's `index` method.

6. **`DogPipelineService` is mandatory.** Never update `caught_dogs.status` directly from a controller. Route every transition through `DogPipelineService::transition()`. This guarantees the audit log is always written.

7. **`total_amount` is always server-calculated.** Never trust the client-submitted `totalAmount` or `oldTotalAmount` on the Bills form. Recompute before saving.

8. **Quick-add modals are shared.** The same `#cityModal` / `#hospitalModal` appears across 7+ different pages. One controller handles each — the JS simply calls the correct endpoint regardless of which page it's on.

9. **FormRequest classes for every store/update method.** Never inline-validate in controllers.

10. **Storage linking.** Run `php artisan storage:link` once during deployment. All file paths stored in the database are relative to `storage/app/public/` and accessed via `asset('storage/' . $path)`.

11. **Security note on PINs.** The 4-digit project PIN and vehicle/staff `login_password` values should be hashed with `bcrypt`. Confirm with the client whether the mobile app needs plaintext PIN comparison (if so, consider a reversible encryption or a separate unhashed column for the mobile API only).

12. **Client Project Portal (Phase 4+).** The "Set Login Details" Contact + PIN implies a separate client-facing portal route group (`/client/*`) — distinct from this admin panel. Plan this as Phase 4+ scope.

13. **GPS coordinates.** Map iframes in Dog Catcher and ARV forms are currently static embeds. In a future iteration, add two hidden `<input>` fields (`latitude`, `longitude`) populated by a JS map click handler. The database columns can be added via a future migration.

---

## 12. Quick-Add Modal ID & JS Contract Reference

The following IDs are used in the existing JavaScript and **must never be renamed**.

| Modal / Element ID | Used In Pages | Endpoint Wired To |
|---|---|---|
| `#cityModal` | manage_city, add_hospital, add_ngo, add_vehicle, add_doctor, add_arv_staff, add_catching_staff, add_project, add_arv | `POST /manage-city` |
| `#cityForm` | manage_city | `POST /manage-city` |
| `#cityId` | manage_city | (hidden — edit mode) |
| `#cityTitle` | manage_city | `name="city_name"` |
| `#cityImage` | manage_city | `name="image"` |
| `#cityNameInput` | all quick-add modals | `POST /manage-city` |
| `#hospitalModal` | add_vehicle, add_doctor, add_arv_staff, add_catching_staff, add_project, add_arv | `POST /add-hospital` |
| `#hospitalModalForm` | all hospital quick-adds | `POST /add-hospital` |
| `#hospitalNameInput` | all pages | `name="name"` |
| `#hospitalContactInput` | catching_staff page | `name="contact"` |
| `#hospitalCityInput` | catching_staff page | `name="city_id"` |
| `#ngoModal` | add_project | `POST /add-ngo` |
| `#vehicleModal` | add_project | `POST /add-vehicle` |
| `#receiveModal` | catched_dog_list | `POST /caught-dogs/{id}/receive` |
| `#receiveForm` | catched_dog_list | — |
| `#receiveId` | catched_dog_list | `name="dog_id"` (hidden) |
| `#receiveSubmitBtn` | catched_dog_list | — |
| `#addBillMasterModal` | manage_bill_master | `POST /manage-bill-master` |
| `#editBillMasterModal` | manage_bill_master | `PUT /manage-bill-master/{id}` |
| `#addMedicineModal` | manage_medicine | `POST /manage-medicine` |
| `#editMedicineModal` | manage_medicine | `PUT /manage-medicine/{id}` |
| `#medicareModal` | manage_medicare | `POST /manage-medicare` or `PUT /manage-medicare/{id}` |
| `#roleModal` | role.blade.php | `POST /roles` |
| `#permissionModal` | permissions.blade.php | `POST /permissions` |
| `#manage-city-table` | manage_city | DataTable — must not rename |
| `#manage-hospital-table` | manage_hospital | DataTable |
| `#manage-ngo-table` | manage_ngo | DataTable |
| `#manage-vehicle-table` | manage_vehicle | DataTable |
| `#manage-doctor-table` | manage_doctor | DataTable |
| `#manage-arv-staff-table` | manage_arv_staff | DataTable |
| `#manage-catching-staff-table` | manage_catching_staff | DataTable |
| `#manage-project-table` | manage_project | DataTable |
| `#manage-arv-table` | manage_arv | DataTable |
| `#manage-medicine-table` | manage_medicine | DataTable |
| `#manage-medicare-table` | manage_medicare | DataTable |
| `#manage-bill-master-table` | manage_bill_master | DataTable |
| `#manage-role-table` | role.blade.php | DataTable |
| `#manage-permission-table` | permissions.blade.php | DataTable |
| `#catch-dog-master-table` | catched_dog_list | DataTable |
| `#received-dog-master-table` | received_dog_list | DataTable |
| `#process-dog-master-table` | process_dog_list | DataTable |
| `#observation-dog-master-table` | observation_dog_list | DataTable |
| `#r4r-dog-master-table` | r4r_dog_list | DataTable |
| `#completed-operation-dog-table` | completed_operation_dog_list | DataTable |
| `#rejected-dog-master-table` | rejected_dog_list | DataTable |
| `#total-reject-dog-master-table` | total_rejected_dog_list | DataTable |
| `#dispose-dog-master-table` | dispose_pending_dog_list | DataTable |
| `#total-expired-dog-master-table` | total_expired_dog_list | DataTable |
| `#daily-running-table` | daily_running_sheet | DataTable |
| `#add-bill-form` | add_bill | Form ID |
| `#formBasicDetails` | settings | Form ID |
| `#formSmsDetails` | settings | Form ID |
| `.login-details-card` | add_project | CSS class — toggled via `.is-visible` by JS |
