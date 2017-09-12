@extends('include_home.main')
@section('page_title')
    Home
@endsection
@section('sidebar')
    @include('include_home.ta_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/teachingassistant')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-home"></i>&nbsp;Home</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Recent Queries</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="dashboard-widget-content">
                                <ul class="list-unstyled timeline widget">
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Viewing last year's marks</a>
                                                </h2>
                                                <div class="byline">
                                                    <span>13 hours ago</span>
                                                </div>
                                                <p class="excerpt">I want to view my marks for CSC2003S which I did last year. How can I do... <a>Read&nbsp;More</a>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Can I query my marks on this system?</a>
                                                </h2>
                                                <div class="byline">
                                                    <span>13 hours ago</span></a>
                                                </div>
                                                <p class="excerpt">I have seen my marks for a course. Should I be querying my marks using... <a>Read&nbsp;More</a>
                                                </p>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-4 col-xs-12">
                    <div class="x_panel tile fixed_height_320">
                        <div class="x_title">
                            <h2>Courses Done So Far...</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <h4>Courses Done For The Past 3 Years</h4>
                            <div class="widget_summary">
                                <div class="w_left w_25">
                                    <span>2017</span>
                                </div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="10" style="width: 67%;">
                                            <span class="sr-only">2 Courses</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">
                                    <span>2</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="widget_summary">
                                <div class="w_left w_25">
                                    <span>2016</span>
                                </div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="10" style="width: 100%;">
                                            <span class="sr-only">3 Courses</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">
                                    <span>3</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="widget_summary">
                                <div class="w_left w_25">
                                    <span>2015</span>
                                </div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="10" style="width: 67%;">
                                            <span class="sr-only">2 Courses</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">
                                    <span>2</span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




{{--
@extends('layouts.dashboard.main')

@section('title')
    Dashboard
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
                <li class="active">
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
                <li>
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
                    / <a href="">Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
--}}
