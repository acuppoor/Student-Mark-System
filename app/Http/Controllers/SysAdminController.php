<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\Department;
use App\DeptAdminDeptMap;
use App\Faculty;
use App\FinalGradeType;
use App\LecturerCourseMap;
use App\SectionUserMarkMap;
use App\TACourseMap;
use App\User;
use App\UserCourseFinalGrade;
use App\UserCourseMap;
use App\UserDepartmentMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SysAdminController extends Controller
{
    public function getFaculties(){
        $faculties = [];
        foreach (Faculty::all() as $faculty){
            $fc = [];
            $fc['name'] = $faculty->name;
            $fc['id'] = $faculty->id;
            $depts = [];

            foreach ($faculty->departments as $department) {
                $dept = [];
                $dept['name'] = $department->name;
                $dept['code'] = $department->code;
                $dept['id'] = $department->id;
                $deptAdminMaps = $department->adminMaps;
                $admins = [];
                foreach ($deptAdminMaps as $deptAdmin) {
                    if($deptAdmin->status == 1) {
                        $admins[] = $deptAdmin->admin;
                    }
                }
                $dept['admins'] = $admins;
                $depts[] = $dept;
            }
            $fc['depts'] = $depts;
            $faculties[] = $fc;
        }


        return view('systemadmin.faculties_departments')->with('faculties', $faculties);
    }

    public function getDepartments(Request $request){
        $facultyId = $request->input('facultyId');
        $depts = [];
        foreach (Faculty::where('id', $facultyId)->first()->departments as $department) {
            $dept = [];
            $dept['name'] = $department->name;
            $dept['id'] = $department->id;
            $depts[] = $dept;
        }
        return Response::json($depts);
    }

    public function addDepartmentAdmin(Request $request){
        $departmentId = $request->input('departmentId');
        $email = $request->input('email');

        $user = User::where('email', $email)->first();
        if(!$user){
            $user = new User();
            $user->email = $email;
            $user->account_registered = 0;
            $user->student_number = $this->getRandomWord(9);
            $user->employee_id = $this->getRandomNumber(7);
            $user->role_id = 5;
            $user->save();
        }

        if($user){
            $user->role_id = 5;// 5 is the role id for department admin
            $userMap = DeptAdminDeptMap::where('department_id', $departmentId)->where('user_id', $user->id)->first();
            if(!$userMap) {
                $userMap = new DeptAdminDeptMap();
                $userMap->user_id = $user->id;
                $userMap->department_id = $departmentId;
            }
            $userMap->status = 1;
            $user->save();
            $userMap->save();
        }
    }

    public function addFaculty(Request $request){
        $name = $request->input('facultyName');
        $faculty = Faculty::where('name', $name)->first();
        if(!$faculty && $name){
            $faculty = new Faculty();
            $faculty->name = $name;
            $faculty->save();
        } else {
            throwException();
        }
    }

    public function addDepartment(Request $request){
        $name = $request->input('name');
        $code = $request->input('code');
        $facultyId = $request->input('facultyId');

        $department = Department::where('code', $code)->orWhere('name', $name)->first();

        if(!$department && $name && $code){
            $department = new Department();
            $department->name = $name;
            $department->code = $code;
            $department->faculty_id = $facultyId;
            $department->save();
        } else {
            throwException();
        }
    }

    public function updateFaculty(Request $request){
        $name = $request->input('name');
        $facultyId = $request->input('facultyId');

        $faculty = Faculty::where('id', $facultyId)->first();

        if($faculty && $name){
            $faculty->name = $name;
            $faculty->save();
        } else {
            throwException();
        }
    }

    public function deleteFaculty(Request $request){
        $facultyId = $request->input('facultyId');
        $faculty = Faculty::where('id', $facultyId)->first();
        if($faculty) {
            $departments = $faculty->departments;
            foreach ($departments as $department) {
                $courses = $department->courses;
                foreach ($courses as $course) {
                    $course->delete();
                }
                $department->delete();
            }
            $faculty->delete();
        }
    }

    public function updateDepartment(Request $request){
        $facultyId = $request->input('facultyId');
        $departmentId = $request->input('departmentId');
        $code = $request->input('code');
        $userIds = $request->input('userIds');
        $name = $request->input('name');

       $department = Department::where('id', $departmentId)->first();
       if($department){
           $department->name = $name;
           $department->faculty_id = $facultyId;
           $department->code = $code;
           $department->save();

           if($userIds) {
               foreach ($userIds as $userId) {
                   $userMap = DeptAdminDeptMap::where('user_id', $userId)->where('department_id', $departmentId)->first();
                   if ($userMap) {
                       $userMap->status = 0;
                       $userMap->save();
                   }
               }
           }

       } else {
           throwException();
       }
    }

    public function deleteDepartment(Request $request){
        $departmentId = $request->input('departmentId');
        $department = Department::where('id', $departmentId)->first();
        if($department){
            $courses = $department->courses;
            foreach ($courses as $course) {
                $course->delete();
            }
            $department->delete();
        } else {
            throwException('Department not found!');
        }
    }

    private function isSimilar($haystack, $needle){
        $pos = strpos(strtolower($haystack), strtolower($needle));
        return ($pos===0||$pos>=1) || strtolower($haystack)==strtolower($needle);
    }

    public function getCourses(Request $request){
        if($request->input('courseYear')){
            $currentYear = date($request->input('courseYear').'-01-01');
        } else {
            $currentYear = date('Y-01-01');
        }
        $selectedCourses = Course::where('start_date', '>=', $currentYear)->get();

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

        return view('systemadmin.courses')->with('courses', $courses);
    }

    public function resetPassword(Request $request){
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if(!$email || !$user || !$request->input('password')){
            throwException();
        }

        $password = bcrypt($request->input('password'));
        $user->password = $password;
        $user->save();
    }

    /**
     * This returns a specific students marks when search using the searchMarks page
     * looks for all the courses that is mapped to the user and is in the dept of the convenor/lecturer and returns the marks
     * @param Request $request
     * @return array
     */
    public function getMarks(Request $request){
        $studentNumber = $request->input('studentNumber');
        $courseYear = $request->input('courseYear');
        $courseCode = $request->input('courseCode');
        $department = $request->input('courseDepartment');

        if($department){
            $department = explode('- ', $department)[1];
            if($department){
                $department = Department::where('name', $department)->first();
                if($department){
                    $department = $department->id;
                }
            }
        }

        $student = User::where('student_number', $studentNumber)->orWhere('employee_id', $studentNumber)->first();
        if(!$studentNumber || !$student){return [];}

        $possibleCourses = [];
        foreach (Department::all() as $dept) {
            if($department && $dept->id != $department){
                continue;
            }
            foreach ($dept->courses as $crs) {
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

    public function createCourse(Request $request){
        $name = $request->input('name');
        $code = $request->input('code');
        $description = $request->input('description');
        $type = $request->input('type');
        $term = $request->input('term');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $endDate = $endDate?$endDate:$startDate;
        $deptId = $request->input('department');

        if($deptId && !is_numeric($deptId)){
            $deptId = explode('- ', $deptId)[1];
            if($deptId){
                $deptId = Department::where('name', $deptId)->first();
                if($deptId){
                    $deptId = $deptId->id;
                }
            }
        } else if (!$deptId){
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

        $course = Course::where('id', $courseId)->first();

        if(!$course){
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

    /**
     * return a random word of a particular length, useful for random student number
     * @param int $len
     * @return bool|string
     */
    private function getRandomWord($len = 10) {
        $word = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($word);
        return substr(implode($word), 0, $len);
    }

    /**
     * generate a random integer of a particular length
     * useful for unique employee id
     * @param $length
     * @return string
     */
    private function getRandomNumber($length) {
        $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    /**
     *
     */
    public function approveByEmail(Request $request){
        $email = $request->input('email');

        if($email){
            $user = User::where('email', $email)->first();
            if($user){
                $user->approved = 1;
                $user->save();
                return;
            }
        }
        throwException();
    }
}
