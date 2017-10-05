<?php

namespace App\Http\Controllers;

use App\Course;
use App\Coursework;
use App\FinalGradeType;
use App\SectionUserMarkMap;
use App\SubCourseworkUserMarkMap;
use App\TACourseMap;
use App\User;
use App\UserCourseFinalGrade;
use App\UserCourseMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    /**
     * return the student home/marks page with the courses array
     * @return $this
     */
    public function studentHome(){
        return view('student.my_marks')->with('courses', $this->getCourses(null, null, null, null));
    }

    /**
     * calls the getCourses function with search-filters passed into the request object
     * @param Request $request
     * @return $this
     */
    public function marksFilter(Request $request){
        return view('student.my_marks')
            ->with(array('courses'=> $this->getCourses(
                    $request->input('courseCode'),
                    $request->input('courseYear'),
                    $request->input('courseType'),
                    $request->input('courseDepartment')),
                'request'=> ""
            ));
    }

    /**
     * filters out the courses which the TA can see
     * put them in an array with their details
     * returns the ta_courses view with the list of courses
     * @param $request
     * @return $this
     */
    public function taFilter($request){
        $courses = [];
        foreach (Auth::user()->courseTAMaps as $courseMap){
            if($courseMap->status == 0){
                continue;
            }
            $crs = $courseMap->course;
            $course = [];
            $course['year'] = explode('-', $crs->start_date)[0];
            $course['type'] = $crs->type->name;

            if($request && (
                ($request->input('courseCode') && !$this->isSimilar($crs->code, $request->input('courseCode'))) ||
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
    }

    /**
     * get the marks for a student. takes in a compulsory studentnumber and optional year and optional coursecode
     * search for the students' marks and return that to the view
     * @param Request $request
     * @return array|void
     */
    public function getMarks(Request $request){
        $studentNumber = $request->input('studentNumber');
        $courseYear = $request->input('courseYear');
        $courseCode = $request->input('courseCode');

        $student = User::where('student_number', $studentNumber)->orWhere('employee_id', $studentNumber)->first();
        if(!$studentNumber || !$student){return;}

        $taMaps = Auth::user()->courseTAMaps;
        $possibleCourses = [];
        foreach ($taMaps as $taMap) {
            if($taMap->status == 0){continue;}
            $crs = $taMap->course;
            if(($courseCode && $this->isSimilar($crs->code, $courseCode)) && ($courseYear && explode('-', $crs->start_date)[0]==$courseYear)) {
                $possibleCourses[] = $crs;
            } else if(!$courseCode && $courseYear && explode('-', $crs->start_date)[0]==$courseYear) {
                $possibleCourses[] = $crs;
            } else if(!$courseYear && $courseCode && $this->isSimilar($crs->code, $courseCode)){
                $possibleCourses[] = $crs;
            } else if(!$courseCode && !$courseYear) {
                $possibleCourses[] = $crs;
            }
        }

        $courses = [];
        $userId = $student->id;
        foreach ($possibleCourses as $possibleCourse) {
            $courseId = $possibleCourse->id;
            $studentCourseMap = UserCourseMap::where('user_id', $userId)->where('course_id', $courseId)->first();
            if(!$studentCourseMap){
                continue;
            }
            $courses[] = $possibleCourse;
        }


        $results = [];
        foreach ($courses as $course){
            $classMark = 0.0;
            $yearMark = 0.0;
            $result = [];
            $result['courseName'] = $course->code;
            $result['year'] = $courseYear;
            $courseworks = [];
            $cwrks = $course->courseworks;


            // DP Calculation starts
            $subms = $course->subminimums;
            $subminimums = [];
            foreach ($subms as $subm) {
                if($subm->for_dp == 1){
                    $subminimum = [];
                    $subminimum['threshold'] = $subm->threshold;
                    $rows = [];
                    $rws = $subm->subminimumRows;
                    foreach ($rws as $rw) {
                        $row = [];
                        $row['coursework_id'] = $rw->coursework_id;
                        $row['subcoursework_id'] = $rw->subcoursework_id;
                        $row['weighting'] = $rw->weighting;
                        $rows[] = $row;
                    }
                    $subminimum['rows'] = $rows;
                    $subminimums[] = $subminimum;
                }
            }
            $submCourseworks = [];
            // DP Calculation stops


            foreach ($cwrks as $cwrk){
                if($cwrk->display_to_students > (date('Y').'-'.date('m').'-'.date('d'))){
                    continue;
                }

                $weightingYear = $cwrk->weighting_in_yearmark;
                $weightingClass = $cwrk->weighting_in_classrecord;

                $courseworkTotalMark = 0;

                $subcourseworks = [];
                $submSubcourseworks = [];

                foreach ($cwrk->subcourseworks as $subcwrk) {
                    if($subcwrk->display_to_students > (date('Y').'-'.date('m').'-'.date('d'))){
                        continue;
                    }

                    $subcoursework = [];
                    $subcoursework['name'] = $subcwrk->name;
                    $subcoursework['max_marks'] = round($subcwrk->max_marks, 2);
                    $subcoursework['weighting'] = round($subcwrk->weighting_in_coursework, 2);

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
                        $section['marks'] = round($mark, 2);
                        $section['max_marks'] = round($sctn->max_marks, 2);
                        $sections[] = $section;
                    }
                    $subcourseworkFinalMark = $subcourseworkMarkD==0?0:($subcourseworkMarkN/$subcourseworkMarkD)*$subcwrk->weighting_in_coursework;
                    $subcoursework['numerator'] = round($subcourseworkMarkN, 2);
                    $subcoursework['denominator'] = round($subcourseworkMarkD, 2);
                    $subcoursework['weighted_marks'] = round($subcourseworkFinalMark, 2);
                    $subcoursework['sections'] = $sections;
                    $subcourseworks[] = $subcoursework;
                    $courseworkTotalMark += $subcourseworkFinalMark;
                    $submSubcourseworks[$subcwrk->id] = $subcourseworkMarkD!=0?($subcourseworkMarkN*100.0)/$subcourseworkMarkD:0;
                }

                $coursework['name'] = $cwrk->name;
                $coursework['subcourseworks'] = $subcourseworks;
                $coursework['total_marks'] = round($courseworkTotalMark, 2);
                $coursework['weighting_classrecord'] = round($cwrk->weighting_in_classrecord, 2);
                $coursework['weighting_yearmark'] = round($cwrk->weighting_in_yearmark, 2);
                $coursework['weighted_mark_class'] = round(($courseworkTotalMark * $weightingClass / 100.0), 2);
                $coursework['weighted_mark_year'] = round(($courseworkTotalMark * $weightingYear / 100.0), 2);
                $classMark += $coursework['weighted_mark_class'];
                $yearMark += $coursework['weighted_mark_year'];
                $courseworks[] = $coursework;

                $submCoursework = [];
                $submCoursework['total'] = $courseworkTotalMark;
                $submCoursework['subs'] = $submSubcourseworks;
                $submCourseworks[$cwrk->id] = $submCoursework;

            }
            $result['courseworks'] = $courseworks;
            $result['class_mark'] = round($classMark, 2);
            $result['year_mark'] = round($yearMark, 2);

            $finalGrade = UserCourseFinalGrade::where('user_id',Auth::user()->id)
                ->where('course_id', $course->id)->first();
            if($finalGrade){
                if($finalGrade->type_id == 1){
                    $result['final_mark'] = round($yearMark, 2);
                } else {
                    $result['final_mark'] = FinalGradeType::where('id', $finalGrade->type_id)->first()->name;
                }
            } else {
                $result['final_mark'] = round($yearMark, 2);
            }

            $result['dp_status'] = 'DP';
//            print_r($subminimums); print_r($submCourseworks); die();

            foreach ($subminimums as $subminimum) {
                $threshold = $subminimum['threshold'];
                $total = 0;
                foreach ($subminimum['rows'] as $row) {
                    $cwrk = $submCourseworks[$row['coursework_id']];
                    if($row['subcoursework_id'] && $row['subcoursework_id']!=-1){
                        $subcwrkMarks = $cwrk['subs'][$row['subcoursework_id']];
                        $total += ($subcwrkMarks*$row['weighting']/100.0);
                    } else {
                        $total += ($cwrk['total']*$row['weighting']/100.0);
                    }
                }
                if($total<$threshold){
                    $result['dp_status'] = 'DPR';
                    break;
                }
            }

            $results[] = $result;
        }
        return $results;

    }

    /**
     * utility function to check for similarity between 2 strings.
     * Works same way as the LIKE sql operator.
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function isSimilar($haystack, $needle){
        $pos = strpos(strtolower($haystack), strtolower($needle));
        return ($pos===0||$pos>=1) || strtolower($haystack)==strtolower($needle);
    }

    /**
     * returns a list of courses which the students can see with their marks
     * DP calculation and course/subcoursework/classmark/yearmark calculations are done here
     * @param null $courseCode
     * @param null $year
     * @param null $type
     * @param null $department
     * @return array
     */
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
                ($courseCode && !$this->isSimilar($course->code, $courseCode)) ||
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


            // DP Calculation starts
            $subms = $course->subminimums;
            $subminimums = [];
            foreach ($subms as $subm) {
                if($subm->for_dp == 1){
                    $subminimum = [];
                    $subminimum['threshold'] = $subm->threshold;
                    $rows = [];
                    $rws = $subm->subminimumRows;
                    foreach ($rws as $rw) {
                        $row = [];
                        $row['coursework_id'] = $rw->coursework_id;
                        $row['subcoursework_id'] = $rw->subcoursework_id;
                        $row['weighting'] = $rw->weighting;
                        $rows[] = $row;
                    }
                    $subminimum['rows'] = $rows;
                    $subminimums[] = $subminimum;
                }
            }
            $submCourseworks = [];
            // DP Calculation stops


            foreach ($cwrks as $cwrk){
                if($cwrk->display_to_students > (date('Y').'-'.date('m').'-'.date('d'))){
                    continue;
                }

                $weightingYear = $cwrk->weighting_in_yearmark;
                $weightingClass = $cwrk->weighting_in_classrecord;

                $courseworkTotalMark = 0;

                $subcourseworks = [];
                $submSubcourseworks = [];

                foreach ($cwrk->subcourseworks as $subcwrk) {
                    if($subcwrk->display_to_students > (date('Y').'-'.date('m').'-'.date('d'))){
                        continue;
                    }

                    $subcoursework = [];
                    $subcoursework['name'] = $subcwrk->name;
                    $subcoursework['max_marks'] = round($subcwrk->max_marks, 2);
                    $subcoursework['weighting'] = round($subcwrk->weighting_in_coursework, 2);

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
                        $section['marks'] = round($mark, 2);
                        $section['max_marks'] = round($sctn->max_marks, 2);
                        $sections[] = $section;
                    }
                    $subcourseworkFinalMark = $subcourseworkMarkD==0?0:($subcourseworkMarkN/$subcourseworkMarkD)*$subcwrk->weighting_in_coursework;
                    $subcoursework['numerator'] = round($subcourseworkMarkN, 2);
                    $subcoursework['denominator'] = round($subcourseworkMarkD, 2);
                    $subcoursework['weighted_marks'] = round($subcourseworkFinalMark, 2);
                    $subcoursework['sections'] = $sections;
                    $subcourseworks[] = $subcoursework;
                    $courseworkTotalMark += $subcourseworkFinalMark;
                    $submSubcourseworks[$subcwrk->id] = $subcourseworkMarkD!=0?($subcourseworkMarkN*100.0)/$subcourseworkMarkD:0;
                }

                $coursework['name'] = $cwrk->name;
                $coursework['subcourseworks'] = $subcourseworks;
                $coursework['total_marks'] = round($courseworkTotalMark, 2);
                $coursework['weighting_classrecord'] = round($cwrk->weighting_in_classrecord, 2);
                $coursework['weighting_yearmark'] = round($cwrk->weighting_in_yearmark, 2);
                $coursework['weighted_mark_class'] = round(($courseworkTotalMark * $weightingClass / 100.0), 2);
                $coursework['weighted_mark_year'] = round(($courseworkTotalMark * $weightingYear / 100.0), 2);
                $classMark += $coursework['weighted_mark_class'];
                $yearMark += $coursework['weighted_mark_year'];
                $courseworks[] = $coursework;

                $submCoursework = [];
                $submCoursework['total'] = $courseworkTotalMark;
                $submCoursework['subs'] = $submSubcourseworks;
                $submCourseworks[$cwrk->id] = $submCoursework;

            }
            $result['courseworks'] = $courseworks;
            $result['class_mark'] = round($classMark, 2);
            $result['year_mark'] = round($yearMark, 2);

            $finalGrade = UserCourseFinalGrade::where('user_id',Auth::user()->id)
                ->where('course_id', $course->id)->first();
            if($finalGrade){
                if($finalGrade->type_id == 1){
                    $result['final_mark'] = round($yearMark, 2);
                } else {
                    $result['final_mark'] = FinalGradeType::where('id', $finalGrade->type_id)->first()->name;
                }
            } else {
                $result['final_mark'] = round($yearMark, 2);
            }

            $result['dp_status'] = 'DP';

            foreach ($subminimums as $subminimum) {
                $threshold = $subminimum['threshold'];
                $total = 0;
                foreach ($subminimum['rows'] as $row) {
                    $cwrk = $submCourseworks[$row['coursework_id']];
                    if($row['subcoursework_id'] && $row['subcoursework_id']!=-1){
                        $subcwrkMarks = $cwrk['subs'][$row['subcoursework_id']];
                        $total += ($subcwrkMarks*$row['weighting']/100.0);
                    } else {
                        $total += ($cwrk['total']*$row['weighting']/100.0);
                    }
                }
                if($total<$threshold){
                    $result['dp_status'] = 'DPR';
                    break;
                }
            }

            $results[] = $result;
        }
        return $results;
    }
}
