<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check() && Auth::user()->approved){
            return redirect()->route("home");
        }
        return view('contact');
    }
}
