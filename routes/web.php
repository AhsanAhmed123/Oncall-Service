<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\IvrController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\TwilioIVRController;
use App\Http\Controllers\OncallController;
use App\Http\Controllers\ManageRoasterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});


    Route::group(['middleware' => ['admin.guest']], function () {
        Route::get('/', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'postLogin'])->name('admin.authenticate');        
    });

    // Apply auth middleware to protect these routes
        Route::middleware('auth')->group(function () {
        //auth routes 
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::get('/change-password', [AuthController::class, 'chagepassword'])->name('change-password');
        Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
        //Dashboard routes
        Route::get('dashboard', [DashbaordController::class, 'index'])->name('index-dashboard');
        //sms routes
        Route::get('index-sms', [SmsController::class, 'index'])->name('index-sms');
        Route::post('/send-sms', [SmsController::class, 'sendSms'])->name('send.sms');
        
        //Department
        Route::get('index-ivr', [IvrController::class, 'index'])->name('index-ivr');
        Route::get('departments', [DepartmentController::class, 'index'])->name('index-departmemts');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    
        // Route to display the edit form
        Route::get('/ivr/{id}/edit', [IvrController::class, 'edit'])->name('ivr.edit');
        
        Route::put('/ivr', [IvrController::class, 'update'])->name('ivr.update');
        Route::post('/ivr/schedule-greeting', [IvrController::class, 'add_schdeule_greeting'])->name('ivr.schedule_greeting');
        Route::put('/ivr/schedule_greeting_edit/{id}', [IvrController::class, 'update_schedule_greeting'])->name('ivr.schedule_greeting.edit');
        Route::get('/ivr/schedule_greeting_delete/{id}', [IvrController::class, 'delete_schedule_greeting'])->name('ivr.schedule_greeting.delete');
        route::post('/ivr/save-options', [IvrController::class, 'save_options'])->name('ivr.save_options');


        // On-call persons routes
        Route::get('/oncall-persons', [OncallController::class, 'index'])->name('oncall.index');
        Route::post('/oncall-persons', [OncallController::class, 'store'])->name('oncall.store');
        Route::get('/oncall-persons/{id}/edit', [OncallController::class, 'edit'])->name('oncall.edit');
        Route::put('/oncall-persons/{id}', [OncallController::class, 'update'])->name('oncall.update');
        Route::delete('/oncall-persons/{id}', [OncallController::class, 'destroy'])->name('oncall.destroy');

        // beckup Routes
        Route::get('backup', [BackupController::class, 'index'])->name('backup');
        Route::get('/departments/{department}/users', [BackupController::class, 'details']);
         Route::post('/saveOncallPeopleOrder', [BackupController::class,'saveOncallPeopleOrder'])->name('saveOncallPeopleOrder');

        //survery routes
        Route::get('index-survey', [SurveyController::class, 'index'])->name('index-survey');
        Route::get('/survey/{departmentId}/questions', [SurveyController::class, 'getQuestions']);
        Route::post('/survey/store', [SurveyController::class, 'store'])->name('survey.store');
        
        //Roaster   
        Route::get('/manage-roasters', [ManageRoasterController::class,'index'])->name('roster.index');
        Route::get('/roster-details', [ManageRoasterController::class,'getRosterDetails'])->name('roster.details');
        Route::post('/roster-details', [ManageRoasterController::class,'getRosterDetails'])->name('roster.details');
        Route::post('/roster-save', [ManageRoasterController::class,'store'])->name('roster.save');
        Route::post('/update-event', [ManageRoasterController::class, 'updateEvent']);
        Route::post('/delete-event', [ManageRoasterController::class, 'deleteEvent']);
        
        //Service Controller
        
        
        Route::get('/email-create', [ServiceController::class, 'email'])->name('email.create'); 
        Route::match(['put', 'post'],'/mail/update', [ServiceController::class, 'createorupdateemail'])->name('update.email');

        Route::get('/sms-create', [ServiceController::class, 'sms'])->name('sms.create'); 
        Route::match(['put', 'post'],'/sms/update', [ServiceController::class, 'createorupdatesms'])->name('update.sms');
        
        
        Route::get('/call-report', [ReportController::class, 'index'])->name('call.report');
    
        
        Route::post('/submit-callback', [DashbaordController::class, 'callerstore']);
        Route::get('/fetch-notes/{callRecordingId}', [DashbaordController::class, 'fetchNotes']);
        Route::post('/voicemail/delete', [DashbaordController::class, 'delete'])->name('voicemail.delete');


}); 

        Route::get('/admin', [AdminController::class, 'index'])->name('Admin.index');
        Route::get('/accounts', [AdminController::class, 'Accounts'])->name('index-accounts');
        Route::post('/accounts/store', [AdminController::class, 'store'])->name('Admin.store');
        Route::post('admin/users/store', [AdminController::class, 'store'])->name('admin.users.store');
        Route::post('admin/users/update', [AdminController::class, 'update'])->name('admin.users.update');
        Route::put('admin/users/update/{id}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::post('admin/users/reset-password', [AdminController::class, 'resetPassword'])->name('admin.users.resetPassword');
        Route::get('admin/users/{id}', [AdminController::class, 'show'])->name('admin.users.show');
        Route::post('admin/users/delete', [AdminController::class, 'destroy'])->name('admin.users.delete');       
        Route::post('/update-user-status', [AdminController::class, 'updateUserStatus'])->name('user.updateStatus');
        Route::get('/Super-admin', [SuperAdminController::class, 'index'])->name('superadmin.index');
        // Ivr configration
        Route::post('/Super-admin-login', [SuperAdminController::class, 'shadow_login'])->name('superadmin.shadow_login');
        Route::match(['get', 'post'], '/ivr/incoming-call', [TwilioIVRController::class, 'handleIncomingCall']);
        Route::match(['get', 'post'],'/ivr/handle-input', [TwilioIVRController::class, 'handleInput'])->name('ivr.handle-input');
        Route::match(['get', 'post'],'/ivr/handle-recording', [TwilioIVRController::class, 'handleRecording'])->name('ivr.handle-recording');
        Route::match(['get', 'post'],'/ivr/next-call', [TwilioIVRController::class, 'nextCall'])->name('next.call');
        Route::match(['get', 'post'],'/ivr/save-voicemail', [TwilioIVRController::class, 'saveVoicemail']);

