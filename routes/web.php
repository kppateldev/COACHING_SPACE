<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "All cleared";
});

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'App\Http\Controllers\Front\Login@login');


//========================================================================//
//=============================== Front Routes============================//
//========================================================================//

## Before Login
//check for existing email
 Route::post('verify-email', 'App\Http\Controllers\Front\Login@verifyEmail');
 Route::post('verify-password', 'App\Http\Controllers\Front\Login@verifyPassword');
// verify link in Email template
Route::get('verification/{token?}','App\Http\Controllers\Front\Login@verificationEmail');
//Show verify email page
 Route::get('verification-email/{token}','App\Http\Controllers\Front\Login@verificationEmailAfterLogin');
// Resend email link
 Route::post('resend-email','App\Http\Controllers\Front\Login@resendEmail');

## Login
 Route::get('login', 'App\Http\Controllers\Front\Login@login');
 Route::post('login', 'App\Http\Controllers\Front\Login@postLogin');

## Logout
 Route::get('logout', 'App\Http\Controllers\Front\Login@Logout');

## Forgot password
 Route::get('forgotpassword', 'App\Http\Controllers\Front\Login@getForgotPassword');
 Route::post('forgotpassword', 'App\Http\Controllers\Front\Login@postForgotPassword');
 Route::get('new-password/{id}', 'App\Http\Controllers\Front\Login@newPassword');
 Route::post('confirm-new-password', 'App\Http\Controllers\Front\Login@postConfirmNewPassword');

## Video
Route::get('video', 'App\Http\Controllers\Front\Login@video');
Route::get('update-video', 'App\Http\Controllers\Front\Login@updatevideo');

## Change Password
Route::get('change-password', 'App\Http\Controllers\Front\Login@changepassword');
Route::post('update-change-password', 'App\Http\Controllers\Front\Login@updatechangepassword');


## Agreement Status
Route::get('agreement', 'App\Http\Controllers\Front\Login@agreement');
Route::get('update-agreement', 'App\Http\Controllers\Front\Login@updateagreement');

## OTP Verification
Route::get('otp-verification', 'App\Http\Controllers\Front\Login@otpVerification');
Route::post('post-verification', 'App\Http\Controllers\Front\Login@loginWithOtp');

## User console
Route::group(['middleware' => ['user']], function () {
    Route::get('dashboard', 'App\Http\Controllers\Front\UserController@dashboard');
    Route::get('/coach-profile/{slug}', 'App\Http\Controllers\Front\UserController@coachprofile')->name('coachprofile');
    Route::get('myprofile', 'App\Http\Controllers\Front\UserController@myProfile');
    Route::post('myprofile', 'App\Http\Controllers\Front\UserController@myProfileUpdate');
    Route::post('cropprofile', 'App\Http\Controllers\Front\UserController@cropProfile')->name('cropprofile');
    Route::get('/user-change-password', 'App\Http\Controllers\Front\UserController@getChangePassword');
    Route::post('/user-change-password', 'App\Http\Controllers\Front\UserController@postChangePassword');
    Route::get('confirm-session-popup', 'App\Http\Controllers\Front\UserController@confirmSessionPopup');
    //Route::post('confirm-session-submit', 'App\Http\Controllers\Front\UserController@confirmSessionSubmit');
    Route::post('confirm-session-submit', 'App\Http\Controllers\Front\SessionController@confirmSessionSubmit');
    Route::get('booking-confirmed/{id}', 'App\Http\Controllers\Front\SessionController@bookingConfirmed');

    //My Session
    Route::get('my-sessions', 'App\Http\Controllers\Front\SessionController@mysessions')->name('mysessions');
    Route::get('user-notes-popup', 'App\Http\Controllers\Front\SessionController@userNotesPopup');
    Route::post('user-notes-submit', 'App\Http\Controllers\Front\SessionController@userNotesSubmit');
    Route::get('/my-sessions-details/{id}', 'App\Http\Controllers\Front\SessionController@mySessionDetails')->name('mySessionDetails');

    //Attend a session
    Route::post('give-review-submit', 'App\Http\Controllers\Front\CronController@giveReviewPost');

    //Delete Account
    Route::get('delete-account','App\Http\Controllers\Front\UserController@deleteAccount');

    //Get Timelot By Day and Coach ID
    Route::get('get-timeslot-by-day', 'App\Http\Controllers\Front\UserController@getTimeSlotByDay');

    //Cancel Session
    Route::get('cancel-session-popup', 'App\Http\Controllers\Front\SessionController@cancelSessionPopup');
    Route::post('cancel-session-submit', 'App\Http\Controllers\Front\SessionController@cancelSessionSubmit');
 });


//========================================================================//
//=============================== Admin Routes============================//
//========================================================================//

Route::name('admin.')->prefix('admin')->middleware('admin_web')->group( function () {

    Route::get('login', 'App\Http\Controllers\Admin\LoginController@login')->name('login');
    Route::post('login', 'App\Http\Controllers\Admin\LoginController@loginPost')->name('login.post');
    Route::get('forgot-password', 'App\Http\Controllers\Admin\LoginController@forgotPassword')->name('forgotPassword');
    Route::post('forgot-password', 'App\Http\Controllers\Admin\LoginController@forgotPasswordPost')->name('forgotPassword.post');

    ## OTP Verification
    Route::get('otp-verification', 'App\Http\Controllers\Admin\LoginController@otpVerification');
    Route::post('post-verification', 'App\Http\Controllers\Admin\LoginController@loginWithOtp');

});

Route::name('admin.')->prefix('admin')->middleware('is_admin')->group( function () {

    Route::get('/', 'App\Http\Controllers\Admin\AdminController@dashboard')->name('dashboard');
    Route::get('logout', 'App\Http\Controllers\Admin\AdminController@logout')->name('logout');
    Route::get('site-settings', 'App\Http\Controllers\Admin\SettingsController@index')->name('site-settings');
    Route::post('site-settings', 'App\Http\Controllers\Admin\SettingsController@store')->name('site-settings.store');
    Route::post('site-settings/payment', 'App\Http\Controllers\Admin\SettingsController@storePayment')->name('site-settings.store.payment');
    Route::post('site-settings/other', 'App\Http\Controllers\Admin\SettingsController@storeOther')->name('site-settings.store.other');
    Route::get('user-settings', 'App\Http\Controllers\Admin\AdminController@userSettings')->name('userSettings');
    Route::post('user-settings/update/{type}', 'App\Http\Controllers\Admin\AdminController@updateSettings')->name('updateSettings');
    //Clear Cache value
    Route::get('cache-clear', 'App\Http\Controllers\Admin\AdminController@cache_clear')->name('cache-clear');

    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "All cleared";
    });

    Route::prefix('users')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\UserController@index')->name('users');
        Route::get('data/', 'App\Http\Controllers\Admin\UserController@fetchUserData')->name('users.data');
        Route::get('create', 'App\Http\Controllers\Admin\UserController@create')->name('users.create');
        Route::post('create', 'App\Http\Controllers\Admin\UserController@store')->name('users.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\UserController@create')->name('users.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\UserController@store')->name('users.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\UserController@delete')->name('users.delete');
        Route::get('restore/{id}', 'App\Http\Controllers\Admin\UserController@restore')->name('users.restore');
        //KP 06082022
        Route::get('permentdelete/{id}', 'App\Http\Controllers\Admin\UserController@permentdelete')->name('users.permentdelete');
        //KP 06082022
        Route::get('change_status/{id}', 'App\Http\Controllers\Admin\UserController@change_status')->name('users.change_status');
        Route::get('view_user/{id}', 'App\Http\Controllers\Admin\UserController@view_user')->name('users.view_user');
        Route::post('cropprofile', 'App\Http\Controllers\Admin\UserController@cropProfile')->name('users.cropprofile');

        Route::get('create-bulk-user', 'App\Http\Controllers\Admin\UserController@createBulkUser')->name('users.createBulkUser');
        Route::post('file-import', 'App\Http\Controllers\Admin\UserController@fileImport')->name('file-import');
    });

    Route::prefix('organizations')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\OrganizationController@index')->name('organizations');
        Route::get('data/', 'App\Http\Controllers\Admin\OrganizationController@fetchOrganizationData')->name('organizations.data');
        Route::get('create', 'App\Http\Controllers\Admin\OrganizationController@create')->name('organizations.create');
        Route::post('create', 'App\Http\Controllers\Admin\OrganizationController@store')->name('organizations.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\OrganizationController@create')->name('organizations.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\OrganizationController@store')->name('organizations.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\OrganizationController@delete')->name('organizations.delete');
        //KP 06082022
        Route::get('permentdelete/{id}', 'App\Http\Controllers\Admin\OrganizationController@permentdelete')->name('organizations.permentdelete');
        //KP 06082022
        Route::get('restore/{id}', 'App\Http\Controllers\Admin\OrganizationController@restore')->name('organizations.restore');
        Route::get('change_status/{id}', 'App\Http\Controllers\Admin\OrganizationController@change_status')->name('organizations.change_status');
        Route::get('view_organization/{id}', 'App\Http\Controllers\Admin\OrganizationController@view_organization')->name('organizations.view_organization');
        Route::get('users-list/{id}', 'App\Http\Controllers\Admin\OrganizationController@usersList')->name('organizations.users.list');
        Route::get('users-list-data/{id}', 'App\Http\Controllers\Admin\OrganizationController@usersListData')->name('organizations.users.data');
    });

    Route::prefix('coach')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\CoachController@index')->name('coach');
        Route::get('data/', 'App\Http\Controllers\Admin\CoachController@fetchCoachData')->name('coach.data');
        Route::get('create', 'App\Http\Controllers\Admin\CoachController@create')->name('coach.create');
        Route::post('create', 'App\Http\Controllers\Admin\CoachController@store')->name('coach.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\CoachController@create')->name('coach.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\CoachController@store')->name('coach.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\CoachController@delete')->name('coach.delete');
        //KP 06082022
        Route::get('permentdelete/{id}', 'App\Http\Controllers\Admin\CoachController@permentdelete')->name('coach.permentdelete');
        //KP 06082022
        Route::get('restore/{id}', 'App\Http\Controllers\Admin\CoachController@restore')->name('coach.restore');
        Route::get('change_status/{id}', 'App\Http\Controllers\Admin\CoachController@change_status')->name('coach.change_status');
        Route::get('view_user/{id}', 'App\Http\Controllers\Admin\CoachController@view_coach')->name('coach.view_coach');

        Route::post('cropprofile', 'App\Http\Controllers\Admin\CoachController@cropProfile')->name('coach.cropprofile');

        //Calender Code
        Route::get('get_calender/{id}', 'App\Http\Controllers\Admin\CoachController@get_calender')->name('coach.get_calender');
        Route::post('store_calender', 'App\Http\Controllers\Admin\CoachController@storeAvailableData')->name('coach.store_calender');
        Route::get('/getData/{id}', 'App\Http\Controllers\Admin\CoachController@getData')->name('coach.getData');

        //full calender code
        Route::get('full-calender', 'App\Http\Controllers\Admin\CoachController@fullCalender')->name('fullCalender');
        Route::get('getEvents', 'App\Http\Controllers\Admin\CoachController@getEvents')->name('getEvents');

        //Set Availbility 
        Route::get('set-availability', 'App\Http\Controllers\Admin\CoachController@setAvailability');
        Route::get('set-availability-available', 'App\Http\Controllers\Admin\CoachController@setAvailabilityAvailable');
        Route::post('insert-available', 'App\Http\Controllers\Admin\CoachController@insertAvailable');
        Route::get('set-availability-unavailable', 'App\Http\Controllers\Admin\CoachController@setAvailabilityUnAvailable');
        Route::post('insert-unavailable-date', 'App\Http\Controllers\Admin\CoachController@insertUnAvailable');
        Route::post('insert-unavailable-datetime', 'App\Http\Controllers\Admin\CoachController@insertUnAvailable');
        Route::post('remove-unavailable-date', 'App\Http\Controllers\Admin\CoachController@removeUnavailabledate');
        Route::post('remove-unavailable-datetime', 'App\Http\Controllers\Admin\CoachController@removeUnavailabledatetime');

        Route::get('get-timeslot-by-date', 'App\Http\Controllers\Admin\CoachController@getTimeSlotByDate');

        //KP 22082022
        Route::get('get-avail-timeslot-by-date', 'App\Http\Controllers\Admin\CoachController@getAvailTimeSlotByDate');

    });

    Route::prefix('coaching_levels')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\CoachingLevelController@index')->name('coaching_levels');
        Route::get('create', 'App\Http\Controllers\Admin\CoachingLevelController@create')->name('coaching_levels.create');
        Route::post('create', 'App\Http\Controllers\Admin\CoachingLevelController@store')->name('coaching_levels.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\CoachingLevelController@create')->name('coaching_levels.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\CoachingLevelController@store')->name('coaching_levels.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\CoachingLevelController@delete')->name('coaching_levels.delete');
    });

    Route::prefix('strengths')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\StrengthsController@index')->name('strengths');
        Route::get('create', 'App\Http\Controllers\Admin\StrengthsController@create')->name('strengths.create');
        Route::post('create', 'App\Http\Controllers\Admin\StrengthsController@store')->name('strengths.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\StrengthsController@create')->name('strengths.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\StrengthsController@store')->name('strengths.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\StrengthsController@delete')->name('strengths.delete');
    });

    Route::prefix('departments')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\DepartmentsController@index')->name('departments');
        Route::get('create', 'App\Http\Controllers\Admin\DepartmentsController@create')->name('departments.create');
        Route::post('create', 'App\Http\Controllers\Admin\DepartmentsController@store')->name('departments.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\DepartmentsController@create')->name('departments.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\DepartmentsController@store')->name('departments.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\DepartmentsController@delete')->name('departments.delete');
    });

    Route::prefix('sessions')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\SessionController@index')->name('sessions');
        Route::get('data/', 'App\Http\Controllers\Admin\SessionController@fetchSessionData')->name('sessions.data');
        Route::get('view_session/{id}', 'App\Http\Controllers\Admin\SessionController@view_session')->name('sessions.view_session');
    });

    Route::prefix('pages')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\PagesController@index')->name('pages');
        Route::get('create', 'App\Http\Controllers\Admin\PagesController@create')->name('pages.create');
        Route::post('create', 'App\Http\Controllers\Admin\PagesController@store')->name('pages.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\PagesController@create')->name('pages.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\PagesController@store')->name('pages.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\PagesController@delete')->name('pages.delete');
        Route::get('change_status/{id}', 'App\Http\Controllers\Admin\PagesController@change_status')->name('pages.change_status');
    });

    Route::prefix('reviews')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\ReviewController@index')->name('reviews');
        Route::get('data', 'App\Http\Controllers\Admin\ReviewController@fetchReviewsData')->name('reviews.data');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\ReviewController@delete')->name('reviews.delete');
        Route::get('change_status/{id}', 'App\Http\Controllers\Admin\ReviewController@change_status')->name('reviews.change_status');
        Route::get('view_review/{id}', 'App\Http\Controllers\Admin\ReviewController@view_review')->name('reviews.view_review');
    });

    Route::prefix('facilities')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\FacilitiesController@index')->name('facilities');
        Route::get('create', 'App\Http\Controllers\Admin\FacilitiesController@create')->name('facilities.create');
        Route::post('create', 'App\Http\Controllers\Admin\FacilitiesController@store')->name('facilities.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\FacilitiesController@create')->name('facilities.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\FacilitiesController@store')->name('facilities.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\FacilitiesController@delete')->name('facilities.delete');
    });

    Route::prefix('services')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\ServicesController@index')->name('services');
        Route::get('create', 'App\Http\Controllers\Admin\ServicesController@create')->name('services.create');
        Route::post('create', 'App\Http\Controllers\Admin\ServicesController@store')->name('services.store');
        Route::get('edit/{id}', 'App\Http\Controllers\Admin\ServicesController@create')->name('services.edit');
        Route::post('edit/{id}', 'App\Http\Controllers\Admin\ServicesController@store')->name('services.update');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\ServicesController@delete')->name('services.delete');
    });

    Route::prefix('offers')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\OffersController@index')->name('offers');
        Route::get('data', 'App\Http\Controllers\Admin\OffersController@fetchOffersData')->name('offers.data');
        Route::get('detail/{id}', 'App\Http\Controllers\Admin\OffersController@detail')->name('offers.detail');
        Route::get('delete/{id}', 'App\Http\Controllers\Admin\OffersController@delete')->name('offers.delete');
        Route::get('change_status/{id}', 'App\Http\Controllers\Admin\OffersController@change_status')->name('offers.change_status');
    });

    Route::prefix('email_header_template')->group( function () {
        Route::get('/','App\Http\Controllers\Admin\EmailHeader@index')->name('email_header_template');
        Route::get('/add','App\Http\Controllers\Admin\EmailHeader@Add')->name('email_header_template.add');
        Route::get('/edit/{id}','App\Http\Controllers\Admin\EmailHeader@Edit')->name('email_header_template.edit');
        Route::post('/action/{action}/{_id}', 'App\Http\Controllers\Admin\EmailHeader@Action');
        Route::get('/action/{action}/{_id}', 'App\Http\Controllers\Admin\EmailHeader@Action');
    });

    Route::prefix('email_footer_template')->group( function () {
        Route::get('/', 'App\Http\Controllers\Admin\EmailFooter@index')->name('email_footer_template');
        Route::get('/add','App\Http\Controllers\Admin\EmailFooter@Add')->name('email_footer_template.add');
        Route::get('/edit/{id}','App\Http\Controllers\Admin\EmailFooter@Edit')->name('email_footer_template.edit');
        Route::post('/action/{action}/{_id}', 'App\Http\Controllers\Admin\EmailFooter@Action');
        Route::get('/action/{action}/{_id}', 'App\Http\Controllers\Admin\EmailFooter@Action');
    });

    Route::prefix('email_templates')->group( function () {
        Route::get('/','App\Http\Controllers\Admin\EmailTemplates@index')->name('email_templates');
        Route::get('/add','App\Http\Controllers\Admin\EmailTemplates@Add')->name('email_templates.add');
        Route::get('/edit/{id}','App\Http\Controllers\Admin\EmailTemplates@Edit')->name('email_templates.edit');
        Route::post('/action/{action}/{_id}', 'App\Http\Controllers\Admin\EmailTemplates@Action');
        Route::get('/action/{action}/{_id}', 'App\Http\Controllers\Admin\EmailTemplates@Action');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Non-Login pages
Route::get('add-session-report/{token}', 'App\Http\Controllers\Front\CronController@addSessionReport');
Route::post('add-session-report/{id}', 'App\Http\Controllers\Front\CronController@addSessionReportSubmit');
Route::get('thanks', 'App\Http\Controllers\Front\CronController@thanks');

//CRONS
Route::get('oneorthreedays_before_email', 'App\Http\Controllers\Front\CronController@oneORthreeDaysBeforeEmail');
Route::get('reminder_for_booksession', 'App\Http\Controllers\Front\CronController@ReminderForBooksession');
Route::get('askingfor_user_review', 'App\Http\Controllers\Front\CronController@askingforUserReview');