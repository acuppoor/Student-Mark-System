<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
            case 2:
                return view('student.home');
            case 3:
            case 4:
                return view('lecturer.home');
            case 5:
                return view('departmentadmin.home');
            case 6:
                return view('systemadmin.home');
        }

    }

    public function searchMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.access_denied');
                break;
            case 2:
                return view('student.searchmarks');
                break;
            case 3:
                return view('lecturer.searchmarks');
                break;
            case 4:
                return view('courseconvenor.searchmarks');
                break;
            case 5:
                return view('departmentadmin.searchmarks');
                break;
            case 6:
                return view('systemadmin.searchmarks');
                break;
        }
    }

    public function myMarks(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1 || 2:
                return view('student.my_marks');
            default:
                return view('stdent.access_denied');
        }
    }

    public function taCourses(){
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 2:
                return view('student.ta_courses');
            default:
                return view('stdent.access_denied');
        }
    }
}
