@extends('layouts.dashboard.main')

@section('title')
    Dashboard
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
                    <a href="/systemadmin">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="/systemadmin/facsanddepts">
                        <i class="ti-panel"></i>
                        <p>Faculties & Departments</p>
                    </a>
                </li>
                <li id="system_admin_tab">
                    <a href="/systemadmin/departmentportal">
                        <i class="ti-panel"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li id="system_admin_tab">
                    <a href="/systemadmin/searchmarks">
                        <i class="ti-panel"></i>
                        <p>Search Marks</p>
                    </a>
                </li>
                <li class="active">
                    <a href="/systemadmin/admin">
                        <i class="ti-panel"></i>
                        <p>System Admin</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        @include('include.dashboard.nav')
        <div class="row" style="background-color: whitesmoke">
            <div class="card">
                <div class="col-md-12">
                    / <a href="">System Admin</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
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
                                        <label class="form-control-label" for="course_code">Filter by Student Numbers</label>
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
@endsection