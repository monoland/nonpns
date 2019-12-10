<?php

use App\Models\Teacher;

Route::middleware('guest')->group(function () {
    Route::get('/', 'Mono\WebController@index');

    Route::get('/samplex', function() {
        dd(Teacher::first());
    });
});