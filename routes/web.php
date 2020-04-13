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

Auth::routes();
Route::get('/', 'WelcomeController@index')->name('welcome');



Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', 'AdminController@index')->name('home');

    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('companies', 'CompanyController');
    Route::resource('departments', 'DepartmentController');
    Route::resource('positions', 'PositionController');
    Route::resource('trainings', 'TrainingController');
    Route::resource('registries', 'RegistryController');

    });

Route::namespace('User')->name('user.')->group(function () {

    Route::get('/home', 'HomeController@home')->name('home');
    Route::get('/{company}', 'HomeController@index')->name('dashboard');

    Route::resource('/{company}/employees', 'EmployeeController');
    Route::get('/{company}/trainings/{training}/certificates', 'CertificateController@index')->name('certificates.index');
    Route::get('/{company}/certificates/create', 'CertificateController@create')->name('certificates.create');
    Route::post('/{company}/certificates', 'CertificateController@store')->name('certificates.store');
    Route::get('/{company}/trainings/{training}/certificates/{certificate}', 'CertificateController@show')->name('certificates.show');
    Route::get('/{company}/trainings/{training}/certificates/{certificate}/edit', 'CertificateController@edit')->name('certificates.edit');
    Route::patch('/{company}/trainings/{training}/certificates/{certificate}', 'CertificateController@update')->name('certificates.update');
    Route::delete('/{company}/trainings/{training}/certificates/{certificate}', 'CertificateController@destroy')->name('certificates.destroy');
    Route::resource('/{company}/trainings', 'TrainingController')->only(['index', 'show']);
    Route::resource('/{company}/reports', 'ReportController');
    Route::resource('/{company}/registries', 'RegistryController');

});







