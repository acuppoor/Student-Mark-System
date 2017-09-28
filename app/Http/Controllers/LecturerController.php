<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\CourseType;
use App\Coursework;
use App\CourseworkType;
use App\LecturerCourseMap;
use App\Section;
use App\SectionUserMarkMap;
use App\SubCoursework;
use App\Subminimum;
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
            $subminimum['name'] = $subm->name;
            $subminimum['for_dp'] = $subm->for_dp;
            $subminimum['threshold'] = $subm->threshold;

            $rows = [];
            foreach ($subm->subminimumRows as $rw){
                $row = [];
                $row['id'] = $rw->id;
                $row['coursework'] = Coursework::where('id', $rw->coursework_id)->first()->name;
                $subcwrk = SubCoursework::where('id', $rw->subcoursework_id)->first();
                $row['subcoursework'] = $subcwrk? $subcwrk->name : '';
                $row['weighting'] = $rw->weighting;
                $rows[] = $row;
            }
            $subminimum['rows'] = $rows;
            $subminimums[] = $subminimum;
        }
        $courseDetails['subminimums'] = $subminimums;
        return $courseDetails;
    }

    public function createCoursework(Request $request){
        $name = $request->input('name');
        $type = $request->input('type');
        $releaseDate = $request->input('releaseDate');
        $classWeighting = $request->input('classWeighting');
        $yearWeighting = $request->input('yearWeighting');
        $courseId = $request->input('courseId');

        $coursework = new Coursework();
        $coursework->name = $name;
        $coursework->coursework_type_id = $type;
        $coursework->display_to_students = $releaseDate;
        $coursework->weighting_in_classrecord = $classWeighting;
        $coursework->weighting_in_yearmark = $yearWeighting;
        $coursework->course_id = $courseId;
        $coursework->save();
    }

    public function deleteCoursework(Request $request){
        $courseworkId = $request->input('courseworkId');
        Coursework::destroy($courseworkId);
    }

    public function createSubcoursework(Request $request){
        $courseworkId = $request->input('courseworkId');
        $name = $request->input('name');
        $releaseDate = $request->input('releaseDate');
        $maxMarks = $request->input('maxMarks');
        $weighting = $request->input('weighting');
        $displayMarks = $request->input('displayMarks');
        $displayPercentage = $request->input('displayPercentage');


        $subcoursework = new SubCoursework();
        $subcoursework->coursework_id = $courseworkId;
        $subcoursework->name = $name;
        $subcoursework->display_to_students = $releaseDate;
        $subcoursework->display_marks = $displayMarks;
        $subcoursework->display_percentage = $displayPercentage;
        $subcoursework->weighting_in_coursework = $weighting;
        $subcoursework->max_marks = $maxMarks;
        $subcoursework->save();
        return Response::json('success');
    }

    public function deleteSubcoursework(Request $request)
    {
        $subcourseworkId = $request->input('subcourseworkId');
//        echo($subcourseworkId); die();
        SubCoursework::destroy($subcourseworkId);
    }

    public function createSection(Request $request)
    {
        $subcourseworkId = $request->input('subcourseworkId');
        $name = $request->input('name');
        $maxMarks = $request->input('maxMarks');

        $section = new Section();
        $section->subcoursework_id = $subcourseworkId;
        $section->name = $name;
        $section->max_marks = $maxMarks;
        $section->save();
    }

    public function deleteSection(Request $request)
    {
        $sectionId = $request->input('sectionId');
//        echo($subcourseworkId); die();
        Section::destroy($sectionId);
    }

    public function createSubminimum(Request $request){
        $name = $request->input('name');
        $type = $request->input('type');
        $courseId = $request->input('courseId');
        $threshold = $request->input('threshold');

        $subminimum = new Subminimum();
        $subminimum->name = $name;
        $subminimum->for_dp = $type;
        $subminimum->course_id = $courseId;
        $subminimum->threshold = $threshold;
        $subminimum->save();
    }

    public function getSubCourseworks(Request $request){
        $courseworkId = Coursework::where('name', $request->input('coursework'))->first()->id;

        $subcourseworks = SubCoursework::where('coursework_id', $courseworkId)->get();
        $results=[];
        foreach ($subcourseworks as $subcwrk){
            $results[] = $subcwrk->name;
        }

        return Response::json($results);
    }

    public function getSections(Request $request){
        $subcourseworkId = SubCoursework::where('name', $request->input('subcoursework'))->first()->id;

        $sections = Section::where('subcoursework_id', $subcourseworkId)->get();
        $results=[];
        foreach ($sections as $sctn){
            $results[] = $sctn->name;
        }

        return Response::json($results);
    }

    public function getStudentsMarks(Request $request){
        $studentNumber = $request->input('studentNumber');
        $courseId = $request->input('courseId');
        $limit = 30;
        $offsetRaw = $request->input('offset');
        $offset = $offsetRaw*$limit;

        $students = [];
        if($studentNumber){
            $usr = User::where('student_number', $studentNumber)
                ->orWhere('employee_id', $studentNumber)->first();
            if($usr) {
                $students[] = UserCourseMap::where('user_id', $usr->id)
                                            ->where('course_id', $courseId)->first()->user;
            }
        } else {
            $users = [];
            if($offsetRaw == -1){
                $users = UserCourseMap::where('course_id', $courseId)->first();
            } else {
                $users = UserCourseMap::where('course_id', $courseId)
                    ->limit($limit)->offset($offset)->get();
            }
            foreach($users as $user){
                $students[] = $user->user;
            }
        }

        $course = Course::where('id', $courseId)->first();
        $courseworks = $course->courseworks;
        $results = [];
        foreach ($students as $student){
            $result = [];
            $result['student_number'] = $student->student_number;
            $result['employee_id'] = $student->employee_id;
            $yearmark = 0.0;
            $classmark = 0.0;

            foreach ($courseworks as $coursework) {
                $inClassMark = ($coursework->weighting_in_classrecord > 0);
                $inYearMark = ($coursework->weighting_in_yearmark > 0);

                if($inClassMark || $inYearMark){
                    $classMarkWeighting = $coursework->weighting_in_classrecord;
                    $yearMarkWeighting = $coursework->weighting_in_yearmark;
                    $courseworkTotalMark = 0.0;

                    foreach ($coursework->subcourseworks as $subcoursework) {
                        $markReleased = $subcoursework->display_to_students <= (date('Y').'-'.date('m').'-'.date('d'));
                        $inCourseWork = $subcoursework->weighting_in_coursework > 0;

                        if($inCourseWork && $markReleased){
                            $subcourseworkWeighting = $subcoursework->weighting_in_coursework;
                            $subcourseworkN = 0.0;
                            $subcourseworkD = 0.0;
                            foreach ($subcoursework->sections as $section) {
                                $subcourseworkD += $section->max_marks;
                                $subcourseworkN += SectionUserMarkMap::where('user_id', $student->id)
                                                    ->where('section_id', $section->id)->first()->marks;
                            }
                            $subcourseworkFinalMark = $subcourseworkD!=0?($subcourseworkN*$subcourseworkWeighting)/$subcourseworkD:0;
                            $courseworkTotalMark += $subcourseworkFinalMark;
                        }
                    }
                    $courseworkFinalClassMark = ($courseworkTotalMark*$classMarkWeighting)/100.0;
                    $courseworkFinalYearMark = ($courseworkTotalMark*$yearMarkWeighting)/100.0;

                    $classmark += $courseworkFinalClassMark;
                    $yearmark += $courseworkFinalYearMark;
                }
            }
            $result['class_mark'] = $classmark;
            $result['year_mark'] = $yearmark;
            $results[] = $result;
        }

        return Response::json($results);
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
//        print_r($users); die();
        $users = $users?array_unique($users):$users;
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
                    $result["id"] = $user->id;
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

    public function getStudents(Request $request){
        $courseId = $request->input('courseId');
        $studentMaps = UserCourseMap::where('course_id', $courseId)->get();
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
        return $students;
    }

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
}
