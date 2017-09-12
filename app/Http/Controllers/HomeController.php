<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        if(Auth::user()->approved != 1){
            Auth::logout();
            return view('auth.login');
        }
        $roleID = Auth::user()->role_id;
        switch ($roleID){
            case 1:
                return view('student.home');
                break;
            case 2:
                return view('teachingassistant.home');
                break;
            case 3:
                return view('lecturer.home');
                break;
            case 4:
                return view('courseconvenor.home');
                break;
            case 5:
                return view('departmentadmin.home');
                break;
            case 6:
                return view('systemadmin.home');
                break;
        }

    }
}
