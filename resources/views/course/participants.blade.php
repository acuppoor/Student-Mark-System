@extends('layouts.dashboard.main')

@section('title')
    Participants
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
                        / <a href="#">Convening Courses </a> / <a href="#"> CSC1016S</a> / <a href=""> Participants</a>
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
                                <li role="presentation" class="active"><a href="/course/participants">Participants</a></li>
                                <li role="presentation"><a href="/course/coursework">Coursework</a></li>
                                <li role="presentation"><a href="/course/marks">View/Update Marks</a></li>
                                <li role="presentation"><a href="/course/export">Export Marks</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="card">
                                <div class="header" style="border-bottom: solid 1px black">
                                    <h5 class="title"><b>Add/Remove Participants</b></h5>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="header"><h5>Add Teaching Assistant</h5></div>
                                        <div class="col-md-4">
                                            <label class="form-control-label" for="ta_email">Email</label>
                                            <input id="ta_email" type="email" style="border: 1px solid black" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-control-label" for="invitation_mail"><font color="black">Send Invitation Mail</font></label><br/>
                                            <div class="checkbox">
                                                <input id="invitation_mail" type="checkbox" checked>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="text-align: center">
                                            <br/>
                                            <button class="btn btn-danger btn-xl">Add TA</button>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="header"><h5>Add Lecturer</h5></div>
                                        <div class="col-md-4">
                                            <label class="form-control-label" for="ta_email">Email</label>
                                            <input class="form-control" style="border: solid 1px black" type="text" list="lecturers" />
                                            <datalist id="lecturers">
                                                <option>lecturer1@cs.uct.ac.za</option>
                                                <option>lecturer2@cs.uct.ac.za</option>
                                                <option>lecturer3@cs.uct.ac.za</option>
                                            </datalist>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-control-label" for="invitation_mail"><font color="black">Send Invitation Mail</font></label><br/>
                                            <div class="checkbox">
                                                <input id="invitation_mail" type="checkbox" checked>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="text-align: center">
                                            <br/>
                                            <button class="btn btn-danger btn-xl">Add Lecturer</button>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="header"><h5>Remove Teaching Assistant/Lecturer</h5></div>
                                        <div class="col-md-4">
                                            <label class="form-control-label" for="ta_email">Email</label>
                                            <input class="form-control" style="border: solid 1px black" type="text" list="participants" />
                                            <datalist id="participants">
                                                <option>lecturer1@cs.uct.ac.za</option>
                                                <option>lecturer2@cs.uct.ac.za</option>
                                                <option>lecturer3@cs.uct.ac.za</option>
                                                <option>ta_1@cs.uct.ac.za</option>
                                                <option>ta_2@cs.uct.ac.za</option>
                                            </datalist>
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-3" style="text-align: center">
                                            <br/>
                                            <button class="btn btn-danger btn-xl">Remove User</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="header"><h5>Update Students' List</h5></div>
                                        <div class="col-md-4">
                                            <label for="2">File Containing Students' Details</label>
                                            <div class="form-control-file">
                                                <input id="1" class="form-control" type="file" style="border: 1px solid black">
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3" style="text-align: center">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-danger btn-xl">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="card">
                                <div class="header" style="border-bottom: solid 1px black">
                                    <h5 class="title"><b>Participants List</b></h5>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-control-label" for="course_code"><font color="black">Select Participants</font></label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <input id="checkbox1" type="checkbox">
                                                        <label for="checkbox1">
                                                            <font color="black">All Users</font>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <input id="checkbox1" type="checkbox">
                                                        <label for="checkbox1">
                                                            <font color="black">Lecturers</font>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <input id="checkbox1" type="checkbox">
                                                        <label for="checkbox1">
                                                            <font color="black">Students</font>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <input id="checkbox1" type="checkbox">
                                                        <label for="checkbox1">
                                                            <font color="black">Teaching Assistants</font>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <br/>
                                            <button id="search_btn_table" class="btn btn-danger btn-xl">Search</button>
                                            <button class="btn btn-danger btn-xl">Export</button>
                                        </div>
                                    </div>
                                    <hr>

                                    <div id="table_results_div" class="row">
                                        <div style="text-align: center">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <li>
                                                        <a href="#" aria-label="Previous">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <li class="active"><a href="#">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                    <li><a href="#">4</a></li>
                                                    <li><a href="#">5</a></li>
                                                    <li>
                                                        <a href="#" aria-label="Next">
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>Firstname</th>
                                                <th>Lastname</th>
                                                <th>Student/Staff Number</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>John</td>
                                                <td>Doe</td>
                                                <td>1234567</td>
                                                <td>john@example.com</td>
                                                <td>Lecturer</td>
                                                <td>Registered</td>
                                            </tr>
                                            <tr>
                                                <td>Another</td>
                                                <td>Doe</td>
                                                <td>1234567</td>
                                                <td>another@example.com</td>
                                                <td>Lecturer</td>
                                                <td>Deregistered</td>
                                            </tr>
                                            <tr>
                                                <td>Other</td>
                                                <td>Doe</td>
                                                <td>1234567</td>
                                                <td>other@example.com</td>
                                                <td>Lecturer</td>
                                                <td>Registered</td>
                                            </tr>
                                            </tbody>
                                        </table>
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
