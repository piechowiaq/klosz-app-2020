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









    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::get('/admin/users', 'UserController@index')->name('users.index');
    Route::get('/admin/users/create', 'UserController@create')->name('users.create');
    Route::post('/admin/users', 'UserController@store')->name('users.store');
    Route::patch('/admin/users/{user}', 'UserController@update')->name('users.update');
    Route::get('/admin/users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::get('/admin/users/{user}', 'UserController@show')->name('users.show');
    Route::delete('/admin/users/{user}', 'UserController@destroy')->name('users.destroy');

    Route::get('/admin/roles', 'RoleController@index')->name('roles.index');
    Route::get('/admin/roles/create', 'RoleController@create')->name('roles.create');
    Route::post('/admin/roles', 'RoleController@store')->name('roles.store');
    Route::get('/admin/roles/{role}', 'RoleController@show')->name('roles.show');
    Route::patch('/admin/roles/{role}', 'RoleController@update');
    Route::get('/admin/roles/{role}/edit', 'RoleController@edit');
    Route::delete('/admin/roles/{role}', 'RoleController@destroy');

    Route::get('/admin/companies', 'CompanyController@index')->name('companies.index');
    Route::get('/admin/companies/create', 'CompanyController@create')->name('companies.create');
    Route::post('/admin/companies', 'CompanyController@store')->name('companies.store');
    Route::patch('/admin/companies/{company}', 'CompanyController@update')->name('companies.update');
    Route::get('/admin/companies/{company}/edit', 'CompanyController@edit')->name('companies.edit');
    Route::get('/admin/companies/{company}', 'CompanyController@show')->name('companies.show');
    Route::delete('/admin/companies/{company}', 'CompanyController@destroy')->name('companies.destroy');

    Route::get('/admin/departments', 'DepartmentController@index')->name('departments.index');
    Route::get('/admin/departments/create', 'DepartmentController@create')->name('departments.create');
    Route::post('/admin/departments', 'DepartmentController@store')->name('departments.store');
    Route::patch('/admin/departments/{department}', 'DepartmentController@update')->name('departments.update');
    Route::get('/admin/departments/{department}/edit', 'DepartmentController@edit')->name('departments.edit');
//    Route::get('/admin/departments/{department}', 'DepartmentController@show')->name('departments.show');
    Route::delete('/admin/departments/{department}', 'DepartmentController@destroy')->name('departments.destroy');

//    Route::get('/admin/employees', 'EmployeeController@index')->name('employees.index');
    Route::get('/admin/employees/create', 'EmployeeController@create')->name('employees.create');
    Route::post('/admin/employees', 'EmployeeController@store')->name('employees.store');
    Route::patch('/admin/employees/{employee}', 'EmployeeController@update')->name('employees.update');
    Route::get('/admin/employees/{employee}/edit', 'EmployeeController@edit')->name('employees.edit');
//    Route::get('/admin/employees/{employee}', 'EmployeeController@show')->name('employees.show');
    Route::delete('/admin/employees/{employee}', 'EmployeeController@destroy')->name('employees.destroy');

//    Route::get('/admin/positions', 'PositionController@index');
    Route::get('/admin/positions/create', 'PositionController@create');
    Route::post('/admin/positions', 'PositionController@store');
    Route::patch('/admin/positions/{position}', 'PositionController@update');
    Route::get('/admin/positions/{position}/edit', 'PositionController@edit');
//    Route::get('/admin/positions/{position}', 'PositionController@show');
    Route::delete('/admin/positions/{position}', 'PositionController@destroy');

//    Route::get('/admin/trainings', 'TrainingController@index');
    Route::get('/admin/trainings/create', 'TrainingController@create');
    Route::post('/admin/trainings', 'TrainingController@store');
    Route::patch('/admin/trainings/{training}', 'TrainingController@update');
    Route::get('/admin/trainings/{training}/edit', 'TrainingController@edit');
//    Route::get('/admin/trainings/{training}', 'TrainingController@show');
    Route::delete('/admin/trainings/{training}', 'TrainingController@destroy');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

