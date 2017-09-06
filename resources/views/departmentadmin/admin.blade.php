@extends('layouts.dashboard.main')

@section('title')
    Admin
@endsection

@section('content')
<div class="wrapper">
{{--    @include('include.dashboard.sidepanel')--}}

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
                <li id="dashboard_tab">
                    <a href="/departmentadmin">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li id="department_admin_tab">
                    <a href="/departmentadmin/courses">
                        <i class="ti-panel"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li id="department_admin_tab">
                    <a href="/departmentadmin/searchmarks">
                        <i class="ti-panel"></i>
                        <p>Search Marks</p>
                    </a>
                </li>
                <li id="department_admin_tab" class="active">
                    <a href="/departmentadmin/admin">
                        <i class="ti-panel"></i>
                        <p>Admin</p>
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
                    <a class="navbar-brand" href="#">System Admin Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="py-0 dropdown">
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
                    / <a href="">Admin</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="header" style="border-bottom: 1px solid black">
                                <h5 class="title">Add User</h5>
                            </div>
                            <div class="content">
                                <div class="header"><h5>Course Convenor</h5></div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Email</font></label>
                                        <input type="email" class="form-control" style="border: solid 1px black">
                                    </div>
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Staff #</font></label>
                                        <input type="text" class="form-control" style="border: solid 1px black">
                                    </div>
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Course</font></label>
                                        <select class="form-control" style="border: solid 1px black">
                                            <option selected>CSC1016S</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Department</font></label>
                                        <select class="form-control" style="border: solid 1px black">
                                            <option selected>Computer Science</option>
                                            <option>Biochem</option>
                                            <option>Physics</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Faculty</font></label>
                                        <select class="form-control" style="border: solid 1px black">
                                            <option selected>Science</option>
                                            <option>Humanities</option>
                                            <option>Engineering</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="text-align: center">
                                        <p>&nbsp;</p>
                                        <button class="btn btn-danger btn-xl">Add</button> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="header">
                                <h5 class="title">Approve Accounts</h5>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label" for="course_code">Filter by Student Number</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input class="form-control" style="border: solid 1px black" placeholder="<none>">
                                            </div>
                                            <div class="col-md-3">
                                                <button id="search_btn_table" class="btn btn-danger btn-xl">Search</button>
                                            </div>

                                        </div>
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
                                            <th>Approve</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>John</td>
                                            <td>Doe</td>
                                            <td>1234567</td>
                                            <td>john@example.com</td>
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Another</td>
                                            <td>Doe</td>
                                            <td>1234567</td>
                                            <td>another@example.com</td>
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Other</td>
                                            <td>Doe</td>
                                            <td>1234567</td>
                                            <td>other@example.com</td>
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox">
                                                </div>
                                            </td>
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
