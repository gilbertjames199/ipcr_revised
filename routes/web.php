<?php

use App\Http\Controllers\DailyAccomplishmentController;
use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ChangeLogController;
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
use App\Http\Controllers\EmployeeSpecialDepartmentController;
use App\Http\Controllers\ForbiddenController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\IndividualFinalOutputController;
use App\Http\Controllers\InvalidLinkController;
use App\Http\Controllers\IpcrProbTempoTargetController;
use App\Http\Controllers\IpcrScoreController;
use App\Http\Controllers\IpcrSemestralController;
use App\Http\Controllers\IpcrTargetController;
use App\Http\Controllers\IpcrTargetNewController;
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
use App\Http\Controllers\SummaryOfRatingController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\UserEmployeesController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageMail;
use App\Models\EmployeeSpecialDepartment;
use App\Models\IndividualFinalOutput;
use App\Models\IpcrProbTempoTarget;
use App\Models\IpcrTarget;
use App\Models\IPCRTargets;
use App\Models\ProbationaryTemporaryEmployees;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Lab404\Impersonate\Controllers\ImpersonateController;

Auth::routes(['verify' => true]);
/*
Route::get('/email', function(){
    Mail::to('email@email.com')->send(new MessageMail());
    return new MessageMail();
});
*/
//************************************* */
// Route::middleware(['validate-reset-token'])->group(function () {
//     Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
//         ->name('password.reset');
//     Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
// });
Route::get('invalid-reset-link', [InvalidLinkController::class, 'index'])
    ->name('invalid-reset-link');
//*********************************** */
Route::middleware(['auth', 'check.default.password'])->group(function () {
    Route::prefix('/')->group(function () {
        Route::get('/', [DashBoardController::class, 'index']);
    });

    Route::impersonate();

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
    //IPCR Targets New
    Route::prefix('/ipcrtargets/r')->group(function () {
        ///get/ipcr/targets
        Route::get('/{slug}', [IpcrTargetController::class, 'index']);
        Route::get('/create/{slug}', [IpcrTargetController::class, 'create']);
        Route::post('/store/{id}', [IpcrTargetController::class, 'store']);
        Route::get('/get/ipcr/targets', [IpcrTargetController::class, 'review_ipcr']);
        Route::get('/edit/{slug}/{slug_sem}', [IpcrTargetController::class, 'edit']);
        Route::patch('/{id}', [IpcrTargetController::class, 'update']);
        Route::delete('/{id}/{slug}/delete', [IpcrTargetController::class, 'destroy']);
        Route::get('/get/ipcr/targets/2', [IPCRTargetsController::class, 'review_ipcr2']);
        // '/ipcrtargetsreview/targetid/{id_target}/status/{target_status}
        ///ipcrtargets/create/${id}/
        // /ipcrtargets/get/ipcr/targets
        Route::get('/create/{slug}/additional/ipcr/targets', [IpcrTargetController::class, 'additional_create']);
        Route::post('/store/{id}/additional/ipcr/targets/store', [IPCRTargetsController::class, 'additional_store']);
        // /ipcrtargets/recall/" + id_target + "/additional/ipcr/targets/" + ipcr_id
        Route::post('/recall/{id_target}/additional/ipcr/targets/{ipcr_id}', [IPCRTargetsController::class, 'additional_recall']);
    });
    //IPXR Target Review
    // /ipcrtargetsreview/targetid/" + id_target + '/status/' + target_status
    Route::prefix('/ipcrtargetsreview/r')->group(function () {
        Route::post('/{id}/{source}/{id_sem}', [IpcrTargetController::class, 'ipcrtargets_review']);
        Route::post('/targetid/{id_target}/status/{target_status}', [IpcrTargetController::class, 'ipcrtargets_update_status']);
        Route::delete('/delete/{id}/{source}/{id_sem}', [IpcrTargetController::class, 'destroy_additional_taget']);
        Route::post('/recall/my/target/{source}/{id_sem}', [IPCRTargetsController::class, 'recall']);
    });
    // Route::prefix('/ipcrtargetsreview')->group(function () {
    //IPCR TARGETS
    Route::prefix('/ipcrtargets')->group(function () {
        ///get/ipcr/targets
        Route::get('/{id}', [IPCRTargetsController::class, 'index']);
        Route::get('/create/{slug}', [IPCRTargetsController::class, 'create']);
        Route::get('/get/ipcr/targets', [IPCRTargetsController::class, 'review_ipcr']);
        Route::post('/store/{id}', [IPCRTargetsController::class, 'store']);
        Route::get('/edit/{id}', [IPCRTargetsController::class, 'edit']);
        Route::patch('/{id}', [IPCRTargetsController::class, 'update']);
        Route::delete('/{id}/{empl_id}/delete', [IPCRTargetsController::class, 'destroy']);
        Route::get('/get/ipcr/targets/2', [IPCRTargetsController::class, 'review_ipcr2']);

        ///ipcrtargets/create/${id}/additional
        Route::get('/create/{id}/additional/ipcr/targets', [IPCRTargetsController::class, 'additional_create']);
        Route::post('/store/{id}/additional/ipcr/targets/store', [IPCRTargetsController::class, 'additional_store']);
        // /ipcrtargets/recall/" + id_target + "/additional/ipcr/targets/" + ipcr_id
        Route::post('/recall/{id_target}/additional/ipcr/targets/{ipcr_id}', [IPCRTargetsController::class, 'additional_recall']);
    });

    Route::prefix('/update-target-columns')->group(function () {
        Route::get('/', [IPCRTargetsController::class, 'updateTargetColumns']);
        //countNullTargets
        Route::get('/count', [IPCRTargetsController::class, 'countNullTargets']);
    });
    Route::prefix('/ipcrtargetsreview')->group(function () {
        Route::post('/{id}/{source}/{id_sem}', [IPCRTargetsController::class, 'ipcrtargets_review']);
        Route::post('/targetid/{id_target}/status/{target_status}', [IPCRTargetsController::class, 'ipcrtargets_update_status']);
        // /ipcrtargetsreview/delete/" + id_target + '/' + this.source + '/' + ipcr_id
        Route::delete('/delete/{id}/{source}/{id_sem}', [IPCRTargetsController::class, 'destroy_additional_taget']);
        // /ipcrtargetsreview/recall/my/target/" + id_target + '/' + this.source+ '/' + ipcr_id);
        Route::post('/recall/my/target/{source}/{id_sem}', [IPCRTargetsController::class, 'recall']);
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
    Route::prefix('/ipcrsemestral2')->group(function () {
        Route::get('/', [IpcrSemestralController::class, 'index2']);
        Route::get('/edit/{id}', [IpcrSemestralController::class, 'create2']);
        Route::get('/get/divisions/{office_code}', [IpcrSemestralController::class, 'divisions']);
        Route::patch('/update/{id}/save/it/now', [IpcrSemestralController::class, 'update2']);
    });
    //FOR REVIEW/APPROVAL
    // /review/approve/" + stat + "/" + this.emp_sem_id, this.form
    // /review/approve/" + stat + "/" + this.emp_sem_id + "/from/acted/semestrals
    Route::prefix('review/approve')->group(function () {
        Route::get('/', [ReviewApproveController::class, 'index']);
        Route::post('/{status}/{sem_id}', [ReviewApproveController::class, 'updateStatus']);
        Route::post('/{status}/{sem_id}/from/acted/semestrals', [ReviewApproveController::class, 'updateStatusSem']);
        Route::post('/{status}/{sem_id}/probationary', [ReviewApproveController::class, 'updateStatusProb']);
    });
    //FOR REVIEW/APPROVAL OF MONTHLY ACCOMPLISHMENTS
    Route::prefix('approve/accomplishments')->group(function () {
        Route::get('/', [MonthlyAccomplishmentController::class, 'approve_monthly']);
        Route::get('/get/specific/accomplishment/and/target', [MonthlyAccomplishmentController::class, 'specific_accomplishment']);
        Route::post('/{status}/{acc_id}', [MonthlyAccomplishmentController::class, 'updateStatusAccomp']);
        ///acted/monthly
        Route::post('/{status}/{acc_id}/acted/monthly', [MonthlyAccomplishmentController::class, 'updateStatusAccompReturn']);
        Route::get('/kobo/humanitarian/response/application/program/interface', [MonthlyAccomplishmentController::class, 'api_kobo']);
        // Route::post('/{status}/{sem_id}', [ReviewApproveController::class, 'updateStatus']);
        // Route::post('/{status}/{sem_id}/probationary', [ReviewApproveController::class, 'updateStatusProb']);
    });
    //approve/semestral-accomplishments/up/stat/acc/{status}/{acc_id}
    //approve/semestral-accomplishments/{status}/{acc_id}
    //FOR REVIEW/APPROVAL OF SEMESTRAL ACCOMPLISHMENTS
    Route::prefix('approve/semestral-accomplishments')->group(function () {
        Route::get('/', [SemestralAccomplishmentController::class, 'approve_monthly']);
        Route::get('/get/specific/accomplishment/and/target', [SemestralAccomplishmentController::class, 'specific_accomplishment']);
        Route::post('/{status}/{acc_id}', [SemestralAccomplishmentController::class, 'updateStatusAccomp']);
        Route::post('/up/stat/acc/{status}/{acc_id}', [SemestralAccomplishmentController::class, 'updateStatusAccompRev']);
        Route::get('/kobo/humanitarian/response/application/program/interface', [SemestralAccomplishmentController::class, 'api_kobo']);
    });
    // Route::prefix('approve/semestral-accomplishments')->group(function () {
    // });
    Route::prefix('calculate-total/accomplishments')->group(function () {
        Route::get('/{sem_id}/{emp_code}', [SemestralAccomplishmentController::class, 'getAccomplishmentValue']);
        ///calculate-total/accomplishments/monthly/' + my_month + '/' + e_year;
        Route::get('/monthly/{month}/{year}/{emp_code}/{sem_id}', [SemestralAccomplishmentController::class, 'getAccomplishmentValueMonthly']);
    });
    Route::prefix('identify/person/responsible')->group(function () {
        Route::get('', [ReturnRemarksController::class, 'returnRemarksResponsible']);
    });
    Route::prefix('acted/particulars')->group(function () {
        Route::get('', [ReturnRemarksController::class, 'actedParticulars']);
        Route::get('targets', [ReturnRemarksController::class, 'actedParticularsTargets']);
        Route::get('accomp/lishments', [ReturnRemarksController::class, 'actedParticularsAccomplishments']);
        Route::get('accomp/lishments/monthly', [ReturnRemarksController::class, 'actedParticularsAccomplishmentsMonthly']);
    });
    //Employees
    Route::prefix('/employees')->group(function () {
        Route::get('/', [UserEmployeesController::class, 'index']);
        Route::get('/a/l/l', [UserEmployeesController::class, 'all_employees_redirector']);
        Route::get('/all', [UserEmployeesController::class, 'all_employees'])->name('employees.all');
        Route::post('/all/reset/passwpord/{id}', [UserEmployeesController::class, 'resetpass']);
        Route::post('/updateEmail', [UserEmployeesController::class, 'resetEmail']);
        Route::get('/division/{dept_code}', [UserEmployeesController::class, 'get_division']);
        Route::post('/all/update/status/{id}/{status}', [UserEmployeesController::class, 'updatestat']);
        Route::get('/s/y/n/c/all/employees/selected', [UserEmployeesController::class, 'syncemployees_1']);
        // /employees/all/update/status/" + this.id+"/"+this.disp_active_stat
        // this.$inertia.post("/employees/all/reset/passwpord")
        // 'employees/division/' + this . office_selected;
    });
    Route::prefix('/password/change/log')->group(function () {
        Route::get('/', [ChangeLogController::class, 'index']);
        Route::get('/email', [ChangeLogController::class, 'email']);
    });
    //ROute
    Route::prefix('/email')->group(function () {
        Route::get('/', [UserEmployeesController::class, 'change_my_email']);
        Route::get('/change', [UserEmployeesController::class, 'set_my_email']);
        Route::post('/update-email', [UserEmployeesController::class, 'update_email']);
        Route::get('/log', [UserEmployeesController::class, 'email_log']);
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
        Route::get('/sync_daily/PM', [DailyAccomplishmentController::class, 'sync_daily']);
    });

    Route::prefix('/IPCR_Tracking')->group(function () {
        Route::get('/', [ReturnRemarksController::class, 'index']);
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
    Route::prefix('/summary-rating')->group(function () {
        Route::get('/', [AccomplishmentController::class, 'summaryRating']);
        Route::get('/monthly', [AccomplishmentController::class, 'monthly']);
        //ALL OFFICES
        Route::get('/alloffices/{department_code}', [AccomplishmentController::class, 'summaryRatingAll']);
        Route::get('/monthly/all-offices/{department_code}', [AccomplishmentController::class, 'monthlyAll']);
        Route::get('/semester/all-offices/{department_code}', [AccomplishmentController::class, 'SemesterRatingAll']);
    });
    ROute::prefix('/offices')->group(function () {
        Route::get('/', [SummaryOfRatingController::class, 'getOffices']);
        Route::get('/{office_id}', [SummaryOfRatingController::class, 'setPGHead']);
        Route::patch('/update_pghead/{id}', [SummaryOfRatingController::class, 'updatePGHead']);
    });
    Route::prefix('/new-submission/accomplishment')->group(function () {
        Route::get('/monthly', [AccomplishmentController::class, 'get_this_monthly']);
        // /new-submission/accomplishment/monthly/recall
        Route::post('/monthly/recall', [AccomplishmentController::class, 'recall_this_monthly']);
    });
    //API used for viewing employee's monthly accomplishments data ifrom approver/reviewer side
    Route::prefix('/monthly-details')->group(function () {
        Route::get('/monthly/accomplishments/object/{emp_code}/{semt}/{year}/{ipcr_semestral_id}/{month}', [AccomplishmentController::class, 'monthly_object']);
    });
    //Semester Accomplishment
    Route::prefix('/semester-accomplishment')->group(function () {
        Route::get('/semestral/accomplishment/{id}', [SemesterController::class, 'semestral']);
        Route::post('/get-time-ranges', [SemesterController::class, 'getTimeRanges']);
        Route::post('/submit/ipcr/semestral/{id}', [SemesterController::class, 'submitAccomplishment']);
        Route::get('/get/semestralAccomplishment', [SemesterController::class, 'semestralReview']);
        ///semester-accomp/submit/ipcr/semestral/recall/' + this.sem_id
        Route::post('/submit/ipcr/semestral/recall/{id}', [SemesterController::class, 'recallAccomplishment']);
        Route::post('/store', [SemesterController::class, 'store']);
        Route::patch('/{id}', [SemesterController::class, 'update']);
        Route::delete('/{id}', [SemesterController::class, 'destroy']);
    });
    Route::prefix('/semester-rating')->group(function () {
        Route::get('/semester', [SemesterController::class, 'SemesterRating']);
        Route::post('/sem_store', [SemesterController::class, 'semester_store']);
        Route::patch('/sems/{id}', [SemesterController::class, 'semester_update']);
        Route::delete('/{id}', [SemesterController::class, 'semester_destroy']);
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

    //IPCR Dashboard Design
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashBoardController::class, 'dashboard']);
        Route::get('/faos', [DashBoardController::class, 'FAOS']);
        Route::get('/create', [DashBoardController::class, 'create']);
        Route::post('/store', [DashBoardController::class, 'store']);
        Route::get('/{id}/edit', [DashBoardController::class, 'edit']);
        Route::patch('/update/{id}', [DashBoardController::class, 'update']);
        Route::delete('/delete/{id}', [DashBoardController::class, 'destroy']);
        Route::patch('notice/update/{id}', [DashBoardController::class, 'notice_update']);
    });

    //EMPLOYEE SPECIAL DEPARTMENT
    Route::prefix('/employee/special/department')->group(function () {
        Route::get('/', [EmployeeSpecialDepartmentController::class, 'index']);
        Route::get('/create', [EmployeeSpecialDepartmentController::class, 'create']);
        Route::post('/store', [EmployeeSpecialDepartmentController::class, 'store']);
        Route::get('/{id}/edit', [EmployeeSpecialDepartmentController::class, 'edit']);
        Route::patch('/update/{id}', [EmployeeSpecialDepartmentController::class, 'update']);
        Route::delete('/delete/{id}', [EmployeeSpecialDepartmentController::class, 'destroy']);
    });
});


Route::prefix('/PDA')->group(function () {
    Route::get('/Print', [DailyAccomplishmentController::class, 'UserEmployee']);
});

Route::prefix('/summaryRating')->group(function () {
    Route::get('/monthlySummary/print', [AccomplishmentController::class, 'monthlyPrintSummary']);
});

Route::prefix('/semestralRating')->group(function () {
    Route::get('/SemesterSummary/print', [SemesterController::class, 'SemestralPrintSummary']);
    Route::get('/all/print', [SemesterController::class, 'SemestralAllPrintSummary']);
});



Route::prefix('/monthly')->group(function () {
    Route::get('/IPCR', [AccomplishmentController::class, 'MonthlyPrint']);
    Route::get('/Print/types', [AccomplishmentController::class, 'MonthlyPrintTypes']);
    Route::get('/IPCR/main', [AccomplishmentController::class, 'MonthlyPrintMain']);
    //MONTHLY API
    Route::get('/IPCR/main/types', [AccomplishmentController::class, 'MonthlyPrintMainTypes']);
});
//API for printing semestral targets
Route::prefix('target/print/r')->group(function () {
    Route::get('/types', [IpcrTargetController::class, 'target_types']);
    Route::get('/types/IPCR', [IpcrTargetController::class, 'get_ipcr_targets']);
});
//API for printing semestral targets
Route::prefix('target/print')->group(function () {
    Route::get('/types', [IPCRTargetsController::class, 'target_types']);
    Route::get('/types/IPCR', [IPCRTargetsController::class, 'get_ipcr_targets']);
});


Route::prefix('semester/print')->group(function () {
    Route::get('/semester/first', [SemesterController::class, 'semester_print']);
    Route::get('/semester/secondPrint', [SemesterController::class, 'semester_print_score']);
    Route::get('/semester/second', [SemesterController::class, 'semester_second_print']);
    Route::get('/semester/PrintSecond', [SemesterController::class, 'semester_print_second']);
});
Route::prefix('/ipcr-code')->group(function () {
    Route::get('/', [SemesterController::class, 'api_ipcr']);
});

Route::prefix('/Daily_Accomplishment')->group(function () {
    Route::get('/api', [DailyAccomplishmentController::class, 'store_api']);
});

Route::fallback(function () {
    return redirect('/forbidden')
        ->with('error', 'Access forbidden!asasasa');
});
