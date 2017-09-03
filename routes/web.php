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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/systemadmin', function(){return view('systemadmin.dashboard');});
Route::get('/systemadmin/departmentportal', function(){return view('systemadmin.courses');});
Route::get('/systemadmin/admin', function(){return view('systemadmin.system_admin');});
Route::get('/systemadmin/facsanddepts', function(){return view('systemadmin.faculties_departments');});

Route::get('/departmentadmin', function(){return view('departmentadmin.dashboard');});
Route::get('/departmentadmin/courses', function(){return view('departmentadmin.courses');});
Route::get('/departmentadmin/admin', function(){return view('departmentadmin.admin');});
Route::get('/departmentadmin/searchmarks', function(){return view('departmentadmin.searchmarks');});

Route::get('/courseconvenor', function(){return view('courseconvenor.dashboard');});
Route::get('/courseconvenor/convenor_courses', function(){return view('courseconvenor.convenorcourses');});
Route::get('/courseconvenor/courses', function(){return view('courseconvenor.courses');});
Route::get('/courseconvenor/searchmarks', function(){return view('courseconvenor.searchmarks');});

Route::get('/lecturer', function(){return view('lecturer.dashboard');});
Route::get('/lecturer/courses', function(){return view('lecturer.courses');});

Route::get('/teachingassistant', function(){return view('teachingassistant.dashboard');});
Route::get('/teachingassistant/courses', function(){return view('teachingassistant.marks');});
Route::get('/teachingassistant/courses_ta', function(){return view('teachingassistant.courses_ta');});

Route::get('/student', function(){return view('student.marks');});

Route::get('/login', function (){return view('auth.login');});

Route::get('/contact', 'ContactController@index');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

/*Route::get('/', 'DashboardController@index');*/