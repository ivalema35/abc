# Android API & UI/UX Requirements — ABC Project
## Animal Birth Control Management System (Goal Foundation)
### Version 1.0 — Prototype Testing Scope

> **Prepared for:** Android Developer + UI/UX Figma Designer
> **Backend Stack:** Laravel 10.x · Sanctum 3.3 · Spatie Permission 6.x · MySQL
> **App:** Native Android (Kotlin/Java) · Min SDK 24 · Target SDK 34
> **Base URL (Local Dev):** `http://10.0.2.2` (Android Emulator → Laragon localhost)
> **Base URL (Device):** `http://{YOUR_LAN_IP}` (Physical device on same Wi-Fi)
> **API Prefix:** `/api/v1/`
> **Document Status:** AUTHORITATIVE — Hand-off ready for both Android Developer and Figma Designer

---

## ⚠️ Critical Pre-requisites (Laravel Backend Setup)

Before the Android developer begins testing, the Laravel backend engineer **must** complete these steps first. The Android app will fail silently without them.

### Step 1 — Create `routes/api.php`
The current project has no `routes/api.php` with Sanctum-protected routes. The backend developer must add:

```php
// routes/api.php
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\NgoController;
use App\Http\Controllers\Api\V1\HospitalController;
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\VehicleController;

Route::prefix('v1')->group(function () {

    // Public routes — no token required
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes — Sanctum token required
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Master Data CRUDs
        Route::apiResource('cities',    CityController::class);
        Route::apiResource('ngos',      NgoController::class);
        Route::apiResource('hospitals', HospitalController::class);
        Route::apiResource('doctors',   DoctorController::class);
        Route::apiResource('vehicles',  VehicleController::class);

        // Dropdown helpers (for Add/Edit forms)
        Route::get('cities/dropdown',    [CityController::class,    'dropdown']);
        Route::get('hospitals/dropdown', [HospitalController::class, 'dropdown']);
    });
});
```

### Step 2 — Create Dedicated API Controllers
Create a separate namespace `App\Http\Controllers\Api\V1\` for API controllers. **Do not reuse** the existing web `Admin\*` controllers — those return Blade views. API controllers return only `JsonResponse`.

### Step 3 — Configure Sanctum for Stateless Mobile API
In `config/sanctum.php`, ensure the token expiry is set:
```php
'expiration' => 1440, // 24 hours in minutes (adjust as needed)
```

In `.env`, add:
```
SANCTUM_STATEFUL_DOMAINS=localhost
```

### Step 4 — Set `Accept: application/json` Header Globally on Android
This is the **most important header**. Without it, Laravel returns HTML error pages instead of JSON, breaking the Android app. Configure this in Retrofit's OkHttp interceptor (see Section 1.3).

---

---

# Section 1: Security & Authentication Protocol

---

## 1.1 Authentication Mechanism — Laravel Sanctum Bearer Token

This application uses **Laravel Sanctum** for stateless API token authentication. Sanctum issues personal access tokens (PATs) that are stored on the Android device and sent with every authenticated request via the `Authorization` HTTP header.

### Why Sanctum (Not Passport)?
- Sanctum is already installed in this project (`laravel/sanctum ^3.3`).
- The `User` model already has `use HasApiTokens;` — the app is ready to issue tokens immediately.
- Sanctum PATs are simpler, faster, and ideal for a single-app mobile integration like this.

### Token Lifecycle

```
┌─────────────────────────────────────────────────────────────────┐
│                  TOKEN LIFECYCLE DIAGRAM                        │
│                                                                 │
│  [App Launch]                                                   │
│       │                                                         │
│       ▼                                                         │
│  [Check DataStore: is token saved?]                             │
│       │                                                         │
│  ┌────┴────┐                                                     │
│  │  YES    │──────► [Call GET /api/v1/me to validate token]     │
│  └─────────┘             │                                       │
│                    ┌─────┴──────┐                               │
│                    │ 200 OK?    │──► [Go to Dashboard]          │
│                    └────────────┘                               │
│                    │ 401?       │──► [Clear DataStore → Login]  │
│                    └────────────┘                               │
│  ┌────┐                                                          │
│  │ NO │──────────────────────────► [Show Login Screen]         │
│  └────┘                                                          │
│                                                                 │
│  [During any authenticated API call]                            │
│       │                                                         │
│       ▼                                                         │
│  [API returns HTTP 401]                                         │
│       │                                                         │
│       ▼                                                         │
│  [MANDATORY: Clear ALL DataStore/SharedPreferences]             │
│       │                                                         │
│       ▼                                                         │
│  [Navigate to Login Screen — clear back stack]                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 1.2 Required HTTP Headers

Every API request from the Android app **must** include the following headers:

| Header | Value | Required On |
|---|---|---|
| `Accept` | `application/json` | ALL requests — public & authenticated |
| `Content-Type` | `application/json` | POST/PUT with JSON body |
| `Content-Type` | `multipart/form-data` | POST/PUT with file uploads |
| `Authorization` | `Bearer {token}` | All authenticated routes |

### ⚠️ CSRF is NOT Required for Mobile API
Unlike the web dashboard (which uses Laravel Breeze with CSRF cookies), the mobile API is **completely stateless**. The Android app must:
- ✅ Send `Accept: application/json`
- ✅ Send `Authorization: Bearer {token}`
- ❌ Never send `X-CSRF-TOKEN`
- ❌ Never attempt to fetch `/sanctum/csrf-cookie`

The `auth:sanctum` middleware on API routes automatically switches to token-based auth when it detects an `Authorization: Bearer` header instead of a session cookie.

---

## 1.3 Android OkHttp Interceptor (Kotlin — Retrofit Setup)

```kotlin
// ApiClient.kt
object ApiClient {
    private const val BASE_URL = "http://10.0.2.2/" // Emulator
    // private const val BASE_URL = "http://192.168.1.x/" // Physical device

    // DataStore key for token
    val TOKEN_KEY = stringPreferencesKey("auth_token")

    fun create(context: Context): ApiService {
        val prefs = runBlocking {
            context.dataStore.data.first()
        }
        val token = prefs[TOKEN_KEY] ?: ""

        val authInterceptor = Interceptor { chain ->
            val request = chain.request().newBuilder()
                .addHeader("Accept", "application/json")
                .apply {
                    if (token.isNotEmpty()) {
                        addHeader("Authorization", "Bearer $token")
                    }
                }
                .build()
            chain.proceed(request)
        }

        // 401 Auto-logout interceptor
        val unauthorizedInterceptor = Interceptor { chain ->
            val response = chain.proceed(chain.request())
            if (response.code == 401) {
                // Clear token from DataStore
                runBlocking {
                    context.dataStore.edit { it.remove(TOKEN_KEY) }
                }
                // Post event to navigate to Login (use EventBus or SharedFlow)
                AuthEventBus.postLogout()
            }
            response
        }

        val okHttpClient = OkHttpClient.Builder()
            .addInterceptor(authInterceptor)
            .addInterceptor(unauthorizedInterceptor)
            .connectTimeout(30, TimeUnit.SECONDS)
            .readTimeout(30, TimeUnit.SECONDS)
            .build()

        return Retrofit.Builder()
            .baseUrl(BASE_URL)
            .client(okHttpClient)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(ApiService::class.java)
    }
}
```

---

## 1.4 Token Storage — Jetpack DataStore (Recommended)

Do **not** use `SharedPreferences` directly. Use Jetpack `DataStore<Preferences>` for secure, coroutine-friendly storage:

```kotlin
// DataStore extension
val Context.dataStore: DataStore<Preferences> by preferencesDataStore(name = "abc_prefs")

// Save token after login
suspend fun saveToken(context: Context, token: String) {
    context.dataStore.edit { prefs ->
        prefs[ApiClient.TOKEN_KEY] = token
    }
}

// Clear token on logout/401
suspend fun clearToken(context: Context) {
    context.dataStore.edit { prefs ->
        prefs.clear() // Clear ALL stored prefs, not just token
    }
}
```

---

## 1.5 Standardized API Response Envelope

**Every** API response from the Laravel backend follows this envelope contract. The Android app must parse this structure for every call:

### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully.",
    "data": { ... }
}
```

### Validation Error Response (HTTP 422)
```json
{
    "success": false,
    "message": "Validation failed.",
    "errors": {
        "field_name": ["Error message for this field."],
        "email": ["The email has already been taken."]
    }
}
```

### Unauthorized Response (HTTP 401)
```json
{
    "message": "Unauthenticated."
}
```
> **Android Action on 401:** Immediately clear DataStore, navigate to Login screen with `Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK`.

### Forbidden Response (HTTP 403)
```json
{
    "message": "This action is unauthorized."
}
```
> **Android Action on 403:** Show a `Snackbar` with "You don't have permission to perform this action."

### Not Found Response (HTTP 404)
```json
{
    "message": "No query results for model [App\\Models\\City] 5"
}
```

### Business Logic Error Response (HTTP 422)
```json
{
    "success": false,
    "message": "Cannot delete this City because it has linked Hospitals."
}
```

---

---

# Section 2: API Endpoints Contract (JSON Structures)

---

## 2.1 Authentication Endpoints

---

### `POST /api/v1/login`

**Description:** Authenticates an admin user and returns a Sanctum Bearer token.
**Auth Required:** No
**Content-Type:** `application/json`

#### Request Body
```json
{
    "email": "admin@goalf.org",
    "password": "Admin@1234"
}
```

#### Field Validation Rules
| Field | Rule |
|---|---|
| `email` | required · string · valid email format |
| `password` | required · string · min:6 |

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "message": "Login successful.",
    "data": {
        "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ1234567890abcdef",
        "token_type": "Bearer",
        "user": {
            "id": 1,
            "name": "Super Admin",
            "email": "admin@goalf.org",
            "is_active": true,
            "roles": ["Admin"],
            "permissions": [
                "view city", "add city", "edit city", "delete city",
                "view hospital", "add hospital", "edit hospital", "delete hospital"
            ],
            "created_at": "2026-04-01T10:00:00.000000Z"
        }
    }
}
```

#### Response — HTTP 422 Validation Error ❌
```json
{
    "success": false,
    "message": "The provided credentials are incorrect.",
    "errors": {
        "email": ["The provided credentials are incorrect."]
    }
}
```

#### Android Implementation Note
After a successful 200 response:
1. Save `data.token` to DataStore using `saveToken()`.
2. Save `data.user.name` and `data.user.email` to DataStore for display in the profile/nav drawer.
3. Save `data.user.roles[0]` to DataStore for conditional UI rendering.
4. Navigate to `DashboardActivity` with `Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK` (clears back stack).

---

### `POST /api/v1/logout`

**Description:** Revokes the current Bearer token on the server. The token becomes permanently invalid.
**Auth Required:** Yes — `Authorization: Bearer {token}`
**Content-Type:** `application/json`

#### Request Body
```json
{}
```
*(Empty body — no payload needed)*

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "message": "Logged out successfully."
}
```

#### Android Implementation Note
After a successful response:
1. Call `clearToken(context)` to wipe DataStore.
2. Navigate to `LoginActivity` with cleared back stack.
3. Show a `Toast`: "You have been logged out."

---

### `GET /api/v1/me`

**Description:** Returns the currently authenticated user's profile. Used on app startup to validate if a stored token is still valid.
**Auth Required:** Yes

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Super Admin",
        "email": "admin@goalf.org",
        "is_active": true,
        "roles": ["Admin"],
        "created_at": "2026-04-01T10:00:00.000000Z"
    }
}
```

---

## 2.2 Dashboard Endpoint

---

### `GET /api/v1/dashboard`

**Description:** Returns real-time aggregated counts for the Dashboard home screen stat cards.
**Auth Required:** Yes

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "city_count": 12,
        "ngo_count": 9,
        "hospital_count": 8,
        "doctor_count": 26,
        "vehicle_count": 17,
        "staff_count": 39,
        "master_data_total": 111
    }
}
```

> **Backend Note:** This maps directly to the existing `DashboardController::index()` logic which already queries `City::count()`, `Ngo::count()`, `Hospital::count()`, `Doctor::count()`, `Vehicle::count()`. The API controller simply wraps these in the JSON envelope.

---

## 2.3 Master Data CRUD — Standard Blueprint

> All Master Data endpoints follow this **identical pattern**. Only the fields and URLs differ. Read this section once and apply it to all 5 entities.

### ⚠️ File Upload Note
All `store` (POST) and `update` (PUT) endpoints that include an `image` field **must** use `multipart/form-data` as the Content-Type, not `application/json`.

```kotlin
// Retrofit — multipart example for image upload
@Multipart
@POST("api/v1/cities")
suspend fun createCity(
    @Part("city_name") cityName: RequestBody,
    @Part image: MultipartBody.Part? // nullable — image is optional
): Response<ApiResponse<CityModel>>
```

For requests **without** an image (or when only updating non-image fields), standard JSON can be used.

---

## 2.4 Cities API

---

### `GET /api/v1/cities`

**Description:** Returns a paginated list of all cities.
**Auth Required:** Yes · Permission: `view city`

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "per_page": 15,
        "total": 12,
        "last_page": 1,
        "data": [
            {
                "id": 1,
                "city_name": "Rajkot",
                "image": "uploads/cities/1680000001_abc123.jpg",
                "image_url": "http://10.0.2.2/uploads/cities/1680000001_abc123.jpg",
                "is_active": true,
                "created_at": "2026-04-03T05:39:19.000000Z"
            },
            {
                "id": 2,
                "city_name": "Surat",
                "image": null,
                "image_url": null,
                "is_active": true,
                "created_at": "2026-04-03T05:40:00.000000Z"
            }
        ]
    }
}
```

> **`image_url` field:** The backend must construct this as `config('app.url') . '/' . $city->image`. The Android app uses `image_url` directly with Glide/Coil for image loading. Never concatenate the base URL on the Android side.

---

### `POST /api/v1/cities`

**Description:** Creates a new city.
**Auth Required:** Yes · Permission: `add city`
**Content-Type:** `multipart/form-data` *(always, even without image)*

#### Request Body (multipart/form-data)
| Field | Type | Validation |
|---|---|---|
| `city_name` | string | required · max:255 · unique:cities,city_name |
| `image` | file | nullable · image · mimes:jpeg,png,jpg,webp · max:5MB |

#### Response — HTTP 201 Created ✅
```json
{
    "success": true,
    "message": "City added successfully!",
    "data": {
        "id": 13,
        "city_name": "Ahmedabad",
        "image": "uploads/cities/1712345678_xyz.jpg",
        "image_url": "http://10.0.2.2/uploads/cities/1712345678_xyz.jpg",
        "is_active": true,
        "created_at": "2026-04-06T10:30:00.000000Z"
    }
}
```

#### Response — HTTP 422 Validation Error ❌
```json
{
    "success": false,
    "message": "Validation failed.",
    "errors": {
        "city_name": ["The city name has already been taken."]
    }
}
```

---

### `GET /api/v1/cities/{id}`

**Description:** Returns a single city by ID.
**Auth Required:** Yes · Permission: `view city`

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "id": 1,
        "city_name": "Rajkot",
        "image": "uploads/cities/1680000001_abc123.jpg",
        "image_url": "http://10.0.2.2/uploads/cities/1680000001_abc123.jpg",
        "is_active": true,
        "created_at": "2026-04-03T05:39:19.000000Z"
    }
}
```

---

### `PUT /api/v1/cities/{id}`

**Description:** Updates an existing city.
**Auth Required:** Yes · Permission: `edit city`
**Content-Type:** `multipart/form-data`

> **⚠️ Important:** Android must send `PUT` via `POST` with a `_method=PUT` field for multipart. Retrofit handles this with `@Field("_method") method: String = "PUT"` or using `@POST` + `@FormUrlEncoded` with method spoofing.

#### Request Body (multipart/form-data)
| Field | Type | Validation |
|---|---|---|
| `city_name` | string | required · max:255 · unique:cities,city_name,{id} |
| `image` | file | nullable · image · mimes:jpeg,png,jpg,webp · max:5MB |
| `_method` | string | required · value: `"PUT"` |

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "message": "City updated successfully!",
    "data": {
        "id": 1,
        "city_name": "Rajkot Updated",
        "image": "uploads/cities/new_image.jpg",
        "image_url": "http://10.0.2.2/uploads/cities/new_image.jpg",
        "is_active": true
    }
}
```

---

### `DELETE /api/v1/cities/{id}`

**Description:** Soft-deletes a city. Will be blocked if the city has linked Hospitals.
**Auth Required:** Yes · Permission: `delete city`
**Content-Type:** `application/json`

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "message": "City deleted successfully!"
}
```

#### Response — HTTP 422 Business Logic Error ❌
```json
{
    "success": false,
    "message": "Cannot delete this City because it has linked Hospitals."
}
```

---

### `GET /api/v1/cities/dropdown`

**Description:** Returns a lightweight list of active cities for dropdown/spinner population in Add/Edit forms.
**Auth Required:** Yes

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": [
        { "id": 1, "city_name": "Rajkot" },
        { "id": 2, "city_name": "Surat" },
        { "id": 3, "city_name": "Ahmedabad" }
    ]
}
```

---

## 2.5 NGOs API

---

### `GET /api/v1/ngos`

**Auth Required:** Yes · Permission: `view ngo`

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "per_page": 15,
        "total": 9,
        "data": [
            {
                "id": 1,
                "city_id": 1,
                "name": "Goal Foundation",
                "contact": "9876543210",
                "email": "info@goalf.org",
                "address": "123 Main Street, Rajkot",
                "image": "uploads/ngos/1680000001.jpg",
                "image_url": "http://10.0.2.2/uploads/ngos/1680000001.jpg",
                "is_active": true,
                "city": {
                    "id": 1,
                    "city_name": "Rajkot"
                },
                "created_at": "2026-04-03T05:39:19.000000Z"
            }
        ]
    }
}
```

---

### `POST /api/v1/ngos`

**Auth Required:** Yes · Permission: `add ngo`
**Content-Type:** `multipart/form-data`

#### Request Fields
| Field | Type | Validation |
|---|---|---|
| `city_id` | integer | required · exists:cities,id |
| `name` | string | required · max:255 |
| `contact` | string | required · max:20 |
| `email` | string | nullable · email |
| `address` | string | nullable |
| `image` | file | nullable · image · mimes:jpeg,png,jpg,webp · max:5MB |

#### Response — HTTP 201 Created ✅
```json
{
    "success": true,
    "message": "NGO added successfully!",
    "data": {
        "id": 10,
        "city_id": 1,
        "name": "New NGO",
        "contact": "9800000001",
        "email": "new@ngo.org",
        "address": "456 Street, Rajkot",
        "image": null,
        "image_url": null,
        "is_active": true,
        "city": { "id": 1, "city_name": "Rajkot" }
    }
}
```

---

### `GET /api/v1/ngos/{id}` · `PUT /api/v1/ngos/{id}` · `DELETE /api/v1/ngos/{id}`

Follows the identical pattern as Cities. Delete blocked if NGO has linked hospitals.

---

## 2.6 Hospitals API

---

### `GET /api/v1/hospitals`

**Auth Required:** Yes · Permission: `view hospital`

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "per_page": 15,
        "total": 8,
        "data": [
            {
                "id": 1,
                "city_id": 1,
                "name": "City Civil Hospital",
                "contact": "9876543210",
                "email": "civil@hospital.gov.in",
                "address": "Civil Hospital Road, Rajkot",
                "login_pin": "4721",
                "rfid_start": "100",
                "rfid_end": "500",
                "net_quantity": 25,
                "image": "uploads/hospitals/1680000001.jpg",
                "image_url": "http://10.0.2.2/uploads/hospitals/1680000001.jpg",
                "is_active": true,
                "city": {
                    "id": 1,
                    "city_name": "Rajkot"
                },
                "created_at": "2026-04-03T07:05:17.000000Z"
            }
        ]
    }
}
```

---

### `POST /api/v1/hospitals`

**Auth Required:** Yes · Permission: `add hospital`
**Content-Type:** `multipart/form-data`

#### Request Fields
| Field | Type | Validation |
|---|---|---|
| `city_id` | integer | required · exists:cities,id |
| `name` | string | required · max:255 |
| `contact` | string | required · max:20 |
| `email` | string | nullable · email |
| `address` | string | nullable |
| `login_pin` | string | required · digits:4 |
| `rfid_start` | string | nullable |
| `rfid_end` | string | nullable |
| `net_quantity` | integer | required · min:0 |
| `image` | file | nullable · image · mimes:jpeg,png,jpg,webp · max:5MB |

#### Response — HTTP 201 Created ✅
```json
{
    "success": true,
    "message": "Hospital added successfully!",
    "data": {
        "id": 9,
        "city_id": 1,
        "name": "New Hospital",
        "contact": "9800000001",
        "email": null,
        "address": "789 Road, Rajkot",
        "login_pin": "1234",
        "rfid_start": "501",
        "rfid_end": "800",
        "net_quantity": 10,
        "image": null,
        "image_url": null,
        "is_active": true
    }
}
```

---

### `GET /api/v1/hospitals/dropdown`

Returns lightweight list for dropdown in Doctor/Vehicle/Staff add forms:

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": [
        { "id": 1, "name": "City Civil Hospital" },
        { "id": 2, "name": "Shree Health Center" }
    ]
}
```

---

## 2.7 Doctors API

---

### `GET /api/v1/doctors`

**Auth Required:** Yes · Permission: `view doctor`

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "per_page": 15,
        "total": 26,
        "data": [
            {
                "id": 1,
                "hospital_id": 1,
                "city_id": 1,
                "name": "Dr. Raisuddin Badi",
                "contact": "9876543210",
                "email": "dr.badi@hospital.com",
                "address": "Civil Hospital, Rajkot",
                "image": "uploads/doctors/1680000001.jpg",
                "image_url": "http://10.0.2.2/uploads/doctors/1680000001.jpg",
                "is_active": true,
                "hospital": {
                    "id": 1,
                    "name": "City Civil Hospital"
                },
                "city": {
                    "id": 1,
                    "city_name": "Rajkot"
                },
                "created_at": "2026-04-03T08:29:57.000000Z"
            }
        ]
    }
}
```

---

### `POST /api/v1/doctors`

**Auth Required:** Yes · Permission: `add doctor`
**Content-Type:** `multipart/form-data`

#### Request Fields
| Field | Type | Validation |
|---|---|---|
| `hospital_id` | integer | required · exists:hospitals,id |
| `city_id` | integer | required · exists:cities,id |
| `name` | string | required · max:255 |
| `contact` | string | required · max:20 |
| `email` | string | nullable · email |
| `address` | string | nullable |
| `image` | file | nullable · image · mimes:jpeg,png,jpg,webp · max:5MB |

#### Response — HTTP 201 Created ✅
```json
{
    "success": true,
    "message": "Doctor added successfully!",
    "data": {
        "id": 27,
        "hospital_id": 1,
        "city_id": 1,
        "name": "Dr. New Doctor",
        "contact": "9800000001",
        "email": "new@doc.com",
        "address": null,
        "image": null,
        "image_url": null,
        "is_active": true,
        "hospital": { "id": 1, "name": "City Civil Hospital" },
        "city": { "id": 1, "city_name": "Rajkot" }
    }
}
```

---

## 2.8 Vehicles API

---

### `GET /api/v1/vehicles`

**Auth Required:** Yes · Permission: `view vehicle`

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "per_page": 15,
        "total": 17,
        "data": [
            {
                "id": 1,
                "hospital_id": 1,
                "city_id": 1,
                "vehicle_number": "GJ-01-JT-2002",
                "login_id": "vehicle_gj01jt",
                "is_active": true,
                "hospital": {
                    "id": 1,
                    "name": "City Civil Hospital"
                },
                "city": {
                    "id": 1,
                    "city_name": "Rajkot"
                },
                "image": "uploads/vehicles/1680000001.jpg",
                "image_url": "http://10.0.2.2/uploads/vehicles/1680000001.jpg",
                "created_at": "2026-04-03T10:00:00.000000Z"
            }
        ]
    }
}
```

> **Security Note:** The `login_password` field is **never** returned in API responses. It is bcrypt-hashed in the database and excluded from all serialization.

---

### `POST /api/v1/vehicles`

**Auth Required:** Yes · Permission: `add vehicle`
**Content-Type:** `multipart/form-data`

#### Request Fields
| Field | Type | Validation |
|---|---|---|
| `hospital_id` | integer | required · exists:hospitals,id |
| `city_id` | integer | required · exists:cities,id |
| `vehicle_number` | string | required · max:20 · unique:vehicles,vehicle_number |
| `login_id` | string | required · max:100 · unique:vehicles,login_id |
| `login_password` | string | required · min:4 |
| `image` | file | nullable · image · mimes:jpeg,png,jpg,webp · max:5MB |

> **`login_password` on Edit:** When updating a vehicle, `login_password` is `nullable`. If left empty/blank in the Android form, the existing password is preserved. If filled, it is re-hashed and updated.

#### Response — HTTP 201 Created ✅
```json
{
    "success": true,
    "message": "Vehicle added successfully!",
    "data": {
        "id": 18,
        "hospital_id": 1,
        "city_id": 1,
        "vehicle_number": "GJ-05-AB-9999",
        "login_id": "vehicle_new_01",
        "is_active": true,
        "image": null,
        "image_url": null
    }
}
```

---

## 2.9 Global Toggle Status Endpoint (All Master Entities)

Each master data entity supports an active/inactive toggle. This maps to the `toggleStatus()` method in each existing controller.

```
POST /api/v1/{entity}/{id}/toggle-status
```

#### Examples
```
POST /api/v1/cities/1/toggle-status
POST /api/v1/hospitals/3/toggle-status
POST /api/v1/doctors/7/toggle-status
POST /api/v1/vehicles/2/toggle-status
POST /api/v1/ngos/4/toggle-status
```

#### Response — HTTP 200 OK ✅
```json
{
    "success": true,
    "message": "City status updated successfully!",
    "data": {
        "is_active": false
    }
}
```

> **Android UI:** Use this endpoint when the user toggles the `Switch`/`ChipGroup` on a list item or the detail screen. Update the list item state locally on success without a full list refresh.

---

## 2.10 HTTP Status Code Reference

| Code | Meaning | Android Action |
|---|---|---|
| `200 OK` | Success (GET, PUT, DELETE, toggle) | Parse `data`, update UI |
| `201 Created` | Success (POST create) | Parse `data`, add to list, show Snackbar |
| `401 Unauthorized` | Token expired or invalid | **MANDATORY:** Clear DataStore → LoginActivity |
| `403 Forbidden` | Permission denied | Show Snackbar: "Permission denied" |
| `404 Not Found` | Resource does not exist | Show error state in UI |
| `422 Unprocessable` | Validation or business logic error | Show field errors or Snackbar with `message` |
| `500 Server Error` | Internal server error | Show generic error dialog |

---

---

# Section 3: Figma UI/UX Blueprint (Sneat Theme Adaptation)

---

## 3.1 Design System Foundation

This section defines the **single source of truth** for all visual decisions in Figma. All colors, spacing, typography, and component styles must be created as **Figma Variables** and **Styles** before any screen is designed.

---

### 3.1.1 Color Palette

```
┌─────────────────────────────────────────────────────────┐
│                   COLOR TOKENS                          │
│                                                         │
│  PRIMARY (Sneat Indigo)                                 │
│  ├─ Primary-Main        #696cff   ← Buttons, FAB, Links│
│  ├─ Primary-Light       #e7e7ff   ← Chip backgrounds   │
│  ├─ Primary-Dark        #5558e3   ← Pressed state      │
│  └─ Primary-On          #ffffff   ← Text on primary    │
│                                                         │
│  NEUTRAL                                                │
│  ├─ Background          #f5f5f9   ← App background     │
│  ├─ Surface             #ffffff   ← Cards, bottom sheet│
│  ├─ Divider             #dbdade   ← List dividers      │
│  ├─ Border              #e7e7e8   ← Input borders      │
│  └─ Disabled            #b9b9b9   ← Disabled inputs    │
│                                                         │
│  TEXT                                                   │
│  ├─ Text-Primary        #566a7f   ← Body text          │
│  ├─ Text-Secondary      #8592a3   ← Subtitles, hints   │
│  ├─ Text-Heading        #333333   ← H1, H2, H3         │
│  └─ Text-On-Surface     #697a8d   ← Input text         │
│                                                         │
│  STATUS                                                 │
│  ├─ Success             #28c76f   ← Active badges       │
│  ├─ Success-Light       #e8f8ee   ← Success bg chip    │
│  ├─ Danger              #ea5455   ← Delete, errors      │
│  ├─ Danger-Light        #fce8e8   ← Error bg chip      │
│  ├─ Warning             #ff9f43   ← Warning states     │
│  ├─ Warning-Light       #fff3e5   ← Warning bg chip    │
│  ├─ Info                #00cfe8   ← Info states        │
│  └─ Info-Light          #e0f9fc   ← Info bg chip       │
│                                                         │
│  SIDEBAR (Sneat Dark Menu)                              │
│  ├─ Sidebar-BG          #2f3349   ← Sidebar background │
│  ├─ Sidebar-Text        #a3a4cc   ← Inactive menu item │
│  ├─ Sidebar-Active      #696cff   ← Active menu item   │
│  └─ Sidebar-Active-BG   #ffffff14 ← Active item pill   │
└─────────────────────────────────────────────────────────┘
```

---

### 3.1.2 Typography Scale

**Font Family:** `Public Sans` (Google Fonts — exactly matching the Sneat web theme)
**Fallback:** `Inter`, `Roboto`, `Sans-serif`

```
┌─────────────────────────────────────────────────────────┐
│                  TYPOGRAPHY TOKENS                      │
│                                                         │
│  Display / Hero                                         │
│  ├─ Display-Large    24sp · Weight 700 · #333333        │
│  └─ Display-Medium   20sp · Weight 600 · #333333        │
│                                                         │
│  Headline                                               │
│  ├─ Headline-Large   18sp · Weight 600 · #333333        │
│  └─ Headline-Medium  16sp · Weight 600 · #333333        │
│                                                         │
│  Title                                                  │
│  ├─ Title-Large      16sp · Weight 500 · #566a7f        │
│  └─ Title-Medium     14sp · Weight 500 · #566a7f        │
│                                                         │
│  Body                                                   │
│  ├─ Body-Large       15sp · Weight 400 · #566a7f        │
│  └─ Body-Medium      13sp · Weight 400 · #8592a3        │
│                                                         │
│  Label / Caption                                        │
│  ├─ Label-Large      12sp · Weight 600 · #697a8d        │
│  └─ Label-Small      11sp · Weight 400 · #8592a3        │
│                                                         │
│  Button                                                 │
│  └─ Button-Text      14sp · Weight 600 · UPPERCASE OFF  │
└─────────────────────────────────────────────────────────┘
```

---

### 3.1.3 Spacing & Grid System

```
Base Unit: 4dp

Spacing Scale:
  xs  =  4dp
  sm  =  8dp
  md  = 16dp
  lg  = 24dp
  xl  = 32dp
  2xl = 48dp

Screen Margins: 16dp (left & right)
Card Padding:   16dp (all sides)
List Item Height: 72dp (with image), 56dp (text only)
FAB Size: 56dp × 56dp
Bottom Nav Height: 64dp
Top AppBar Height: 56dp
```

---

### 3.1.4 Elevation & Shadows

```
Card Shadow:
  Offset: 0dp Y, 2dp Y
  Blur: 8dp
  Color: #00000014 (shadow-sm)

Bottom Sheet Shadow:
  Offset: 0dp Y, -4dp Y
  Blur: 16dp
  Color: #0000001a

FAB Shadow:
  Offset: 0dp Y, 4dp
  Blur: 12dp
  Color: #696cff40

Bottom Nav Shadow:
  Offset: 0dp Y, -1dp
  Blur: 4dp
  Color: #0000000f
```

---

### 3.1.5 Component Library (Define in Figma as reusable components)

| Component | Key Specs |
|---|---|
| **Primary Button** | BG: `#696cff` · Text: white · Corner: 8dp · Height: 48dp · Padding: 16dp H |
| **Outlined Button** | Border: `#696cff` 1dp · Text: `#696cff` · Corner: 8dp · Height: 48dp |
| **Danger Button** | BG: `#ea5455` · Text: white · Corner: 8dp · Height: 48dp |
| **Text Input** | Border: `#e7e7e8` 1dp · Corner: 8dp · Height: 52dp · Padding: 14dp |
| **Focused Input** | Border: `#696cff` 1.5dp · Label color: `#696cff` |
| **Error Input** | Border: `#ea5455` · Helper text: `#ea5455` |
| **Status Chip — Active** | BG: `#e8f8ee` · Text: `#28c76f` · Corner: 999dp · Padding: 4dp 10dp |
| **Status Chip — Inactive** | BG: `#fce8e8` · Text: `#ea5455` · Corner: 999dp |
| **Stat Card** | BG: white · Corner: 12dp · Shadow: sm · Padding: 16dp |
| **List Card** | BG: white · Corner: 12dp · Shadow: sm · Padding: 16dp |
| **FAB** | BG: `#696cff` · Icon: white · Size: 56dp · Corner: 16dp · Shadow: FAB |
| **Bottom Nav Item** | Icon: 24dp · Label: 11sp · Active: `#696cff` · Inactive: `#8592a3` |
| **Divider** | Height: 1dp · Color: `#dbdade` |
| **Snackbar** | BG: `#333333` · Text: white · Action: `#696cff` · Corner: 8dp |
| **Avatar Circle** | Size: 40dp · Corner: 999dp · BG: `#e7e7ff` |

---

## 3.2 Screen 1 — Login Screen

---

### Layout Architecture

```
┌────────────────────────────────────┐
│         STATUS BAR (transparent)   │
│                                     │
│         ████████████████           │
│            [LOGO IMAGE]            │  ← 120dp × 120dp · centered
│            Goal Foundation         │  ← Display-Large · #333333
│         Animal Birth Control       │  ← Body-Medium · #8592a3
│                                     │
│  ┌──────────────────────────────┐  │  ← Card · Corner: 20dp
│  │                              │  │    Padding: 24dp · Shadow: sm
│  │   Welcome Back 🐾            │  │  ← Title-Large · #333333
│  │   Sign in to continue        │  │  ← Body-Medium · #8592a3 · mb:24dp
│  │                              │  │
│  │   Email Address              │  │  ← Label-Large · #697a8d
│  │  ┌────────────────────────┐  │  │  ← Input · height: 52dp
│  │  │ 📧  email@goalf.org    │  │  │    Prefix icon: mail_outline
│  │  └────────────────────────┘  │  │
│  │                              │  │
│  │   Password                   │  │  ← Label-Large · #697a8d
│  │  ┌────────────────────────┐  │  │  ← Input · height: 52dp
│  │  │ 🔒  ••••••••          👁│  │  │    Prefix: lock · Suffix: eye toggle
│  │  └────────────────────────┘  │  │
│  │                              │  │
│  │   ☐ Remember Me              │  │  ← Checkbox + Label-Large
│  │                              │  │
│  │  ┌────────────────────────┐  │  │
│  │  │     SIGN IN            │  │  │  ← Primary Button · full width · 48dp
│  │  └────────────────────────┘  │  │    BG: #696cff · Loading spinner on submit
│  │                              │  │
│  └──────────────────────────────┘  │
│                                     │
│  Powered by IV Infotech             │  ← Label-Small · #8592a3 · centered
│                                     │
└────────────────────────────────────┘
```

### Interaction States
- **Default:** All inputs empty, Sign In button enabled.
- **Loading:** After tap, button shows `CircularProgressIndicator` (white, 20dp), button disabled, inputs disabled.
- **Error:** Input borders turn `#ea5455`, helper text appears below in `#ea5455`. Error message in a `Snackbar` at bottom.
- **Success:** Brief success animation (fade), navigate to Dashboard with `slideInRight` transition.

### Background Design
- Full screen gradient: Top `#f5f5f9` → Bottom `#eeeeff` (subtle Sneat purple tint).
- No background illustration — keep it clean and professional.

---

## 3.3 Screen 2 — Dashboard (Home Screen)

---

### Navigation Pattern
Use **Bottom Navigation** with 4 tabs (not a hamburger sidebar — mobile-first decision):

```
Bottom Navigation Bar:
Tab 1: 🏠  Home (Dashboard)
Tab 2: 🏙️  Cities
Tab 3: 🏥  Hospitals
Tab 4: ⋯   More (NGOs, Doctors, Vehicles in a sub-list)
```

### Layout Architecture

```
┌────────────────────────────────────┐
│  STATUS BAR                        │
├────────────────────────────────────┤
│ ≡  ABC Dashboard         🔔  👤   │  ← TopAppBar · BG: white · Shadow: sm
│    Goal Foundation               │  │    Title: Headline-Medium
├────────────────────────────────────┤
│                                    │
│  ┌──────────────────────────────┐  │  ← Hero welcome card
│  │  🐾  Good morning, Admin!    │  │    BG: gradient #696cff → #9c9eff
│  │  Here's your daily overview  │  │    Corner: 16dp · Padding: 20dp
│  │                              │  │    Text: white
│  │  ████████████████████████   │  │  ← Project overview bar (animated)
│  └──────────────────────────────┘  │
│                                    │
│  Master Data Overview              │  ← Section label · Label-Large · #697a8d
│                                    │
│  ┌───────────┐  ┌───────────┐     │  ← 2-column grid · gap: 12dp
│  │ 🏙️         │  │ 🤝         │     │
│  │    12      │  │    09      │     │  ← Stat value · Display-Large · #333333
│  │  Cities   │  │   NGOs    │     │  ← Label · Body-Medium · #8592a3
│  └───────────┘  └───────────┘     │
│                                    │
│  ┌───────────┐  ┌───────────┐     │
│  │ 🏥         │  │ 👨‍⚕️         │     │
│  │    08      │  │    26      │     │
│  │ Hospitals │  │  Doctors  │     │
│  └───────────┘  └───────────┘     │
│                                    │
│  ┌───────────┐  ┌───────────┐     │
│  │ 🚐         │  │ 👥         │     │
│  │    17      │  │    39      │     │
│  │ Vehicles  │  │   Staff   │     │
│  └───────────┘  └───────────┘     │
│                                    │
├────────────────────────────────────┤
│  🏠   🏙️   🏥   ⋯              │  ← Bottom Navigation · BG: white
└────────────────────────────────────┘
```

### Stat Card Specs (Figma Component)

```
Card:
  Width: (screen_width - 48dp) / 2   ← 2-column with 12dp gap and 16dp margins
  Height: 100dp
  Background: #ffffff
  Corner Radius: 12dp
  Shadow: 0 2dp 8dp #00000014
  Padding: 16dp

Icon Container:
  Size: 40dp × 40dp
  Corner: 10dp
  Background: #e7e7ff (Primary-Light)
  Icon Size: 22dp
  Icon Color: #696cff

Value Text:
  Font: Public Sans
  Size: 24sp
  Weight: 700
  Color: #333333

Label Text:
  Font: Public Sans
  Size: 12sp
  Weight: 400
  Color: #8592a3
  Margin Top: 2dp

Tap Effect:
  Ripple: #696cff1a
  On tap: Navigate to the relevant list screen (e.g., Cities list)
```

### Shimmer Loading State
While the `GET /api/v1/dashboard` call is in progress, show **skeleton shimmer** cards in the 2-column grid using a shimmer animation (animated gradient from `#f0f0f0` → `#e0e0e0` → `#f0f0f0`).

---

## 3.4 Screen 3 — Master Data List Screen (e.g., Hospital List)

This screen is **templated** — the same layout applies to Cities, NGOs, Hospitals, Doctors, and Vehicles. Only the data fields displayed per card differ.

---

### Layout Architecture

```
┌────────────────────────────────────┐
│  STATUS BAR                        │
├────────────────────────────────────┤
│ ←  Hospitals              🔍      │  ← TopAppBar · Back arrow + Search icon
├────────────────────────────────────┤
│                                    │
│  ┌─────────────────────────────┐  │  ← Filter chip row (horizontal scroll)
│  │ All  │ Active │ Inactive   │  │    BG: #e7e7ff · Corner: 999dp
│  └─────────────────────────────┘  │    Selected: #696cff · Text: white
│                                    │
│  ┌──────────────────────────────┐  │  ← List Card · margin: 16dp 0
│  │ ┌────┐  City Civil Hospital  │  │    ← Avatar/image 48dp × 48dp · Corner: 10dp
│  │ │ 🏥 │  Rajkot · 9876543210 │  │    Title: Title-Large · #333333
│  │ └────┘  ● Active            ⋮│  │    Subtitle: Body-Medium · #8592a3
│  └──────────────────────────────┘  │    Status chip · 3-dot menu icon
│                                    │
│  ┌──────────────────────────────┐  │
│  │ ┌────┐  Shree Health Center  │  │
│  │ │img │  Surat · 9800000001   │  │
│  │ └────┘  ○ Inactive          ⋮│  │
│  └──────────────────────────────┘  │
│                                    │
│  (RecyclerView — LinearLayout)     │
│  (Pull to Refresh enabled)         │
│                                    │
│                        ┌───────┐   │
│                        │  +    │   │  ← FAB · BG: #696cff · Corner: 16dp
│                        └───────┘   │    Tapping opens Add screen / BottomSheet
├────────────────────────────────────┤
│  🏠   🏙️   🏥   ⋯              │
└────────────────────────────────────┘
```

### List Card — Detailed Specs

```
Card Container:
  Margin: 16dp horizontal, 6dp vertical
  Background: #ffffff
  Corner: 12dp
  Shadow: 0 2dp 8dp #00000014
  Padding: 12dp 16dp

Avatar / Image:
  Size: 48dp × 48dp
  Corner: 10dp
  If image_url is null: Show placeholder icon (BG: #e7e7ff, Icon: #696cff)
  Load with Glide: .placeholder(R.drawable.ic_placeholder) .error(R.drawable.ic_error)

Content (Right of Avatar):
  Title: Title-Large (16sp, Weight 500, #333333)
  Subtitle Line 1: Body-Medium (13sp, #8592a3)  ← e.g. "City · Contact"
  Subtitle Line 2: Status Chip

Status Chip:
  Active:   BG #e8f8ee · Text #28c76f · "● Active"
  Inactive: BG #fce8e8 · Text #ea5455 · "○ Inactive"
  Size: 12sp · Padding: 3dp 8dp · Corner: 999dp

3-Dot Menu (PopupMenu):
  Options: "Edit", "Delete", "Toggle Status"
  "Delete" option text color: #ea5455
  Shown on: anchor to 3-dot icon button
```

### Swipe Actions (Alternative to 3-dot Menu — implement one or both)
```
Swipe Left → Reveal DELETE action
  BG: #ea5455 · Icon: delete_outline · Width: 80dp
  On release: Show confirmation AlertDialog before calling DELETE API

Swipe Right → Reveal EDIT action
  BG: #696cff · Icon: edit_outlined · Width: 80dp
  On release: Navigate to Edit screen / open BottomSheet with data pre-filled
```

### Empty State
```
When API returns empty list:
  ┌────────────────────┐
  │                    │
  │   [Empty icon]     │  ← 80dp icon · Color: #dbdade
  │   No Hospitals     │  ← Headline-Medium · #566a7f
  │  found yet.        │
  │  Tap + to add one  │  ← Body-Medium · #8592a3
  │                    │
  │  [+ ADD HOSPITAL]  │  ← Outlined button · BG transparent
  └────────────────────┘
```

### Error State
```
When API call fails (network error / server error):
  ┌────────────────────┐
  │  ⚠️                │
  │  Something went    │
  │  wrong.            │
  │  [RETRY]           │  ← Primary button → re-calls API
  └────────────────────┘
```

### Search Functionality
- Search icon in TopAppBar expands into a `SearchView`.
- Filter is applied locally (client-side) on the already-loaded list — no new API call.
- Filter on: `name`, `city.city_name`, `contact`.

---

## 3.5 Screen 4 — Add / Edit Form (BottomSheet or Full Screen Activity)

---

### Pattern Decision
| Pattern | When to Use |
|---|---|
| **ModalBottomSheet** | Simple forms with 3–4 fields (e.g., City: just `city_name` + `image`) |
| **Full-screen Activity** | Complex forms with 6+ fields (e.g., Hospital: 8 fields; Doctor: 7 fields) |

---

### Layout Architecture — ModalBottomSheet (City Add/Edit)

```
┌────────────────────────────────────┐
│                                    │
│            ━━━━━━━━━━━             │  ← Drag handle · #dbdade · 4dp × 32dp
│                                    │
│  Add New City                      │  ← Headline-Medium · #333333
│                                    │
│  ──────────────────────────────   │  ← Divider
│                                    │
│  City Name *                       │  ← Label-Large
│  ┌──────────────────────────────┐  │
│  │  Enter city name             │  │  ← TextInputLayout · Outlined style
│  └──────────────────────────────┘  │    Corner: 8dp · Error: #ea5455
│                                    │
│  City Image                        │  ← Label-Large
│  ┌──────────────────────────────┐  │
│  │  ┌─────────┐                 │  │
│  │  │    +    │  Tap to upload  │  │  ← Image placeholder · dashed border
│  │  │  image  │  PNG, JPG < 5MB │  │    BG: #f5f5f9 · Border: #dbdade dashed
│  │  └─────────┘                 │  │    Corner: 8dp · height: 120dp
│  └──────────────────────────────┘  │    After selection: shows thumbnail preview
│                                    │    with ✕ remove button overlay
│  ┌──────────────────────────────┐  │
│  │       SAVE CITY              │  │  ← Primary Button · full width · STICKY BOTTOM
│  └──────────────────────────────┘  │    BG: #696cff · Height: 52dp · Corner: 10dp
└────────────────────────────────────┘
```

---

### Layout Architecture — Full-Screen Activity (Hospital Add/Edit)

```
┌────────────────────────────────────┐
│  STATUS BAR                        │
├────────────────────────────────────┤
│ ←  Add Hospital                   │  ← TopAppBar · BG: white
├────────────────────────────────────┤
│                                    │
│  (Scrollable content below)        │
│                                    │
│  ──── Hospital Image ────         │  ← Section label
│  ┌──────────────────────────────┐  │
│  │  ┌───────────────────────┐  │  │  ← ImageView · 120dp height
│  │  │  [ TAP TO ADD PHOTO ] │  │  │    dashed border · Corner: 12dp
│  │  └───────────────────────┘  │  │    After upload: show full-width preview
│  └──────────────────────────────┘  │    + ✕ remove button (top-right)
│                                    │
│  ──── Basic Information ───       │
│                                    │
│  Hospital Name *                   │
│  ┌──────────────────────────────┐  │
│  │  Enter hospital name         │  │
│  └──────────────────────────────┘  │
│                                    │
│  City *                            │
│  ┌──────────────────────────────┐  │  ← ExposedDropdownMenu (Material Spinner)
│  │  Select City              ▼  │  │    Populated from GET /api/v1/cities/dropdown
│  └──────────────────────────────┘  │
│                                    │
│  Contact Number *                  │
│  ┌──────────────────────────────┐  │
│  │  📞  9876543210              │  │  ← InputType: phone
│  └──────────────────────────────┘  │
│                                    │
│  Email Address                     │
│  ┌──────────────────────────────┐  │
│  │  ✉️  email@hospital.com      │  │  ← InputType: email · nullable
│  └──────────────────────────────┘  │
│                                    │
│  ──── Login & RFID ─────         │
│                                    │
│  Hospital PIN *                    │  ← Helper: "4-digit numeric PIN"
│  ┌──────────────────────────────┐  │
│  │  ••••                        │  │  ← InputType: numberPassword · maxLength: 4
│  └──────────────────────────────┘  │
│                                    │
│  RFID Tag Start                    │
│  ┌──────────────────────────────┐  │
│  │  100                         │  │
│  └──────────────────────────────┘  │
│                                    │
│  RFID Tag End                      │
│  ┌──────────────────────────────┐  │
│  │  500                         │  │
│  └──────────────────────────────┘  │
│                                    │
│  Net Quantity (Catching Nets) *    │
│  ┌──────────────────────────────┐  │
│  │  25                          │  │  ← InputType: number · default: 0
│  └──────────────────────────────┘  │
│                                    │
│  Address                           │
│  ┌──────────────────────────────┐  │
│  │                              │  │  ← Multi-line · min 3 lines
│  │                              │  │    InputType: text|textMultiLine
│  └──────────────────────────────┘  │
│                                    │
│                                    │
├────────────────────────────────────┤
│  ┌──────────────────────────────┐  │  ← STICKY BOTTOM BUTTON
│  │     SAVE HOSPITAL            │  │    Elevation: 8dp · BG: white (parent)
│  └──────────────────────────────┘  │    Button: Primary full-width · 52dp
└────────────────────────────────────┘
```

---

### Form Validation States (Figma — Design All States)

```
Default State:
  Border: #e7e7e8 · 1dp
  Label: #697a8d · 14sp
  Input text: #333333

Focused State:
  Border: #696cff · 1.5dp
  Label: #696cff · 12sp (floats above)
  Cursor: #696cff

Error State:
  Border: #ea5455 · 1.5dp
  Label: #ea5455
  Helper text below: "This field is required." · #ea5455 · 12sp

Success/Valid State:
  Border: #28c76f · 1dp (optional — apply after blur if valid)

Disabled State:
  BG: #f5f5f9
  Border: #e7e7e8 · dashed
  Text: #b9b9b9
```

---

### Image Upload Component (Figma States)

```
State 1 — Empty / Default:
  ┌─────────────────────────────┐
  │   ╔═══════════════════╗    │
  │   ║  📷               ║    │  ← dashed border #dbdade
  │   ║  Tap to add photo  ║    │     Corner: 12dp · BG: #f5f5f9
  │   ║  PNG, JPG < 5MB    ║    │     Icon: add_photo_alternate · #8592a3
  │   ╚═══════════════════╝    │
  └─────────────────────────────┘

State 2 — Image Selected / Preview:
  ┌─────────────────────────────┐
  │  ┌───────────────────┐ ✕   │  ← ✕ button: 24dp · BG: #ea5455 · top-right
  │  │                   │     │
  │  │  [preview image]  │     │  ← Fills the container · ObjectFit: COVER
  │  │                   │     │     Corner: 12dp
  │  └───────────────────┘     │
  └─────────────────────────────┘

State 3 — Uploading:
  ┌─────────────────────────────┐
  │   ╔═══════════════════╗    │
  │   ║  ↻  Uploading...  ║    │  ← CircularProgressIndicator · #696cff
  │   ╚═══════════════════╝    │
  └─────────────────────────────┘
```

---

### Save Button — Sticky Bottom Pattern

```
Footer Container:
  BG: #ffffff
  Elevation: 8dp (shadow above)
  Padding: 12dp 16dp
  Height: 76dp (button + safe area inset)

Button:
  Full width (match_parent with 16dp margin each side)
  Height: 52dp
  Corner: 10dp
  BG: #696cff
  Text: "SAVE HOSPITAL" · 14sp · Weight 600 · white · NO ALL CAPS
  Loading state: replace text with white CircularProgressIndicator (20dp)
  Disabled state: BG #b9b9b9 (when form has errors or loading)
```

---

## 3.6 Screen 5 — Navigation Drawer / "More" Tab

For the "More" (⋯) bottom nav tab, show a list of additional modules:

```
┌────────────────────────────────────┐
│ ←  More                           │  ← TopAppBar
├────────────────────────────────────┤
│                                    │
│  ┌──────────────────────────────┐  │  ← Section card
│  │  🤝  NGOs               ›   │  │    Title-Large · #333333
│  └──────────────────────────────┘  │    Subtitle: "9 active NGOs" · #8592a3
│                                    │
│  ┌──────────────────────────────┐  │
│  │  👨‍⚕️  Doctors              ›  │  │
│  └──────────────────────────────┘  │
│                                    │
│  ┌──────────────────────────────┐  │
│  │  🚐  Vehicles               ›  │  │
│  └──────────────────────────────┘  │
│                                    │
│  ────── Settings ──────────       │  ← Divider + Section label
│                                    │
│  ┌──────────────────────────────┐  │
│  │  👤  My Profile            ›   │  │
│  └──────────────────────────────┘  │
│                                    │
│  ┌──────────────────────────────┐  │
│  │  🚪  Logout                  │  │  ← Text: #ea5455 (danger color)
│  └──────────────────────────────┘  │
│                                    │
├────────────────────────────────────┤
│  🏠   🏙️   🏥   ⋯              │
└────────────────────────────────────┘
```

---

## 3.7 Figma File Structure (Recommended Frame Organization)

```
ABC Project — Android UI
├── 📁 00 - Design System
│   ├── Colors          (all color tokens as Figma Variables)
│   ├── Typography      (all text styles)
│   ├── Spacing         (spacing tokens)
│   └── Components      (all reusable components)
│
├── 📁 01 - Flows
│   ├── Auth Flow       (Splash → Login → Dashboard)
│   └── Master Data Flow (Dashboard → List → Add/Edit → Back)
│
├── 📁 02 - Screens
│   ├── 01_Splash
│   ├── 02_Login
│   ├── 03_Dashboard
│   ├── 04_City_List
│   ├── 05_City_Add_BottomSheet
│   ├── 06_NGO_List
│   ├── 07_NGO_Add_Full
│   ├── 08_Hospital_List
│   ├── 09_Hospital_Add_Full
│   ├── 10_Doctor_List
│   ├── 11_Doctor_Add_Full
│   ├── 12_Vehicle_List
│   ├── 13_Vehicle_Add_Full
│   └── 14_More_Screen
│
├── 📁 03 - States
│   ├── Loading (Shimmer)
│   ├── Empty State
│   ├── Error State
│   └── Form Validation States
│
└── 📁 04 - Handoff
    ├── Annotated screens
    └── Developer spec notes
```

---

## 3.8 Android Project Technology Stack Recommendations

| Layer | Recommendation | Reason |
|---|---|---|
| **Language** | Kotlin | Modern, concise, coroutine support |
| **Architecture** | MVVM + Repository | Separation of concerns, testable |
| **HTTP Client** | Retrofit 2 + OkHttp | Industry standard, works perfectly with Sanctum |
| **JSON Parsing** | Gson or Moshi | Moshi preferred for null safety |
| **Image Loading** | Coil (Kotlin-native) | Better than Glide for Kotlin projects |
| **Async** | Coroutines + Flow | Native Kotlin, integrates with ViewModel |
| **State Management** | StateFlow + LiveData | ViewModel lifecycle awareness |
| **Local Storage** | DataStore Preferences | Replaces SharedPreferences |
| **DI Framework** | Hilt | Official Google DI, minimal boilerplate |
| **Navigation** | Navigation Component | Bottom nav + BottomSheet integration |
| **UI Components** | Material Design 3 | Matches Sneat theme system |
| **Pagination** | Paging 3 Library | For large master data lists |
| **Multipart Upload** | OkHttp MultipartBody | Direct file upload to API |
| **Min SDK** | 24 (Android 7.0) | ~94% device coverage |

---

## 3.9 Handoff Notes for Android Developer

### Priority Build Order (Prototype Scope)

```
Sprint 1 (Foundation):
  ✅ Setup Retrofit + OkHttp + DataStore
  ✅ Implement Login screen + POST /api/v1/login
  ✅ Implement token storage + 401 auto-logout interceptor
  ✅ Implement Dashboard screen + GET /api/v1/dashboard

Sprint 2 (Master Data Read):
  ✅ Cities list + GET /api/v1/cities
  ✅ Hospitals list + GET /api/v1/hospitals
  ✅ Doctors list + GET /api/v1/doctors
  ✅ Vehicles list + GET /api/v1/vehicles
  ✅ NGOs list + GET /api/v1/ngos

Sprint 3 (Master Data Write):
  ✅ City Add/Edit BottomSheet (POST + PUT /api/v1/cities)
  ✅ Hospital Add/Edit Full Screen (POST + PUT /api/v1/hospitals)
  ✅ Doctor Add Full Screen (POST + PUT /api/v1/doctors)
  ✅ Vehicle Add Full Screen (POST + PUT /api/v1/vehicles)
  ✅ NGO Add Full Screen (POST + PUT /api/v1/ngos)
  ✅ Delete confirmations + DELETE endpoints for all
```

### Method Spoofing for Multipart PUT
Laravel requires `POST` for multipart requests. To simulate `PUT`, send `_method=PUT` as a form field:

```kotlin
@Multipart
@POST("api/v1/hospitals/{id}")
suspend fun updateHospital(
    @Path("id") id: Int,
    @Part("_method") method: RequestBody = "PUT".toRequestBody(),
    @Part("name") name: RequestBody,
    // ... other fields
    @Part image: MultipartBody.Part?
): Response<ApiResponse<HospitalModel>>
```

### Null Image Handling
If `image_url` is `null` in the API response, show a placeholder drawable:
```kotlin
Coil:
imageView.load(hospital.imageUrl) {
    placeholder(R.drawable.ic_hospital_placeholder)
    error(R.drawable.ic_hospital_placeholder)
    transformations(RoundedCornersTransformation(24f))
}
```

### Dropdown Population Sequence
For forms with dependent dropdowns (e.g., Hospital form needs cities):
1. Call `GET /api/v1/cities/dropdown` when the form opens.
2. Show `CircularProgressIndicator` in the dropdown while loading.
3. Populate `ExposedDropdownMenuAdapter` on success.
4. On Edit mode: pre-select the existing `city_id` after the dropdown is populated.

---

## 3.10 Handoff Notes for Figma Designer

1. **Import Public Sans** into Figma via Google Fonts plugin before starting any design work.
2. **Create all colors as Figma Variables** (not just styles) to enable dark mode prototyping later.
3. **Every component must have all states designed:** Default, Focused, Error, Disabled, Loading. Use Figma's Component Variants for this.
4. **Use Auto Layout** on all components — this ensures frames are developer-friendly and resize correctly across screen widths.
5. **Frame size:** Use 390 × 844dp (iPhone 14 Pro size — industry standard for prototypes regardless of platform) and then export specs at 360 × 800dp (standard Android medium phone).
6. **All icons:** Use Material Symbols (Rounded) — available as a Figma plugin. This matches Material Design 3 which the Android developer will use.
7. **Annotate edge cases explicitly:** Empty states, error states, permission-denied states.
8. **Use Figma's Inspect panel** to export all spacing, colors, and corner radii — the Android developer will reference this directly.

---

*End of Document*

---

> **Version History**
> | Version | Date | Author | Changes |
> |---|---|---|---|
> | V1.0 | April 2026 | AI Architect | Initial release — Prototype scope |

