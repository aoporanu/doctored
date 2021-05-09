<?php

use Illuminate\Support\Facades\Route;

Route::any('/login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@loginForm']);
Route::any('/loginsubmit', 'Auth\LoginController@userLogin');
Route::any('/logout', 'Auth\LoginController@logout')->name('logout');
