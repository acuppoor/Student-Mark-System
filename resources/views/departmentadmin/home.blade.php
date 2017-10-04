@extends('include_home.main')
@section('page_title')
    Home
@endsection
@section('sidebar')
    @include('include_home.dept_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/home')}}" class="user-profile " data-toggle="dropdown" aria-expanded="false">
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
                            <h2><a href="{{route('other_courses')}}">Course Management</a></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content"  style="display: block">
                            <div class="dashboard-widget-content">
                                <ul class="list-unstyled timeline widget">
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Creating a Course</a>
                                                </h2>
                                                <p class="excerpt">
                                                    From the <a href="{{route('other_courses')}}">Course</a> page, click on the 'Create Course' button
                                                    on the top right-handside of the screen. A modal will appear asking for the course details. Compulsory fields
                                                    are marked with an '*'.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Deleting a Course</a>
                                                </h2>
                                                <p class="excerpt">
                                                    From the <a href="{{route('other_courses')}}">Course</a> page, click on the 'Delete' button next
                                                    to a course name and the course with all its contents will be deleted. Warning: A deleted course
                                                    cannot be recovered.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Viewing/Editing a Course</a>
                                                </h2>
                                                <p class="excerpt">
                                                    From the <a href="{{route('other_courses')}}">Course</a> page, click on a course and the course-management
                                                    page for the course will be shown with all the details of the course, including the courseworks, subcourseworks,
                                                    sections, subminimums, participants and marks. Various operations are available.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><a href="{{route('search_marks')}}">Viewing Students Marks</a></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="display: block">
                            <div class="dashboard-widget-content">
                                <ul class="list-unstyled timeline widget">
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Searching</a>
                                                </h2>
                                                <p class="excerpt">
                                                    A student number/employee ID is compulsory for the search. Only records which matches the
                                                    student number/employee ID exactly will be returned. Other filters such as course code,
                                                    year and department are optional.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>Viewing</a>
                                                </h2>
                                                <p class="excerpt">
                                                    If any record has been found, it will be displayed on the page. Each result if linked to a course.
                                                    The marks can be drilled down upto the section marks for the course.
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection