<?php

use App\Http\Controllers\DailyAccomplishmentController;
use App\Http\Controllers\AccomplishmentController;
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
use App\Http\Controllers\IndividualFinalOutputController;
use App\Http\Controllers\IpcrProbTempoTargetController;
use App\Http\Controllers\IpcrScoreController;
use App\Http\Controllers\IpcrSemestralController;
use App\Http\Controllers\IPCRTargetsController;
use App\Http\Controllers\MonthlyAccomplishmentController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\PerformanceStandardController;
use App\Http\Controllers\ProbationaryTemporaryController;
use App\Http\Controllers\ProbationaryTemporaryEmployeesController;
use App\Http\Controllers\ProbTempoEmployeesController;
use App\Http\Controllers\ReturnRemarksController;
use App\Http\Controllers\ReviewApproveController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SemestralAccomplishmentController;
use App\Http\Controllers\SocialInclusionController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\UserEmployeesController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageMail;
use App\Models\IndividualFinalOutput;
use App\Models\IpcrProbTempoTarget;
use App\Models\IPCRTargets;
use App\Models\ProbationaryTemporaryEmployees;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

Auth::routes(['verify' => true]);
/*
Route::get('/email', function(){
    Mail::to('email@email.com')->send(new MessageMail());
    return new MessageMail();
});
*/
Route::middleware('auth')->group(function () {
    Route::prefix('/')->group(function () {
        Route::get('/', [DashBoardController::class, 'index']);
    });

    //Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('/home')->group(function () {
        Route::get('/', [DashBoardController::class, 'index']);
    });
    //FORBIDDEN PAGE
    Route::prefix('/forbidden')->group(function () {
        Route::get('/', [ForbiddenController::class, 'index']);
    });
    //Users
    Route::prefix('/users')->group(function () {
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
    Route::prefix('/ipcrtargets')->group(function () {
        ///get/ipcr/targets
        Route::get('/{id}', [IPCRTargetsController::class, 'index']);
        Route::get('/create/{id}', [IPCRTargetsController::class, 'create']);
        Route::get('/get/ipcr/targets', [IPCRTargetsController::class, 'review_ipcr']);
        Route::post('/store/{id}', [IPCRTargetsController::class, 'store']);
        Route::get('/edit/{id}', [IPCRTargetsController::class, 'edit']);
        Route::patch('/{id}', [IPCRTargetsController::class, 'update']);
        Route::delete('/{id}/{empl_id}/delete', [IPCRTargetsController::class, 'destroy']);
        Route::get('/get/ipcr/targets/2', [IPCRTargetsController::class, 'review_ipcr2']);

        ///ipcrtargets/create/${id}/additional
        Route::get('/create/{id}/additional/ipcr/targets', [IPCRTargetsController::class, 'additional_create']);
        Route::post('/store/{id}/additional/ipcr/targets/store', [IPCRTargetsController::class, 'additional_store']);
    });
    Route::prefix('/ipcrtargetsreview')->group(function () {
        Route::post('/{id}/{source}/{id_sem}', [IPCRTargetsController::class, 'ipcrtargets_review']);
        Route::post('/targetid/{id_target}/status/{target_status}', [IPCRTargetsController::class, 'ipcrtargets_update_status']);
    });
    Route::prefix('/fetch/data')->group(function () {
        Route::post('/major/final/outputs', [IndividualFinalOutputController::class, 'get_mfos']);
        Route::post('/sub/mfos', [IndividualFinalOutputController::class, 'get_submfos']);
        Route::post('/division/div-outputs', [IndividualFinalOutputController::class, 'get_div_output']);
    });
    //IPCR SEMESTRAL TARGETS
    Route::prefix('/ipcrsemestral')->group(function () {
        Route::get('/{id}/{source}', [IpcrSemestralController::class, 'index']);
        Route::get('/create/{id}/{source}', [IpcrSemestralController::class, 'create']);
        Route::post('/store/{id}', [IpcrSemestralController::class, 'store']);
        Route::get('/edit/{id}/{source}/ipcr', [IpcrSemestralController::class, 'edit']);
        // Route::get('/edit/{id}', [IPCRTargetsController::class, 'edit']);
        // /ipcrsemestral/submit/" + ipcr_id +'/'+this.source
        Route::patch('/update/{id}', [IpcrSemestralController::class, 'update']);
        Route::delete('/delete/{id}/{source}', [IpcrSemestralController::class, 'destroy']);
        Route::post('/submit/{id}/{source}', [IpcrSemestralController::class, 'submission']);
        ///ipcrsemestral/FROM/" + this.ipcr_id_copied + "/TO/" + this.ipcr_id_passed
        Route::post('/FROM/{ipcr_id_copied}/TO/{ipcr_id_passed}', [IpcrSemestralController::class, 'copyIpcr']);
    });
    //FOR REVIEW/APPROVAL
    Route::prefix('review/approve')->group(function () {
        Route::get('/', [ReviewApproveController::class, 'index']);
        Route::post('/{status}/{sem_id}', [ReviewApproveController::class, 'updateStatus']);
        Route::post('/{status}/{sem_id}/probationary', [ReviewApproveController::class, 'updateStatusProb']);
    });
    //FOR REVIEW/APPROVAL OF MONTHLY ACCOMPLISHMENTS
    Route::prefix('approve/accomplishments')->group(function () {
        Route::get('/', [MonthlyAccomplishmentController::class, 'approve_monthly']);
        Route::get('/get/specific/accomplishment/and/target', [MonthlyAccomplishmentController::class, 'specific_accomplishment']);
        Route::post('/{status}/{acc_id}', [MonthlyAccomplishmentController::class, 'updateStatusAccomp']);
        Route::get('/kobo/humanitarian/response/application/program/interface', [MonthlyAccomplishmentController::class, 'api_kobo']);
        // Route::post('/{status}/{sem_id}', [ReviewApproveController::class, 'updateStatus']);
        // Route::post('/{status}/{sem_id}/probationary', [ReviewApproveController::class, 'updateStatusProb']);
    });
    //FOR REVIEW/APPROVAL OF SEMESTRAL ACCOMPLISHMENTS
    Route::prefix('approve/semestral-accomplishments')->group(function () {
        Route::get('/', [SemestralAccomplishmentController::class, 'approve_monthly']);
        Route::get('/get/specific/accomplishment/and/target', [SemestralAccomplishmentController::class, 'specific_accomplishment']);
        Route::post('/{status}/{acc_id}', [SemestralAccomplishmentController::class, 'updateStatusAccomp']);
        Route::get('/kobo/humanitarian/response/application/program/interface', [SemestralAccomplishmentController::class, 'api_kobo']);
        // Route::post('/{status}/{sem_id}', [ReviewApproveController::class, 'updateStatus']);
        // Route::post('/{status}/{sem_id}/probationary', [ReviewApproveController::class, 'updateStatusProb']);
    });
    //Employees
    Route::prefix('/employees')->group(function () {
        Route::get('/', [UserEmployeesController::class, 'index']);
        Route::get('/all', [UserEmployeesController::class, 'all_employees']);
        Route::post('/all/reset/passwpord/{id}', [UserEmployeesController::class, 'resetpass']);
        // this.$inertia.post("/employees/all/reset/passwpord")
    });
    //Probationary/Temporary Employees
    Route::prefix('/probationary/temporary')->group(function () {
        // Route::get('/', [ProbTempoEmployeesController::class, 'index']);
        // Route::get('/create', [ProbTempoEmployeesController::class, 'create']);
        // Route::post('/store', [ProbTempoEmployeesController::class, 'store']);
        // Route::get('/{id}/edit', [ProbTempoEmployeesController::class, 'edit']);
        // Route::patch('/update/{id}', [ProbTempoEmployeesController::class, 'update']);
        // Route::delete('/delete/{id}', [ProbTempoEmployeesController::class, 'destroy']);
        Route::get('/individual/targets/list', [ProbationaryTemporaryEmployeesController::class, 'individual']);
    });
    //Probationary
    Route::prefix('/probationary')->group(function () {
        Route::get('/', [ProbationaryTemporaryEmployeesController::class, 'index']);
        Route::get('/create', [ProbationaryTemporaryEmployeesController::class, 'create']);
        Route::post('/store', [ProbationaryTemporaryEmployeesController::class, 'store']);
        Route::get('/{id}/edit', [ProbationaryTemporaryEmployeesController::class, 'edit']);
        Route::patch('/update/{id}', [ProbationaryTemporaryEmployeesController::class, 'update']);
        Route::delete('/delete/{id}', [ProbationaryTemporaryEmployeesController::class, 'destroy']);
        // Route::get('/individual/targets/list', [ProbTempoEmployeesController::class, 'individual']);
    });
    //Probationary /Temporary Employees' Targets
    Route::prefix('/prob/individual/targets')->group(function () {
        Route::get('/{id}', [IpcrProbTempoTargetController::class, 'index']);
        Route::get('/create/{id}', [IpcrProbTempoTargetController::class, 'create']);
        Route::post('/store/{id}', [IpcrProbTempoTargetController::class, 'store']);
        Route::get('/{id}/edit/{probid}', [IpcrProbTempoTargetController::class, 'edit']);
        Route::patch('/update/{id}', [IpcrProbTempoTargetController::class, 'update']);
        Route::delete('/delete/{id}', [IpcrProbTempoTargetController::class, 'destroy']);
        Route::get('/submit/target/{id}', [IpcrProbTempoTargetController::class, 'submit']);
        //
        // Route::patch('/update/{id}', [ProbTempoEmployeesController::class, 'update']);
        // Route::delete('/delete/{id}', [ProbTempoEmployeesController::class, 'destroy']);
        // Route::get('/individual/targets/list', [ProbTempoEmployeesController::class, 'individual']);
    });
    //Daily Accomplishment
    Route::prefix('/Daily_Accomplishment')->group(function () {
        Route::get('/', [DailyAccomplishmentController::class, 'index']);
        Route::get('/create', [DailyAccomplishmentController::class, 'create']);
        Route::post('/store', [DailyAccomplishmentController::class, 'store']);
        Route::get('/{id}/edit', [DailyAccomplishmentController::class, 'edit']);
        Route::patch('/{id}', [DailyAccomplishmentController::class, 'update']);
        Route::delete('/{id}', [DailyAccomplishmentController::class, 'destroy']);
        Route::post('/ipcr_code', [DailyAccomplishmentController::class, 'ipcr_code']);
    });
    //IPCR Targets -Daily Accomplishment
    Route::prefix('/IPCR-Targets/Daily_Accomplishment')->group(function () {
        Route::get('/{id}', [DailyAccomplishmentController::class, 'index_target']);
    });
    //Monthly Accomplishment
    Route::prefix('/monthly-accomplishment')->group(function () {
        //semestral_monthly
        Route::get('/', [AccomplishmentController::class, 'semestral_monthly']);
        Route::get('/submit/monthly/accomplishment/{id}', [AccomplishmentController::class, 'submit_monthly']);
        //Generate Monthly accomplishment for all IPCR Semestrals
        Route::get('/generate/monthly', [AccomplishmentController::class, 'generate_monthly_accomplishment']);
        Route::post('/store', [AccomplishmentController::class, 'store']);
        Route::patch('/{id}', [AccomplishmentController::class, 'update']);
        Route::delete('/{id}', [AccomplishmentController::class, 'destroy']);
    });
    Route::prefix('/new-submission/accomplishment')->group(function () {
        Route::get('/monthly', [AccomplishmentController::class, 'get_this_monthly']);
    });


    //Semester Accomplishment
    Route::prefix('/semester-accomplishment')->group(function () {
        //semestral_monthly
        // Route::get('/', [SemesterController::class, 'semestral']);
        Route::get('/semestral/accomplishment/{id}', [SemesterController::class, 'semestral']);
        Route::post('/get-time-ranges', [SemesterController::class, 'getTimeRanges']);
        Route::post('/submit/ipcr/semestral/{id}', [SemesterController::class, 'submitAccomplishment']);
        Route::post('/store', [SemesterController::class, 'store']);
        Route::patch('/{id}', [SemesterController::class, 'update']);
        Route::delete('/{id}', [SemesterController::class, 'destroy']);
    });
    Route::prefix('/Accomplishment')->group(function () {
        Route::get('/', [AccomplishmentController::class, 'index']);
    });
    //Return
    Route::prefix('/return')->group(function () {
        Route::post('/remarks', [ReturnRemarksController::class, 'returnRemarks']);
        Route::post('/accomplishments/remarks', [ReturnRemarksController::class, 'returnRemarksAccomplishments']);
    });
    //Performance Standard
    Route::prefix('/imports')->group(function () {
        Route::get('/performance/standard', [PerformanceStandardController::class, 'import_performance_standard']);
        Route::post('/performance/standard/upload', [PerformanceStandardController::class, 'upload_performance_standard']);
    });
    //Avatar file upload
    Route::post('/files/upload', [FileHandleController::class, 'uploadAvatar']);
    Route::delete('/files/upload/delete', [FileHandleController::class, 'destroyAvatar']);
    //IPCR Score
    Route::prefix('/ipcr/score')->group(function () {
        Route::get('/', [IpcrScoreController::class, 'index']);
        Route::post('/import', [IpcrScoreController::class, 'import']);
    });
    //IPCR CRUD
    Route::prefix('/individual-final-output-crud')->group(function () {
        Route::get('/', [IndividualFinalOutputController::class, 'index']);
        Route::get('/create', [IndividualFinalOutputController::class, 'create']);
        Route::post('/store', [IndividualFinalOutputController::class, 'store']);
        Route::get('/{id}/edit', [IndividualFinalOutputController::class, 'edit']);
        Route::patch('/update/{id}', [IndividualFinalOutputController::class, 'update']);
        Route::delete('/delete/{id}', [IndividualFinalOutputController::class, 'destroy']);
    });
});


Route::prefix('/PDA')->group(function () {
    Route::get('/Print', [DailyAccomplishmentController::class, 'UserEmployee']);
});

Route::prefix('/monthly')->group(function () {
    Route::get('/IPCR', [AccomplishmentController::class, 'MonthlyPrint']);
    Route::get('/Print/types', [AccomplishmentController::class, 'MonthlyPrintTypes']);
    Route::get('/IPCR/main', [AccomplishmentController::class, 'MonthlyPrintMain']);
    Route::get('/IPCR/main/types', [AccomplishmentController::class, 'MonthlyPrintMainTypes']);
});

Route::prefix('target/print')->group(function () {
    Route::get('/types', [IPCRTargetsController::class, 'target_types']);
    Route::get('/types/IPCR', [IPCRTargetsController::class, 'get_ipcr_targets']);
});


Route::prefix('semester/print')->group(function () {
    Route::get('/semester/first', [SemesterController::class, 'semester_print']);
    Route::get('/semester/secondPrint', [SemesterController::class, 'semester_print_score']);
});
Route::prefix('/ipcr-code')->group(function () {
    Route::get('/', [SemesterController::class, 'api_ipcr']);
});

Route::prefix('/Daily_Accomplishment')->group(function () {
    Route::get('/api', [DailyAccomplishmentController::class, 'store_api']);
});
