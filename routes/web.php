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
Route::get('/systemadmin/searchmarks', function(){return view('systemadmin.searchmarks');});

Route::get('/departmentadmin', function(){return view('departmentadmin.dashboard');});
Route::get('/departmentadmin/courses', function(){return view('departmentadmin.courses');});
Route::get('/departmentadmin/admin', function(){return view('departmentadmin.admin');});
Route::get('/departmentadmin/searchmarks', function(){return view('departmentadmin.searchmarks');});

Route::get('/courseconvenor', function(){return view('courseconvenor.dashboard');});
Route::get('/courseconvenor/convenor_courses', function(){return view('courseconvenor.convenorcourses');});
Route::get('/courseconvenor/courses', function(){return view('courseconvenor.courses');});
Route::get('/courseconvenor/searchmarks', function(){return view('courseconvenor.searchmarks');});
Route::get('/courseconvenor/courseedit', function(){return view('course.coursedetails');});
Route::get('/courseconvenor/courseworkedit', function(){return view('courseconvenor.coursework_cat');});

Route::get('/course/details', function(){return view('course.coursedetails');});
Route::get('/course/participants', function(){return view('course.participants');});
Route::get('/course/coursework', function(){return view('course.coursework');});
Route::get('/course/marks', function(){return view('course.marks');});
Route::get('/course/export', function(){return view('course.export');});
Route::get('/course/courseworkedit', function(){return view('course.cwedit');});
Route::get('/course/subminimum', function(){return view('course.subminimum');});
Route::get('/course/tests', function(){return view('course.tests');});

Route::get('/lecturer', function(){return view('lecturer.dashboard');});
Route::get('/lecturer/courses', function(){return view('lecturer.courses');});
Route::get('/lecturer/searchmarks', function(){return view('lecturer.searchmarks');});

Route::get('/teachingassistant', function(){return view('teachingassistant.dashboard');});
Route::get('/teachingassistant/courses', function(){return view('teachingassistant.marks');});
Route::get('/teachingassistant/courses_ta', function(){return view('teachingassistant.courses_ta');});
Route::get('/teachingassistant/searchmarks', function(){return view('teachingassistant.searchmarks');});

Route::get('/student', function(){return view('student.marks');});

Route::get('/login', function (){return view('auth.login');});

Route::get('/contact', 'ContactController@index');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/', function(){return view('menu');});