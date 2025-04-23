<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollaboratorsController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RhManagementContoller;
use App\Http\Controllers\RhUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // email confrimation and password definition
    Route::get('/confim-account/{url}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
    Route::post('/confim-account}', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', 'home');
    Route::get('/home', function () {
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.home');
        } else if (auth()->user()->role == 'rh') {
            return redirect()->route('rhcollaborators.managementHome');
        } else {
            return redirect()->route('collaborator');
        }
    })->name('home');

    //user profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile/update-password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::put('/user/profile/update-user-data', [ProfileController::class, 'changeUserData'])->name('change.userdata');
    Route::put('/user/profile/update-user-address', [ProfileController::class, 'changeUserAddress'])->name('change.useraddress');

    //departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new-department', [DepartmentController::class, 'newDepartment'])->name('new.department');
    Route::post('/department/store-new-department', [DepartmentController::class, 'storeDepartment'])->name('store.department');
    Route::get('/department/edit-department/{id}', [DepartmentController::class, 'editDepartment'])->name('edit.department');
    Route::put('/department/update-department', [DepartmentController::class, 'updateDapartment'])->name('update.department');
    Route::get('/department/delete-department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('delete.department');
    Route::get('/department/delete-department-confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('delete.department.confirm');

    // RH colaborators routes
    Route::get('/rhcollaborators', [RhUserController::class, 'index'])->name('rhcollaborators');
    Route::get('/rhcollaborators/new-collaborator', [RhUserController::class, 'newCollaborator'])->name('rhcollaborators.new-collaborator');
    Route::post('/rhcollaborators/create-collaborator', [RhUserController::class, 'createCollaborator'])->name('rhcollaborators.create-collaborator');
    Route::get('/rhcollaborators/edit-collaborator/{id}', [RhUserController::class, 'editRhCollaborator'])->name('rhcollaborators.edit-collaborator');
    Route::put('/rhcollaborators/update-collaborator', [RhUserController::class, 'updateRhCollaborator'])->name('rhcollaborators.update-collaborator');
    Route::get('/rhcollaborators/delete-collaborator/{id}', [RhUserController::class, 'deleteRhCollaborator'])->name('rhcollaborators.delete-collaborator');
    Route::get('/rhcollaborators/delete-collaborator-confirm/{id}', [RhUserController::class, 'deleteRhCollaboratorConfirm'])->name('rhcollaborators.delete-collaborator-confirm');
    Route::get('/rhcollaborators/restore/{id}', [RhUserController::class, 'restoreRhCollaborator'])->name('rhcollaborators.restore');

    // RH management routes
    Route::get('/rhcollaborators/management/home', [RhManagementContoller::class, 'home'])->name('rhcollaborators.managementHome');
    Route::get('/rhcollaborators/management/new-collaborator', [RhManagementContoller::class, 'newCollaborator'])->name('rhcollaborators.newCollaborator');
    Route::post('/rhcollaborators/management/store-collaborator', [RhManagementContoller::class, 'storeCollaborator'])->name('rhcollaborators.storeCollaborator');
    Route::get('/rhcollaborators/management/edit-collaborator/{id}', [RhManagementContoller::class, 'editCollaborator'])->name('rhcollaborators.editCollaborator');
    Route::put('/rhcollaborators/management/update-collaborator', [RhManagementContoller::class, 'updateCollaborator'])->name('rhcollaborators.updateCollaborator');
    Route::get('/rhcollaborators/management/show-collaborator-details/{id}', [RhManagementContoller::class, 'showCollaboratorDetails'])->name('rhcollaborators.showCollaboratorDetails');
    Route::get('/rhcollaborators/management/delete-collaborator/{id}', [RhManagementContoller::class, 'deleteCollaborator'])->name('rhcollaborators.deleteCollaborator');
    Route::get('/rhcollaborators/management/delete-collaborator-confirm/{id}', [RhManagementContoller::class, 'deleteCollaboratorConfirm'])->name('rhcollaborators.deleteCollaboratorConfirm');
    Route::get('/rhcollaborators/management/restore-collaborator/{id}', [RhManagementContoller::class, 'restoreCollaborator'])->name('rhcollaborators.restoreCollaborator');

    // Admin collaborators
    Route::get('/collaborators', [CollaboratorsController::class, 'index'])->name('all-collaborators');
    Route::get('/collaborators/details/{id}', [CollaboratorsController::class, 'showDetails'])->name('collaborators-details');
    Route::get('/collaborators/delete/{id}', [CollaboratorsController::class, 'deleteCollaborator'])->name('collaborators-delete');
    Route::get('/collaborators/delete-confirm/{id}', [CollaboratorsController::class, 'deleteCollaboratorConfirm'])->name('collaborators-delete-confirm');
    Route::get('/collaborators/restore/{id}', [CollaboratorsController::class, 'restoreCollaborator'])->name('collaborators.restore');

    // admin routes
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

    // collaborator routes
    Route::get('/collaborator', [CollaboratorsController::class, 'home'])->name('collaborator');
});
