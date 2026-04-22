<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin']);
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

        // Staff management routes
        Route::get('/staff', [\App\Http\Controllers\Admin\StaffController::class, 'index'])->name('admin.staff.index');
        Route::get('/staff/create', [\App\Http\Controllers\Admin\StaffController::class, 'create'])->name('admin.staff.create');
        Route::post('/staff', [\App\Http\Controllers\Admin\StaffController::class, 'store'])->name('admin.staff.store');
        Route::get('/staff/{staff}', [\App\Http\Controllers\Admin\StaffController::class, 'edit'])->name('admin.staff.edit');
        Route::put('/staff/{staff}', [\App\Http\Controllers\Admin\StaffController::class, 'update'])->name('admin.staff.update');
        Route::delete('/staff/{staff}', [\App\Http\Controllers\Admin\StaffController::class, 'destroy'])->name('admin.staff.destroy');

        // Tasks management routes
        Route::get('/tasks', [\App\Http\Controllers\Admin\TaskController::class, 'index'])->name('admin.tasks.index');
        Route::post('/tasks/{task}/toggle-lock', [\App\Http\Controllers\Admin\TaskController::class, 'toggleLock'])->name('admin.tasks.toggle-lock');

        // Reports routes
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    });
});

// Staff routes
Route::prefix('staff')->group(function () {
    Route::get('/login', [AuthController::class, 'showStaffLogin'])->name('staff.login');
    Route::post('/login', [AuthController::class, 'staffLogin']);
    Route::post('/logout', [AuthController::class, 'staffLogout'])->name('staff.logout');
    
    Route::middleware('auth:staff')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
        
        // Task CRUD routes
        Route::resource('tasks', \App\Http\Controllers\Staff\TaskController::class)->names([
            'index' => 'staff.tasks.index',
            'create' => 'staff.tasks.create',
            'store' => 'staff.tasks.store',
            'show' => 'staff.tasks.show',
            'edit' => 'staff.tasks.edit',
            'update' => 'staff.tasks.update',
            'destroy' => 'staff.tasks.destroy',
        ]);
        
        // Task status update route
        Route::post('/tasks/{task}/update-status', [\App\Http\Controllers\Staff\TaskController::class, 'updateStatus'])->name('staff.tasks.update-status');
    });
});
