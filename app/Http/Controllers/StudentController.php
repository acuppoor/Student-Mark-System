<?php

namespace App\Http\Controllers;

use App\Coursework;
use App\SectionUserMarkMap;
use App\SubCourseworkUserMarkMap;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(){
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
            $result = [];
            $result['courseName'] = $course->name;
            $result['year'] = (explode('-', $course->start_date))[0];
            $courseworks = [];
            $cwrks = $course->courseworks;
            foreach ($cwrks as $cwrk){
                $coursework = [];
                $coursework['name'] = $cwrk->name;
                $subcwrks = $cwrk->subcourseworks;
                $subCourseworks = [];
                foreach ($subcwrks as $subcwrk){
                    // todo: check puclish date first, and display marks or percentage
                    $subCoursework = [];
                    $subCoursework['name'] = $subcwrk->name;
                    $subCoursework['max_marks'] = $subcwrk->max_marks;
                    $subCoursework['marks'] = $subcwrk->userMarkMap;

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
                $courseworks[] = $temp;
            }
            $result['courseworks'] = $courseworks;
            $results[] = $result;
        }

//        var_dump($subCourseworksMarks); die();
        return view('student.my_marks')->with('courses', $results);
    }
}
