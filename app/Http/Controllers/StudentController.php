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
    public function index(){
        return view('student.my_marks')->with('courses', $this->getCourses(null, null, null, null));
    }

    public function filter(Request $request){
        return Response::json($this->getCourses(
            $request->input('courseCode'),
            $request->input('courseYear'),
            $request->input('courseType'),
            $request->input('courseDepartment')
        ));
    }

    private function isSimilar($wordOne, $wordTwo){
        return true;
    }

    private function getCourses($courseCode=null, $year = null, $type=null, $department=null){
        if(!$year){
            $year = (int) date("Y");
        }
        $courses = [];
        $user = Auth::user();
        $subCourseworksMarks = $user->subCourseworkmarks;

        foreach ($subCourseworksMarks as $i){
            $subCoursework = $i->subcoursework;
            $coursework = $subCoursework->coursework;
            $course = $coursework->course;
            $courses[] = $course;
        }
        $courses = array_unique($courses);

        $results = [];
        foreach ($courses as $course){
            $courseYear = (explode('-', $course->start_date))[0];
            if(
                $courseYear != $year ||
                ($courseCode && !$this->isSimilar($courseCode, $course->code)) ||
                ($type && $course->type->name != $type) ||
                ($department && $course->department->name != $department)
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
//                print_r($s); die();
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
