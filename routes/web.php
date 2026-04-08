<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ArvStaffController;
use App\Http\Controllers\Admin\BillMasterController;
use App\Http\Controllers\Admin\CatchingStaffController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\MedicareController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\NgoController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // todaycatchlist routes
    Route::get('/today-catch-list', function () {
        return view('admin.todaycatchlist.todays_catch_list');
    })->name('today-catch-list');

    Route::get('/dog-catching-list', function () {
        return view('admin.todaycatchlist.dog_catching_list');
    })->name('dog-catching-list');

    Route::get('/view-catch', function () {
        return view('admin.todaycatchlist.view_catch');
    })->name('view-catch');

    // completedoperationlist routes
    Route::get('/completed-operation-list', function () {
        return view('admin.completeoperationlist.completed_operation_list');
    })->name('completed-operation-list');

    Route::get('/complete-list', function () {
        return view('admin.completeoperationlist.complete_list');
    })->name('complete-list');

    Route::get('/view-completed-operation', function () {
        return view('admin.completeoperationlist.view_completed_operation');
    })->name('view-completed-operation');

    // project routes
    Route::get('/manage-project', function () {
        return view('admin.project.manage_project');
    })->name('manage-project');

    Route::get('/add-project', function () {
        return view('admin.project.add_project');
    })->name('add-project');

    Route::get('/view-project', function () {
        return view('admin.project.view_project');
    })->name('view-project');

    // arv dog list routes
    Route::get('/manage-arv', function () {
        return view('admin.arvdoglist.manage_arv');
    })->name('manage-arv');

    Route::get('/add-arv', function () {
        return view('admin.arvdoglist.add_arv');
    })->name('add-arv');

    // catching staff routes
    Route::post('/manage-catching-staff/{id}/toggle-status', [CatchingStaffController::class, 'toggleStatus'])->name('manage-catching-staff.toggle-status');
    Route::resource('manage-catching-staff', CatchingStaffController::class);

    Route::get('/add-bill', function () {
        return view('admin.bill.add_bill');
    })->name('add-bill');

    Route::get('/view-bill', function () {
        return view('admin.bill.view_bill');
    })->name('view-bill');

    // dogcatchinglist routes
    Route::get('/manage-dog-catcher', function () {
        return view('admin.dogcathchinglist.dog_catcher');
    })->name('manage-dog-catcher');

    Route::get('/add-dog-catcher', function () {
        return view('admin.dogcathchinglist.add_dog_catcher');
    })->name('add-dog-catcher');

    Route::get('/catched-dog-list', function () {
        return view('admin.dogcathchinglist.catched_dog_list');
    })->name('catched-dog-list');

    Route::get('/view-catching-staff', function () {
        return view('admin.dogcathchinglist.view_catching_staff');
    })->name('view-catching-staff');

    // catchprocess routes
    Route::get('/manage-catch-process', function () {
        return view('admin.catchprocess.catch_process');
    })->name('manage-catch-process');

    // dieddoglist routes
    Route::get('/expired-dog-list', function () {
        return view('admin.dieddoglist.expired_dog_list');
    })->name('expired-dog-list');

    Route::get('/dispose-pending-dog-list', function () {
        return view('admin.dieddoglist.dispose_pending_dog_list');
    })->name('dispose-pending-dog-list');

    Route::get('/total-expired-dog-list', function () {
        return view('admin.dieddoglist.total_expired_dog_list');
    })->name('total-expired-dog-list');

    Route::get('/view-expired-dog-list', function () {
        return view('admin.dieddoglist.view_total_expired_dog');
    })->name('view-expired-dog-list');

    Route::get('/view-expired-dog', function () {
        return view('admin.dieddoglist.view_expired_dog_list');
    })->name('view-expired-dog');

    // r4rdoglist routes
    Route::get('/R4R-operation-list', function () {
        return view('admin.r4rdoglist.R4R_operation_list');
    })->name('R4R-operation-list');

    Route::get('/manage-r4r-dog-list', function () {
        return view('admin.r4rdoglist.r4r_dog_list');
    })->name('manage-r4r-dog-list');

    Route::get('/view-r4r-dog', function () {
        return view('admin.r4rdoglist.view_r4r_dog');
    })->name('view-r4r-dog');

    Route::get('/view-r4r-operation-list', function () {
        return view('admin.r4rdoglist.view_r4r_operation_list');
    })->name('view-r4r-operation-list');

    // completed operatioon dog list routes
    Route::get('/manage-completed-operation-dog-list', function () {
        return view('admin.completedoperationdoglist.completed_operation_dog_list');
    })->name('manage-completed-operation-dog-list');

    Route::get('/view-completed-operation-dog-list', function () {
        return view('admin.completedoperationdoglist.view_completed_operation_dog_list');
    })->name('view-completed-operation-dog-list');

    // daily running sheet routes
    Route::get('/daily-running-sheet', function () {
        return view('admin.dailyrunnigsheet.daily_running_sheet');
    })->name('daily-running-sheet');

    // observation dog list routes
    Route::get('/manage-observation-dog-list', function () {
        return view('admin.observationdoglist.observation_dog_list');
    })->name('manage-observation-dog-list');

    Route::get('/view-observation-dog-list', function () {
        return view('admin.observationdoglist.view_observation_dog');
    })->name('view-observation-dog-list');

    // processdoglist routes
    Route::get('/manage-process-dog-list', function () {
        return view('admin.processdoglist.process_dog_list');
    })->name('manage-process-dog-list');

    // projectsummary routes
    Route::get('/project-summary', function () {
        return view('admin.projectsummary.project_summary');
    })->name('project-summary');

    // recevidoglist routes
    Route::get('/manage-received-dog-list', function () {
        return view('admin.recevidoglist.received_dog_list');
    })->name('manage-received-dog-list');

    // rejected_dog_list routes
    Route::get('/rejected-dog-list', function () {
        return view('admin.rejecteddoglist.rejected_dog_list');
    })->name('rejected-dog-list');

    Route::get('/view-total-rejected-dog-list', function () {
        return view('admin.rejecteddoglist.view_total_reject_dog_list');
    })->name('view-total-rejected-dog-list');

    Route::get('/total-rejected-dog-list', function () {
        return view('admin.rejecteddoglist.total_rejected_dog_list');
    })->name('total-rejected-dog-list');

    Route::get('/api/cities', [CityController::class, 'apiList'])->name('cities.api');
    Route::get('/api/bill-masters', [BillMasterController::class, 'apiList']);
    Route::get('/api/arv-staff', [ArvStaffController::class, 'apiList']);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/basic', [SettingController::class, 'saveBasic'])->name('settings.basic');
    Route::post('/settings/sms', [SettingController::class, 'saveSms'])->name('settings.sms');
    Route::resource('roles', RoleController::class)->except(['create', 'show', 'edit']);
    Route::post('/roles/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggle-status');
    Route::resource('permissions', PermissionController::class)->except(['create', 'show', 'edit']);
    Route::resource('manage-city', CityController::class)
        ->except(['create', 'show', 'edit'])
        ->parameters(['manage-city' => 'id'])
        ->names(['index' => 'manage-city']);
    Route::patch('/manage-city/{id}/toggle-status', [CityController::class, 'toggleStatus'])->name('manage-city.toggle-status');
    Route::resource('manage-hospital', HospitalController::class)
        ->except(['show'])
        ->parameters(['manage-hospital' => 'id']);
    Route::get('/view-hospital/{id}', [HospitalController::class, 'show'])->name('view-hospital');
    Route::post('/manage-hospital/{id}/toggle-status', [HospitalController::class, 'toggleStatus'])->name('manage-hospital.toggle-status');
    Route::resource('manage-doctor', DoctorController::class)
        ->parameters(['manage-doctor' => 'id']);
    Route::post('/manage-doctor/{id}/toggle-status', [DoctorController::class, 'toggleStatus'])->name('manage-doctor.toggle-status');
    Route::resource('manage-arv-staff', ArvStaffController::class);
    Route::post('/manage-arv-staff/{id}/toggle-status', [ArvStaffController::class, 'toggleStatus'])->name('manage-arv-staff.toggle-status');
    Route::resource('manage-bill-master', BillMasterController::class);
    Route::post('/manage-bill-master/{id}/toggle-status', [BillMasterController::class, 'toggleStatus'])->name('manage-bill-master.toggle-status');
    Route::resource('manage-medicare', MedicareController::class);
    Route::post('/manage-medicare/{id}/toggle-status', [MedicareController::class, 'toggleStatus'])->name('manage-medicare.toggle-status');
    Route::resource('manage-medicine', MedicineController::class);
    Route::post('/manage-medicine/{id}/toggle-status', [MedicineController::class, 'toggleStatus'])->name('manage-medicine.toggle-status');
    Route::resource('manage-vehicle', VehicleController::class);
    Route::post('/manage-vehicle/{id}/toggle-status', [VehicleController::class, 'toggleStatus'])->name('manage-vehicle.toggle-status');

    // --- Temporary Routes for Staff Master UI Preview ---
    Route::get('/manage-staff-preview', function () {
        return view('admin.staff.manage_staff');
    });
    Route::get('/add-staff-preview', function () {
        return view('admin.staff.add_edit_staff');
    });
    // ----------------------------------------------------

    Route::resource('manage-ngo', NgoController::class)
        ->except(['create', 'store', 'show'])
        ->parameters(['manage-ngo' => 'id'])
        ->names(['index' => 'manage-ngo']);
    Route::patch('/manage-ngo/{id}/toggle-status', [NgoController::class, 'toggleStatus'])->name('manage-ngo.toggle-status');
    Route::get('/add-ngo', [NgoController::class, 'create'])->name('add-ngo');
    Route::post('/add-ngo', [NgoController::class, 'store'])->name('add-ngo.store');
    Route::get('/view-ngo/{id}', [NgoController::class, 'show'])->name('view-ngo');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
