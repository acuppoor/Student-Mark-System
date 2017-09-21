@extends('include_home.main')
@section('page_title')
    Convening Courses
@endsection
@section('sidebar')
    @include('include_home.lecturer_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/lecturer/convening_courses')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-book"></i>&nbsp;Courses</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="col-md-2 form-group pull-left top_search">
                                <label for="fullname">Course Code:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Course Code">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="coursetype">Type:</label>
                                <select class="form-control">
                                    <option></option>
                                    <option>F</option>
                                    <option>H</option>
                                    <option>S</option>
                                    <option>W</option>
                                    <option>Z</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="year_dropdown">Year:</label>
                                <select class="form-control">
                                    <option selected><?php echo(date("Y"));?></option>
                                    <?php
                                    $currentYear = (int) date("Y");
                                    for ($i = $currentYear-1; $i >= 2010; $i--){
                                        echo('<option>'.$i.'</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="faculty">Faculty:</label>
                                <select id="faculty" class="form-control">
                                    <option>Science</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="department">Department:</label>
                                <select id="department" class="form-control">
                                    <option>Computer Science</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group pull-left top_search">
                                <p>&nbsp;</p>
                                {{--<div class="input-group">--}}
                                {{--<span class="input-group-btn">--}}
                                <button class="btn btn-round btn-primary" type="button">Go!</button>
                                {{--</span>--}}
                                {{--</div>--}}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <h4>Results:</h4>
            <a href="{{url('/courseconvenor/courseedit')}}">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>1. CSC1016S (2017)</h2>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>2. CSC1015F (2017)</h2>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
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

    @include('include.dashboard.courselist')
</div>
@endsection
--}}
