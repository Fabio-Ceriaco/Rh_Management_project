<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::redirect('/', 'home');
    Route::view('/home', 'home')->name('home');

    //user profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile/update-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::put('/user/profile/update-user-data', [ProfileController::class, 'changeUserData'])->name('change.userdata');

    //departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new-department', [DepartmentController::class, 'newDepartment'])->name('new.department');
    Route::post('/department/store-new-department', [DepartmentController::class, 'storeDepartment'])->name('store.department');
});
