<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.home');
            case 3:
            case 4:
                return view('lecturer.home');
            case 5:
                return view('departmentadmin.home');
            case 6:
                return view('systemadmin.home');
        }
    }

    public function searchMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return view('student.searchmarks')->with('courses', array());
            case 3:
            case 4:
                return view('lecturer.searchmarks');
            case 5:
                return view('departmentadmin.searchmarks');
            case 6:
                return view('systemadmin.searchmarks');
        }
    }

    public function getMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return view('student.searchmarks')->with('courses', app('App\Http\Controllers\StudentController')->getMarks($request));
            case 3:
            case 4:
                return view('lecturer.searchmarks');
            case 5:
                return view('departmentadmin.searchmarks');
            case 6:
                return view('systemadmin.searchmarks');
        }
    }

    public function myMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return app('App\Http\Controllers\StudentController')->studentHome();
            default:
                return view('student.access_denied');
        }
    }

    public function myMarksFilter(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return app('App\Http\Controllers\StudentController')->marksfilter($request);
            default:
                return view('student.access_denied');
        }
    }

    public function lecturerCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.lecturing_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getLecturerCourses($request));
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }
    public function conveningCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.convening_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getConveningCourses($request));
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }


    public function getCourseDetails($courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.course_details_convenor')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateCourseInfo(Request $request, $courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateCourseInfo($request, $courseId);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function addCourseConvenor(Request $request, $courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->addCourseConvenor($request, $courseId);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function addLecturer(Request $request, $courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->addLecturer($request, $courseId);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }
    public function addTA(Request $request, $courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->addTA($request, $courseId);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function participantsList(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->participantsList($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function createCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createCoursework($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function deleteCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteCoursework($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function createSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSubcoursework($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function deleteSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubcoursework($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getConvenors(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getConvenors($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getLecturers(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getLecturers($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getStudents(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudents($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getTAs(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getTAs($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function createSubminimumRow(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSubminimumRow($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function createSection(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSection($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function deleteSection(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSection($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function createSubminimum(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSubminimum($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function deleteSubminimumRow(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimumRow($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function deleteSubminimum(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimum($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getSubCourseworks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getSubCourseworks($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getStudentsCourseworkMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsCourseworkMarks($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getStudentsSubcourseworkMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsSubcourseworkMarks($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateSectionMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSectionMarks($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function approveUsers(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->approveUsers($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function convenorsAccess(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->convenorsAccess($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function lecturersAccess(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->lecturersAccess($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function tasAccess(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->tasAccess($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateCoursework($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSubcoursework($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateSection(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSection($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateSubminimum(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSubminimum($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateSubminimumRow(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSubminimumRow($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateStudentsList(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateStudentsList($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function uploadSectionMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->uploadSectionMarks($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getGradeTypes(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getGradeTypes($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getSections(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getSections($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function getStudentsMarks(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsMarks($request);
            case 5:
                return view('departmentadmin.courses');
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function otherCourses(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.other_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getOtherCourses($request));
            case 5:
                return view('departmentadmin.courses')->with('courses', app('App\Http\Controllers\LecturerController')->getOtherCourses($request));
            case 6:
                return view('systemadmin.courses')->with('courses', app('App\Http\Controllers\LecturerController')->getOtherCourses($request));
        }
    }

    public function taCourses(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return app('App\Http\Controllers\StudentController')->taFilter(null);
            case 3:
            case 4:
            case 5:
            case 6:
                return redirect()->route('courses');
        }
    }

    public function getTaCourse($courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return app('App\Http\Controllers\StudentController')->getTaCourse($courseId);
            case 3:
            case 4:
            case 5:
            case 6:
                return redirect()->route('courses');
        }
    }

    public function taCoursesFilter(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
            case 2:
                return app('App\Http\Controllers\StudentController')->taFilter($request);
            case 3:
            case 4:
            case 5:
            case 6:
                return redirect()->route('courses');
        }
    }


    public function admin(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
            case 4:
                return view('lecturer.access_denied');
            case 5:
                return view('departmentadmin.admin');
            case 6:
                return view('systemadmin.admin');
        }
    }

}
