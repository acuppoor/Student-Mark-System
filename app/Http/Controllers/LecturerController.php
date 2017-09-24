<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\CourseType;
use App\LecturerCourseMap;
use App\TACourseMap;
use App\User;
use App\UserCourseMap;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{

    public function getCourseDetails($courseId){
        return $this->getCourseInfo($courseId);
    }

    private function getCourseInfo($courseId){
        $course = Course::where('id', $courseId)->first();
        return array(
            'id' => $courseId,
            'name' => $course->name,
            'code' => $course->code,
            'term' => $course->term_number,
            'type' => $course->type->name,
            'start_date' => $course->start_date,
            'end_date' => $course->end_date,
            'description' => $course->description,
            'year' => explode('-', $course->start_date)[0]
        );
    }


    public function getLecturerCourses(Request $request){
        $courseMaps = Auth::user()->lecturerCourseMaps;
        $courses = [];

        foreach ($courseMaps as $courseMap) {
            $crs = $courseMap->course;
            $course = [];
            $course['year'] = explode('-', $crs->start_date)[0];
            $course['type'] = $crs->type->name;

            if($request && (
                    ($request->input('courseCode') && !$this->isSimilar($crs->name, $request->input('courseCode'))) ||
                    ($request->input('courseDepartment') && $crs->department->code.' - '.$crs->department->name != $request->input('courseDepartment')) ||
                    ($request->input('courseYear') && $course['year'] != $request->input('courseYear')) ||
                    ($request->input('courseType') && $course['type'] != $request->input('courseType'))
                )){
                continue;
            }
            $course['id'] = $crs->id;
            $course['name'] = $crs->name;
            $course['description'] = $crs->description;
            $course['code'] = $crs->code;
            $course['term_number'] = $crs->term_number;
            $course['start_date'] = $crs->start_date;
            $course['end_date'] = $crs->end_date;
            $course['department'] = $crs->department->name;
            $course['faculty'] = $crs->department->faculty->name;
            $courses[] = $course;
        }
//        print_r($courses);die();
        return $courses;
    }

    public function getConveningCourses(Request $request){
        $courseMaps = Auth::user()->convenorCourseMaps;
        $courses = [];
        foreach ($courseMaps as $courseMap) {
            $crs = $courseMap->course;
//            print_r($crs);die();
            $course = [];
            $course['year'] = explode('-', $crs->start_date)[0];
            $course['type'] = $crs->type->name;

            if($request && (
                    ($request->input('courseCode') && !$this->isSimilar($crs->name, $request->input('courseCode'))) ||
                    ($request->input('courseDepartment') && $crs->department->code.' - '.$crs->department->name != $request->input('courseDepartment')) ||
                    ($request->input('courseYear') && $course['year'] != $request->input('courseYear')) ||
                    ($request->input('courseType') && $course['type'] != $request->input('courseType'))
                )){
                continue;
            }
            $course['id'] = $crs->id;
            $course['name'] = $crs->name;
            $course['description'] = $crs->description;
            $course['code'] = $crs->code;
            $course['term_number'] = $crs->term_number;
            $course['start_date'] = $crs->start_date;
            $course['end_date'] = $crs->end_date;
            $course['department'] = $crs->department->name;
            $course['faculty'] = $crs->department->faculty->name;
            $courses[] = $course;
        }
        return $courses;
    }

    public function getOtherCourses(Request $request){
        $departmentCourses = Auth::user()->departmentMaps->first()->department->courses;
//        print_r($this->getConveningCourses($request));die();
        $otherCourses = array_merge($this->getLecturerCourses($request), $this->getConveningCourses($request));
        $courses = [];
        foreach ($departmentCourses as $crs) {
            /*if(!empty(array_search($crs->id, array_column($otherCourses, 'id')))){
                continue;
            }*/
            $contains = false;
            foreach ($otherCourses as $c){
                if($c['id'] == $crs->id){
                    $contains = true;
                    break;
                }
            }
            if($contains){continue;}

            $course = [];
            $course['year'] = explode('-', $crs->start_date)[0];
            $course['type'] = $crs->type->name;

            if($request && (
                    ($request->input('courseCode') && !$this->isSimilar($crs->name, $request->input('courseCode'))) ||
                    ($request->input('courseDepartment') && $crs->department->code.' - '.$crs->department->name != $request->input('courseDepartment')) ||
                    ($request->input('courseYear') && $course['year'] != $request->input('courseYear')) ||
                    ($request->input('courseType') && $course['type'] != $request->input('courseType'))
                )){
                continue;
            }
            $course['id'] = $crs->id;
            $course['name'] = $crs->name;
            $course['description'] = $crs->description;
            $course['code'] = $crs->code;
            $course['term_number'] = $crs->term_number;
            $course['start_date'] = $crs->start_date;
            $course['end_date'] = $crs->end_date;
            $course['department'] = $crs->department->name;
            $course['faculty'] = $crs->department->faculty->name;
            $courses[] = $course;
        }
        return $courses;
    }


    private function isSimilar($wordOne, $wordTwo){
        return true;
    }

    public function updateCourseInfo(Request $request, $courseId){
        $course = Course::where('id', $courseId)->first();
        $course->name = $request->input('name');
        $course->code = $request->input('code');
        $course->type_id = CourseType::where('name', $request->input('type'))->first()->id;
        $course->description = $request->input('description');
        $course->start_date = $request->input('startDate');
        $course->end_date = $request->input('endDate');
        $course->term_number = $request->input('term');

        $course->save();
        return Response::json("Success");
    }

    public function addCourseConvenor(Request $request, $courseId){
        $email = $request->input('email');
        $user = User::where('email', $email)->firstOrCreate(
            ['email'=> $email],
            ['account_registered' => 0]
            );
        $user->role_id = 4;
        $user->approved = 1; $user->save();
//        print_r($user);die();
        $convenorCourseMap = new ConvenorCourseMap();
        $convenorCourseMap->user_id = $user->id;
        $convenorCourseMap->course_id = $courseId;
        $convenorCourseMap->status = 1;
        $convenorCourseMap->save();

        return Response::json("Success");
    }

    public function addLecturer(Request $request, $courseId){
        $email = $request->input('email');
        $user = User::where('email', $email)->firstOrCreate(
            ['email'=> $email],
            ['account_registered' => 0]
        );
        $user->approved = 1;
        $user->role_id = 3; $user->save();
//        print_r($user);die();
        $lecturerCourseMap = new LecturerCourseMap();
        $lecturerCourseMap->user_id = $user->id;
        $lecturerCourseMap->course_id = $courseId;
        $lecturerCourseMap->status = 1;
        $lecturerCourseMap->save();

        return Response::json("Success");
    }

    public function addTA(Request $request, $courseId){
        $email = $request->input('email');
        $user = User::where('email', $email)->firstOrCreate(
            ['email'=> $email],
            ['account_registered' => 0]
        );
        $user->approved = 1;
        $user->role_id = 2; $user->save();
//        print_r($user);die();
        $taCourseMap = new TACourseMap();
        $taCourseMap->user_id = $user->id;
        $taCourseMap->course_id = $courseId;
        $taCourseMap->status = 1;
        $taCourseMap->save();

        return Response::json("Success");
    }


    public function participantsList(Request $request){
        $email = $request->input('emailAddress');
        $studentNumber = $request->input('studentNumber');
        $courseId = $request->input('courseId');
        $users = null;
        if($studentNumber && $email){
            $users = User::where('email', $email)->where('student_number', $studentNumber)->get();
        } else if ($email){
            $users = User::where('email', $email)->get();
        } else if ($studentNumber){
            $users = User::where('student_number', $studentNumber)->get();
        } else {
            // must select al the students in the course
        }
        $results=[];
        if($users){
            foreach ($users as $user){
                $studentMap = UserCourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();
                $lecturerMap = LecturerCourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();
                $convenorMap = ConvenorCourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();
                $taMap = TACourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();

                $status = -1;
                $role = "";
                if($studentMap){
                    $status=$studentMap->status;
                    $role .= "Student";
                }
                if($lecturerMap) {
                    $status = $lecturerMap->status;
                    $role .= ($role ? ' | ' : '') . "Lecturer";
                }
                if($convenorMap) {
                    $status = $convenorMap->status;
                    $role .= ($role ? ' | ' : '') . "Course Convenor";
                }
                if($taMap){
                    $status=$taMap->status;
                    $role .= ($role?' | ':'')."Teaching Assistant";
                }
                if($status != -1){
                    $result = [];
                    $result["firstName"] = $user->first_name;
                    $result["lastName"] = $user->last_name;
                    $result["studentNumber"] = $user->student_number;
                    $result["email"] = $user->email;
                    $result["employeeId"]= $user->employee_id;
                    $result["role"] = $role;
                    $result["status"] = "Registered";
                    $result["approved"] = $user->approved==1?'Yes':'No';
                    $results[] = $result;
                }
            }
        }
        return Response::json($results);
    }
}
