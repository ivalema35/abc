# ABC Project - Development Tracker

## 🚨 MASTER WORKFLOW RULE (CRITICAL)
1. **Audit First:** AI (Copilot) must analyze the existing code/structure for the specific module.
2. **Review:** We review the analysis to ensure it aligns with the PRD.
3. **Execute:** AI (Copilot) is given exact instructions to generate/apply the code. *(Never write backend code blindly without checking the frontend HTML/existing files first).*
4. **No Module Left Behind:** Kisi bhi module ko tabhi "Complete" mark karenge jab uske saare features (Add, View, Edit, Delete) 100% working aur data-backed honge.
5. **Secure by Default (NEW):** Jab bhi koi naya module create hoga, uski Spatie permissions (`view`, `add`, `edit`, `delete`) usi waqt generate, seed, aur wire-up (Controller Middleware & Blade `@can`) karni compulsory hain.
6. **Server-Side DataTables (NEW):** Sabhi master list/manage views mein DataTables strictly AJAX (Server-Side Processing) ke through populate honge. Koi bhi table directly Blade `@foreach` se render nahi hoga. Yajra DataTables (ya manual AJAX JSON response) use karna standard hoga.

## 🛠️ NEW STRUCTURAL STANDARDS (V2.1)
1. **Unified Storage:** Images `public/uploads/{master_name}/` folder mein store hongi.
2. **Single Blade Pattern:** Har module ke liye ek hi `manage_{master}.blade.php` ya `form_{master}.blade.php` use hoga jo Add aur Edit dono handle karega.
3. **Data Integrity:** Har master table mein `is_active` (tinyInt status) aur `SoftDeletes` (`deleted_at`) compulsory hai.
- **Module-Specific Uploads:** `UploadController` abandoned. Image uploads will be handled directly in the respective module's controller using standard `$request->file()`.
- **FormData AJAX:** Frontend AJAX submissions will use `FormData` to send text inputs and files simultaneously.
4. **FormData AJAX:** Frontend AJAX submissions will use `FormData` to send text inputs and files simultaneously.
5. **AJAX DataTables:** List pages must use `ajax: "{route}"` in DataTable initialization.

### 🎉 Project Status: PRODUCTION READY
* All PRD v2.0 requirements met.
* 100% Spatie Role/Permission integration (Rule #5).
* 100% Server-Side DataTables and AJAX forms.

### Completed Modules
* [x] PRD V2.0 Finalized
* [x] Phase 1.1 & 1.2: Foundation (Auth, Layouts)
* [x] Phase 1.3: Role & Permission System (Spatie installed, module & status columns added),Settings Module
* [x] **Phase 1.3 Bug Fixes:** Roles & Permissions full CRUD, dynamic wiring, & `is_active` toggle complete.
* [x] Phase 1.4: Dynamic Dashboard (Completed, real counts wired)
* [x] **Phase 1.5: Security Patch:** - *AdminUserSeeder skipped (Superadmin already exists). Security & Route Patch (Completed, Backend Secured)*
* [x] **Phase 2.1 City Management:** Full CRUD + SoftDeletes + Status Toggle.
* [x] **Phase 2.2 NGO Management:** Full CRUD + Unified Form.
* [x] **Phase 2.3 Hospital Management:** CRUD, PIN, RFID, Net Qty.
* [x] **Phase 2.4 Doctor Management:** Normalized folder, Dual Dropdowns.
* [x] **Phase 2.5 Catching Staff Management:** Decoupled from Transactional workflow, Views Normalized.
* [x] **Phase 2.6 Master Data Security:** Permissions generated and wired via Spatie Middleware and Blade `@can` across all 5 Master Modules.
* [x] **Phase 2.7: Vehicle Management:** Full CRUD, Spatie Permissions (Rule #5 applied), Hashed Passwords, Masked UI.
* [x] **Phase 2.8: Medicine Management:** Converted to V2.2 Unified Blade, Spatie Permissions applied.
* [x] **Phase 2.9: Medicare Management:** Relocated to dedicated folder, Full CRUD, Single Blade Pattern, Spatie Permissions applied.
* [x] **Phase 2.10: Bill Master:** Converted to V2.2 Unified Blade, Spatie Permissions applied.
* [x] **Phase 2.11: ARV Staff Management (Master Data)**
* [x] **Phase 2.12: Master Data Integrity:**
* [x] **API Phase 1: Sanctum Setup & Auth API** (Login, Logout, Token Gateway wired).
* [x] **API Phase 2: Dashboard API** (Mirrored web counts, Secured).
* [x] **API Phase 3: Master Data CRUD APIs** 
* [x] DataTables AJAX Retrofit applied across ALL Master Data for max performance.
* [x] Global UI/UX: SweetAlert2 & Toast Integration (All Views).
* [x] Phase 2.13: Consolidated Staff Master (Static UI & Sidebar Preview Wired).
* [x] **Phase 2.14: Project Master CRUD** (Backend, Modal UI, & Routes Wired).
* [x] **UI Hotfix:** Resolved Sneat theme duplicate layout render and asset path (Sidebar restored).
* [x] **Phase 3.1: Dog Catching Records** (Cascading dropdowns, FormData AJAX, and Rule #5 Spatie Permissions wired).
* [x] **Phase 3.2: Surgery / Operation Records** (Backend Scaffold, V2.2 DataTables, Dynamic Modal Inject, Status Flow & Permissions wired).
* [x] **Phase 3.3: Post-Operative Care (Observation)** (Minimal Approach, Timeline Audit Logs `dog_stage_logs`, DataTables AJAX, SweetAlert2 Transitions).
* [x] Phase 3.4: R4R (Ready for Release) & Completed Records (End-to-end Lifecycle finished).
* [x] **Phase 4.1: Dashboard Real-Time Wiring** (Live Counters & ApexCharts lifecycle integration).
* [x] **Phase 4.2: Reports Module** (Daily Running Sheet, Project Summary, Completed List with Maatwebsite Excel Exports).
* [X] **Phase 4.3: Final UI Polish & Project Handover**
* [x] **UI Rescue 1:** Migrated Dog Catcher Modal to a completely Standalone Full-Page Form.
* [x] **UI Rescue 2:** Integrated Google Maps API with HTML5 Auto-Geolocation for Catching Records.
* [x] **DB Update:** Added `latitude` & `longitude` to `caught_dogs` (via `catching_records` migration) and updated Model `$fillable`.
* [x] **UI Rescue 3:** Built "View Dog Catcher" Profile Page (with Google Map pin).
* [x] **Feature Addition:** Wired AJAX "Update" and "Quick Release" with SweetAlert2 & auto-audit logging.

### 🔄 Active Task
* [ ] **Dog Catcher View Page:** - Add "Eye" (View) button in Action column of `manage_catching_records`.
  - Reconstruct `view_catching_record.blade.php` based on original mockup.
  - Map read-only data & wire "Update" / "Release" quick actions.

### Pending Modules (Queue)

      
### Notes & Changes from Plan
* Replaced fragmented Dropzone setups with a single master script in `layout.blade.php`.
* Changed Spatie's default `permissions` table to include a `module` column for dynamic UI grouping.
* **UX Improvement:** NGO/Doctor modules mein Quick-Add modals feature add kiya gaya.
* **Data Integrity:** Inactive master data now correctly hidden in Create mode but preserved in Edit mode.
* **Folder Normalization:** `doctore` -> `doctor` and `dogcathchinglist` -> `catching_records`.
* **UX Standard:** 1.5-second delayed redirect implemented on all master modules for better feedback.
* Successfully integrated Spatie roles across the entire Master Data pipeline before moving to Transactional workflows.
* **DataTables AJAX Retrofit** applied across ALL Master Data for max performance.
* **Google Maps Key:** API Key `Maps_API_KEY` is moved to `.env`. Production deploy ke waqt config cache clear (`php artisan config:clear`) karna zaroori hai.
* **Standalone vs Modal:** Chote master data (City, Vehicle) ke liye Modals theek hain, par complex entries jahan Maps ya multiple Image uploads hain, wahan hamesha standalone pages use honge.
* **DataTable Routing:** DataTables ke action buttons mein URL concat karte waqt JS logic use hoga: `'/catching-records/' + row.id + '/edit'`. Blade helper JS ke andar directly render nahi hota.
* **Coordinate Accuracy:** Abhi `string` format use ho raha hai. Agar aage "Radius Search" (find dogs within 2km) karna ho, toh migration ko `decimal(10,8)` par update karna padega.
* **UI Consistency:** Sidebar labels ab original design se synced hain (e.g., "Dog Catcher List"). Active highlighting `request()->routeIs('catching-records.*')` pattern par based hai.
* **Hidden Fields Hack:** Jab view page (read-only mode) se form update karna ho, toh backend validation satisfy karne ke liye purane required fields ko hidden form mein pass karna zaroori hai.
* **Audit Trail Rule:** Kabhi bhi `status` update karo (jaise `quickRelease`), toh hamesha `DogStageLog` mein entry create karo taaki timeline kabhi break na ho.