<?php

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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});






Route::group(['middleware' => ['auth', 'can:edit-settings']], function () {

    Route::get('/admin', 'UserController@index');

    Route::get('/admin/users', 'UserController@index');
    Route::get('/admin/users/create', 'UserController@create');
    Route::post('/admin/users', 'UserController@store');
    Route::delete('/admin/users/{user}', 'UserController@destroy');
    Route::patch('/admin/users/{user}', 'UserController@update');
    Route::get('/admin/users/{user}/edit', 'UserController@edit');

    Route::post('/admin/roles', 'RoleController@store');
    Route::patch('/admin/roles/{role}', 'RoleController@update');
    Route::get('/admin/roles/{role}/edit', 'RoleController@edit');
    Route::delete('/admin/roles/{role}', 'RoleController@destroy');

    Route::post('/admin/companies', 'CompanyController@store');
    Route::patch('/admin/companies/{company}', 'CompanyController@update');
    Route::get('/admin/companies/{company}/edit', 'CompanyController@edit');
    Route::delete('/admin/companies/{company}', 'CompanyController@destroy');


});





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

