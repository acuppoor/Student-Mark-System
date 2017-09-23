<?php

namespace App\Http\Controllers;

use App\Coursework;
use App\SectionUserMarkMap;
use App\SubCourseworkUserMarkMap;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    public function studentHome(){
        return view('student.my_marks')->with('courses', $this->getCourses(null, null, null, null));
    }

    public function marksFilter(Request $request){
        /*return Response::json($this->getCourses(
            $request->input('courseCode'),
            $request->input('courseYear'),
            $request->input('courseType'),
            $request->input('courseDepartment')
        ));*/
        return view('student.my_marks')
            ->with(array('courses'=> $this->getCourses(
                    $request->input('courseCode'),
                    $request->input('courseYear'),
                    $request->input('courseType'),
                    $request->input('courseDepartment')),
                'request'=> ""
            ));
    }

    public function taFilter($request){
        $courses = [];
        foreach (Auth::user()->courseTAMaps as $courseMap){
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
        return view('student.ta_courses')->with('courses', $courses);
//        return Response::json($courses);
    }

    public function getTaCourse($courseId){

    }

    public function getMarks(Request $request){
        $studentNumber = $request->input('studentNumber');
        $courseYear = $request->input('courseYear');
        $courseCode = $request->input('courseCode');

        $user = User::where('student_number', $studentNumber)->first();
        if(!$user || ($user->role_id != 1 && $user->role_id != 2)){
            return array();
        }

        $courses = [];
        foreach ($user->courseMaps as $courseMap) {
            $crs = $courseMap->course;
            if(explode('-', $crs['start_date'])[0] != $courseYear ||
                ($courseCode && !$this->isSimilar($crs['code'], $courseCode))
            ){
                continue;
            }

            $course = [];
            $course['code'] = $crs->code;
            $course['year'] = explode('-', $crs['start_date'])[0];
            // get the marks for the student. will follow same approach as student viewing their own marks.
            // once students' marks are optimised, then this one can be completed.
            $courses[] = $course;
        }
        return $courses;
    }

    private function isSimilar($wordOne, $wordTwo){
        return true;
    }

    private function getCourses($courseCode=null, $year = null, $type=null, $department=null){
        if(!$year){
            $year = (int) date("Y");
        }

        $courses = [];
        foreach (Auth::user()->courseMaps as $courseMap) {
            $courses[] = $courseMap->course;
        }

        $results = [];
        foreach ($courses as $course){
            $courseYear = (explode('-', $course->start_date))[0];
            if(
                $courseYear != $year ||
                ($courseCode && !$this->isSimilar($courseCode, $course->code)) ||
                ($type && $course->type->name != $type) ||
                ($department && ($course->department->code . ' - ' . $course->department->name) != $department)
            ){
                continue;
            }
            $classRecord = 0;
            $result = [];
            $result['courseName'] = $course->name;
            $result['year'] = $courseYear;
            $courseworks = [];
            $cwrks = $course->courseworks;
            foreach ($cwrks as $cwrk){
                $totalCourseworkMarks = 0;
                $subcwrks = $cwrk->subcourseworks;
                $subCourseworks = [];
                foreach ($subcwrks as $subcwrk){
                    // todo: check puclish date first, and display marks or percentage
                    $subCoursework = [];
                    $subCoursework['name'] = $subcwrk->name;
                    $subCoursework['max_marks'] = $subcwrk->max_marks;
                    $subCoursework['marks'] = $subcwrk->userMarkMap->marks;
                    $subCoursework['weighting'] = $subcwrk->weighting_in_coursework;
                    $subCoursework['weighted_marks'] =
                        ($subCoursework['marks']/(double)$subCoursework['max_marks'])*$subCoursework['weighting'];
                    $totalCourseworkMarks += $subCoursework['weighted_marks'];

                    $sctns=$subcwrk->sections;
                    $sections = [];
                    foreach ($sctns as $sctn){
                        $section['name'] = $sctn->name;
                        $section['marks'] = $sctn->userMarkMap->marks;
                        $section['max_marks'] = $sctn->max_marks;
                        $sections[] = $section;
                    }
                    $subCoursework['sections'] = $sections;
                    $subCourseworks[] = $subCoursework;
                }
                $temp['name'] = $cwrk->name;
                $temp['contents'] = $subCourseworks;
                $temp['total'] = $totalCourseworkMarks;
                $temp['weighting'] = $cwrk->weighting_in_classrecord;
                $temp['weighted_marks'] = ((double)$temp['total'] * $temp['weighting'] / 100.0);
                $classRecord += $temp['weighted_marks'];
                $courseworks[] = $temp;
            }
            $result['courseworks'] = $courseworks;
            $result['classrecord'] = $classRecord;
            $results[] = $result;
        }
        return $results;
    }


}
