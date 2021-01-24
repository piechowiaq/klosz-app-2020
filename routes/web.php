<?php

declare(strict_types=1);

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
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'WelcomeController@index')->name('welcome');

Route::middleware('auth')->group(static function (): void {
    Route::namespace('Admin')->middleware('admin.authorize')->prefix('admin')->name('admin.')->group(static function (): void {
        Route::get('/', 'AdminController@index')->name('home');

        Route::resource('users', 'UserController');
        Route::resource('companies', 'CompanyController');
        Route::resource('departments', 'DepartmentController');
        Route::resource('positions', 'PositionController');
        Route::resource('trainings', 'TrainingController');
        Route::resource('registries', 'RegistryController');
    });

    Route::namespace('User')->name('user.')->group(static function (): void {
        Route::get('/home', 'HomeController@home')->name('home');
        Route::prefix('{company}')->middleware('company.authorize')->group(static function (): void {
            Route::get('/', 'HomeController@index')->name('dashboard');
            Route::resource('employees', 'EmployeeController');
            Route::get('trainings/{training}/certificates', 'CertificateController@index')->name('certificates.index');
            Route::get('certificates/create', 'CertificateController@create')->name('certificates.create');
            Route::post('certificates', 'CertificateController@store')->name('certificates.store');
            Route::get('certificates/{certificate}/download', 'CertificateController@download')->name('certificates.download');
            Route::get('trainings/{training}/certificates/{certificate}', 'CertificateController@show')->name('certificates.show');
            Route::get('trainings/{training}/certificates/{certificate}/edit', 'CertificateController@edit')->name('certificates.edit');
            Route::patch('trainings/{training}/certificates/{certificate}', 'CertificateController@update')->name('certificates.update');
            Route::delete('trainings/{training}/certificates/{certificate}', 'CertificateController@destroy')->name('certificates.destroy');
            Route::resource('trainings', 'TrainingController');
            Route::resource('reports', 'ReportController');
            Route::get('reports/{report}/download', 'ReportController@download')->name('reports.download');
            Route::resource('registries', 'RegistryController');
        });
    });
});
