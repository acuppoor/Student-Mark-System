@extends('dashboard.main')
@section('page_title')
    Courses
@endsection
@section('sidebar')
    @include('dashboard.sys_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/systemadmin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-book"></i>&nbsp;Courses</h4>
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
    Courses
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
                <li class="active">
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
                <li id="system_admin_tab">
                    <a href="/systemadmin/admin">
                        <i class="ti-panel"></i>
                        <p>System Admin</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @include('include.dashboard.courselist')
</div>
@endsection
--}}
