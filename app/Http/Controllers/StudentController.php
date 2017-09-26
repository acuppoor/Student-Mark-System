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

    private function getCourses($courseCode=null, $year = null, $type=null, $department=null){ // student
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
            $classMark = 0.0;
            $yearMark = 0.0;
            $result = [];
            $result['courseName'] = $course->code;
            $result['year'] = $courseYear;
            $courseworks = [];
            $cwrks = $course->courseworks;
            foreach ($cwrks as $cwrk){
                if($cwrk->display_to_students > (date('Y').'-'.date('m').'-'.date('d'))){
                    continue;
                }
                $weightingYear = $cwrk->weighting_in_yearmark;
                $weightingClass = $cwrk->weighting_in_classrecord;

                $courseworkTotalMark = 0;

                $subcourseworks = [];

                foreach ($cwrk->subcourseworks as $subcwrk) {
                    if($subcwrk->display_to_students > (date('Y').'-'.date('m').'-'.date('d'))){
                        continue;
                    }

                    $subcoursework = [];
                    $subcoursework['name'] = $subcwrk->name;
                    $subcoursework['max_marks'] = $subcwrk->max_marks;
                    $subcoursework['weighting'] = $subcwrk->weighting_in_coursework;

                    $subcourseworkFinalMark = 0.0;
                    $subcourseworkMarkN = 0.0;
                    $subcourseworkMarkD = 0.0;

                    $sections = [];
                    foreach ($subcwrk->sections as $sctn){
                        $mark = SectionUserMarkMap::where('section_id', $sctn->id)
                                                    ->where('user_id', Auth::user()->id)->first();

                        $mark = $mark? $mark->marks:0;

                        $subcourseworkMarkD += $sctn->max_marks;
                        $subcourseworkMarkN += $mark;

                        $section['name'] = $sctn->name;
                        $section['marks'] = $mark;
                        $section['max_marks'] = $sctn->max_marks;
                        $sections[] = $section;
                    }
                    $subcourseworkFinalMark = $subcourseworkMarkD==0?0:($subcourseworkMarkN/$subcourseworkMarkD)*$subcwrk->weighting_in_coursework;
                    $subcoursework['numerator'] = $subcourseworkMarkN;
                    $subcoursework['denominator'] = $subcourseworkMarkD;
                    $subcoursework['weighted_marks'] = $subcourseworkFinalMark;
                    $subcoursework['sections'] = $sections;
                    $subcourseworks[] = $subcoursework;
                    $courseworkTotalMark += $subcourseworkFinalMark;
                }

                $coursework['name'] = $cwrk->name;
                $coursework['subcourseworks'] = $subcourseworks;
                $coursework['total_marks'] = $courseworkTotalMark;
                $coursework['weighting_classrecord'] = $cwrk->weighting_in_classrecord;
                $coursework['weighting_yearmark'] = $cwrk->weighting_in_yearmark;
                $coursework['weighted_mark_class'] = $courseworkTotalMark * $weightingClass / 100.0;
                $coursework['weighted_mark_year'] = $courseworkTotalMark * $weightingYear / 100.0;
                $classMark += $coursework['weighted_mark_class'];
                $yearMark += $coursework['weighted_mark_year'];
                $courseworks[] = $coursework;
            }
            $result['courseworks'] = $courseworks;
            $result['class_mark'] = $classMark;
            $result['year_mark'] = $yearMark;
            $result['final_mark'] = $yearMark;
            $result['dp_status'] = 'DP';
            $results[] = $result;
        }
        return $results;
    }


}
