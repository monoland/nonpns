<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:200,1')->group(function () {
    Route::get('company', 'Mono\WebController@company');
});

Route::middleware(['auth:api', 'throttle:5000,1'])->group(function () {
    Route::post('document', 'Mono\DocumentController@store')->name('document.store');
    Route::post('media', 'Mono\MediaController@store')->name('media.store');
});

Route::middleware(['api', 'auth:api'])->group(function () {
    // monoland
    Route::get('user', 'Mono\WebController@user')->name('user.info');
    Route::get('menus', 'Mono\WebController@menus')->name('user.menu');
    Route::put('profile', 'Mono\WebController@profile')->name('user.profile');
    Route::put('password', 'Mono\WebController@password')->name('change.password');
    Route::get('authent/combo', 'Mono\AuthentController@combo');
    Route::post('users/bulkdelete', 'Mono\UserController@bulkdelete');

    Route::resource('users', 'Mono\UserController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('setting', 'Mono\SettingController')->only(['index', 'store', 'update', 'show', 'destroy']);
    Route::resource('client', 'Mono\ClientController')->only(['index', 'store', 'update', 'destroy']);
    Route::post('document/bulkdelete', 'Mono\DocumentController@bulkdelete');
    Route::resource('document', 'Mono\DocumentController')->only(['index', 'update', 'destroy']);

    // application
    Route::resource('city', 'Apps\CityController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('education', 'Apps\EducationController')->only(['index', 'store', 'update', 'destroy']);
    Route::get('subject/reports', 'Apps\SubjectController@reports');
    Route::resource('subject', 'Apps\SubjectController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('branch', 'Apps\BranchController')->only(['index', 'store', 'update', 'destroy']);
    Route::post('school/{school}/reset', 'Apps\SchoolController@resetPassword');
    Route::resource('branch.school', 'Apps\SchoolController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('branch.teacher', 'Apps\BranchTeacherController')->only(['index']);
    Route::resource('school.teacher', 'Apps\TeacherController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('school.user', 'Apps\SchoolUserController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('requirement', 'Apps\RequirementController')->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('teacher', 'Apps\OperatorTeacherController')->only(['index', 'store', 'show', 'update', 'destroy']);
});
