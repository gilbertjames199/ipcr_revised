<?php

use App\Http\Controllers\FileHandleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImportDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\GovernmentController;
use App\Http\Controllers\EconomicController;
use App\Http\Controllers\ForbiddenController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\IPCRTargetsController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\SocialInclusionController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\UserEmployeesController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageMail;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

Auth::routes(['verify'=>true]);
/*
Route::get('/email', function(){
    Mail::to('email@email.com')->send(new MessageMail());
    return new MessageMail();
});
*/
Route::middleware('auth')->group(function() {
    Route::prefix('/')->group(function() {
        Route::get('/', [DashBoardController::class, 'index']);
    });

    //Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('/home')->group(function() {
        Route::get('/', [DashBoardController::class, 'index']);
    });
    //FORBIDDEN PAGE
    Route::prefix('/forbidden')->group(function() {
        Route::get('/', [ForbiddenController::class, 'index']);
    });
    //Users
    Route::prefix('/users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->can('create', 'App\Model\User');
        Route::post('/', [UserController::class, 'store']);
        Route::get('/create', [UserController::class, 'create'])->can('create', 'App\Model\User');
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::patch('/{id}', [UserController::class, 'update']);
        Route::patch('/update_verified_at', [UserController::class, 'update_verified_at']);
        Route::get('/change-password', [UserController::class, 'changePassword']);
        Route::post('/update-password', [UserController::class, 'updatePassword']);
        Route::get('/settings', [UserController::class, 'settings']);
        Route::post('/change-name', [UserController::class, 'changeName']);
        Route::post('/change-photo', [UserController::class, 'changePhoto']);
        Route::post('user-permissions', [UserController::class, 'userPermissions']);
        Route::get('/update-permissions', [UserController::class, 'updatePermissions']);
        Route::post('/get-barangays', [UserController::class, 'getBarangays']);
        Route::post('/get-puroks', [UserController::class, 'getPuroks']);
    });
    //IPCR TARGETS
    Route::prefix('/ipcrtargets')->group(function() {
        Route::get('/{id}', [IPCRTargetsController::class, 'index']);
        Route::get('/create/{id}', [IPCRTargetsController::class, 'create']);
    });
    //Employees
    Route::prefix('/employees')->group(function() {
        Route::get('/', [UserEmployeesController::class, 'index']);
    });

    //Avatar file upload
    Route::post('/files/upload', [FileHandleController::class, 'uploadAvatar']);
    Route::delete('/files/upload/delete', [FileHandleController::class, 'destroyAvatar']);
});
