<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CrimeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route Admin Register, Login, and Logout Functions
Route::get('/register_admin', [AdminController::class, 'showRegistrationForm'])->name('showRegistrationForm');
Route::post('/admin_register', [AdminController::class, 'adminRegister']);
Route::get('/login_admin', [AdminController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/admin_login', [AdminController::class, 'adminLogin']);
Route::post('/admin_logout', [AdminController::class, 'adminLogout'])->name('admin.logout');

// Route Admin Webpage (Protected by admin auth middleware)
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/homepage', [DashboardController::class, 'displayRecently'])->name('displayRecently');
    Route::get('/user_dash', [DashboardController::class, 'displayUser'])->name('displayUser');
    Route::get('/crime_dash', [DashboardController::class, 'displayCrime'])->name('displayCrime');
    Route::get('/crime_chart', function () {
        return view('admin_page/charts');
    });
    Route::get('/contacts', [DashboardController::class, 'displayContacts'])->name('displayContacts');
    Route::get('/pending_report', [DashboardController::class, 'displayPendingCrime'])->name('displayPendingCrime');
    Route::get('/crime_map', function () {
        return view('admin_page/map');
    });
    Route::get('/admin_pf', function () {
        $admins = [];
        if (auth()->check()) {
            $admins = auth()->user();
        }
        return view('admin_page/profile', ['admins' => $admins]);
    });
        Route::get('/addcrimetype', [DashboardController::class, 'addCrimeType'])->name('addCrimeType');
        Route::post('/crimetype', [DashboardController::class, 'storeCrimeType'])->name('storeCrimeType');
        Route::get('/showcrimetype', [DashboardController::class, 'showCrimeType'])->name('displayCrimeType');

    // Delete, Edit, and Confirm Function
    Route::delete('/deleteCrimetype/{id}', [DashboardController::class, 'deleteCrimetype'])->name('deleteCrimetype');
    Route::delete('/delete_user/{user}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::delete('/delete_crime/{crime}', [CrimeController::class, 'deleteCrime'])->name('deleteCrime');

    Route::get('/crimes_edit/{crime}', [CrimeController::class, 'crimeEdit'])->name('crimeEdit');
    Route::put('/crimes_update/{crime}', [CrimeController::class, 'update'])->name('crimes.update');
    Route::put('/users_update/{user}', [UserController::class, 'update'])->name('users.update');

    Route::post('/confirm_pending_crime/{crime_pending}', [CrimeController::class, 'approvePendingCrime'])->name('approvePendingCrime');
    Route::delete('/delete_pending_crime/{crime_pending}', [CrimeController::class, 'deletePendingCrime'])->name('deletePendingCrime');
    Route::delete('/delete_contact/{contact}', [ContactController::class, 'deleteContact'])->name('deleteContact');
});

    