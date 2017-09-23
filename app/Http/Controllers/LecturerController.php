<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
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
}
