<?php

namespace App\Http\Controllers;

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
                $deptAdmins = $department->adminMaps;
                $admins = [];
                foreach ($deptAdmins as $deptAdmin) {
                    $admins[] = $deptAdmin->user;
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
}
