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






Route::patch('/admin/roles/{role}', 'RoleController@update');
//Route::group(['middleware' => ['auth', 'can:edit-settings']], function () {

    Route::get('/admin', 'AdminController@index');

    Route::get('/admin/users', 'UserController@index')->name('users.index');
    Route::get('/admin/users/create', 'UserController@create')->name('users.create');
    Route::post('/admin/users', 'UserController@store')->name('users.store');
    Route::delete('/admin/users/{user}', 'UserController@destroy');
    Route::patch('/admin/users/{user}', 'UserController@update')->name('users.update');
    Route::get('/admin/users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::get('/admin/users/{user}', 'UserController@show')->name('users.show');

    Route::get('/admin/roles', 'RoleController@index')->name('roles.index');
    Route::get('/admin/roles/create', 'RoleController@create')->name('roles.create');
    Route::post('/admin/roles', 'RoleController@store')->name('roles.store');
    Route::get('/admin/roles/{role}', 'RoleController@show')->name('roles.show');

    Route::get('/admin/roles/{role}/edit', 'RoleController@edit');
    Route::delete('/admin/roles/{role}', 'RoleController@destroy');

    Route::get('/admin/companies', 'CompanyController@index')->name('companies.index');
    Route::get('/admin/companies/create', 'CompanyController@create')->name('companies.create');
    Route::post('/admin/companies', 'CompanyController@store')->name('companies.store');
    Route::patch('/admin/companies/{company}', 'CompanyController@update');
    Route::get('/admin/companies/{company}/edit', 'CompanyController@edit');
    Route::delete('/admin/companies/{company}', 'CompanyController@destroy');


//});





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

