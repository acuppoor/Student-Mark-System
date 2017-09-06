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
                <li>
                    <a href="/teachingassistant/courses_ta">
                        <i class="ti-panel"></i>
                        <p>Courses (TA)</p>
                    </a>
                </li>
                <li class="active">
                    <a href="/teachingassistant/searchmarks">
                        <i class="ti-panel"></i>
                        <p>Search Marks</p>
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
