<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\LecturerCourseMap;
use App\TACourseMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    /*
     * This class mainly acts as a middleware between the routes and the other controllers.
     * All routes redirects to a method in this class, and some checks are done.
     * Checks such as user authentication and determining if user is permitted to do the operation in question.
     * If user is permitted to do the operation, the correct method from the controller is called.
     * */


    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * returns the home page depending on the user's role
     * */
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

    /*
     * return the searchmarks page for the user depending on his role
     * */
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

    /*
     * get the marks for a selected course
     * */
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
                return view('lecturer.searchmarks')->with('courses', app('App\Http\Controllers\StudentController')->getMarks($request));
            case 5:
                return view('departmentadmin.searchmarks')->with('courses', app('App\Http\Controllers\StudentController')->getMarks($request));
            case 6:
                return view('systemadmin.searchmarks')->with('courses', app('App\Http\Controllers\StudentController')->getMarks($request));
        }
    }

    /*
     * return the 'my_marks' page for student/TA
     * */
    public function myMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return app('App\Http\Controllers\StudentController')->studentHome();
            case 3:
            case 4:
                return view('lecturer.access_denied');
            case 5:
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /*
     * filter the marks availables for student/TA
     * */
    public function myMarksFilter(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return app('App\Http\Controllers\StudentController')->marksfilter($request);
            case 3:
            case 4:
                return view('lecturer.access_denied');
            case 5:
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /*
     * get the courses for which the logged-in user is a lecturer
     * */
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
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /*
     * get the concening courses for the logged-in user
     * */
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
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }


    public function getCourseDetails($courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        if($roleID == 5){
            return app('App\Http\Controllers\DeptAdminController')->getCourseDetails($courseId);
        } else if($roleID == 6){
            return view('systemadmin.course_details_super')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        }

        $convenorMap = ConvenorCourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();
        $lecturerMap = LecturerCourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();
        $taMap = TACourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();

        if($convenorMap){
            return view('lecturer.course_details_convenor')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($lecturerMap){
            return view('lecturer.course_details_lecturer')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($taMap){
            return view('student.course_details_ta')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($roleID == 3){
            return view('lecturer.course_details_other')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        }
        return view('student.access_denied');
    }

    public function createCourse(Request $request){
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
                return app('App\Http\Controllers\DeptAdminController')->createCourse($request);
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function deleteCourse(Request $request){
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
                return app('App\Http\Controllers\DeptAdminController')->deleteCourse($request);
            case 6:
                return view('systemadmin.courses');
        }
    }

    public function updateCourseInfo(Request $request){
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
                return view('lecturer.access_denied');
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateCourseInfo($request);
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateCourseInfo($request);
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    public function addCourseConvenor(Request $request){
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addCourseConvenor($request);
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    public function addLecturer(Request $request){
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addLecturer($request);
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    public function addTA(Request $request){
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addTA($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('student.access_denied');
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->participantsList($request);
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
                throwException();
            case 2:
                /*return view('student.access_denied');*/

            case 3:
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->createCoursework($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->deleteCoursework($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->createSubcoursework($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->deleteSubcoursework($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('student.access_denied');
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getConvenors($request);
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
                return view('student.access_denied');
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getLecturers($request);
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
                return view('lecturer.access_denied');
            case 3:
            case 2:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getStudents($request);
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
                return view('student.access_denied');
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getTAs($request);
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSubminimumRow($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSection($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSection($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSubminimum($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimumRow($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimum($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 4:
            case 6:
            return app('App\Http\Controllers\LecturerController')->getSubCourseworks($request);
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
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsCourseworkMarks($request);
            case 6:
                return view('systemadmin.access_denied');
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
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsSubcourseworkMarks($request);
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSectionMarks($request);
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
            case 5:
                return app('App\Http\Controllers\LecturerController')->approveUsers($request);
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
            case 5:
                return app('App\Http\Controllers\LecturerController')->convenorsAccess($request);
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
            case 5:
                return app('App\Http\Controllers\LecturerController')->lecturersAccess($request);
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
            case 5:
                return app('App\Http\Controllers\LecturerController')->tasAccess($request);
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateCoursework($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateSubcoursework($request);
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSection($request);
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
                return view('lecturer.access_denied');
            case 4:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateSubminimum($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSubminimumRow($request);
            case 6:
                return view('systemadmin.access_denied');
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
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateStudentsList($request);
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
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->uploadSectionMarks($request);
            case 6:
                return view('systemadmin.access_denied');
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
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getSections($request);
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
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsMarks($request);
            case 6:
                return view('systemadmin.access_denied');
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
                return app('App\Http\Controllers\DeptAdminController')->getCourses($request);
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getCourses($request);
        }
    }

    public function updateFinalGrade(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID) {
            case 1:
            case 2:
                return view('student.access_denied');
            case 3:
                return view('lecturer.access_denied');
            case 5:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateFinalGrade($request);
            case 6:
                return view('systemadmin.courses');
        }

    }

    public function downloadFinalGrade(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID) {
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->downloadFinalGrade($request);
        }

    }

    public function downloadDPList(Request $request=null){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID) {
            case 1:
                return view('student.access_denied');
            case 2:
            case 3:
            case 5:
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->downloadDPList($request);
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

    public function faculties(){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getFaculties();
        }
    }

    public function getDepartments(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getDepartments($request);
        }
    }

    public function addDepartmentAdmin(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->addDepartmentAdmin($request);
        }
    }

    public function addFaculty(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->addFaculty($request);
        }
    }

    public function addDepartment(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->addDepartment($request);
        }
    }

    public function updateFaculty(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->updateFaculty($request);
        }
    }

    public function deleteFaculty(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->deleteFaculty($request);
        }
    }

    public function updateDepartment(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->updateDepartment($request);
        }
    }

    public function deleteDepartment(Request $request){
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
                return view('departmentadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->deleteDepartment($request);
        }
    }

    public function resetPassword(Request $request){
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
                return view('systemadmin.access_denied');
            case 6:
                return app('App\Http\Controllers\SysAdminController')->resetPassword($request);
        }
    }
}
