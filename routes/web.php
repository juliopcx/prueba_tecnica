<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::post('/login','LoginController@login')->name('login');
Route::post('/recovery-password','PasswordRecovery@reset')->name('recoveryPassword');
Route::get('/reset-password/{token}', [PasswordRecovery::class, 'verifyToken'])->name('password.reset.verify');

