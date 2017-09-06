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
                        / <a href="#">Convening Courses </a> / <a href="#"> CSC1016S</a> / <a href="">Marks</a> / <a
                                href="">Marks</a>
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
                                <li role="presentation"><a href="/coourse/details">Course Details</a></li>
                                <li role="presentation"><a href="/course/participants">Participants</a></li>
                                <li role="presentation"><a href="/course/coursework">Courseworks</a></li>
                                <li role="presentation" class="active"><a href="/course/marks">View/Update Marks</a></li>
                                <li role="presentation"><a href="/course/export">Export Marks</a></li>
                            </ul>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="card">
                                <div class="header">
                                    <h5 class="title">View/Update Marks</h5>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-control-label" for="course_code">Student/Employee #</label>
                                            <input type="text" class="form-control" style="border: solid black 1px">
                                        </div>
                                        <div class="col-md-8" style="text-align: right">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-danger btn-xl">Save</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div id="table_results_div" class="row">
                                        <div style="text-align: center">
                                            <nav aria-label="Page navigation">
                                                <div style="text-align: right">
                                                    <button class="btn btn-danger btn-xl">Update Marks</button>
                                                </div>
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
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th rowspan="2">Std #</th>
                                                <th>
                                                    <a href="">Test 1 (/35)</a>
                                                </th>
                                                <th>
                                                    <a href="">Test 2 (/35)</a>
                                                </th>
                                                <th>
                                                    Total marks (/70)
                                                </th>
                                                <th>
                                                    Total Percentage
                                                </th>
                                                <th>
                                                    Subminimum Met?
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1234567</td>
                                                <td><input class="form-control" style="border: solid 1px black; width:65px;" value="30"></td>
                                                <td><input class="form-control" style="border: solid 1px black; width:65px;" value="35"></td>
                                                <td>65</td>
                                                <td>92.85</td>
                                                <td>Y</td>
                                            </tr>
                                            <tr>
                                                <td>7654321</td>
                                                <td><input class="form-control" style="border: solid 1px black; width:65px;" value="30"></td>
                                                <td><input class="form-control" style="border: solid 1px black; width:65px;" value="35"></td>
                                                <td>65</td>
                                                <td>92.85</td>
                                                <td>Y</td>
                                            </tr>
                                            <tr>
                                                <td>1234567</td>
                                                <td><input class="form-control" style="border: solid 1px black; width:65px;" value="30"></td>
                                                <td><input class="form-control" style="border: solid 1px black; width:65px;" value="35"></td>
                                                <td>65</td>
                                                <td>92.85</td>
                                                <td>Y</td>
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
