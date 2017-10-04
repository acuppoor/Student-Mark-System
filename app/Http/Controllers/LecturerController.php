<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\CourseType;
use App\Coursework;
use App\CourseworkType;
use App\DeptAdminDeptMap;
use App\FinalGradeType;
use App\LecturerCourseMap;
use App\Mail\InvitationMail;
use App\Section;
use App\SectionUserMarkMap;
use App\SubCoursework;
use App\Subminimum;
use App\SubminimumColumnMap;
use App\TACourseMap;
use App\User;
use App\UserCourseFinalGrade;
use App\UserCourseMap;
use App\UserDepartmentMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LecturerController extends Controller
{
    /**
     * returns the full course details to the client including subminimums
     * no further checks needed because they are being done in PagesController
     * @param $courseId
     * @return array
     */
    public function getCourseDetails($courseId){
        $course = Course::where('id', $courseId)->first();
        if(!$course){return array();}

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
//        return view('lecturer.course_details_convenor')->with('course', $courseDetails);
        return $courseDetails;
    }

    /**
     * Before a coursework is created, it is checked if the course exists
     * Then it is verified if the client is a convenor for the course or a deptAdmin for the
     * department of the course. System Admin can also create coursework
     * @param Request $request
     */
    public function createCoursework(Request $request){
        $name = $request->input('name');
        $type = $request->input('type');
        $releaseDate = $request->input('releaseDate');
        $classWeighting = $request->input('classWeighting');
        $yearWeighting = $request->input('yearWeighting');
        $courseId = $request->input('courseId');

        $roleId = Auth::user()->role_id;
        $course = Course::where('id', $courseId)->first();
        if(!$course){throwException();}

        if($roleId == 4){
            $convenorMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                        ->where('course_id', $courseId)->first();
            if(!$convenorMap || ($convenorMap && $convenorMap->status==0)){
                throwException();
            }
        } else if ($roleId == 5){
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                        ->where('department_id', $course->department->id)->first();
            if(!$deptMap || ($deptMap && $deptMap->status == 0)){
                throwException();
            }
        }

        $coursework = new Coursework();
        $coursework->name = $name;
        $coursework->coursework_type_id = $type;
        $coursework->display_to_students = $releaseDate;
        $coursework->weighting_in_classrecord = $classWeighting;
        $coursework->weighting_in_yearmark = $yearWeighting;
        $coursework->course_id = $courseId;
        $coursework->save();
    }

    /**
     * First verifies whether user is allowed to delete.
     * Then all assosciated SubminimumColumnMaps, SectionMark, Sections, Subcourseworks assosciated with the coursework
     * are deleted and then the coursework is deleted.
     * @param Request $request
     */
    public function deleteCoursework(Request $request){
        $courseworkId = $request->input('courseworkId');
        $subcourseworks = SubCoursework::where('coursework_id', $courseworkId)->get();

        $roleId = Auth::user()->role_id;

        $coursework = Coursework::where('id', $courseworkId)->first();
        if(!$coursework){throwException();}

        if($roleId == 4){
            $convenorMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $coursework->course->id)->first();
            if(!$convenorMap || ($convenorMap && $convenorMap->status==0)){
                throwException(); // not a convenor or was a convenor
            }
        } else if ($roleId == 5){
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $coursework->course->department->id)->first();
            if(!$deptMap || ($deptMap && $deptMap->status == 0)){
                // user is not a dept admin for the dept of the course
                throwException();
            }
        }

        foreach($subcourseworks as $subcoursework){
            foreach ($subcoursework->sections as $section) {
                foreach ($section->userMarkMap as $item) {
                    $item->delete();
                }
                $section->delete();
            }
            SubminimumColumnMap::where('subcoursework_id', $subcoursework->id)->delete();
            $subcoursework->delete();
        }
        SubminimumColumnMap::where('coursework_id', $courseworkId)->delete();
        $coursework->delete();
    }

    /** After checking that the user is allowed to do this operation,
     * it is checked if the coursework exists, if yes, then only a subcoursework for that is created
     * @param Request $request
     */
    public function createSubcoursework(Request $request){
        $courseworkId = $request->input('courseworkId');
        $name = $request->input('name');
        $releaseDate = $request->input('releaseDate');
        $maxMarks = $request->input('maxMarks');
        $weighting = $request->input('weighting');
        $displayMarks = $request->input('displayMarks');
        $displayPercentage = $request->input('displayPercentage');

        $roleId = Auth::user()->role_id;
        $coursework = Coursework::where('id', $courseworkId)->first();
        if(!$coursework){throwException();}

        if($roleId == 4){
            $convenorMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $coursework->course->id)->first();
            if(!$convenorMap || ($convenorMap && $convenorMap->status==0)){
                throwException(); // not a convenor or was a convenor
            }
        } else if ($roleId == 5){
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $coursework->course->department->id)->first();
            if(!$deptMap || ($deptMap && $deptMap->status == 0)){
                // user is not a dept admin for the dept of the course
                throwException();
            }
        }

        $subcoursework = new SubCoursework();
        $subcoursework->coursework_id = $courseworkId;
        $subcoursework->name = $name;
        $subcoursework->display_to_students = $releaseDate;
        $subcoursework->display_marks = $displayMarks;
        $subcoursework->display_percentage = $displayPercentage;
        $subcoursework->weighting_in_coursework = $weighting;
        $subcoursework->max_marks = $maxMarks;
        $subcoursework->save();
    }

    /**
     * After verifying that the user is allowed to do the operation,
     * it is checked if the subcoursework exists, if yes, then only all its assosciated objects are deleted.
     * @param Request $request
     */
    public function deleteSubcoursework(Request $request)
    {
        $subcourseworkId = $request->input('subcourseworkId');
        $subcoursework = SubCoursework::where('id', $subcourseworkId)->first();

        $roleId = Auth::user()->role_id;
        if(!$subcoursework){throwException();}

        if($roleId == 4){
            $convenorMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $subcoursework->coursework->course->id)->first();
            if(!$convenorMap || ($convenorMap && $convenorMap->status==0)){
                throwException(); // not a convenor or was a convenor
            }
        } else if ($roleId == 5){
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $subcoursework->coursework->course->department->id)->first();
            if(!$deptMap || ($deptMap && $deptMap->status == 0)){
                // user is not a dept admin for the dept of the course
                throwException();
            }
        }

        $sections = $subcoursework->sections;
        foreach ($sections as $section){
            foreach ($section->userMarkMap as $sectionUserMap) {
                $sectionUserMap->delete();
            }
            $section->delete();
        }
        SubminimumColumnMap::where('subcoursework_id', $subcourseworkId)->delete();
        $subcoursework->delete();
    }

    /**
     * It is first checked if the user is allowed to do the operation. If yes,
     * it is then checked if the subcoursework (for which a section is being created) exists.
     * If yes, then only the section is created and assosciated to the subcoursework.
     * @param Request $request
     */
    public function createSection(Request $request)
    {
        $subcourseworkId = $request->input('subcourseworkId');
        $name = $request->input('name');
        $maxMarks = $request->input('maxMarks');

        $roleId = Auth::user()->role_id;

        $subcoursework = SubCoursework::where('id', $subcourseworkId)->first();
        if(!$subcoursework){throwException();}

        if($roleId == 4){
            $convenorMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $subcoursework->coursework->course->id)->first();
            if(!$convenorMap || ($convenorMap && $convenorMap->status==0)){
                throwException(); // not a convenor or was a convenor
            }
        } else if ($roleId == 5){
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $subcoursework->coursework->course->department->id)->first();
            if(!$deptMap || ($deptMap && $deptMap->status == 0)){
                // user is not a dept admin for the dept of the course
                throwException();
            }
        }

        $section = new Section();
        $section->subcoursework_id = $subcourseworkId;
        $section->name = $name;
        $section->max_marks = $maxMarks;
        $section->save();
    }

    /**
     * If user is allowed to do this, the section marks are deleted first followed by the actual section
     * @param Request $request
     */
    public function deleteSection(Request $request)
    {
        $sectionId = $request->input('sectionId');
        $section = Section::where('id', $sectionId)->first();

        $roleId = Auth::user()->role_id;

        if(!$section){throwException();}

        if($roleId == 4){
            $convenorMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $section->subcoursework->coursework->course->id)->first();
            if(!$convenorMap || ($convenorMap && $convenorMap->status==0)){
                throwException(); // not a convenor or was a convenor
            }
        } else if ($roleId == 5){
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $section->subcoursework->coursework->course->department->id)->first();
            if(!$deptMap || ($deptMap && $deptMap->status == 0)){
                // user is not a dept admin for the dept of the course
                throwException();
            }
        }

        SectionUserMarkMap::where('section_id', $sectionId)->delete();
        $section->delete();
    }

    /**
     * The subminimum is created only if the course to which it is being assosciated exist and that
     * the user initiating th operation is allowed to do so.
     * @param Request $request
     */
    public function createSubminimum(Request $request){
        $name = $request->input('name');
        $type = $request->input('type');
        $courseId = $request->input('courseId');
        $threshold = $request->input('threshold');

        $roleId = Auth::user()->role_id;

        $course = Course::where('id', $courseId)->first();
        if(!$course){throwException();}

        if($roleId == 4){
            $convenorMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $courseId)->first();
            if(!$convenorMap || ($convenorMap && $convenorMap->status==0)){
                throwException(); // not a convenor or was a convenor
            }
        } else if ($roleId == 5){
            $deptMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $course->department->id)->first();
            if(!$deptMap || ($deptMap && $deptMap->status == 0)){
                // user is not a dept admin for the dept of the course
                throwException();
            }
        }

        $subminimum = new Subminimum();
        $subminimum->name = $name;
        $subminimum->for_dp = $type;
        $subminimum->course_id = $courseId;
        $subminimum->threshold = $threshold;
        $subminimum->save();
    }

    /**
     * no extra security needed for this one.
     * It returns the subcourseworks assosciated with a coursework
     * @param Request $request
     * @return mixed
     */
    public function getSubCourseworks(Request $request){
        $cwrkValue = $request->input('coursework');

        if(!$cwrkValue){
            return Response::json(array());
        }

        if(is_numeric($cwrkValue)){
            $courseworkId = $cwrkValue;
            $subcourseworks = SubCoursework::where('coursework_id', $courseworkId)->get();
            $results=[];
            foreach ($subcourseworks as $subcwrk){
                $result = [];
                $result['name'] = $subcwrk->name;
                $result['id'] = $subcwrk->id;
                $results[] = $result;
            }
        } else {
            $coursework = Coursework::where('name', $cwrkValue)->first();
            if(!$coursework){
                return Response::json(array());
            }
            $courseworkId = $coursework->id;
            $subcourseworks = SubCoursework::where('coursework_id', $courseworkId)->get();
            $results=[];
            foreach ($subcourseworks as $subcwrk){
                $result = [];
                $result['name'] = $subcwrk->name;
                $result['id'] = $subcwrk->id;
                $results[] = $result;
            }
        }
        return Response::json($results);
    }

    /**
     * it takes in a subcourseworkId, finds the assosciated sections and returns them.
     * No extra security needed here.
     * @param Request $request
     * @return mixed
     */
    public function getSections(Request $request){
        $subcoursework = SubCoursework::where('id', $request->input('subcoursework'))->first();

        if(!$subcoursework){
            return Response::json(array());
        } else {
            $subcourseworkId = $subcoursework->id;
        }

        $sections = Section::where('subcoursework_id', $subcourseworkId)->get();
        $results=[];
        foreach ($sections as $sctn){
            $result = [];
            $result['name'] = $sctn->name;
            $result['id'] = $sctn->id;
            $results[] = $result;
        }

        return Response::json($results);
    }

    /**
     * call getStudentsMarksLists function to get an array of student marks. If the user has chosen
     * the 'export' option, then a csv file is created and the name of the file is returned as a JSON response
     * Otherwise the array of student marks is returned
     * @param Request $request
     * @return mixed
     */
    public function getStudentsMarks(Request $request){
        $studentNumber = $request->input('studentNumber');
        $courseId = $request->input('courseId');
        $download = $request->input('download');
        $offsetRaw = $request->input('offset');

        $returnResults = $this->getStudentMarksList($studentNumber, $courseId, $offsetRaw);

        if(!$download) {
            return Response::json($returnResults);
        } else {
            $studentsMarks = $returnResults[0];

            $fileName = "class_year_marks_".$courseId.".csv";
            $fullFileName = "generated_files/".$fileName;

            $myfile = fopen($fullFileName, "w");

            fputcsv($myfile, explode(', ','Campus Id, Emplid, Class Mark, Year Mark, DP Status, Final Grade'));

            foreach($studentsMarks as $result){
                $line = implode(', ', [$result['student_number'], $result['employee_id'], $result['class_mark'],
                    $result['year_mark'], $result['dp_status'], $result['final_grade']]);
                fputcsv($myfile, explode(', ', $line));
            }
            fclose($myfile);

            return Response::json($fullFileName);
        }
    }

    /**
     * Returns the courses for which the logged in user is a lecturer.
     * get the logged in user id and choose all courseIds from LecturerCourseMap table.
     * for each courseId, the course details are fetched and returned in an array
     * courses can be filtered according to department chosen, code, year and type
     * @param Request $request
     * @return array
     *
     */
    public function getLecturerCourses(Request $request){
        $courseMaps = Auth::user()->lecturerCourseMaps;
        $courses = [];

        foreach ($courseMaps as $courseMap) {
            if($courseMap->status == 0){continue;}
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
        return $courses;
    }

    /**
     * returns all the courses for which the logged in user is a convenor
     * can be filtered by course code, year, department and type
     * Same technique as getLecturerCourses method
     * @param Request $request
     * @return array
     */
    public function getConveningCourses(Request $request){
        $courseMaps = Auth::user()->convenorCourseMaps;
        $courses = [];
        foreach ($courseMaps as $courseMap) {
            if($courseMap->status == 0){continue;}
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
        return $courses;
    }

    /**
     * return the courses for which the logged in user is not a lecturer nor a convenor.
     * that is, the remaining courses in the departments
     * @param Request $request
     * @return array
     */
    public function getOtherCourses(Request $request){
        $departmentCourses = Auth::user()->departmentMaps->first()->department->courses;

        $otherCourses = array_merge($this->getLecturerCourses($request), $this->getConveningCourses($request));
        $courses = [];

        foreach ($departmentCourses as $crs) {
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

    /**
     * utility method to check if 2 words are 'LIKE' each other (same 'LIKE' as sql)
     * @param $haystack
     * @param $needle
     * @return bool
     */
    private function isSimilar($haystack, $needle){
//        echo(strrpos(strtolower($haystack), strtolower($needle));die();
        $pos = strpos(strtolower($haystack), strtolower($needle));
        return ($pos===0||$pos>=1) || strtolower($haystack)==strtolower($needle);
    }

    /**
     * checks if the logged in user is a convenor for the course, or a department admin for the
     * department in question or a system admin for the system.
     * If yes
     * @param Request $request
     */
    public function updateCourseInfo(Request $request){
        $courseId = $request->input('courseId');

        $userId = Auth::user()->id;
        $course = Course::where('id', $courseId)->first();
        $department = $course->department;
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', $userId)
                            ->where('department_id', $department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', $userId)
                            ->where('course_id', $courseId)->first();

        if(!$courseId || !$course ||
            ((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
            ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6)){
            throwException();
        }
        $course->name = $request->input('name');
        $course->code = $request->input('code');
        $course->type_id = CourseType::where('name', $request->input('type'))->first()->id;
        $course->description = $request->input('description');
        $course->start_date = $request->input('startDate');
        $course->end_date = $request->input('endDate');
        $course->term_number = $request->input('term');
        $course->save();
    }

    /**
     * It's first checked if the loggedIn user is a department admin for the department
     * or a convenor for the course
     * or a system admin with full rights on the system
     * if the user is one of the above, then the new convenor is added to the course
     * @param Request $request
     */
    public function addCourseConvenor(Request $request){
        $courseId = $request->input('courseId');

        $userLoggedIn = Auth::user()->id;
        $course = Course::where('id', $courseId)->first();
        $department = $course->department;
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', $userLoggedIn)
            ->where('department_id', $department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', $userLoggedIn)
            ->where('course_id', $courseId)->first();
        if(!$courseId || !$course ||
            ((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) || ($convenorCourseMap && $convenorCourseMap->status==0))
            && Auth::user()->role_id != 6)
            ){
            throwException();
        }

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if(!$user){
            $user = new User();
            $user->email = $email;
            $user->account_registered = 0;
            $user->student_number = $this->getRandomWord(9);
            $user->employee_id = $this->getRandomNumber(7);
            $user->role_id = 5;
        }
        $user->role_id = 4;
        $user->approved = 1; $user->save();

        // adding user to the department
        $departmentMap = UserDepartmentMap::where('user_id', $user->id)
                        ->where('department_id', $department->id)->first();
        if(!$departmentMap){
            $departmentMap = new UserDepartmentMap();
            $departmentMap->user_id = $user->id;
            $departmentMap->department_id = $department->id;
            $departmentMap->status = 1;
        }
        $departmentMap->status = 1; $departmentMap->save();

        // checks if to-be-convenor is already a courseconvenor for the course
        $convenorCourseMap = ConvenorCourseMap::where('course_id', $courseId)
                            ->where('user_id', $user->id)->first();
        if(!$convenorCourseMap) {
            $convenorCourseMap = new ConvenorCourseMap();
            $convenorCourseMap->user_id = $user->id;
            $convenorCourseMap->course_id = $courseId;
        }
        $convenorCourseMap->status = 1;
        $convenorCourseMap->save();
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
     * The user is checked against some tables in the database to verify that he is permitted to do the operation
     * If user is permitted, then it is checked if the course exist otherwise error
     * the to-be-lecturer account is searched. if not found, one is created
     * to-be-lecturer is mapped to the department of the course
     * @param Request $request
     */
    public function addLecturer(Request $request){
        $courseId = $request->input('courseId');

        $userLoggedIn = Auth::user()->id;
        $course = Course::where('id', $courseId)->first();
        $department = $course->department;
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', $userLoggedIn)
            ->where('department_id', $department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', $userLoggedIn)
            ->where('course_id', $courseId)->first();

        if(!$courseId || !$course ||
            ((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) || ($convenorCourseMap && $convenorCourseMap->status==0))
                && Auth::user()->role_id != 6)
        ){
            throwException();
        }

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if(!$user){
            $user = new User();
            $user->email = $email;
            $user->account_registered = 0;
            $user->student_number = $this->getRandomWord(9);
            $user->employee_id = $this->getRandomNumber(7);
            $user->role_id = 3;
        }
        $user->approved = 1; $user->save();

        // adding user to the department
        $departmentMap = UserDepartmentMap::where('user_id', $user->id)
            ->where('department_id', $department->id)->first();
        if(!$departmentMap){
            $departmentMap = new UserDepartmentMap();
            $departmentMap->user_id = $user->id;
            $departmentMap->department_id = $department->id;
            $departmentMap->status = 1;
        }
        $departmentMap->status = 1; $departmentMap->save();

        // adding user as a lecturer to the course
        $lecturerCourseMap = LecturerCourseMap::where('user_id', $user->id)
                            ->where('course_id', $courseId)->first();
        if(!$lecturerCourseMap) {
            $lecturerCourseMap = new LecturerCourseMap();
            $lecturerCourseMap->user_id = $user->id;
            $lecturerCourseMap->course_id = $courseId;
        }
        $lecturerCourseMap->status = 1;
        $lecturerCourseMap->save();
    }

    /**
     * The user is checked against some tables in the database to verify that he is permitted to do the operation
     * If user is permitted, then it is checked if the course exist otherwise error
     * the to-be-TA account is searched. if not found, one is created
     * to-be-lecturer is mapped to the department of the course
     * @param Request $request
     */
    public function addTA(Request $request){
        $courseId = $request->input('courseId');

        $userLoggedIn = Auth::user()->id;
        $course = Course::where('id', $courseId)->first();
        $department = $course->department;
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', $userLoggedIn)
            ->where('department_id', $department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', $userLoggedIn)
            ->where('course_id', $courseId)->first();
        if(!$courseId || !$course ||
            ((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) || ($convenorCourseMap && $convenorCourseMap->status==0))
                && Auth::user()->role_id != 6)
        ){
            throwException();
        }

        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if(!$user){
            $user = new User();
            $user->email = $email;
            $user->account_registered = 0;
            $user->student_number = $this->getRandomWord(9);
            $user->employee_id = $this->getRandomNumber(7);
            $user->role_id = 5;
        }
        $user->approved = 1;
        $user->role_id = 2; $user->save();


        // adding user to the department
        $departmentMap = UserDepartmentMap::where('user_id', $user->id)
            ->where('department_id', $department->id)->first();
        if(!$departmentMap){
            $departmentMap = new UserDepartmentMap();
            $departmentMap->user_id = $user->id;
            $departmentMap->department_id = $department->id;
            $departmentMap->status = 1;
        }
        $departmentMap->status = 1; $departmentMap->save();


        $taCourseMap = TACourseMap::where('user_id', $user->id)
                        ->where('course_id', $courseId)->first();
        if(!$taCourseMap) {
            $taCourseMap = new TACourseMap();
            $taCourseMap->user_id = $user->id;
            $taCourseMap->course_id = $courseId;
        }
        $taCourseMap->status = 1;
        $taCourseMap->save();
    }

    /**
     * Returns a list of participants for the course
     * @param Request $request
     * @return mixed
     */
    public function participantsList(Request $request){
        $email = $request->input('emailAddress');
        $studentNumber = $request->input('studentNumber');
        $courseId = $request->input('courseId');
        $offset = $request->input('offset')-1;
        $limit = $request->input('limit') != 'Max'? 30:'Max';

        $users = [];

        if($studentNumber || $email){
            if($studentNumber && $email){
                $usrs = User::where('employee_id', 'like', '%'.$studentNumber.'%')
                              ->orWhere('student_number', 'like', '%'.$studentNumber.'%')->get();
                $temp = [];
                foreach($usrs as $usr){
                     if($this->isSimilar($usr->email, $email)){
                         $temp[] = $usr;
                     }
                }
                $usrs = $temp;
            } else if ($email){
                $usrs = User::where('email', 'like', '%'.$email.'%')->get();
            } else if ($studentNumber){
                $usrs = User::where('student_number', 'like', '%'.$studentNumber.'%')
                    ->orWhere('employee_id', 'like', '%'.$studentNumber.'%')
                    ->get();
            }
            foreach ($usrs as $usr) {
                $users[] = $usr;
            }
        } else {
            // must select al the students in the course
            foreach (UserCourseMap::all() as $usr) {
                $users[] = $usr->user;
            }
            foreach (TACourseMap::all() as $usr) {
                $users[] = $usr->user;
            }
            foreach (LecturerCourseMap::all() as $usr) {
                $users[] = $usr->lecturer;
            }
            foreach (ConvenorCourseMap::all() as $usr) {
                $users[] = $usr->user;
            }
        }

        $users = $users?array_unique($users):$users;

        if($limit!='Max'){
            $users = array_slice($users, $offset, $limit);
        }

        $results=[];
        if($users){
            foreach ($users as $user){
                $studentMap = UserCourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();
                $lecturerMap = LecturerCourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();
                $convenorMap = ConvenorCourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();
                $taMap = TACourseMap::where('user_id', $user->id)->where('course_id', $courseId)->first();

                $status = '';
                $role = "";
                if($studentMap){
                    $status.= ($studentMap->status==1?'Registered':'Other');
                    $role .= "Student";
                }
                if($lecturerMap) {
                    $status  .= ($status?' | ':'').($lecturerMap->status==1?'Access':'No Access');
                    $role .= ($role ? ' | ' : '') . "Lecturer";
                }
                if($convenorMap) {
                    $status .= ($status?' | ':'').($convenorMap->status==1?'Access':'No Access');
                    $role .= ($role ? ' | ' : '') . "Course Convenor";
                }
                if($taMap){
                    $status .= ($status?' | ':'').($taMap->status==1?'Access':'No Access');
                    $role .= ($role?' | ':'')."Teaching Assistant";
                }
                if($status){
                    $result = [];
                    $result["id"] = $user->id;
                    $result["firstName"] = $user->first_name;
                    $result["lastName"] = $user->last_name;
                    $result["studentNumber"] = $user->student_number;
                    $result["email"] = $user->email;
                    $result["employeeId"]= $user->employee_id;
                    $result["role"] = $role;
                    $result["status"] = $status;
                    $result["approved"] = $user->approved==1?'Yes':'No';
                    $results[] = $result;
                }
            }
        }
        return Response::json($results);
    }

    /**
     * Search for the convenors of the course and return it
     * criteria for search can be entered by the user
     * @param Request $request
     * @return array
     */
    public function getConvenors(Request $request){
        $courseId = $request->input('courseId');
        $convenorMaps = ConvenorCourseMap::where('course_id', $courseId)->get();
        $convenors = [];
        foreach ($convenorMaps as $convenorMap) {
            $convenor = [];
            $user = $convenorMap->user;
            $convenor['id'] = $user->id;
            $convenor['staff_number'] = $user->student_number;
            $convenor['employee_id'] = $user->employee_id;
            $convenor['first_name'] = $user->first_name;
            $convenor['last_name'] = $user->last_name;
            $convenor['email'] = $user->email;
            $convenor['access'] = $convenorMap->status==1?'Yes':'No';
            $convenor['approved'] = $user->approved==1?'Yes':'No';
            $convenors[] = $convenor;
        }
        return $convenors;
    }

    /**
     * Search for lecturers assosciated with the course
     * criterias for search can be entered by the user
     * @param Request $request
     * @return array
     */
    public function getLecturers(Request $request){
        $courseId = $request->input('courseId');
        $lecturerMaps = LecturerCourseMap::where('course_id', $courseId)->get();
        $lecturers = [];
        foreach ($lecturerMaps as $lecturerMap) {
            $lecturer = [];
            $user = $lecturerMap->lecturer;
            $lecturer['id'] = $user->id;
            $lecturer['staff_number'] = $user->student_number;
            $lecturer['employee_id'] = $user->employee_id;
            $lecturer['first_name'] = $user->first_name;
            $lecturer['last_name'] = $user->last_name;
            $lecturer['email'] = $user->email;
            $lecturer['access'] = $lecturerMap->status==1?'Yes':'No';
            $lecturer['approved'] = $user->approved==1?'Yes':'No';
            $lecturers[] = $lecturer;
        }
        return $lecturers;
    }

    /**
     * search for all students for a course that matches a certain criteria, if entered by the user
     * @param Request $request
     * @return array
     */
    public function getStudents(Request $request){
        $courseId = $request->input('courseId');
        $studentMaps = UserCourseMap::where('course_id', $courseId)->get();
        $download = $request->input('download');
        $students = [];
        foreach ($studentMaps as $studentMap) {
            $student = [];
            $user = $studentMap->user;
            $student['id'] = $user->id;
            $student['staff_number'] = $user->student_number;
            $student['employee_id'] = $user->employee_id;
            $student['first_name'] = $user->first_name;
            $student['last_name'] = $user->last_name;
            $student['email'] = $user->email;
            $student['access'] = $studentMap->status==1?'Registered':'Deregistered';
            $student['approved'] = $user->approved==1?'Yes':'No';
            $students[] = $student;
        }
        if(!$download){
            return $students;
        } else {

            $fileName = "students_list_".$courseId.".csv";
            $fullFileName = "generated_files/".$fileName;

            $myfile = fopen($fullFileName, "w");

            fputcsv($myfile, explode(', ','Emplid, Campus ID, First Name, Last Name, Email, Access, Approved, Course'));

            $course = Course::where('id', $courseId)->first();
            $courseName = $course->code.' ('.explode('-', $course->start_date)[0].')';

            foreach($students as $record){
                fputcsv($myfile, [$record['employee_id'], $record['staff_number'], $record['first_name'], $record['last_name'],
                    $record['email'], $record['access'], $record['approved'], $courseName]);
            }
            fclose($myfile);
            return Response::json($fullFileName);
        }
    }

    /**
     * returns TAs for the course, results can be refined depending on the request
     * @param Request $request
     * @return array
     */
    public function getTAs(Request $request){
        $courseId = $request->input('courseId');
        $taMaps = TACourseMap::where('course_id', $courseId)->get();
        $tas = [];
        foreach ($taMaps as $taMap) {
            $ta = [];
            $user = $taMap->user;
            $ta['id'] = $user->id;
            $ta['staff_number'] = $user->student_number;
            $ta['employee_id'] = $user->employee_id;
            $ta['first_name'] = $user->first_name;
            $ta['last_name'] = $user->last_name;
            $ta['email'] = $user->email;
            $ta['access'] = $taMap->status==1?'Yes':'No';
            $ta['approved'] = $user->approved==1?'Yes':'No';
            $tas[] = $ta;
        }
        return $tas;
    }

    /**
     * this creates a subminimum 'row' for a subminimum.
     * For e.g, for a subminimum of 'Tests(50%) and Assignments(50%) >= 45% for DP',
     * Tests(50%) will be a row, with 'Tests' being the coursework and 50% being the weighting
     * A row must have a coursework and can have subcoursework.
     * The permission of the user is checked and then the subminimum is looked for.
     * A row is then mapped to the subminimum
     * @param Request $request
     */
    public function createSubminimumRow(Request $request){
        $id = $request->input('subminimumId');
        $coursework = $request->input('coursework');
        $subcoursework = $request->input('subcoursework');
        $weighting = $request->input('weighting');

        $userId = Auth::user()->id;
        $subminimum = Subminimum::where('id', $id)->first();
        if(!$subminimum){
            throwException();
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', $userId)
            ->where('department_id', $subminimum->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', $userId)
            ->where('course_id', $subminimum->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                    ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        $s = new SubminimumColumnMap();
        $s->coursework_id = $coursework;
        $s->subminimum_id = $id;
        $s->subcoursework_id = $subcoursework?$subcoursework:-1;
        $s->weighting = $weighting;
        $s->save();
    }

    /**
     * Once the permission of the user has been cleared, the subminimumrow is deleted
     * @param Request $request
     */
    public function deleteSubminimumRow(Request $request){
        $id = $request->input('id');

        $userId = Auth::user()->id;
        $row = SubminimumColumnMap::where('id', $id)->first();
        if(!$row){
            throwException();
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', $userId)
            ->where('department_id', $row->subminimum->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', $userId)
            ->where('course_id', $row->subminimum->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }
        $row->delete();
    }

    /*
     * Once the user permission has been cleared, the subminimum is searched to verify that it exist
     * the rows assosciated to it are deleted, then the actual subminimum is deleted.
     * @param Request $request
     */
    public function deleteSubminimum(Request $request){
        $id = $request->input('id');
        $userId = Auth::user()->id;

        $subminimum = Subminimum::where('id', $id)->first();
        if(!$subminimum){
            throwException();
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', $userId)
            ->where('department_id', $subminimum->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', $userId)
            ->where('course_id', $subminimum->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }
        SubminimumColumnMap::where('subminimum_id', $id)->delete();
        $subminimum->delete();
    }

    /**
     * Various parameters are passed into the Request, and using them, the coursework marks are calculated
     * limit by default is 30 records, unless maximum has been specified by the user. If maximum has not been chosen, then
     * the returned results will be determined by the offset and limit.
     * If the download option has been chosen, the name of the file will be returned for the download to start
     * otherwise an array of marks for students are returned
     * @param Request $request
     * @return mixed
     */
    public function getStudentsCourseworkMarks(Request $request){
        $courseId = $request->input('courseId');
        $courseworkId = $request->input('courseworkId');
        $studentNumber = $request->input('studentNumber');
        $download = $request->input('download');
        $limit = 30;
        $offsetRaw = $request->input('offset');
        $offset = $offsetRaw*$limit;

        $students = [];
        if($studentNumber){
            $usrs = User::where('student_number', 'like', '%'.$studentNumber.'%')
                ->orWhere('employee_id', 'like', '%'.$studentNumber.'%')->get();
            if($usrs) {
                foreach ($usrs as $usr) {
                    $students[] = UserCourseMap::where('user_id', $usr->id)
                        ->where('course_id', $courseId)->first()->user;
                }
            }
        } else {
            if($offsetRaw == -1){
                $users = UserCourseMap::where('course_id', $courseId)->get();
            } else {
                $users = UserCourseMap::where('course_id', $courseId)
                    ->limit($limit)->offset($offset)->get();
            }
            if($users) {
                foreach ($users as $user) {
                    $students[] = $user->user;
                }
            }
        }

        $course = Course::where('id', $courseId)->first();
        $coursework = Coursework::where('id', $courseworkId)->first();
        $subcourseworks = $coursework?$coursework->subcourseworks:[];
        $columns = [];
        $results = [];

        foreach($subcourseworks as $subcwrk){
            $columns[] = $subcwrk->name;
        }

        $results['columns'] = $columns;
        $marks = [];

        foreach ($students as $user){
            $result = [];
            $result['student_number'] = $user->student_number;
            $result['employee_id'] = $user->employee_id;

            $courseworkTotalMark = 0.0;

            $subcourseworks = [];
            if($coursework) {
                foreach ($coursework->subcourseworks as $subcoursework) {

                    $subcourseworkWeighting = $subcoursework->weighting_in_coursework;
                    $subcourseworkN = 0.0;
                    $subcourseworkD = 0.0;
                    foreach ($subcoursework->sections as $section) {
                        $subcourseworkD += $section->max_marks;
                        $sectionMap = SectionUserMarkMap::where('user_id', $user->id)
                            ->where('section_id', $section->id)->first();
                        $subcourseworkN += ($sectionMap ? $sectionMap->marks : 0);
                    }
                    $subcourseworkFinalMark = $subcourseworkD != 0 ? ($subcourseworkN * $subcourseworkWeighting) / $subcourseworkD : 0;
                    $courseworkTotalMark += $subcourseworkFinalMark;

                    $subcourseworks[] = round($subcourseworkFinalMark, 2);
                }
            }
            $result['subcourseworks'] = $subcourseworks;
            $result['total_marks'] = round($courseworkTotalMark, 2);
            $marks[] = $result;
        }
        $results['marks'] = $marks;

        if(!$download) {
            return Response::json($results);
        } else {

            $fileName = "coursework_marks_".$courseId.".csv";
            $fullFileName = "generated_files/".$fileName;

            $myfile = fopen($fullFileName, "w");

            $headers = ['Campus Id', 'Emplid'];
            foreach ($results['columns'] as $column) {
                $headers[] = $column;
            }
            $headers[] = 'Total';

            fputcsv($myfile, $headers);

            foreach($results['marks'] as $result){
                $line = [$result['student_number'], $result['employee_id']];
                foreach ($result['subcourseworks'] as $subcoursework) {
                    $line[] = $subcoursework;
                }
                $line[] = $result['total_marks'];
                fputcsv($myfile, $line);
            }
            fclose($myfile);

            return Response::json($fullFileName);
        }
    }

    /**
     * Same concept of the funtion getStudentsCourseworkMarks
     * Limits(default is 30) and offset can be set as well.
     *
     * @param Request $request
     * @return mixed
     */
    public function getStudentsSubcourseworkMarks(Request $request){
        $courseId = $request->input('courseId');
        $courseworkId = $request->input('courseworkId');
        $subcourseworkId = $request->input('subcourseworkId');
        $studentNumber = $request->input('studentNumber');
        $download = $request->input('download');
        $limit = 30;
        $offsetRaw = $request->input('offset');
        $offset = $offsetRaw*$limit;

        $students = [];
        if($studentNumber){
            $usrs = User::where('student_number', 'like', '%'.$studentNumber.'%')
                ->orWhere('employee_id', 'like', '%'.$studentNumber.'%')->get();
            if($usrs) {
                foreach ($usrs as $usr) {
                    $students[] = UserCourseMap::where('user_id', $usr->id)
                        ->where('course_id', $courseId)->first()->user;
                }
            }
        } else {
            if($offsetRaw == -1){
                $users = UserCourseMap::where('course_id', $courseId)->get();
            } else {
                $users = UserCourseMap::where('course_id', $courseId)
                    ->limit($limit)->offset($offset)->get();
            }
            if($users) {
                foreach ($users as $user) {
                    $students[] = $user->user;
                }
            }
        }

        $course = Course::where('id', $courseId)->first();
        $coursework = Coursework::where('id', $courseworkId)->first();
        $subcoursework = SubCoursework::where('id', $subcourseworkId)->first();
        $sections = Section::where('subcoursework_id', $subcourseworkId)->get();

        $columns = [];
        $results = [];

        foreach($sections as $section){
            $columns[] = $section->name;
        }

        $results['columns'] = $columns;
        $records = [];

        foreach ($students as $user){
            $result = [];
            $result['student_number'] = $user->student_number;
            $result['employee_id'] = $user->employee_id;

            $subcourseworkWeighting = $subcoursework->weighting_in_coursework;
            $subcourseworkN = 0.0;
            $subcourseworkD = 0.0;
            $marks = [];
            foreach ($sections as $section) {
                $mark = [];
                $mark['id'] = $section->id;
                $sectionMap = SectionUserMarkMap::where('user_id', $user->id)
                    ->where('section_id', $section->id)->first();
                $mark['numerator'] = $sectionMap? round($sectionMap->marks, 2):0;
                $mark['denominator'] = round($section->max_marks, 2);
                $subcourseworkD += $section->max_marks;
                $subcourseworkN += $mark['numerator'];
                $marks[] = $mark;
            }
            $subcourseworkFinalMark = $subcourseworkD!=0?($subcourseworkN*$subcourseworkWeighting)/$subcourseworkD:0;
            $result['sections'] = $marks;
            $result['total_num'] = round($subcourseworkN, 2);
            $result['total_den'] = round($subcourseworkD, 2);
            $result['percentage'] = round($subcourseworkD!=0?($subcourseworkN*100.0)/$subcourseworkD:0, 2);
            $result['weighted_marks'] = round($subcourseworkFinalMark, 2);
            $records[] = $result;
        }
        $results['marks'] = $records;

        if(!$download) {
            return Response::json($results);
        } else {
            $fileName = "subcoursework_marks_".$courseId.".csv";
            $fullFileName = "generated_files/".$fileName;

            $myfile = fopen($fullFileName, "w");

            $headers = ['Campus Id', 'Emplid'];
            foreach ($results['columns'] as $column) {
                $headers[] = $column;
            }
            $headers[] = 'Total Marks';
            $headers[] = 'Total Marks (%)';
            $headers[] = 'Weighted Marks';

            fputcsv($myfile, $headers);

            foreach($results['marks'] as $result){
                $line = [$result['student_number'], $result['employee_id']];
                foreach ($result['sections'] as $section) {
                    $line[] = $section['numerator'] . '/' . $section['denominator'];
                }
                $line[] = $result['total_num']. '/' . $result['total_den'];
                $line[] = $result['percentage'];
                $line[] = $result['weighted_marks'];
                fputcsv($myfile, $line);
            }
            fclose($myfile);

            return Response::json($fullFileName);
        }

    }

    /**
     * A list of sections, userIds and newMarks are obtained and before the SectionUserMarkMap table is updated,
     *it is verified that the user initiating the update is permitted to perform the transaction.
     * @param Request $request
     */
    public function updateSectionMarks(Request $request){
        $data = $request->input('data');

        if($data){
            $sectionId = $data[0]['section_id'];
            $section = Section::where('id', $sectionId);
            $course = $section->subCoursework->coursework->course;
            if(!$course){
                throwException(); // a section eventually has to be for a course
            }
            $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $course->department->id)->first();
            $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $course->department->id)->first();

            if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                    ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
                throwException();
            }

        }

        foreach($data as $record) {
            $studentNumber = $record['student_number'];
            $sectionId = $record['section_id'];
            $marks = $record['marks'];

            $userId = User::where('student_number', $studentNumber)->first()->id;

            $sectionMap = SectionUserMarkMap::where('section_id', $sectionId)
                                            ->where('user_id', $userId)->first();
            if(!$sectionMap){
                $sectionMap = new SectionUserMarkMap();
                $sectionMap->user_id = $userId;
                $sectionMap->section_id = $sectionId;
            }
            $sectionMap->marks = $marks;
            $sectionMap->save();
        }
    }

    /**
     * takes in a list of userIds and approve them
     * @param Request $request
     */
    public function approveUsers(Request $request){
        $userIds = $request->input('userIds');

        foreach ($userIds as $userId) {
            $user = User::where('id', $userId)->first();
            $user->approved = 1;
            $user->save();
        }
    }

    /**Takes in a list of userIds, a courseId and a status.
     * A mass update is performed to setting their access as a course convenor to the course.
     * A course convenor, however, cannot update his own status
     * @param Request $request
     */
    public function convenorsAccess(Request $request){
        $userIds = $request->input('userIds');
        $status = $request->input('access');
        $courseId = $request->input('courseId');

        $course = Course::where('id', $courseId)->first();
        if(!$course){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        foreach ($userIds as $userId) {
            if($userId == Auth::user()->id){
                continue; // convenor cannot modify their own status for a course
            }
            $map = ConvenorCourseMap::where('user_id', $userId)->where('course_id', $courseId)->first();
            if(!$map){
                $map = new ConvenorCourseMap();
                $map->user_id = $userId; $map->course_id = $courseId;
            }
            $map->status = $status;
            $map->save();
        }
    }

    /**
     * Takes in a list of UserIds, a courseId and a status.
     * Mass update is performed to grant/revoke lecturers' access to the course
     * @param Request $request
     */
    public function lecturersAccess(Request $request){
        $userIds = $request->input('userIds');
        $status = $request->input('access');
        $courseId = $request->input('courseId');

        $course = Course::where('id', $courseId)->first();
        if(!$course){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        foreach ($userIds as $userId) {
            $map = LecturerCourseMap::where('user_id', $userId)->where('course_id', $courseId)->first();
            if(!$map){
                $map = new LecturerCourseMap();
                $map->user_id = $userId; $map->course_id = $courseId;
            }
            $map->status = $status;
            $map->save();
        }
    }

    /**
     * takes in a list of userIds, status and courseId
     * Mass update is carried out to grant/revoke TAs' access to the course
     * @param Request $request
     */
    public function tasAccess(Request $request){
        $userIds = $request->input('userIds');
        $status = $request->input('access');
        $courseId = $request->input('courseId');

        $course = Course::where('id', $courseId)->first();
        if(!$course){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        foreach ($userIds as $userId) {
            $map = TACourseMap::where('user_id', $userId)->where('course_id', $courseId)->first();
            if(!$map){
                $map = new TACourseMap();
                $map->user_id = $userId; $map->course_id = $courseId;
            }
            $map->status = $status;
            $map->save();
        }
    }

    /**
     * It's checked if the coursework exists, if yes and if the user is permitted to do the operation,
     * the new details are obtained from the Request and the table is updated with the new details.
     * @param Request $request
     */
    public function updateCoursework(Request $request){
        $courseworkId = $request->input('courseworkId');
        $name = $request->input('name');
        $type = $request->input('type');
        $releaseDate = $request->input('releaseDate');
        $weightingYear = $request->input('weightingYear');
        $weightingClass = $request->input('weightingClass');

        $coursework = Coursework::where('id', $courseworkId)->first();

        if(!$coursework){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $coursework->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $coursework->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        $coursework->name = $name;
        $coursework->coursework_type_id = CourseworkType::where('name', $type)->first()->id;
        $coursework->display_to_students = $releaseDate;
        $coursework->weighting_in_yearmark = $weightingYear;
        $coursework->weighting_in_classrecord = $weightingClass;
        $coursework->save();

    }

    /**
     * if subcoursework exists and user is permitted to perform the operation,
     * the new details are obtained from the Request oobject and the database is updated.
     * @param Request $request
     */
    public function updateSubcoursework(Request $request){
        $subcourseworkId = $request->input('subcourseworkId');
        $name = $request->input('name');
        $maxMarks = $request->input('maxMarks');
        $releaseDate = $request->input('releaseDate');
        $weightingCourse = $request->input('weightingCourse');
        $displayMarks = $request->input('displayMarks');
        $displayPercentage = $request->input('displayPercentage');

        $subcoursework = SubCoursework::where('id', $subcourseworkId)->first();

        if(!$subcoursework){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $subcoursework->coursework->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $subcoursework->coursework->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        $subcoursework->name = $name;
        $subcoursework->display_to_students = $releaseDate;
        $subcoursework->display_marks = $displayMarks;
        $subcoursework->display_percentage = $displayPercentage;
        $subcoursework->weighting_in_coursework = $weightingCourse;
        $subcoursework->max_marks = $maxMarks;
        $subcoursework->save();

    }

    /**
     * if user is permitted to do the update and the section does exist, the details are udpated.
     * @param Request $request
     */
    public function updateSection(Request $request){
        $sectionId = $request->input('sectionId');
        $name = $request->input('name');
        $maxMarks = $request->input('maxMarks');

        $section = Section::where('id', $sectionId)->first();

        if(!$section){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $section->subCoursework->coursework->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $section->subCoursework->coursework->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        $section->name = $name;
        $section->max_marks = $maxMarks;
        $section->save();

    }

    /**
     * if user is permitted to do the update and the subminimum does exist, the details are udpated.
     * @param Request $request
     */
    public function updateSubminimum(Request $request){
        $subminimumId = $request->input('subminimumId');
        $name = $request->input('name');
        $type = $request->input('type');
        $threshold = $request->input('threshold');

        $subminimum = Subminimum::where('id', $subminimumId)->first();

        if(!$subminimum){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $subminimum->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $subminimum->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        $subminimum->name = $name;
        $subminimum->for_dp = $type;
        $subminimum->threshold = $threshold;
        $subminimum->save();
    }

    /**if user is permitted to do the update and the row does exist, the details are udpated.
     * @param Request $request
     */
    public function updateSubminimumRow(Request $request){
        $rowId = $request->input('rowId');
        $coursework = $request->input('coursework');
        $subcoursework = $request->input('subcoursework');
        $weighting = $request->input('weighting');

        $row = SubminimumColumnMap::where('id', $rowId)->first();

        if(!$row){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $row->subminimum->course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $row->subminimum->course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        $row->coursework_id = $coursework;
        $row->subcoursework_id = $subcoursework?$subcoursework:-1;
        $row->weighting = $weighting;
        $row->save();
    }

    /**
     * The request takes in a list of student details and students are then mapped to the course.
     * If no student account is found with the details, a new one is created with default password: 1234567
     * File must be a .csv file with the following columns: emplid, campus id, term, subject, catalog nbr, class nbr
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStudentsList(Request $request){
        $file = $request->file('file');
        $courseId = $request->input('courseId');
        $course = Course::find($courseId)->first();

        if(!$course){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        $path = Storage::putFileAs('file', $file, 'students_list_'.$courseId.'.csv');

        if($path && $course) {

            Excel::load('storage/app/'.$path, function ($reader) use(&$courseId, &$course){

                $values = $reader->toArray();

                foreach ($values as $row) {
                    $employeeId = $row['emplid'];
                    $campusId = strtolower($row['campus_id']);
                    $term = $row['term'];
                    $subject = $row['subject'];
                    $catalogNumber = $row['catalog_nbr'];
                    $classNumber = $row['class_nbr'];
                    $academicProgram = $row['acad_prog'];

                    $courseCode = $subject.$catalogNumber;
                    /*if(strcasecmp($course->code,$courseCode)!=0 || $term!=$course->term_number){
                        break;
                    }*/

                    $user = User::where('employee_id', $employeeId)
                        ->orWhere('student_number', $campusId)->first();
                    if(!$user) {
                        /*$user = new User([
                            'employee_id' => $employeeId,
                            'student_number' => $campusId,
                            'approved' => 1
                        ]);*/
                        $user = new User();
                        $user->employee_id = $employeeId;
                        $user->student_number = $campusId;
                        $user->approved = 1;
                        $user->save();
                    }
                    $userCourseMap = UserCourseMap::where('user_id', $user->id)
                        ->where('course_id', $courseId)->first();
                    if(!$userCourseMap){
                        $userCourseMap = new UserCourseMap();
                        $userCourseMap->user_id=$user->id;
                        $userCourseMap->course_id=$courseId;
                        $userCourseMap->academic_program=$academicProgram;
                        $userCourseMap->class_number=$classNumber;
                        $userCourseMap->status=1;
                    } else {
                        $userCourseMap->academic_program = $academicProgram;
                        $userCourseMap->class_number = $classNumber;
                    }
                    $userCourseMap->save();
                }
            });
        }
        Storage::delete($path);
        return redirect()->back();
    }

    /**
     * The request takes in a list of student details and students are then mapped to the course, if not already.
     * If no student account is found with the details, a new one is created with default password: 1234567
     * File must be a .csv file with the following columns: emplid, campus id, term, subject, catalog nbr, class nbr, final_grade
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadSectionMarks(Request $request){
        $file = $request->file('marksFile');
        $courseId = $request->input('courseId');
        $courseworkId = $request->input('uploadCoursework');
        $subcourseworkId = $request->input('uploadSubcoursework');
        $sectionId = $request->input('uploadSection');

        if($courseworkId != 0) {
            $section = Section::where('id', $sectionId)->first();
            $subcoursework = SubCoursework::where('id', $subcourseworkId)->first();
            $coursework = Coursework::where('id', $courseworkId)->first();

            $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
                ->where('department_id', $section->subCoursework->coursework->course->department->id)->first();
            $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
                ->where('course_id', $section->subCoursework->coursework->course->department->id)->first();

            if ((($deptAdminCourseMap && $deptAdminCourseMap->status == 0) ||
                    ($convenorCourseMap && $convenorCourseMap->status == 0)) && Auth::user()->role_id != 6) {
                throwException();
            }
        }

        $validation =   $courseworkId==0 || ($coursework && $subcoursework && $section &&
                        $section->subcoursework_id == $subcourseworkId &&
                        $subcoursework->coursework_id == $courseworkId &&
                        $coursework->course_id == $courseId);

        $path = Storage::putFileAs('file', $file, 'marks_file_'.$courseworkId.'_'.$subcourseworkId.'_'.$sectionId.'_'.$courseId.'.csv');

        if($path && $validation) {

            Excel::load('storage/app/'.$path, function ($reader) use(&$sectionId, $courseId, $courseworkId){

                $values = $reader->toArray();
//                print_r($values);

                foreach ($values as $row) {
                    $employeeId = $row['emplid'];
                    $campusId = strtolower($row['campus_id']);
                    $term = $row['term'];
                    $subject = $row['subject'];
                    $catalogNumber = $row['catalog_nbr'];
                    $classNumber = $row['class_nbr'];
                    $academicProgram = $row['acad_prog'];
                    $marks = $row['final_grade'];

                    $courseCode = $subject.$catalogNumber;
                    $course = Course::find($courseId)->first();
                    /*if(strtolower($course->code) != strtolower($courseCode) || $term!=$course->term_number){
                        break;
                    }*/

                    $user = User::where('employee_id', $employeeId)
                        ->orWhere('student_number', $campusId)->first();
                    if(!$user) {
                        $user = new User();
                        $user->employee_id = $employeeId;
                        $user->student_number = $campusId;
                        $user->approved = 1;
                        $user->save();
                    }
                    $userCourseMap = UserCourseMap::where('user_id', $user->id)
                        ->where('course_id', $courseId)->first();
                    if(!$userCourseMap){
                        $userCourseMap = new UserCourseMap();
                        $userCourseMap->user_id=$user->id;
                        $userCourseMap->course_id=$courseId;
                        $userCourseMap->academic_program=$academicProgram;
                        $userCourseMap->class_number=$classNumber;
                        $userCourseMap->status=1;
                        $userCourseMap->save();
                    }
                    if($courseworkId != 0) {
                        $sectionMap = SectionUserMarkMap::where('user_id', $user->id)
                            ->where('section_id', $sectionId)->first();
                        if (!$sectionMap) {
                            $sectionMap = new SectionUserMarkMap();
                            $sectionMap->user_id = $user->id;
                            $sectionMap->section_id = $sectionId;
                        }
                        $sectionMap->marks = $marks;
                        $sectionMap->save();
                    } else {
                        $userFinalMap = UserCourseFinalGrade::where('user_id', $user->id)
                            ->where('course_id', $courseId)->first();
                        if(!$userFinalMap){
                            $userFinalMap = new UserCourseFinalGrade();
                            $userFinalMap->user_id = $user->id;
                            $userFinalMap->course_id = $courseId;
                        }
                        $grade = FinalGradeType::where('name', $marks)->first();
                        $userFinalMap->type_id = (is_numeric($marks) || !$grade || !$marks)?1:$grade->id;
                        $userFinalMap->save();
                    }
                }
            });
        }

        Storage::delete($path);

        return redirect()->back();
    }

    /**
     * return a list of the 18 gradetypes available, useful for ajax request
     * @return mixed
     */
    public function getGradeTypes(){
        $results = [];
        foreach (FinalGradeType::all() as $item) {
            $result = [];
            $result['name'] = $item->name;
            $result['id'] = $item->id;
            $results[] = $result;
        }
        return Response::json($results);
    }

    /**
     * Takes in a courseId, a list containing userId and gradeId.
     * By default, a student will see his final grade points. This can be changed to a symbol such as 'AB', 'OSS'
     * @param Request $request
     */
    public function updateFinalGrade(Request $request){
        $values = $request->input('values');
        $courseId = $request->input('courseId');

        $course = Course::where('id', $courseId)->first();
        if(!$course){
            throwException(); // a section eventually has to be for a course
        }
        $deptAdminCourseMap = DeptAdminDeptMap::where('user_id', Auth::user()->id)
            ->where('department_id', $course->department->id)->first();
        $convenorCourseMap = ConvenorCourseMap::where('user_id', Auth::user()->id)
            ->where('course_id', $course->department->id)->first();

        if((($deptAdminCourseMap && $deptAdminCourseMap->status ==0) ||
                ($convenorCourseMap && $convenorCourseMap->status==0)) && Auth::user()->role_id != 6){
            throwException();
        }

        foreach ($values as $row) {
            $userId = $row[0];
            $gradeId = $row[1];

            $gradeMap = UserCourseFinalGrade::where('user_id', $userId)
                        ->where('course_id', $courseId)->first();
            if(!$gradeMap){
                $gradeMap = new UserCourseFinalGrade();
                $gradeMap->user_id = $userId;
                $gradeMap->course_id = $courseId;
            }
            $gradeMap->type_id = $gradeId;

            $gradeMap->save();
        }
    }

    /**returns a list of students with their class marks, year marks, DP status and Final Grade
     * @param $studentNumber
     * @param $courseId
     * @param $offsetRaw
     * @return array
     */
    public function getStudentMarksList($studentNumber, $courseId, $offsetRaw){
        $limit = 30;
        $offset = $offsetRaw*$limit;

        $students = [];
        if($studentNumber){
            if($offsetRaw==-1) {
                $usrs = User::where('student_number', 'like', '%' . $studentNumber . '%')
                    ->orWhere('employee_id', 'like', '%' . $studentNumber . '%')->get();
            } else {
                $usrs = User::where('student_number', 'like', '%' . $studentNumber . '%')
                    ->orWhere('employee_id', 'like', '%' . $studentNumber . '%')
                    ->limit($limit)->offset($offset)->get();
            }
            if($usrs) {
                foreach ($usrs as $usr) {
                    $students[] = UserCourseMap::where('user_id', $usr->id)
                        ->where('course_id', $courseId)->first()->user;
                }
            }
        } else {
            if($offsetRaw == -1){
                $users = UserCourseMap::where('course_id', $courseId)->get();
            } else {
                $users = UserCourseMap::where('course_id', $courseId)
                    ->limit($limit)->offset($offset)->get();
            }
            if($users) {
                foreach ($users as $user) {
                    $students[] = $user->user;
                }
            }
        }

        $course = Course::where('id', $courseId)->first();
        $courseworks = $course->courseworks;

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

        $results = [];
        foreach ($students as $student){
            $result = [];
            $result['student_number'] = $student->student_number;
            $result['employee_id'] = $student->employee_id;
            $result['id'] = $student->id;
            $yearmark = 0.0;
            $classmark = 0.0;

            foreach ($courseworks as $coursework) {
                $inClassMark = ($coursework->weighting_in_classrecord > 0);
                $inYearMark = ($coursework->weighting_in_yearmark > 0);

                if($inClassMark || $inYearMark){
                    $classMarkWeighting = $coursework->weighting_in_classrecord;
                    $yearMarkWeighting = $coursework->weighting_in_yearmark;
                    $courseworkTotalMark = 0.0;

                    $submSubcourseworks = [];
                    foreach ($coursework->subcourseworks as $subcoursework) {
                        $markReleased = $subcoursework->display_to_students <= (date('Y').'-'.date('m').'-'.date('d'));
                        $inCourseWork = $subcoursework->weighting_in_coursework > 0;

                        if($inCourseWork && $markReleased){
                            $subcourseworkWeighting = $subcoursework->weighting_in_coursework;
                            $subcourseworkN = 0.0;
                            $subcourseworkD = 0.0;
                            foreach ($subcoursework->sections as $section) {
                                $subcourseworkD += $section->max_marks;
                                $numerator = SectionUserMarkMap::where('user_id', $student->id)
                                    ->where('section_id', $section->id)->first();
                                $subcourseworkN = $numerator? $numerator->marks:0;
                            }
                            $subcourseworkFinalMark = $subcourseworkD!=0?($subcourseworkN*$subcourseworkWeighting)/$subcourseworkD:0;
                            $courseworkTotalMark += $subcourseworkFinalMark;
                            
                            $submSubcourseworks[$subcoursework->id] = $subcourseworkD!=0?($subcourseworkN*100.0)/$subcourseworkD:0;
                        }
                    }
                    $courseworkFinalClassMark = ($courseworkTotalMark*$classMarkWeighting)/100.0;
                    $courseworkFinalYearMark = ($courseworkTotalMark*$yearMarkWeighting)/100.0;
                    
                    $classmark += $courseworkFinalClassMark;
                    $yearmark += $courseworkFinalYearMark;
                    
                    $submCoursework = [];
                    $submCoursework['total'] = $courseworkTotalMark;
                    $submCoursework['subs'] = $submSubcourseworks;
                    $submCourseworks[$coursework->id] = $submCoursework;
                }
            }
            $result['class_mark'] = round($classmark, 2);
            $result['year_mark'] = round($yearmark, 2);
            $finalGrade = UserCourseFinalGrade::where('user_id', $student->id)
                ->where('course_id', $courseId)->first();
            if($finalGrade){
                if($finalGrade->type_id == 1){
                    $result['final_grade'] = round($yearmark, 2);
                } else {
                    $result['final_grade'] = FinalGradeType::where('id', $finalGrade->type_id)->first()->name;
                }
            } else {
                $result['final_grade'] = round($yearmark, 2);
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

        $types = [];
        foreach (FinalGradeType::all() as $item) {
            $type = [];
            $type['name'] = $item->name;
            $type['id'] = $item->id;
            $types[] = $type;
        }

        $returnResults = [];
        $returnResults[] = $results;
        $returnResults[] = $types;

        return $returnResults;
    }

    /**
     * Generates a csv file for final grade and return the file name for the download to start
     * @param Request $request
     * @return mixed
     */
    public function downloadFinalGrade(Request $request){
        $courseId = $request->input('courseId');

        $results = $this->getStudentMarksList('', $courseId, -1);

        $marks =  $results[0];

        $fileName = "final_grade_".$courseId.".csv";
        $fullFileName = "generated_files/".$fileName;

        $myfile = fopen($fullFileName, "w");

        fputcsv($myfile, explode(', ','Emplid, Campus ID, Name, Term, Class Nbr, Subject, Catalog Nbr, Acad Prog, Final Grade'));

        $course = Course::where('id', $courseId)->first();

        foreach($marks as $record){
           $campusId = $record['student_number'];
           $employeeId = $record['employee_id'];

           $user = User::where('student_number', $campusId)->where('employee_id', $employeeId)->first();
           $userCourseMap = UserCourseMap::where('user_id', $user->id)->first();

           $name = $user->last_name . ', ' . $user->first_name;
           $classNumber = $userCourseMap->class_number;
           $academicProgram = $userCourseMap->academic_program;
           $subject = substr($course->code, 0, 3);
           $catalogNumber = substr($course->code, 3, strlen($course->code));
           $finalGrade = $record['final_grade'];
           $term = $course->term_number;

           fputcsv($myfile, [$employeeId, $campusId, $name, $term, $classNumber, $subject, $catalogNumber, $academicProgram, $finalGrade]);
        }
        fclose($myfile);
        return Response::json($fullFileName);
    }

    /**
     * generates a csv file for the DP status and return the file name for the download to start
     * @param Request $request
     * @return mixed
     */
    public function downloadDPList(Request $request){
        $courseId = $request->input('courseId');

        $results = $this->getStudentMarksList('', $courseId, -1);

        $marks =  $results[0];

        $fileName = "dp_list_".$courseId.".csv";
        $fullFileName = "generated_files/".$fileName;

        $myfile = fopen($fullFileName, "w");

        fputcsv($myfile, explode(', ','Emplid, Campus ID, Course, Status'));

        $course = Course::where('id', $courseId)->first();

        $courseYear = $course->code . ' ('.explode('-', $course->start_date)[0].')';

        foreach($marks as $record){
            $campusId = $record['student_number'];
            $employeeId = $record['employee_id'];
            $status = $record['dp_status'];
            fputcsv($myfile, [$employeeId, $campusId, $courseYear, $status]);
        }
        fclose($myfile);
        return Response::json($fullFileName);
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

        $student = User::where('student_number', $studentNumber)->orWhere('employee_id', $studentNumber)->first();
        if(!$studentNumber || !$student){return [];}

        $deptMaps = Auth::user()->departmentMaps;
        $possibleCourses = [];
        foreach ($deptMaps as $deptMap) {
            foreach ($deptMap->department->courses as $crs) {
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
}
