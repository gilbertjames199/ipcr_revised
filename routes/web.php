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
use App\Http\Controllers\HealthController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\SocialInclusionController;
use App\Http\Controllers\TimeSheetController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageMail;
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
    //Education
    Route::prefix('/education')->group(function() {
        Route::get('/elementary', [EducationController::class, 'index_elem']);
        Route::get('/juniorhigh', [EducationController::class, 'index_junior']);
        Route::get('/seniorhigh', [EducationController::class, 'index_senior']);
        Route::get('/college', [EducationController::class, 'index_college']);
        Route::get('/osy', [EducationController::class, 'index_osy']);
    });

    //Governance
    Route::prefix('/governance')->group(function() {
        Route::get('/registeredvoters', [GovernmentController::class, 'index_registeredvoters']);
        Route::get('/unregisteredvoters', [GovernmentController::class, 'index_unregisteredvoters']);
        Route::get('/organizations', [GovernmentController::class, 'index_organizations']);
    });

    //Time Sheets
    Route::prefix('/timesheets')->group(function() {
        Route::get('/', [TimeSheetController::class, 'index']);
        Route::get('/new', [TimeSheetController::class, 'new']);
    });
    
    //Economic Activity
    Route::prefix('/economic')->group(function() {
        Route::get('/working', [EconomicController::class, 'index_working']);
        Route::get('/jobseekers', [EconomicController::class, 'index_job']);
    });

    //Health and Nutrition
    Route::prefix('/health')->group(function() {
        Route::get('/philhealth', [HealthController::class, 'index_philhealth']);
        Route::get('/soloparents', [HealthController::class, 'index_solo']);
        Route::get('/pwd', [HealthController::class, 'index_disability']);
        Route::get('/disease', [HealthController::class, 'index_disease']);
        Route::get('/tobacco', [HealthController::class, 'index_tobacco']);
        Route::get('/women', [HealthController::class, 'index_women']);
    });

    //Peace
    Route::prefix('/peace_and_security')->group(function() {
        Route::get('/crime_victims', [OtherController::class, 'index_crim']);
    });

    //Active Citizenship
    Route::prefix('/active_citizenship')->group(function() {
        Route::get('/volunteer_key_area', [OtherController::class, 'index_active']);
    });

    //Environment
    Route::prefix('/environment')->group(function() {
        Route::get('/volunteers', [OtherController::class, 'index_env']);
    });

    //Disaster
    Route::prefix('/disaster')->group(function() {
        Route::get('/skills_training', [OtherController::class, 'index_dist']);
    });

    //Access to Programs and Services
    Route::prefix('/programs')->group(function() {
        Route::get('/services', [OtherController::class, 'index_prog']);
    });

    //Information and Community
    Route::prefix('/information')->group(function() {
        Route::get('/community', [OtherController::class, 'index_info']);
    });

    //Concern
    Route::prefix('/concern')->group(function() {
        Route::get('/need', [OtherController::class, 'index_concern']);
    });

    //Social Inclusion
    Route::prefix('/social')->group(function(){
        Route::get('/ip', [SocialInclusionController::class,'index_ip']);
        Route::get('/muslim', [SocialInclusionController::class, 'index_muslim']);
        Route::get('/ofw', [SocialInclusionController::class, 'index_ofw']);
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

    //Personnel
    Route::prefix('/personnel')->group(function(){
        Route::get('/', function(){
            return Inertia::render('Personnel/Load',[
                'can' => [
                    'createUser' => Auth::user()->can('create', User::class),
                    'editUser' =>Auth::user()->can('edit', User::class),
                    'deleteUser' =>Auth::user()->can('delete', User::class),
                    'canViewUsers' =>Auth::user()->can('can_view_users', User::class),
                    'canInsertUsers' =>Auth::user()->can('can_insert_users', User::class),
                    'canEditUsers' =>Auth::user()->can('can_edit_users', User::class),
                    'canDeleteUsers' =>Auth::user()->can('can_delete_users', User::class),
                    'canUpdateUserPermissions' =>Auth::user()->can('can_update_user_permissions', User::class),
                ]
            ]);
        });
        Route::post('/all', [UserController::class, 'getPersonnel']);
    });
    
    Route::prefix('/imports')->group(function() {
        /*Route::get('/', function () {
            dd('createUser: '.Auth::user()->can('create', User::class).' user_id: '.Auth::user()->id);
            return Inertia::render('Imports/Index', [
                "can" => [
                    'createUser' => Auth::user()->can('create', User::class),
                    'editUser' =>Auth::user()->can('edit', User::class),
                    'deleteUser' =>Auth::user()->can('delete', User::class),
                ],
            ]);
        });*/
        Route::get('/', [ImportDataController::class, 'showIndexPage']);
        Route::post('/import-excel', [ImportDataController::class, 'importAllData']);
        Route::get('/reports', [ReportController::class, 'index']);
    });

    //Charts
    Route::prefix('/charts')->group(function() {
        Route::get('/out', function () {
            return Inertia::render('Charts/ChartEducationOut', 
                [
                    'users'=>User::query()
                        ->paginate(10)
                        ->withQueryString()
                        ->through(fn($user) =>[
                            'id' => $user->id,
                            'name' => $user->name,
                            'can' => [
                                'createUser' => Auth::user()->can('create', User::class),
                                'editUser' =>Auth::user()->can('edit', User::class),
                                'deleteUser' =>Auth::user()->can('delete', User::class),
                                'canViewUsers' =>Auth::user()->can('can_view_users', User::class),
                                'canInsertUsers' =>Auth::user()->can('can_insert_users', User::class),
                                'canEditUsers' =>Auth::user()->can('can_edit_users', User::class),
                                'canDeleteUsers' =>Auth::user()->can('can_delete_users', User::class),
                                'canUpdateUserPermissions' =>Auth::user()->can('can_update_user_permissions', User::class),
                            ]
                        ]),
                    'can' => [
                        'createUser' => Auth::user()->can('create', User::class),
                        'editUser' =>Auth::user()->can('edit', User::class),
                        'deleteUser' =>Auth::user()->can('delete', User::class),
                        'canViewUsers' =>Auth::user()->can('can_view_users', User::class),
                        'canInsertUsers' =>Auth::user()->can('can_insert_users', User::class),
                        'canEditUsers' =>Auth::user()->can('can_edit_users', User::class),
                        'canDeleteUsers' =>Auth::user()->can('can_delete_users', User::class),
                        'canUpdateUserPermissions' =>Auth::user()->can('can_update_user_permissions', User::class),
                    ]
                ]);
            
        });
        Route::get('/emp', function () {
            return Inertia::render('Charts/ChartYouthEmployment',
                [
                    'can' => [
                        'createUser' => Auth::user()->can('create', User::class),
                        'editUser' =>Auth::user()->can('edit', User::class),
                        'deleteUser' =>Auth::user()->can('delete', User::class),
                        'canViewUsers' =>Auth::user()->can('can_view_users', User::class),
                        'canInsertUsers' =>Auth::user()->can('can_insert_users', User::class),
                        'canEditUsers' =>Auth::user()->can('can_edit_users', User::class),
                        'canDeleteUsers' =>Auth::user()->can('can_delete_users', User::class),
                        'canUpdateUserPermissions' =>Auth::user()->can('can_update_user_permissions', User::class),
                    ]
                ]
                
            );
        });
    });
    
    //Avatar file upload
    Route::post('/files/upload', [FileHandleController::class, 'uploadAvatar']);
    Route::delete('/files/upload/delete', [FileHandleController::class, 'destroyAvatar']);
});
