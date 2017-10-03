<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\DeptAdminDeptMap;
use App\Faculty;
use App\User;
use Illuminate\Http\Request;
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
}
