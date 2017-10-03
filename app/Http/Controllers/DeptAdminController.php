<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\Coursework;
use App\CourseworkType;
use App\DeptAdminDeptMap;
use App\FinalGradeType;
use App\LecturerCourseMap;
use App\SectionUserMarkMap;
use App\SubCoursework;
use App\TACourseMap;
use App\User;
use App\UserCourseFinalGrade;
use App\UserCourseMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeptAdminController extends Controller
{
    private function isSimilar($haystack, $needle){
        $pos = strpos(strtolower($haystack), strtolower($needle));
        return ($pos===0||$pos>=1) || strtolower($haystack)==strtolower($needle);
    }

    public function getCourses(Request $request){
        $deptAdminMap = Auth::user()->departmentAdminMap;

        if(!$deptAdminMap){
            return view('departmentadmin.courses')->with('courses', []);
        }

        $selectedCourses = $deptAdminMap->department->courses;

        $courses = [];
        foreach ($selectedCourses as $crs) {

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

        return view('departmentadmin.courses')->with('courses', $courses);
    }

    public function getCourseDetails($courseId){
        $course = Course::where('id', $courseId)->first();

        $deptAdminMap = Auth::user()->departmentAdminMap;
        $courseDepartment = $course?$course->department:'';

        if(!$course || !$deptAdminMap || $courseDepartment->id != $deptAdminMap->department_id){
            return view('departmentadmin.access_denied');
        }

        $courseDetails =  array(
            'id' => $courseId,
            'students_count' => UserCourseMap::where('course_id', $courseId)->count(),
            'name' => $course->name,
            'code' => $course->code,
            'term' => $course->term_number,
            'type' => $course->type->name,
            'start_date' => $course->start_date,
            'end_date' => $course->end_date,
            'description' => $course->description,
            'year' => explode('-', $course->start_date)[0]
        );

        $crswrks = $course->courseworks;
        $courseworks = [];
        foreach($crswrks as $crswrk){
            $coursework = [];
            $coursework['id'] = $crswrk->id;
            $coursework['name'] = $crswrk->name;
            $coursework['type'] = CourseworkType::where('id', $crswrk->coursework_type_id)->first()->name;
            $coursework['display_to_students'] = $crswrk->display_to_students;
            $coursework['weighting_in_classrecord'] = $crswrk->weighting_in_classrecord;
            $coursework['weighting_in_yearmark'] = $crswrk->weighting_in_yearmark;

            $subcrswrks = $crswrk->subcourseworks;
            $subcourseworks = [];

            foreach ($subcrswrks as $subcrswrk){
                $subcoursework = [];
                $subcoursework['id'] = $subcrswrk->id;
                $subcoursework['name'] = $subcrswrk->name;
                $subcoursework['display_to_students'] = $subcrswrk->display_to_students;
                $subcoursework['display_marks'] = $subcrswrk->display_marks;
                $subcoursework['display_percentage'] = $subcrswrk->display_percentage;
                $subcoursework['weighting'] = $subcrswrk->weighting_in_coursework;
                $subcoursework['max_marks'] = $subcrswrk->max_marks;

                $sections = [];
                foreach($subcrswrk->sections as $sctn){
                    $section = [];
                    $section['id'] = $sctn->id;
                    $section['name'] = $sctn->name;
                    $section['max_marks'] = $sctn->max_marks;
                    $sections[] = $section;
                }
                $subcoursework['sections'] = $sections;
                $subcourseworks[] = $subcoursework;
            }
            $coursework['subcourseworks'] = $subcourseworks;
            $courseworks[] = $coursework;
        }
        $courseDetails['courseworks'] = $courseworks;

        $subminimums = [];
        foreach($course->subminimums as $subm){
            $submininum = [];
            $subminimum['id'] = $subm->id;
            $subminimum['name'] = $subm->name;
            $subminimum['for_dp'] = $subm->for_dp;
            $subminimum['threshold'] = $subm->threshold;

            $rows = [];
            foreach ($subm->subminimumRows as $rw){
                $row = [];
                $row['id'] = $rw->id;
                $row['coursework'] = Coursework::where('id', $rw->coursework_id)->first()->name;
                $row['coursework_id'] = $rw->coursework_id;
                $subcwrk = SubCoursework::where('id', $rw->subcoursework_id)->first();
                $row['subcoursework_id'] = $subcwrk?$subcwrk->id:-1;
                $row['subcoursework'] = $subcwrk? $subcwrk->name : '';
                $row['weighting'] = $rw->weighting;
                $rows[] = $row;
            }
            $subminimum['rows'] = $rows;
            $subminimums[] = $subminimum;
        }
        $courseDetails['subminimums'] = $subminimums;
        return view('departmentadmin.course_details')->with('course', $courseDetails);;

    }

    public function createCourse(Request $request){
        $name = $request->input('name');
        $code = $request->input('code');
        $description = $request->input('description');
        $type = $request->input('type');
        $term = $request->input('term');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $endDate = $endDate?$endDate:$startDate;

        $dept = Auth::user()->departmentAdminMap->department;
        $deptId = $dept->id;

        if(!$dept || !$deptId){
            throwException();
        }

        $course = new Course();
        $course->name = $name;
        $course->description = $description;
        $course->code = $code;
        $course->type_id = $type;
        $course->term_number = $term;
        $course->start_date = $startDate;
        $course->end_date = $endDate;
        $course->department_id = $deptId;
        $course->save();
    }

    public function deleteCourse(Request $request){
        $courseId = $request->input('courseId');

        $dept = Auth::user()->departmentAdminMap->department;
        $deptId = $dept->id;
        $course = Course::where('id', $courseId)->first();

        if(!$dept || !$deptId || !$course || $course->department_id != $deptId){
            throwException();
        }

        UserCourseMap::where('course_id', $courseId)->delete();
        TACourseMap::where('course_id', $courseId)->delete();
        LecturerCourseMap::where('course_id', $courseId)->delete();
        ConvenorCourseMap::where('course_id', $courseId)->delete();

        $courseworks = $course->courseworks;
        foreach ($courseworks as $coursework) {
            foreach ($coursework->subcourseworks as $subcoursework) {
                foreach ($subcoursework->sections as $section) {
                    SectionUserMarkMap::where('section_id', $section->id)->delete();
                    $section->delete();
                }
                $subcoursework->delete();
            }
            $coursework->delete();
        }
        $course->delete();
    }

}
