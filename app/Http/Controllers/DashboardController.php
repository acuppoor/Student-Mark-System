<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $role = 'system_admin';

        switch ($role){
            case "system_admin":
                return view('dashboard_sysadmin');
                break;
        }

        return view('dashboard_sysadmin');
    }

}
