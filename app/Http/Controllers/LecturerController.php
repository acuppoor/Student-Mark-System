<?php

namespace App\Http\Controllers;

use App\ConvenorCourseMap;
use App\Course;
use App\CourseType;
use App\Coursework;
use App\CourseworkType;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
        $subcourseworkIds = [];
        $sectionIds = [];
        $mapIds = [];
        $subcourseworks = SubCoursework::where('coursework_id', $courseworkId)->get();

        foreach($subcourseworks as $subcoursework){
            $sections = $subcoursework->sections;
            foreach ($sections as $section){
                $sectionUserMaps = $section->userMarkMap;
                foreach ($sectionUserMaps as $sectionUserMap) {
                    $mapIds[] = $sectionUserMap->id;
                }
                $sectionIds[] = $section->id;
            }
            $subcourseworkIds = $subcoursework->id;
        }

        SectionUserMarkMap::destroy($mapIds);
        Section::destroy($sectionIds);
        SubCoursework::destroy($subcourseworkIds);
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
        $sectionIds = [];
        $mapIds = [];
        $subcoursework = SubCoursework::where('id', $subcourseworkId)->first();

        $sections = $subcoursework->sections;
        foreach ($sections as $section){
            $sectionUserMaps = $section->userMarkMap;
            foreach ($sectionUserMaps as $sectionUserMap) {
                $mapIds[] = $sectionUserMap->id;
            }
            $sectionIds[] = $section->id;
        }

        SectionUserMarkMap::destroy($mapIds);
        Section::destroy($sectionIds);
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
        $section = Section::where('id', $sectionId);
        $mapIds = [];
        $sectionUserMaps = $section->userMarkMap;
        foreach ($sectionUserMaps as $sectionUserMap) {
            $mapIds[] = $sectionUserMap->id;
        }

        SectionUserMarkMap::destroy($mapIds);
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
        $cwrkValue = $request->input('coursework');
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
            $courseworkId = Coursework::where('name', $cwrkValue)->first()->id;
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

    public function getSections(Request $request){
        $subcourseworkId = SubCoursework::where('id', $request->input('subcoursework'))->first()->id;

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

    public function getStudentsMarks(Request $request){
        $studentNumber = $request->input('studentNumber');
        $courseId = $request->input('courseId');
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
        $courseworks = $course->courseworks;
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
            $finalGrade = UserCourseFinalGrade::where('user_id', $student->id)
                                    ->where('course_id', $courseId)->first();
            if($finalGrade){
                if($finalGrade->type_id == 1){
                    $result['final_grade'] = $yearmark;
                } else {
                    $result['final_grade'] = FinalGradeType::where('id', $finalGrade->type_id)->first()->name;
                }
            } else {
                $result['final_grade'] = $yearmark;
            }
            $result['dp_status'] = 'DP';
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

//            $downloadFile = Storage::disk('exports')->get($fileName);
//            return Response::download(public_path().'/'.$fullFileName);
            return Response::json($fileName);
        }
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

    private function isSimilar($haystack, $needle){
//        echo(strrpos(strtolower($haystack), strtolower($needle));die();
        $pos = strpos(strtolower($haystack), strtolower($needle));
        return ($pos===0||$pos>=1) || strtolower($haystack)==strtolower($needle);
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

        Mail::to($email)->send(new InvitationMail());

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

    public function createSubminimumRow(Request $request){
        $id = $request->input('subminimumId');
        $coursework = $request->input('coursework');
        $subcoursework = $request->input('subcoursework');
        $weighting = $request->input('weighting');
        $s = new SubminimumColumnMap();
        $s->coursework_id = $coursework;
        $s->subminimum_id = $id;
        $s->subcoursework_id = $subcoursework;
        $s->weighting = $weighting;
        $s->save();
    }

    public function deleteSubminimumRow(Request $request){
        $id = $request->input('id');
        SubminimumColumnMap::destroy($id);
    }

    public function deleteSubminimum(Request $request){
        $id = $request->input('id');
        SubminimumColumnMap::where('subminimum_id', $id)->delete();
        Subminimum::destroy($id);
    }

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
        $subcourseworks = $coursework->subcourseworks;
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

            foreach ($coursework->subcourseworks as $subcoursework) {

                $subcourseworkWeighting = $subcoursework->weighting_in_coursework;
                $subcourseworkN = 0.0;
                $subcourseworkD = 0.0;
                foreach ($subcoursework->sections as $section) {
                    $subcourseworkD += $section->max_marks;
                    $sectionMap = SectionUserMarkMap::where('user_id', $user->id)
                        ->where('section_id', $section->id)->first();
                    $subcourseworkN += ($sectionMap? $sectionMap->marks:0);
                }
                $subcourseworkFinalMark = $subcourseworkD!=0?($subcourseworkN*$subcourseworkWeighting)/$subcourseworkD:0;
                $courseworkTotalMark += $subcourseworkFinalMark;

                $subcourseworks[] = $subcourseworkFinalMark;
            }
            $result['subcourseworks'] = $subcourseworks;
            $result['total_marks'] = $courseworkTotalMark;
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
                $mark['numerator'] = $sectionMap? $sectionMap->marks:0;
                $mark['denominator'] = $section->max_marks;
                $subcourseworkD += $section->max_marks;
                $subcourseworkN += $mark['numerator'];
                $marks[] = $mark;
            }
            $subcourseworkFinalMark = $subcourseworkD!=0?($subcourseworkN*$subcourseworkWeighting)/$subcourseworkD:0;
            $result['sections'] = $marks;
            $result['total_num'] = $subcourseworkN;
            $result['total_den'] = $subcourseworkD;
            $result['percentage'] = $subcourseworkD!=0?($subcourseworkN*100.0)/$subcourseworkD:0;
            $result['weighted_marks'] = $subcourseworkFinalMark;
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

    public function updateSectionMarks(Request $request){
        $data = $request->input('data');

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

    public function approveUsers(Request $request){
        $userIds = $request->input('userIds');
//        User::where('id', 'IN', $userIds)->update(['approved'=>0]);
        foreach ($userIds as $userId) {
            $user = User::where('id', $userId)->first();
            $user->approved = 1;
            $user->save();
        }
    }

    public function convenorsAccess(Request $request){
        $userIds = $request->input('userIds');
        $status = $request->input('access');
        $courseId = $request->input('courseId');
        foreach ($userIds as $userId) {
            $map = ConvenorCourseMap::where('id', $userId)->where('course_id', $courseId)->first();
            if(!$map){
                $map = new ConvenorCourseMap();
                $map->user_id = $userId; $map->course_id = $courseId;
            }
            $map->status = $status;
            $map->save();
        }
    }

    public function lecturersAccess(Request $request){
        $userIds = $request->input('userIds');
        $status = $request->input('access');
        $courseId = $request->input('courseId');
        foreach ($userIds as $userId) {
            $map = LecturerCourseMap::where('id', $userId)->where('course_id', $courseId)->first();
            if(!$map){
                $map = new LecturerCourseMap();
                $map->user_id = $userId; $map->course_id = $courseId;
            }
            $map->status = $status;
            $map->save();
        }
    }

    public function tasAccess(Request $request){
        $userIds = $request->input('userIds');
        $status = $request->input('access');
        $courseId = $request->input('courseId');
        foreach ($userIds as $userId) {
            $map = TACourseMap::where('id', $userId)->where('course_id', $courseId)->first();
            if(!$map){
                $map = new TACourseMap();
                $map->user_id = $userId; $map->course_id = $courseId;
            }
            $map->status = $status;
            $map->save();
        }
    }

    public function updateCoursework(Request $request){
        $courseworkId = $request->input('courseworkId');
        $name = $request->input('name');
        $type = $request->input('type');
        $releaseDate = $request->input('releaseDate');
        $weightingYear = $request->input('weightingYear');
        $weightingClass = $request->input('weightingClass');

        $coursework = Coursework::where('id', $courseworkId)->first();
        $coursework->name = $name;
        $coursework->coursework_type_id = CourseworkType::where('name', $type)->first()->id;
        $coursework->display_to_students = $releaseDate;
        $coursework->weighting_in_yearmark = $weightingYear;
        $coursework->weighting_in_classrecord = $weightingClass;
        $coursework->save();

    }

    public function updateSubcoursework(Request $request){
        $subcourseworkId = $request->input('subcourseworkId');
        $name = $request->input('name');
        $maxMarks = $request->input('maxMarks');
        $releaseDate = $request->input('releaseDate');
        $weightingCourse = $request->input('weightingCourse');
        $displayMarks = $request->input('displayMarks');
        $displayPercentage = $request->input('displayPercentage');

        $subcoursework = SubCoursework::where('id', $subcourseworkId)->first();
        $subcoursework->name = $name;
        $subcoursework->display_to_students = $releaseDate;
        $subcoursework->display_marks = $displayMarks;
        $subcoursework->display_percentage = $displayPercentage;
        $subcoursework->weighting_in_coursework = $weightingCourse;
        $subcoursework->max_marks = $maxMarks;
        $subcoursework->save();

    }

    public function updateSection(Request $request){
        $sectionId = $request->input('sectionId');
        $name = $request->input('name');
        $maxMarks = $request->input('maxMarks');

        $section = Section::where('id', $sectionId)->first();
        $section->name = $name;
        $section->max_marks = $maxMarks;
        $section->save();

    }

    public function updateSubminimum(Request $request){
        $subminimumId = $request->input('subminimumId');
        $name = $request->input('name');
        $type = $request->input('type');
        $threshold = $request->input('threshold');

        $subminimum = Subminimum::where('id', $subminimumId)->first();
        $subminimum->name = $name;
        $subminimum->for_dp = $type;
        $subminimum->threshold = $threshold;
        $subminimum->save();
    }

    public function updateSubminimumRow(Request $request){
        $rowId = $request->input('rowId');
        $coursework = $request->input('coursework');
        $subcoursework = $request->input('subcoursework');
        $weighting = $request->input('weighting');

//        echo($coursework);die();

        $row = SubminimumColumnMap::where('id', $rowId)->first();
        $row->coursework_id = $coursework;
        $row->subcoursework_id = $subcoursework?$subcoursework:-1;
        $row->weighting = $weighting;
        $row->save();
    }

    public function updateStudentsList(Request $request){
        $file = $request->file('file');
        $courseId = $request->input('courseId');
        $course = Course::find($courseId)->first();


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

    public function uploadSectionMarks(Request $request){
        $file = $request->file('marksFile');
        $courseId = $request->input('courseId');
        $courseworkId = $request->input('uploadCoursework');
        $subcourseworkId = $request->input('uploadSubcoursework');
        $sectionId = $request->input('uploadSection');

        $section = Section::find($sectionId)->first();
        $subcoursework = SubCoursework::find($subcourseworkId)->first();
        $coursework = Coursework::find($courseworkId)->first();

        $validation =   $courseworkId!=0 || ($coursework && $subcoursework && $section &&
                        $section->subcoursework_id == $subcourseworkId &&
                        $subcoursework->coursework_id == $courseworkId &&
                        $coursework->course_id == $courseId);

        $path = Storage::putFileAs('file', $file, 'marks_file_'.$courseworkId.'_'.$subcourseworkId.'_'.$sectionId.'_'.$courseId.'.csv');

        if($path && $section && $validation) {

            Excel::load('storage/app/'.$path, function ($reader) use(&$sectionId, $courseId, $courseworkId){

                $values = $reader->toArray();

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
                        $userFinalMap = new UserCourseFinalGrade();
                        $userFinalMap->user_id = $user->id;
                        $userFinalMap->course_id = $courseId;
                        $userFinalMap->grade_id = FinalGradeType::where('name', $marks);
                    }
                }
            });
        }

        Storage::delete($path);

        return redirect()->back();
    }

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

    public function updateFinalGrade(Request $request){
        $values = $request->input('values');
        $courseId = $request->input('courseId');

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
}
