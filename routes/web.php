<?php
Route::get('/', 'PagesController@home');
Route::get('/contact', 'ContactController@index')->name('contact');

Route::get('/home', 'PagesController@home')->name("home");

Route::get('/mymarks', 'PagesController@myMarks')->name("my_marks");
Route::post('/mymarks', 'PagesController@myMarksFilter');
Route::get('/tacourses', 'PagesController@taCourses')->name("ta_courses");
Route::post('/tacourses', 'PagesController@taCoursesFilter');
Route::get('/tacourses/{courseId}', 'PagesController@getCourseDetails');

Route::get('/conveningcourses', 'PagesController@conveningCourses')->name("convening_courses");
Route::post('/conveningcourses/filter', 'PagesController@conveningCourses');
Route::get('/conveningcourses/{courseId}', 'PagesController@getCourseDetails');
Route::post('/updatecourse', 'PagesController@updateCourseInfo');
Route::post('/addconvenor', 'PagesController@addCourseConvenor');
Route::post('/addlecturer', 'PagesController@addLecturer');
Route::post('/addta', 'PagesController@addTA');
Route::post('/participantslist', 'PagesController@participantsList');
Route::post('/getconvenors', 'PagesController@getConvenors');
Route::post('//getteachingassistants', 'PagesController@getTAs');
Route::post('/getlecturers', 'PagesController@getLecturers');
Route::post('/getstudents', 'PagesController@getStudents');
Route::post('/getteachingassistants', 'PagesController@getTAs');
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
Route::post('/updatesubminimum', 'PagesController@updateSubminimum');
Route::post('/updatesubminimumrow', 'PagesController@updateSubminimumRow');
Route::post('/updatestudentslist', 'PagesController@updateStudentsList');
Route::post('/uploadsectionmarks', 'PagesController@uploadSectionMarks');
Route::post('/getfinalgradetypes', 'PagesController@getGradeTypes');
Route::post('/updatefinalgrade', 'PagesController@updateFinalGrade');
Route::post('/downloadfinalgrade', 'PagesController@downloadFinalGrade');
Route::post('/downloadstudentslist', 'PagesController@downloadFinalGrade');
Route::post('/downloaddplist', 'PagesController@downloadDPList');

Route::post('/getdepartments', 'PagesController@getDepartments');
Route::post('/getfaculties', 'PagesController@getFaculties');
Route::post('/adddepartmentadmin', 'PagesController@addDepartmentAdmin');
Route::post('/addfaculty', 'PagesController@addFaculty');
Route::post('/adddepartment', 'PagesController@addDepartment');
Route::post('/updatefaculty', 'PagesController@updateFaculty');
Route::post('/deletefaculty', 'PagesController@deleteFaculty');
Route::post('/updatedepartment', 'PagesController@updateDepartment');
Route::post('/deletedepartment', 'PagesController@deleteDepartment');
Route::post('/addfaq', 'PagesController@addFAQ');


Route::get('/courses', 'PagesController@otherCourses')->name("other_courses");
Route::post('/courses', 'PagesController@otherCourses');
Route::post('/createcourse', 'PagesController@createCourse');
Route::post('/deletecourse', 'PagesController@deleteCourse');
Route::get('/admincourses/{courseId}', 'PagesController@getCourseDetails');

Route::get('/lecturingcourses', 'PagesController@lecturerCourses')->name("lecturer_courses");
Route::post('/lecturingcourses', 'PagesController@lecturerCourses');
Route::get('/lecturingcourses/{courseId}', 'PagesController@getCourseDetails');
Route::get('/othercourses/{courseId}', 'PagesController@getCourseDetails');
Route::post('/resetpassword', 'PagesController@resetPassword');

Route::get('/searchmarks', 'PagesController@searchMarks')->name("search_marks");
Route::post('/searchmarks', 'PagesController@getMarks');
Route::post('/approveaccount', 'PagesController@approveByEmail');
Route::post('/rejectaccount', 'PagesController@rejectAccount');
Route::post('/changepassword', 'PagesController@changePassword');
Route::post('/updatepersonalinfo', 'PagesController@updatePersonalInfo');
Route::post('/updatefaq', 'PagesController@updateFAQ');
Route::post('/deletefaq', 'PagesController@deleteFAQ');

Route::get('/admin', 'PagesController@admin')->name("admin");
Route::get('/faculties&departments', 'PagesController@faculties')->name("faculties");

Route::get('/faqs', function(){return view('faq');})->name('FAQs');
Route::get('/privacypolicy', function(){return view('privacypolicy');})->name('privacy_policy');
Route::get('/termsandconditions', function(){return view('termsandcondition');})->name('terms_and_conditions');
Route::get('/resetpassword', function(){return view('auth.passwords.reset');})->name('password_reset');
Route::get('/profile', 'PagesController@profilePage')->name('profile');

Auth::routes();