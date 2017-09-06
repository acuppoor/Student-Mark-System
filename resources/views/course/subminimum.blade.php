@extends('layouts.dashboard.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="wrapper">
        <div class="sidebar" data-background-color="black" data-active-color="danger">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="/" class="simple-text">
                        <img src="{{url('images/uct.png')}}" style="width: 50px; height: 50px">
                        &nbsp;
                        Mark System
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a href="/courseconvenor">
                            <i class="ti-panel"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="/courseconvenor/convenor_courses">
                            <i class="ti-panel"></i>
                            <p>Convening Courses</p>
                        </a>
                    </li>
                    <li>
                        <a href="/courseconvenor/courses">
                            <i class="ti-panel"></i>
                            <p>Courses</p>
                        </a>
                    </li>
                    <li>
                        <a href="/courseconvenor/searchmarks">
                            <i class="ti-panel"></i>
                            <p>Search Marks</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                        </button>
                        <a class="navbar-brand" href="#">CSC1016S</a>

                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ /*Auth::user()->firstName?Auth::user()->firstName:*/'Kushal' }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="">Profile</a>
                                    </li>
                                    <li>
                                        <a href="">Request Account Upgrade</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/contact')}}">Contact</a>
                                    </li>
                                    <hr/>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>



            <div class="row" style="background-color: whitesmoke">
                <div class="card">
                    <div class="col-md-12">
                        / <a href="#">Convening Courses </a> / <a href="#"> CSC1016S</a> / <a href=""> Courseworks</a> /
                        <a href="">Subminimum</a>
                    </div>
                </div>
            </div>
            <br/>
            <div class="content" style="padding-top: 0px">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 card">
                            <ul class="nav nav-pills">
                                <li role="presentation"><a href="/course/details">Course Details</a></li>
                                <li role="presentation"><a href="/course/participants">Participants</a></li>
                                <li role="presentation" class="active"><a href="/course/coursework">Courseworks</a></li>
                                <li role="presentation"><a href="/course/marks">View/Update Marks</a></li>
                                <li role="presentation"><a href="/course/export">Export Marks</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title">Subminimum</h5>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="header row">
                                                <strong>New Combined Subminimum Requirement</strong>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="1">1st</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option selected>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">2nd</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option selected>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">3rd</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option selected>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">Min %</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" >
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">For</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option>DP</option>
                                                        <option>Final Grade</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <p>&nbsp;</p>
                                                    <button class="btn btn-danger btn-xl">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" style="border-bottom: solid 1px black">
                                        <div class="col-md-12">
                                            <div class="header row">
                                                <strong>Existing Combined Subminimum Requirement</strong>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    1.
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">1st</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option>--</option>
                                                        <option selected>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">2nd</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option selected>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">3rd</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option selected>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">Min %</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="50">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">For</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option>DP</option>
                                                        <option>Final Grade</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-3" style="text-align: center">
                                                    <p>&nbsp;</p>
                                                    <button class="btn btn-danger btn-xl">Save</button>
                                                </div>
                                                <div class="col-md-3" style="text-align: center">
                                                    <p>&nbsp;</p>
                                                    <button class="btn btn-danger btn-xl">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="header row">
                                                <strong>Existing Combined Subminimum Requirement</strong>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    1.
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">1st</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option selected>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">2nd</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">3rd</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option selected>--</option>
                                                        <option>Tests</option>
                                                        <option>Practests</option>
                                                        <option>Assignments</option>
                                                        <option>Exams</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="1">Min %</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="50">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="1">For</label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option>DP</option>
                                                        <option selected>Final Grade</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-3" style="text-align: center">
                                                    <p>&nbsp;</p>
                                                    <button class="btn btn-danger btn-xl">Save</button>
                                                </div>
                                                <div class="col-md-3" style="text-align: center">
                                                    <p>&nbsp;</p>
                                                    <button class="btn btn-danger btn-xl">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('include.dashboard.footer')
        </div>
    </div>
@endsection
