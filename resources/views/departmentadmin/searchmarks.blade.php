@extends('include_home.main')
@section('page_title')
    Search Marks
@endsection
@section('sidebar')
    @include('include_home.dept_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/departmentadmin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-search"></i>&nbsp;Search</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
        </div>
    </div>
@endsection

{{--
@extends('layouts.dashboard.main')

@section('title')
    Search Marks
@endsection

@section('content')
<div class="wrapper">
--}}
{{--    @include('include.dashboard.sidepanel')--}}{{--


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
                <li id="department_admin_tab" class="active">
                    <a href="/departmentadmin/searchmarks">
                        <i class="ti-panel"></i>
                        <p>Search Marks</p>
                    </a>
                </li>
                <li id="department_admin_tab">
                    <a href="/departmentadmin/admin">
                        <i class="ti-panel"></i>
                        <p>Admin</p>
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
                    / <a href="">Search Marks</a>
                </div>
            </div>
        </div>
        @include('include.dashboard.search')
        @include('include.dashboard.footer')
    </div>
</div>
@endsection
--}}
