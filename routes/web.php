<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', 'Mono\WebController@index');
    Route::get('/{code}', 'Mono\WebController@redirect');
    Route::post('/verify/{code}', 'Mono\WebController@verify');
});
