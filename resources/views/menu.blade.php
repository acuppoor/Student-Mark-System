@extends('layouts.default.app')

@section('title')
    Menus
@endSection

@section('content')
    <div class="container" style="padding-top: 5%;">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="panel panel-default" style="opacity: 0.9">
                    <div class="panel-heading">
                        <div class="section-heading text-center">
                            <h2>Pages</h2>
                            <br/>
                            <i>for easy navigation only... not included in final product</i>
                            <hr>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row" style="text-align: center">
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/register')}}" target="_blank"><button class="btn btn-danger btn-xl">Register</button></a>
                            </div>
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/login')}}" target="_blank"><button class="btn btn-danger btn-xl">Login</button></a>
                            </div>
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/contact')}}" target="_blank"><button class="btn btn-danger btn-xl">Contact</button></a>
                            </div>
                        </div>
                        <br/>
                        <div class="row" style="text-align: center">
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/student')}}" target="_blank"><button class="btn btn-danger btn-xl">Student</button></a>
                            </div>
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/teachingassistant')}}" target="_blank"><button class="btn btn-danger btn-xl">TA</button></a>
                            </div>
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/lecturer')}}" target="_blank"><button class="btn btn-danger btn-xl">Lecturer</button></a>
                            </div>
                        </div>
                        <br/>
                        <div class="row" style="text-align: center">
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/courseconvenor')}}" target="_blank"><button class="btn btn-danger btn-xl">Convenor</button></a>
                            </div>
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/departmentadmin')}}" target="_blank"><button class="btn btn-danger btn-xl">Dept. Admin</button></a>
                            </div>
                            <div class="col-md-4" style="text-align: center">
                                <a href="{{url('/systemadmin')}}" target="_blank"><button class="btn btn-danger btn-xl">Sys. Admin</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('first_bootstrap/js/ContactForm.js')}}"></script>
@endsection
