<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\LecturerCourseMap;
use App\TACourseMap;
use App\UserDepartmentMap;
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
     * initially there is no result
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
                return view('lecturer.searchmarks')->with('courses', array());
            case 5:
                return view('departmentadmin.searchmarks')->with('courses', array());
            case 6:
                return view('systemadmin.searchmarks')->with('courses', array());
        }
    }

    /*
     * return the searchmarks page with the result being a list of courses
     * delegates the request to the appropriate controller based on the user role id
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
                return view('lecturer.searchmarks')->with('courses', app('App\Http\Controllers\LecturerController')->getMarks($request));
            case 5:
                return view('departmentadmin.searchmarks')->with('courses', app('App\Http\Controllers\LecturerController')->getMarks($request));
            case 6:
                return view('systemadmin.searchmarks')->with('courses', app('App\Http\Controllers\SysAdminController')->getMarks($request));
        }
    }

    /*
     * return the 'my_marks' page for student/TA
     * and prevents other kind of users from accessing the page
     * */
    public function myMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
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
                return view('lecturer.access_denied');
            case 4:
                return view('lecturer.convening_courses')->with('courses', app('App\Http\Controllers\LecturerController')->getConveningCourses($request));
            case 5:
                return view('departmentadmin.access_denied');
            case 6:
                return view('systemadmin.access_denied');
        }
    }

    /**
     * returns the course management page with the course details
     * @param $courseId
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCourseDetails($courseId){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        $course = Course::where('id', $courseId)->first();
        if($roleID == 5){
            if(!$course){
                return view('departmentadmin.access_denied');
            }
            $deptMap = UserDepartmentMap::where('user_id', Auth::user()->id)
                    ->where('department_id', $course->department->id)->first();
            if($deptMap) {
                return app('App\Http\Controllers\DeptAdminController')->getCourseDetails($courseId);
            } else {
                return view('departmentadmin.access_denied');
            }
        } else if($roleID == 6){
            return view('systemadmin.course_details_super')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        }

        $convenorMap = ConvenorCourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();
        $lecturerMap = LecturerCourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();
        $taMap = TACourseMap::where('course_id', $courseId)->where('user_id', Auth::user()->id)->first();

        if($convenorMap && $convenorMap->status == 1){
            return view('lecturer.course_details_convenor')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($lecturerMap && $lecturerMap->status == 1){
            return view('lecturer.course_details_lecturer')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($taMap && $taMap->status == 1){
            return view('student.course_details_ta')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
        } else if($roleID == 3){
            if(!$course){
                return view('lecturer.access_denied');
            }
            $deptMap = UserDepartmentMap::where('user_id', Auth::user()->id)
                ->where('department_id', $course->department->id)->first();
            if($deptMap) {
                return view('lecturer.course_details_other')->with('course', app('App\Http\Controllers\LecturerController')->getCourseDetails($courseId));
            } else {
                return view('lecturer.access_denied');
            }
        }
        return view('student.access_denied');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return app('App\Http\Controllers\SysAdminController')->createCourse($request);
        }
    }

    /**
     * Delete a course, only available to dept admins and sys admins
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return app('App\Http\Controllers\SysAdminController')->deleteCourse($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 5:
            case 6:
                return app('App\Http\Controllers\LecturerController')->updateCourseInfo($request);
        }
    }

    /**
     * Add a convenor to a course
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addCourseConvenor($request);
        }
    }

    /**
     * add a lecturer to a course
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addLecturer($request);
        }
    }

    /**
     * Add TA to a course
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->addTA($request);
        }
    }

    /**
     * returns the path for the course studentslist so that it can be downloaded on the client's side
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function participantsList(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                throwException();return;
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->participantsList($request);
        }
    }

    /**
     * allows CC, dept admin and sys admin to create coursework
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException(); return;
            case 4:
            case 5:
            case 6:
                return app('App\Http\Controllers\LecturerController')->createCoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteCoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException(); return;
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->deleteCoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException(); return;
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->createSubcoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleteSubcoursework(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
            case 3:
                throwException();
                return;
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->deleteSubcoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getConvenors(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                throwException();
                return;
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getConvenors($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLecturers(Request $request){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                throwException(); return;
            case 2:
            case 3:
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->getLecturers($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
                return app('App\Http\Controllers\LecturerController')->createSubminimumRow($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSection($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSection($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->createSubminimum($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimumRow($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->deleteSubminimum($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudentsCourseworkMarks(Request $request){
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsCourseworkMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudentsSubcourseworkMarks(Request $request){
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsSubcourseworkMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSectionMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->approveUsers($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->convenorsAccess($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->lecturersAccess($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->tasAccess($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateCoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateSubcoursework($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSection($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateSubminimum($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateSubminimumRow($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return view('lecturer.access_denied');
            case 4:
            case 6:
            case 5:
                return app('App\Http\Controllers\LecturerController')->updateStudentsList($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
                return view('lecturer.access_denied');
            case 5:
            case 4:
            case 6:
                return app('App\Http\Controllers\LecturerController')->uploadSectionMarks($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getGradeTypes(Request $request){
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getGradeTypes($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSections(Request $request){
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getSections($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStudentsMarks(Request $request){
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->getStudentsMarks($request);
        }
    }

    /**
     * get courses which the user is not lecturing or convening
     * @param Request|null $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request|null $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            case 6:
            case 4:
                return app('App\Http\Controllers\LecturerController')->updateFinalGrade($request);
        }

    }

    /**
     * @param Request|null $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request|null $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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

    /**
     * @param $courseId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faculties(){
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
            case 5:
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getFaculties();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDepartments(Request $request){
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
            case 5:
            case 6:
                return app('App\Http\Controllers\SysAdminController')->getDepartments($request);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
