<?php

use App\Http\Middleware\EncryptCookies;
use App\Modules\Frontend\Controllers\BookingAppointmentController;
use App\Modules\Frontend\Controllers\DoctorDashboardController;
use App\Modules\Frontend\Controllers\IndexController;
use App\Modules\Frontend\Controllers\RegisterController;
use App\Modules\Frontend\Controllers\SlotConfigurationController;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

$webMiddlewares = $middlewares = [
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    ShareErrorsFromSession::class,
    SubstituteBindings::class,
];

Route::group(['middleware' => $middlewares], function () {

    Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
        Route::post('member-password-email', 'ForgotPasswordController@sendResetLinkEmail')->name('member.password.email');
        Route::get('member-password/reset/{token}/{type?}', 'ResetPasswordController@showResetForm', function ($id) {
        })->name('member.password.reset')->defaults('type', 0);
        Route::post('member-password/reset', 'ResetPasswordController@reset')->name('member.password.update');

        Route::post('doctor-password-email', 'DoctorForgotPasswordController@sendResetLinkEmail')->name('doctor.password.email');
        Route::get('doctor-password/reset/{token}/{type?}', 'DoctorResetPasswordController@showResetForm')->name('doctor.password.reset')->defaults('type', 1);
        Route::post('doctor-password/reset', 'DoctorResetPasswordController@reset')->name('doctor.password.update');
    });


    Route::group(['namespace' => 'App\Modules\Frontend\Controllers'], function () {
        Route::any('/', 'IndexController@home');
        Route::any('/settimezone/{id}', 'IndexController@settimezone');

        Route::view('/call', 'Frontend::call');
        Route::post('/callinit', 'VoiceController@initiateCall')->name('initiate_call');
        Route::post('/callinitn', 'VoiceController@newCall')->name('initiate_ncall');
        Route::post('/initiate-video-call', 'VideoController@videoCall')->name('initiate_video_call');
        Route::get('access-token', 'GenerateAccessTokenController@generate_token')->name('access-token-generate');

        Route::any('/search', 'SearchController@index');
        Route::any('/getsuggestions', 'IndexController@getHospitalDoctorsList');
        Route::any('/group/{id}', 'IndexController@groupProfile');
        Route::any('/doctor/{id}', 'IndexController@doctorProfile');
        Route::any('/hospital/{id}', 'IndexController@hospitalProfile');

        Route::group(['prefix' => 'doctor'], function () {
            Route::any('edit-profile/{id}', 'IndexController@editDoctorProfile')
                ->name('edit.profile');
            Route::any(
                'register',
                [RegisterController::class,
                'register_doctor']
            )
                ->name('doctor.register');
            Route::get(
                'dashboard',
                [DoctorDashboardController
                ::class,
                'doctorDashboard']
            )
            ->name('doctor.dashboard');
            Route::get('manage-prescription', [IndexController::class, 'managePrescription'])
            ->name('doctor.manage-prescription');
            Route::get('manage-reports', [IndexController::class, 'manageReports'])
            ->name('doctor.manage-reports');
            Route::any('consultation/{slotId}', [IndexController::class, 'doctorConsultation'])
            ->name('doctor.consultation');
            Route::put(
                '/doctor/update-doctor-profile',
                [IndexController::class, 'updateDoctorProfile']
            )
                ->name('doctor-profile.update');
            Route::post('update-doctor-meta', [IndexController::class, 'updateDoctorMetaData'])
            ->name('doctor.update-metadata');
            Route::post('update-consultation-data', [IndexController::class, 'updateDoctorConsultationData'])
            ->name('doctor.update-consultation');
            Route::post('confirm_consultation', [IndexController::class, 'confirmDoctorConsultationData'])
            ->name('doctor.confirm-consultation');
        });



        Route::any('/register', 'RegisterController@register');


        Route::any('/forgot-password', 'IndexController@forgot');
        Route::any('/contact-us', 'IndexController@contactus');
        Route::any('/homecontactsave', 'IndexController@homecontactsave');

        Route::group(['prefix' => 'clinic'], function () {
            Route::get('/info', [DoctorDashboardController::class, 'clinicInfo'])
                ->name('clinic.info');
            Route::post('save', [DoctorDashboardController::class, 'clinicSave'])
                ->name('clinic.save');
        });

        Route::any('/patient-dashboard', 'PatientDashboardController@patientDashboard');

        Route::group(['prefix' => 'slot'], function () {
            Route::get(
                'configure',
                [SlotConfigurationController::class, 'index']
            )
                ->name('slot.configure');
            Route::post('configure', [SlotConfigurationController::class, 'slotConfigure'])
                ->name('slot.configure');
            Route::get('details', [SlotConfigurationController::class, 'slotdetails'])
                ->name('slot.details');
            Route::put('update', [SlotConfigurationController::class, 'updateSlotConfiguration'])
                ->name('slot.update');
            Route::get('manage', [SlotConfigurationController::class, 'manage'])
                ->name('slot.manage');
            Route::get('durations', [SlotConfigurationController::class, 'fetchdurations'])
                ->name('slot.durations');
            Route::post('save', [SlotConfigurationController::class, 'saveSlotConfiguration'])
                ->name('slot.save');
            Route::get('fetch', [SlotConfigurationController::class, 'fetchSlotConfiguration'])
                ->name('slot.save');
            Route::get('appointments', [SlotConfigurationController::class, 'generateAppointments'])
                ->name('slot.generate.appointments');
            Route::delete('details', [SlotConfigurationController::class, 'deletedetails'])
                ->name('slot.delete');
        });
        Route::group(['prefix' => 'bookings'], function () {
            Route::get('manage', [BookingAppointmentController::class, 'managebookings'])
            ->name('bookings.manage');
            Route::any('book', [BookingAppointmentController::class, 'index'])
            ->name('bookings.book');
            Route::get(
                'fetch-by-hospital',
                [BookingAppointmentController::class,
                'fetchSlotDetailsByHospital']
            )
            ->name('bookings.fetch-by-hospital');
            Route::get(
                'fetch-by-type',
                [BookingAppointmentController::class,
                'fetchConsulationsByDate']
            )
            ->name('bookings.fetch-by-type');
            Route::get('fetch-by-date', [BookingAppointmentController::class,
                'fetchSlotTimesByDate'])
                ->name('bookings.fetch-by-date');
            Route::get('fetch-by-time', [BookingAppointmentController::class,
                'getAppointmentTimes'])
                ->name('bookings.get-times');
            Route::get('new', [BookingAppointmentController::class, 'initiateBooking'])
                ->name('bookings.initiate-booking');
            Route::get(
                'fetch-by-hospital',
                [BookingAppointmentController::class, 'fetchSlotsByHospital']
            )
                ->name('bookings.fetch-by-hospital');
            Route::get(
                'fetch-by-doctor',
                [BookingAppointmentController::class, 'fetchSlotsByDoctor']
            )
                ->name('bookings.fetch-by-doctor');
        });

        Route::any('/getCountries', 'CommonController@getCountries');
        Route::any('/getStates', 'CommonController@getStates');
        Route::any('/getStates/{id}', 'CommonController@getStates');


        Route::any('/getCities', 'CommonController@getCities');
        Route::any('/getCities/{id}', 'CommonController@getCities');
        Route::any('/getTimezones', 'CommonController@getTimezones');


        Route::any('/testc', 'CommonController@testc');

        Route::get('/{slug}', array('as' => 'page.show', 'uses' => 'IndexController@show'));
    });
});
