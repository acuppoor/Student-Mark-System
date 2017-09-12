@extends('include_home.main')
@section('page_title')
    TA Courses
@endsection
@section('sidebar')
    @include('include_home.ta_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/teachingassistant/ta_courses')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-book"></i>&nbsp;TA Courses</h4>
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
                <li>
                    <a href="/teachingassistant">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="/teachingassistant/courses">
                        <i class="ti-panel"></i>
                        <p>My Marks</p>
                    </a>
                </li>
                <li class="active">
                    <a href="/teachingassistant/courses_ta">
                        <i class="ti-panel"></i>
                        <p>Courses (TA)</p>
                    </a>
                </li>
                <li>
                    <a href="/teachingassistant/searchmarks">
                        <i class="ti-panel"></i>
                        <p>Search Marks</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    @include('include.dashboard.courselist')

</div>
@endsection
--}}
