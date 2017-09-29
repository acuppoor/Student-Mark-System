<?php



Route::get('/', function(){return view('menu');});
Route::get('/contact', 'ContactController@index')->name('contact');

Route::get('/home', 'PagesController@home')->name("home");

Route::get('/mymarks', 'PagesController@myMarks')->name("my_marks");
Route::post('/mymarks/filter', 'PagesController@myMarksFilter');
Route::get('/tacourses', 'PagesController@taCourses')->name("ta_courses");
Route::post('/tacourses/filter', 'PagesController@taCoursesFilter');
Route::get('tacourses/{courseId}', 'PagesController@getTaCourse');

Route::get('/conveningcourses', 'PagesController@conveningCourses')->name("convening_courses");
Route::post('/conveningcourses/filter', 'PagesController@conveningCourses');
Route::get('/conveningcourses/{courseId}', 'PagesController@getCourseDetails');
Route::post('/conveningcourses/{courseId}/update', 'PagesController@updateCourseInfo');
Route::post('/conveningcourses/{courseId}/addconvenor', 'PagesController@addCourseConvenor');
Route::post('/conveningcourses/{courseId}/addlecturer', 'PagesController@addLecturer');
Route::post('/conveningcourses/{courseId}/addta', 'PagesController@addTA');
Route::post('/participantslist', 'PagesController@participantsList');
Route::post('/getconvenors', 'PagesController@getConvenors');
Route::post('/conveningcourses/getconvenors', 'PagesController@getConvenors');
Route::post('/conveningcourses/getlecturers', 'PagesController@getLecturers');
Route::post('/conveningcourses/getstudents', 'PagesController@getStudents');
Route::post('/conveningcourses/getteachingassistants', 'PagesController@getTAs');
Route::post('/createsubminimumrow', 'PagesController@createSubminimumRow');
Route::post('/deletesubminimumrow', 'PagesController@deleteSubminimumRow');
Route::post('/createcoursework', 'PagesController@createCoursework');
Route::post('/deletecoursework', 'PagesController@deleteCoursework');
Route::post('/createsubcoursework', 'PagesController@createSubcoursework');
Route::post('/deletesubcoursework', 'PagesController@deleteSubcoursework');
Route::post('/createsection', 'PagesController@createSection');
Route::post('/deletesection', 'PagesController@deleteSection');
Route::post('/createsubminimum', 'PagesController@createSubminimum');
Route::post('/deletesubminimum', 'PagesController@deleteSubminimum');
Route::post('/getsubcourseworks', 'PagesController@getSubCourseworks');
Route::post('/getsections', 'PagesController@getSections');
Route::post('/getstudentsmarks', 'PagesController@getStudentsMarks');
Route::post('/getstudentscourseworkmarks', 'PagesController@getStudentsCourseworkMarks');
Route::post('/getstudentssubcourseworkmarks', 'PagesController@getStudentsSubcourseworkMarks');
Route::post('/updatesectionmarks', 'PagesController@updateSectionMarks');
Route::post('/approveusers', 'PagesController@approveUsers');
Route::post('/convenorsaccess', 'PagesController@convenorsAccess');
Route::post('/lecturersaccess', 'PagesController@lecturersAccess');
Route::post('/tasaccess', 'PagesController@tasAccess');
Route::post('/updatecoursework', 'PagesController@updateCoursework');
Route::post('/updatesubcoursework', 'PagesController@updateSubcoursework');
Route::post('/updatesection', 'PagesController@updateSection');

Route::get('/lecturingcourses', 'PagesController@lecturerCourses')->name("lecturer_courses");
Route::post('/lecturingcourses/filter', 'PagesController@lecturerCourses');
Route::get('/lecturingcourses/{courseId}', 'PagesController@lecturerCourses');
Route::get('/courses', 'PagesController@otherCourses')->name("other_courses");
Route::post('/courses/filter', 'PagesController@otherCourses');
Route::get('/courses/{courseId}', 'PagesController@otherCourses');


Route::get('/searchmarks', 'PagesController@searchMarks')->name("search_marks");
Route::post('/searchmarks/search', 'PagesController@getMarks');

Route::get('/admin', 'PagesController@admin')->name("admin");
Route::get('/faculties&departments', 'PagesController@admin')->name("faculties");

Route::get('/courseconvenor/courseedit', function(){return view('lecturer.courseedit');});

Route::get('/faqs', function(){return view('faq');})->name('FAQs');
Route::get('/privacypolicy', function(){return view('privacypolicy');})->name('privacy_policy');
Route::get('/termsandconditions', function(){return view('termsandcondition');})->name('terms_and_conditions');


Auth::routes();


/*
 *
 *
 *
 * */
/*Route::get('/test', function () {
    return view('main');
});
Route::get('/systemadmin', 'HomeController@home');//function(){return view('systemadmin.home');});
Route::get('/systemadmin/admin', function(){return view('systemadmin.system_admin');});
Route::get('/systemadmin/faculties', function(){return view('systemadmin.faculties_departments');});
Route::get('/systemadmin/courses', function(){return view('systemadmin.courses');});
Route::get('/systemadmin/search', function(){return view('systemadmin.searchmarks');});

Route::get('/departmentadmin', function(){return view('departmentadmin.home');});
Route::get('/departmentadmin/courses', function(){return view('departmentadmin.courses');});
Route::get('/departmentadmin/admin', function(){return view('departmentadmin.admin');});
Route::get('/departmentadmin/search', function(){return view('departmentadmin.searchmarks');});

Route::get('/courseconvenor', function(){return view('courseconvenor.home');});
Route::get('/courseconvenor/convening_courses', function(){return view('courseconvenor.convening_courses');});
Route::get('/courseconvenor/other_courses', function(){return view('courseconvenor.courses');});
Route::get('/courseconvenor/search', function(){return view('courseconvenor.searchmarks');});
Route::get('/courseconvenor/courseedit', function(){return view('courseconvenor.courseedit');});
Route::get('/courseconvenor/courseworkedit', function(){return view('courseconvenor.coursework_cat');});

Route::get('/course/details', function(){return view('course.coursedetails');});
Route::get('/course/participants', function(){return view('course.participants');});
Route::get('/course/coursework', function(){return view('course.coursework');});
Route::get('/course/marks', function(){return view('course.marks');});
Route::get('/course/export', function(){return view('course.export');});
Route::get('/course/courseworkedit', function(){return view('course.cwedit');});
Route::get('/course/subminimum', function(){return view('course.subminimum');});
Route::get('/course/tests', function(){return view('course.tests');});*/
/*
Route::get('/lecturer', function(){return view('lecturer.home');});
Route::get('/lecturer/courses', function(){return view('lecturer.courses');});
Route::get('/lecturer/search', function(){return view('lecturer.searchmarks');});

Route::get('/teachingassistant', function(){return view('teachingassistant.home');});
Route::get('/teachingassistant/marks', function(){return view('teachingassistant.marks');});
Route::get('/teachingassistant/ta_courses', function(){return view('teachingassistant.ta_courses');});
Route::get('/teachingassistant/search', function(){return view('teachingassistant.searchmarks');});

Route::get('/student', function(){return view('student.home');});
Route::get('/student/mymarks', function(){return view('student.mymarks');});

Route::get('/login', function (){return view('auth.login');});



Route::get('/home', function(){return view('menu');});



Route::get('/', function(){return view('menu');});*/