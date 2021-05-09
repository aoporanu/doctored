<?php

$webMiddlewares = $middlewares = [
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
//    Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
];

Route::group(['middleware' => $middlewares], function () {

    Route::group(['namespace' => 'App\Http\Controllers\Auth'], function() {

        Route::post('user-password-email', 'UserForgotPasswordController@sendResetLinkEmail')->name('users.password.email');
        Route::get('user-password/reset/{token}/{type?}', 'ResetPasswordController@showResetForm', function($id) {

        })->name('users.password.reset')->defaults('type', 2);
        Route::post('user-password/reset', 'UserResetPasswordController@reset')->name('users.password.update');
    });
    Route::group(['namespace' => 'App\Modules\Frontend\Controllers'], function() {
        Route::any('/getCountries', 'CommonController@getCountries');
        Route::any('/getStates', 'CommonController@getStates');
        Route::any('/getStates/{id}', 'CommonController@getStates');
        Route::any('/getCities', 'CommonController@getCities');
        Route::any('/getCities/{id}', 'CommonController@getCities');
    });
    Route::group(['namespace' => 'App\Modules\Admin\Controllers', 'prefix' => 'admin'], function () {
        Route::any('/reset_passwords', 'AdminIndexController@encryptPasswords');
        Route::any('/login', 'AdminIndexController@login');
        Route::post('/login_submit', 'DashboardController@loginSubmit');
        Route::any('/logout', 'DashboardController@logout');
        Route::any('/getTimezonesbycountry/{id}', 'AdminIndexController@getTimezonesByCountryCode');

        Route::any('/profile', 'AdminIndexController@UserProfile');

        Route::post('/update_profile', 'AdminIndexController@UserProfile');

        Route::any('/update_hospital/{hospital_id}', 'AdminIndexController@updateHospital');

        Route::any('/dashboard', 'DashboardController@index');

        Route::any('/hospitals', 'HospitalsController@hospitals');
        Route::any('/create_hospital', 'HospitalsController@createHospital');
        Route::post('/add_hospital', 'HospitalsController@addHospital');
        Route::get('/edit_hospital/{hospitalId}', 'HospitalsController@editHospital');
        Route::get('/delete_hospital/{hospitalId}', 'HospitalsController@deleteHospital');
        Route::get('/view_hospital/{hospitalId}', 'HospitalsController@viewHospital');
        Route::get('/migrate_hospitalview/{hospitalId}', 'HospitalsController@migrateHospitalView');
        Route::get('/migrate_hospital', 'HospitalsController@migrateHospital');
        Route::get('/hospitals/getUsers/{groupId}', 'AdminIndexController@getUsersByGroupId');


        Route::any('/settings/hospitalmetatypes', 'HospitalMetaTypesController@hospitalMetaTypes');
        Route::any('/create_hospitalmetatype', 'HospitalMetaTypesController@createhospitalMetaType');
        Route::get('/edit_hospitalmetatype/{hmetaId}', 'HospitalMetaTypesController@edithospitalMetaType');
        Route::get('/view_hospitalmetatype/{hmetaId}', 'HospitalMetaTypesController@viewhospitalMetaType');
        Route::post('/add_hospitalmetatype', 'HospitalMetaTypesController@addhospitalMetaType');
        Route::get('/delete_hospitalmetatype/{hmetaId}', 'HospitalMetaTypesController@deletehospitalMetaType');

        Route::any('/settings/doctorsmetatypes', 'DoctorMetaTypesController@doctorMetaTypes');
        Route::any('/create_doctormetatype', 'DoctorMetaTypesController@createDoctorMetaType');
        Route::get('/edit_doctormetatype/{dmetaId}', 'DoctorMetaTypesController@editDoctorMetaType');
        Route::get('/view_doctormetatype/{dmetaId}', 'DoctorMetaTypesController@viewDoctorMetaType');
        Route::post('/add_doctormetatype', 'DoctorMetaTypesController@addDoctorMetaType');
        Route::get('/delete_doctormetatype/{dmetaId}', 'DoctorMetaTypesController@deleteDoctorMetaType');

        Route::any('/settings/patientsmetatypes', 'PatientMetaTypesController@patientMetaTypes');
        Route::any('/create_patientmetatype', 'PatientMetaTypesController@createPatientMetaType');
        Route::get('/edit_patientmetatype/{pmetaId}', 'PatientMetaTypesController@editPatientMetaType');
        Route::get('/view_patientmetatype/{pmetaId}', 'PatientMetaTypesController@viewPatientMetaType');
        Route::post('/add_patientmetatype', 'PatientMetaTypesController@addPatientMetaType');
        Route::get('/delete_patientmetatype/{pmetaId}', 'PatientMetaTypesController@deletePatientMetaType');


        Route::any('/users', 'UserController@users');
        Route::any('/create_user', 'UserController@createUser');
        Route::post('/add_user', 'UserController@addUser');
        Route::any('/edit_user/{userId}', 'UserController@editUser');
        Route::any('/delete_user/{userId}', 'UserController@deleteUser');
//        Route::get('/edit_user/{userId}', function ($userId) {
////            return \App\Http\Middleware\EncryptUrlParams::encrypt($userId);
////            echo $userId;die;
//        });
//        Route::any('/delete_user', 'UserController@deleteUser');

        Route::any('/roles', 'RolesController@roles');
        Route::any('/create_role', 'RolesController@createRole');
        Route::post('/add_role', 'RolesController@addRole');
        Route::get('/edit_role/{roleId}', 'RolesController@editRole');
        Route::get('/delete_role/{roleId}', 'RolesController@deleteRole');
        Route::get('/view_role/{roleId}', 'RolesController@viewRole');

        Route::any('/menus', 'MenusController@menus');
        Route::any('/create_menu', 'MenusController@createMenu');
        Route::post('/add_menu', 'MenusController@addMenu');
        Route::get('/edit_menu/{menuId}', 'MenusController@editMenu');
        Route::get('/delete_menu/{menuId}', 'MenusController@deleteMenu');
        Route::get('/view_menu/{menuId}', 'MenusController@viewMenu');


        Route::any('/durations', 'DurationsController@durations');
        //Route::any('/settings/durations', 'DurationsController@durations');
        Route::any('/create_duration', 'DurationsController@createDuration');
        Route::get('/edit_duration/{id}', 'DurationsController@editDuration');
        Route::post('/add_duration', 'DurationsController@addDuration');
        Route::get('/delete_duration/{id}', 'DurationsController@deleteDuration');
        Route::get('/view_duration/{id}', 'DurationsController@viewDuration');
        Route::get('/status_duration/{id}/{value}', 'DurationsController@statusDuration');

        Route::any('/billing', 'BillingController@index');
        Route::any('/schedule', 'ScheduleController@index');
        Route::any('/slots', 'SlotController@index');
        Route::any('/slotsdetails', 'SlotController@slotsdetails');


        Route::any('/groups', 'GroupsController@groups');
        Route::any('/create_group', 'GroupsController@createGroup');
        Route::post('/add_group', 'GroupsController@addGroup');
        Route::get('/edit_group/{groupId}', 'GroupsController@editGroup');
        Route::get('/delete_group/{groupId}', 'GroupsController@deleteGroup');
        Route::get('/view_group/{groupId}', 'GroupsController@viewGroup');

        Route::any('/settings/groupmetatypes', 'GroupMetaTypesController@groupMetaTypes');
        Route::any('/create_groupmetatype', 'GroupMetaTypesController@createGroupMetaType');
        Route::get('/edit_groupmetatype/{gmetaId}', 'GroupMetaTypesController@editGroupMetaType');
        Route::get('/view_groupmetatype/{gmetaId}', 'GroupMetaTypesController@viewGroupMetaType');
        Route::post('/add_groupmetatype', 'GroupMetaTypesController@addGroupMetaType');
        Route::get('/delete_groupmetatype/{gmetaId}', 'GroupMetaTypesController@deleteGroupMetaType');


        Route::any('/pages', 'PagesController@pages');
        Route::any('/create_page', 'PagesController@createPage');
        Route::post('/add_page', 'PagesController@addPage');
        Route::get('/edit_page', 'PagesController@editPage');
        Route::get('/delete_page', 'PagesController@deletePage');
        Route::get('/view_page', 'PagesController@viewPage');

        Route::any('/create_pageelement', 'PagesController@createPageElement');
        Route::get('/edit_pageelement', 'PagesController@editPageElement');
        Route::get('/delete_pageelement', 'PagesController@deletePageElement');

        Route::any('/sitemanagement', 'SiteManagementController@manage');
        //Route::any('/edit_site', 'SiteManagementController@addSite');

        Route::any('/members', 'PatientsController@members');
        Route::any('/edit_member/{patientId}', 'PatientsController@editMember');
        Route::post('/add_member', 'PatientsController@addMember');
        Route::get('/view_member/{patientId}', 'PatientsController@viewMember');
        Route::get('/delete_member/{patientId}', 'PatientsController@deleteMember');

        Route::any('/specializations', 'SpecializationController@specializations');
        Route::any('/create_specialization', 'SpecializationController@createSpecialization');
        Route::post('/add_specialization', 'SpecializationController@addSpecialization');
        Route::any('/edit_specialization/{spId}', 'SpecializationController@editSpecialization');
        Route::get('/view_specialization/{spId}', 'SpecializationController@viewSpecialization');
        Route::get('/delete_specialization/{spId}', 'SpecializationController@deleteSpecialization');

        Route::any('/doctors/', 'DoctorsController@doctors');
        Route::any('/create_doctors', 'DoctorsController@createDoctors');
        Route::any('/edit_doctors/{doctorId}', 'DoctorsController@editDoctors');
        Route::post('/add_doctors', 'DoctorsController@addDoctors');
        Route::get('/view_doctors/{doctorId}', 'DoctorsController@viewDoctors');
        Route::get('/delete_doctors/{doctorId}', 'DoctorsController@deleteDoctors');
        Route::any('/doctor/verify/{doctorId}', 'DoctorsController@verifydoctor');
        Route::get('/doctormap', 'DoctorsController@doctorHospitalMapping');
        Route::get('/getdoctors', 'DoctorsController@getDoctors');
        Route::post('/getDoctorDetails', 'DoctorsController@getDoctorDetails');
        Route::post('/doctorhostpitalmap', 'DoctorsController@mapDoctorHospital');
        Route::get('/delete_doctor_mapping', 'DoctorsController@deleteDoctorMapping');


        Route::any('/consultationtypes/', 'ConsultationTypesController@consultationtypes');
        Route::any('/create_consultation', 'ConsultationTypesController@createConsultationTypes');
        Route::any('/edit_consultation/{ctypeId}', 'ConsultationTypesController@editConsultationTypes');
        Route::post('/add_consultation', 'ConsultationTypesController@addConsultationTypes');
        Route::get('/view_consultation/{ctypeId}', 'ConsultationTypesController@viewConsultationTypes');
        Route::get('/delete_consultation/{ctypeId}', 'ConsultationTypesController@deleteConsultationTypes');

        Route::any('/settings/apiconfigurations', 'ApiConfigurationController@apiConfigurations');
        Route::any('/create_apiconfigurations', 'ApiConfigurationController@createApiConfigurations');
        Route::get('/edit_apiconfigurations/{id}', 'ApiConfigurationController@editApiConfigurations');
        Route::get('/view_apiconfigurations/{id}', 'ApiConfigurationController@viewApiConfigurations');
        Route::post('/add_apiconfiguration', 'ApiConfigurationController@addApiConfiguration');
        Route::get('/delete_apiconfigurations/{id}', 'ApiConfigurationController@deleteApiConfigurations');
        Route::any('/cities', 'CitiesController@cities');
        Route::any('/login', 'AdminIndexController@login');
        Route::any('/forgotpassword', 'AdminIndexController@forgetpassword');
        Route::any('/validateLicence', 'AdminIndexController@validateLicence');

        Route::any('/update_status', 'AdminIndexController@updateStatus');
    });
});
