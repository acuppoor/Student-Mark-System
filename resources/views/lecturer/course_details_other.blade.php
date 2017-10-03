@extends('include_home.main')
@section('page_title')
    {{$course['code']}}
@endsection
@section('sidebar')
    @include('include_home.lecturer_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/lecturer/convening_courses')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-book"></i>&nbsp;{{$course['code']. '('. $course['year'] .')'}}</h4>
            </a>
        </li>
    </ul>
@endsection

@section('additional_nav_contents')
@endsection


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <input type="hidden" id="courseId" value="{{$course['id']}}">
    <input type="hidden" id="assetPath" value="{{asset('')}}">
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#tab_content_details" id="details-tab" role="tab" data-toggle="tab" aria-expanded="true">
                                    Details
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#tab_content_participants" role="tab" id="participants-tab" data-toggle="tab" aria-expanded="false">
                                    Participants
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#tab_content_coursework" role="tab" id="coursework-tab" data-toggle="tab" aria-expanded="false">
                                    Coursework
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#tab_content_marks" role="tab" id="marks-tab" data-toggle="tab" aria-expanded="false">
                                    Marks Management
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div id="myTabContent" class="tab-content">

                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content_details" aria-labelledby="details-tab">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6" >
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_content" style="display: block;">
                                            <form method="" action="">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="courseName">Name*:</label>
                                                        <input type="text" id="courseName" class="form-control" name="courseName" disabled value="{{$course['name']}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="courseCode">Course Code*:</label>
                                                        <input type="text" id="courseCode" class="form-control" name="courseCode" disabled value="{{$course['code']}}">
                                                    </div>

                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="courseType">Course Type* :</label>
                                                        <select id="courseType" class="form-control" disabled>
                                                            @foreach(\App\CourseType::all() as $type)
                                                                <option {{$type->name==$course['type']?'selected':''}}>{{$type->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="courseTerm">Term:</label>
                                                        <input type="text" id="courseTerm" class="form-control" name="courseTerm" required="" value="{{$course['term']}}" disabled>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="courseStartDate">Start Date*:</label>
                                                        <input type="date" id="courseStartDate" class="date-picker form-control" value="{{$course['start_date']}}" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="courseEndDate">End Date:</label>
                                                        <input type="date" id="courseEndDate" class="date-picker form-control" value="{{$course['end_date']}}" disabled="">
                                                    </div>
                                                </div>
                                                <br/>
                                                <label for="courseDescription">Description:</label>
                                                <textarea id="courseDescription" class="form-control" rows="3" disabled="">{{$course['description']}}</textarea>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab_content_participants" aria-labelledby="participants-tab">

                            <div class="row">
                                <div class="col-md-12">
                                    {{--Search--}}
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Search</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content collapse" style="display: block;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="searchStudentNumber">Student/Staff #:</label>
                                                    <input type="text" class="form-control" id="participantsStudentNumber" placeholder="student/staff #">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="searchStudentNumber">Email Address:</label>
                                                    <input type="text" class="form-control" id="participantsEmail" placeholder="Email">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumber">Results Per Page:</label>
                                                    <select id="participantsPageLimit" class="form-control">
                                                        <option>30</option>
                                                        <option>Max</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumber">Page #:</label>
                                                    <select id="participantsPageOffset" class="form-control">
                                                        @for($i = 1; $i < ($course['students_count']/30)+2; $i++)
                                                            <option {{$i == 1?'selected':''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label> </label><br>
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="searchParticipantsButton">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-search"></i>
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row col-md-12">
                                                <div class="x_panel" style="height: auto; display: none"  id="searchParticipantsPanel">
                                                    <div class="x_title" id="searchParticipantsHeader" >
                                                        <h2>Results</h2>
                                                        <ul class="nav navbar-right panel_toolbox">
                                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                            </li>
                                                        </ul>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" style="display: block;" id="searchParticipantsResults">
                                                        <button class="btn btn-dark btn-round spinnerNeeded" type="button" disabled>
                                                            Approve Selected
                                                        </button>
                                                        <table class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                            <tr class="headings">
                                                                <th>
                                                                    <input type="checkbox" id="checkAllSearchParticipantsResults">
                                                                </th>
                                                                <th class="column-title">First Name</th>
                                                                <th class="column-title">Last Name</th>
                                                                <th class="column-title">Student #</th>
                                                                <th class="column-title">Employee #</th>
                                                                <th class="column-title">Email</th>
                                                                <th class="column-title">Role</th>
                                                                <th class="column-title">Status</th>
                                                                <th class="column-title">Approved?</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="searchParticipantsResultsBody">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    {{--List and export--}}
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Participants List</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" style="display: block;">
                                            <!-- start accordion -->
                                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel">
                                                    <a class="panel-heading collapsed" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                                                        <h4 class="panel-title">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    Course Convenors
                                                                </div>
                                                                <div class="col-md-7" style="text-align: right">
                                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                </div>
                                                            </div>
                                                        </h4>
                                                    </a>
                                                    <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1" aria-expanded="false" style="height: 0px;">
                                                        <div class="panel-body">
                                                            <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshConvenorsList">
                                                                <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                Refresh
                                                            </button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Grant Access To Selected</button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Deny Access To Selected</button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Approve Selected</button>
                                                            <table class="table table-striped jambo_table bulk_action">
                                                                <thead>
                                                                <tr class="headings">
                                                                    <th>
                                                                        <input type="checkbox" class="checkbox" id="checkAllConvenorsList">
                                                                    </th>
                                                                    <th class="column-title">First Name</th>
                                                                    <th class="column-title">Last Name</th>
                                                                    <th class="column-title">Staff #</th>
                                                                    <th class="column-title">Employee #</th>
                                                                    <th class="column-title">Email</th>
                                                                    <th class="column-title">Access</th>
                                                                    <th class="column-title">Approved?</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody id="convenorsListResultsBody">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel">
                                                    <a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                                                        <h4 class="panel-title">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    Lecturers
                                                                </div>
                                                                <div class="col-md-7" style="text-align: right">
                                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                </div>
                                                            </div>
                                                        </h4>
                                                    </a>
                                                    <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo1" aria-expanded="false" style="height: 0px;">
                                                        <div class="panel-body">
                                                            <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshLecturersList">
                                                                <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                Refresh
                                                            </button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Grant Access To Selected</button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Deny Access To Selected</button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Approve Selected</button>
                                                            <table class="table table-striped jambo_table bulk_action">
                                                                <thead>
                                                                <tr class="headings">
                                                                    <th>
                                                                        <input type="checkbox" class="checkbox" id="checkAllLecturersList">
                                                                    </th>
                                                                    <th class="column-title">First Name</th>
                                                                    <th class="column-title">Last Name</th>
                                                                    <th class="column-title">Staff #</th>
                                                                    <th class="column-title">Employee #</th>
                                                                    <th class="column-title">Email</th>
                                                                    <th class="column-title">Access</th>
                                                                    <th class="column-title">Approved?</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody id="lecturersListResultsBody">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel">
                                                    <a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                                                        <h4 class="panel-title">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    Students
                                                                </div>
                                                                <div class="col-md-7" style="text-align: right">
                                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                </div>
                                                            </div>
                                                        </h4>
                                                    </a>
                                                    <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree1" aria-expanded="false" style="height: 0px;">
                                                        <div class="panel-body">
                                                            <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshStudentsList">
                                                                <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                Refresh
                                                            </button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Approve Selected</button>
                                                            <table class="table table-striped jambo_table bulk_action">
                                                                <thead>
                                                                <tr class="headings">
                                                                    <th>
                                                                        <input type="checkbox" class="checkbox" id="checkAllStudentsList">
                                                                    </th>
                                                                    <th class="column-title">First Name</th>
                                                                    <th class="column-title">Last Name</th>
                                                                    <th class="column-title">Student #</th>
                                                                    <th class="column-title">Employee #</th>
                                                                    <th class="column-title">Email</th>
                                                                    <th class="column-title">Status</th>
                                                                    <th class="column-title">Approved?</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody id="studentsListResultsBody">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel">
                                                    <a class="panel-heading collapsed" role="tab" id="headingFour1" data-toggle="collapse" data-parent="#accordion" href="#collapseFour1" aria-expanded="false" aria-controls="collapseFour1">
                                                        <h4 class="panel-title">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    Teaching Assistants
                                                                </div>
                                                                <div class="col-md-7" style="text-align: right">
                                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                </div>
                                                            </div>
                                                        </h4>
                                                    </a>
                                                    <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour1" aria-expanded="false" style="height: 0px;">
                                                        <div class="panel-body">
                                                            <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshTAsList">
                                                                <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                Refresh
                                                            </button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Grant Access To Selected</button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Deny Access To Selected</button>
                                                            <button class="btn btn-dark btn-round" type="button" disabled>
                                                                <i class="spinnerPlaceholder"></i>
                                                                Approve Selected</button>
                                                            <table class="table table-striped jambo_table bulk_action">
                                                                <thead>
                                                                <tr class="headings">
                                                                    <th>
                                                                        <input type="checkbox" class="checkbox" id="checkAllTAsList">
                                                                    </th>
                                                                    <th class="column-title">First Name</th>
                                                                    <th class="column-title">Last Name</th>
                                                                    <th class="column-title">Student #</th>
                                                                    <th class="column-title">Employee #</th>
                                                                    <th class="column-title">Email</th>
                                                                    <th class="column-title">Access</th>
                                                                    <th class="column-title">Approved?</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody id="TAsListResultsBody">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab_content_coursework" aria-labelledby="profile-tab">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Coursework</h2>
                                            <ul class="nav navbar-right panel_toolbox">

                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" style="display: none;">
                                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                @php($count = 0)
                                                @foreach($course['courseworks'] as $coursework)
                                                    @php($count++)
                                                    <div class="panel">
                                                        <div class="row panel-heading collapsed">
                                                            <div class="col-md-12">
                                                                <a class="" role="tab" id="headingTwo{{$count.''.$count}}" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo{{$count.''.$count}}" aria-expanded="false" aria-controls="collapseTwo{{$count.''.$count}}">
                                                                    <h4 class="panel-title">
                                                                        <h4 class="panel-title">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td>
                                                                                                {{$count.'. '}}
                                                                                            </td>
                                                                                            <td>
                                                                                                <input type="text" class="form-control" value="{{$coursework['name']}}" disabled>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-md-7" style="text-align: right">
                                                                                    <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                                </div>
                                                                            </div>
                                                                        </h4>
                                                                    </h4>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div id="collapseTwo{{$count.''.$count}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$count.''.$count}}" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <table class="table table-striped jambo_table bulk_action">
                                                                    <tbody>
                                                                    <tr class="even pointer">
                                                                        <td>Type:</td>
                                                                        <td>
                                                                            <select name="" id="" data-type="type" class="form-control" disabled>
                                                                                @foreach(\App\CourseworkType::all() as $courseworkType)
                                                                                    <option {{$courseworkType->name==$coursework['type']?'selected':''}}>{{$courseworkType->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td></td><td></td><td></td>
                                                                        <td>Release Date:</td>
                                                                        <td><input type="date" data-type="releasedate" class="calendar-date form-control" disabled value="{{$coursework['display_to_students']}}"></td>
                                                                    </tr>
                                                                    <tr class="even pointer">
                                                                        <td>Weighting in Class Record:</td>
                                                                        <td><input type="number" min="-1" max="100" class="form-control" disabled value="{{$coursework['weighting_in_classrecord']}}"></td>
                                                                        <td></td><td></td><td></td>
                                                                        <td>Weighting in Year Mark:</td>
                                                                        <td><input type="number" min="-1" max="100" class="form-control" disabled value="{{$coursework['weighting_in_yearmark']}}"></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <table class="table table-striped jambo_table">
                                                                            <thead>
                                                                            <tr class="headings">
                                                                                <th class="column-title">Subcoursework</th>
                                                                                <th class="column-title">Settings</th>
                                                                                <th class="column-title">Sections</th>
                                                                                {{--<th class="column-title">Delete</th>--}}
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @php($subcount = 0)
                                                                            @foreach($coursework['subcourseworks'] as $subcoursework)
                                                                                @php($subcount++)
                                                                                <tr class="even pointer">
                                                                                    <td>
                                                                                        <h4><input type="text" class="" disabled value="{{$subcoursework['name']}}"></h4>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="panel">
                                                                                            <a class="panel-heading collapsed" role="tab" id="headingTwo{{$count.''.$count.$subcoursework['id']}}" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo{{$count.''.$count.$subcoursework['id']}}" aria-expanded="false" aria-controls="collapseTwo{{$count.''.$count.$subcoursework['id']}}">
                                                                                                <h4 class="panel-title">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-5">
                                                                                                            Settings
                                                                                                        </div>
                                                                                                        <div class="col-md-7" style="text-align: right">
                                                                                                            <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </h4>
                                                                                            </a>
                                                                                            <div id="collapseTwo{{$count.''.$count.$subcoursework['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$count.''.$count.$subcoursework['id']}}" aria-expanded="false" style="height: 0px;">
                                                                                                <div class="panel-body">
                                                                                                    <table class="table table-striped jambo_table bulk_action">
                                                                                                        <tbody>
                                                                                                        <tr class="even pointer">
                                                                                                            <td>Release Date:</td>
                                                                                                            <td><input type="date" style="width:125px" disabled class="calendar-date form-control" value="{{$subcoursework['display_to_students']}}"></td>
                                                                                                        </tr>
                                                                                                        <tr class="even pointer">
                                                                                                            <td>Display Percentage:</td>
                                                                                                            <td><input type="checkbox" disabled data-type="displaypercentage" {{$subcoursework['display_percentage']==1?'checked':''}}  style="width:125px" ></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>Display Marks:</td>
                                                                                                            <td><input type="checkbox" disabled {{$subcoursework['display_marks']==1?'checked':''}} style="width:125px" ></td>
                                                                                                        </tr>
                                                                                                        <tr class="even pointer">
                                                                                                            <td>Max Marks:</td>
                                                                                                            <td><input type="number" min="0" max="100" class="form-control" disabled="" style="width:125px" value="{{$subcoursework['max_marks']}}"></td>
                                                                                                        </tr>
                                                                                                        <tr class="even pointer">
                                                                                                            <td>Weighting in Coursework:</td>
                                                                                                            <td><input type="number" min="-1" max="100" class="form-control" disabled style="width:125px" value="{{$subcoursework['weighting']}}"></td>
                                                                                                        </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="panel">
                                                                                            <a class="panel-heading collapsed" role="tab" id="headingTwo{{$count.''.$count.$subcoursework['id'].$subcount}}" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo{{$count.''.$count.$subcoursework['id'].$subcount}}" aria-expanded="false" aria-controls="collapseTwo{{$count.''.$count.$subcoursework['id'].$subcount}}">
                                                                                                <h4 class="panel-title">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-5">
                                                                                                            Sections
                                                                                                        </div>
                                                                                                        <div class="col-md-7" style="text-align: right">
                                                                                                            <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </h4>
                                                                                            </a>
                                                                                            <div id="collapseTwo{{$count.''.$count.$subcoursework['id'].$subcount}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$count.''.$count.$subcoursework['id'].$subcount}}" aria-expanded="false" style="height: 0px;">
                                                                                                <div class="panel-body">
                                                                                                    @foreach($subcoursework['sections'] as $section)
                                                                                                        <table class="table table-striped jambo_table bulk_action">
                                                                                                            <tbody>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Name:</td>
                                                                                                                <td><input type="text" value="{{$section['name']}}" class="form-control" disabled style="width:125px" ></td>
                                                                                                                <td></td>
                                                                                                                <td>Max Marks:</td>
                                                                                                                <td><input type="number" min="0" max="100" value="{{$section['max_marks']}}" class="form-control" disabled style="width:75px" ></td>
                                                                                                            </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Subminimum</h2>
                                            <ul class="nav navbar-right panel_toolbox">

                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" style="display: none;">
                                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                                @php($count = 0)
                                                @foreach($course['subminimums'] as $subminimum)
                                                    @php($count++)
                                                    <div class="panel">
                                                        <div class="row panel-heading collapsed">
                                                            <div class="col-md-12">
                                                                <a role="tab" id="{{$count.''.$count}}headingTwo{{$count.''.$count}}" data-toggle="collapse" data-parent="#accordion" href="#{{$count.''.$count}}collapseTwo{{$count.''.$count}}" aria-expanded="false" aria-controls="{{$count.''.$count}}collapseTwo{{$count.''.$count}}">
                                                                    <h4 class="panel-title">
                                                                        <div class="row">
                                                                            <div class="col-md-5">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td>
                                                                                            {{$count.'. '}}
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="text" class="form-control {{str_replace(' ', '', $subminimum['name'])}}" data-type="name" value="{{$subminimum['name']}}" disabled>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-md-7" style="text-align: right">
                                                                                <i class="fa fa-angle-double-down" style="text-align: right"></i>
                                                                            </div>
                                                                        </div>
                                                                    </h4>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div id="{{$count.''.$count}}collapseTwo{{$count.''.$count}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$count.''.$count}}headingTwo{{$count.''.$count}}" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <table class="table table-striped jambo_table bulk_action">
                                                                    <tbody>
                                                                    <tr class="even pointer">
                                                                        <td>Type:</td>
                                                                        <td>
                                                                            <select name="" id="" class="form-control" disabled>
                                                                                <option value="1" {{$subminimum['for_dp'] == 1?'selected':''}}>DP</option>
                                                                                <option value="0" {{$subminimum['for_dp'] == 1?'':'selected'}}>Final Grade</option>
                                                                            </select>
                                                                        </td>
                                                                        <td></td><td></td><td></td>
                                                                        <td>Threshold:</td>
                                                                        <td><input type="number" min="-1" max="100" class="form-control" value="{{$subminimum['threshold']}}" disabled></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <table class="table table-striped jambo_table">
                                                                            <thead>
                                                                            <tr class="headings">
                                                                                <th class="column-title">Coursework</th>
                                                                                <th class="column-title">Subcoursework</th>
                                                                                <th class="column-title">Weighting</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @php($subcount = 0)
                                                                            @foreach($subminimum['rows'] as $row)
                                                                                <tr class="even pointer">
                                                                                    <td>
                                                                                        <select data-type="coursework" class="form-control" disabled>
                                                                                            @foreach($course['courseworks'] as $coursework)
                                                                                                <option value="{{$coursework['id']}}" {{$row['coursework']==$coursework['name']?'selected':''}}>{{$coursework['name']}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select class="form-control" disabled>
                                                                                            <option></option>
                                                                                            @foreach($course['courseworks'] as $coursework)
                                                                                                @foreach($coursework['subcourseworks'] as $subcoursework)
                                                                                                    <option value="{{$subcoursework['id']}}" {{$row['subcoursework']==$subcoursework['name']?'selected':''}}>{{$subcoursework['name']}}</option>
                                                                                                @endforeach
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" min="-1" max="100" class="form-control" value="{{$row['weighting']}}" disabled>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tab_content_marks" aria-labelledby="profile-tab">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Classmark And Yearmark View</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content collapse" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="searchStudentNumber">Student/Employee #:</label>
                                                    <input id="searchStudentNumber" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="searchStudentNumber">Results Per Page:</label>
                                                    <select id="searchResultsPageLimit" class="form-control">
                                                        <option>30</option>
                                                        <option>Max</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="searchStudentNumber">Page #:</label>
                                                    <select id="searchResultsPageOffset" class="form-control">
                                                        @for($i = 1; $i < ($course['students_count']/30)+1; $i++)
                                                            <option {{$i == 1?'selected':''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">&nbsp;</label><br>
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="searchMarkButton" >
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-search"></i>
                                                        Search
                                                    </button>
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="exportMarkButton">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-download"></i>
                                                        Export
                                                    </button>
                                                </div>
                                                <hr>
                                            </div>
                                            <br>
                                            <div class="div" id="searchResultsBody" hidden>
                                                <h4>Results:</h4>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                            <tr class="headings">
                                                                <th class="column-title">Student #</th>
                                                                <th class="column-title">Employee #</th>
                                                                <th class="column-title">Class Mark</th>
                                                                <th class="column-title">Year Mark</th>
                                                                <th class="column-title">DP</th>
                                                                <th class="column-title">Final Grade</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody id="searchMarkResultsBody"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Coursework Marks View</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content collapse" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="searchStudentNumberCoursework">Coursework*:</label>
                                                    <select id="courseworkSearchDropdown" class="form-control">
                                                        @foreach($course['courseworks'] as $cwrk)
                                                            <option value="{{$cwrk['id']}}">{{$cwrk['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumberCoursework">Student/Employee #:</label>
                                                    <input id="courseworkSearchStudentNumber" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumber">Results Per Page:</label>
                                                    <select id="courseworkSearchPageLimit" class="form-control">
                                                        <option>30</option>
                                                        <option>Max</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumber">Page #:</label>
                                                    <select id="courseworkSearchPageOffset" class="form-control">
                                                        @for($i = 1; $i < ($course['students_count']/30)+1; $i++)
                                                            <option {{$i == 1?'selected':''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">&nbsp;</label><br>
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="searchCourseworkMarkButton" >
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-search"></i>
                                                        Search
                                                    </button>
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="exportCourseworkMarkButton">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-download"></i>
                                                        Export
                                                    </button>
                                                </div>
                                                <hr>
                                            </div>
                                            <br>
                                            <div class="div" id="searchResultsBody" hidden>
                                                <h4>Results:</h4>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table id="courseworkSearchResultsTable" class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                            <tr class="headings">
                                                                <th class="column-title">Student #</th>
                                                                <th class="column-title">Employee #</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody id="courseworkSearchResultsBody"></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Subcoursework Marks View</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="x_content collapse" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumberCoursework">Coursework*:</label>
                                                    <select id="subcourseworkCourseworkDropdown" class="form-control">
                                                        <option value="-1"></option>
                                                        @foreach($course['courseworks'] as $cwrk)
                                                            <option value="{{$cwrk['id']}}">{{$cwrk['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumberCoursework">Subcoursework*:</label>
                                                    <select id="subcourseworkSubcourseworkDropdown" class="form-control">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumberCoursework">Student/Employee #:</label>
                                                    <input id="subcourseworkSearchStudentNumber" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="searchStudentNumber">Results Per Page:</label>
                                                    <select id="subourseworkSearchPageLimit" class="form-control">
                                                        <option>30</option>
                                                        <option>Max</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="searchStudentNumber">Page #:</label>
                                                    <select id="subcourseworkSearchPageOffset" class="form-control">
                                                        @for($i = 1; $i < ($course['students_count']/30)+1; $i++)
                                                            <option {{$i == 1?'selected':''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">&nbsp;</label><br>
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" data-valid="12345" id="searchSubcourseworkMarkButton" >
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-search"></i>
                                                        Search
                                                    </button>
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="exportSubcourseworkMarkButton">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-download"></i>
                                                        Export
                                                    </button>
                                                </div>
                                                <hr>
                                            </div>
                                            <br>
                                            <div class="div" id="subcourseworkSearchResultsBody" hidden>
                                                <h4>Results:</h4>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table id="subcourseworkSearchResultsTable" class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                            <tr class="headings">
                                                                <th class="column-title">Student #</th>
                                                                <th class="column-title">Employee #</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody id="courseworkSearchResultsBody">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel" style="height: auto;">
                                        <div class="x_title">
                                            <h2>Quick Export</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content collapse" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-4" style="text-align: center">
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="exportDPListButton">
                                                        <i class="spinnerPlaceholder"></i>
                                                        DP List</button>
                                                </div>
                                                <div class="col-md-4" style="text-align: center">
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="exportStudentsListButton">
                                                        <i class="spinnerPlaceholder"></i>
                                                        Students' List</button>
                                                </div>
                                                <div class="col-md-4" style="text-align: center">
                                                    <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="exportFinalGradeButton">
                                                        <i class="spinnerPlaceholder"></i>
                                                        Final Grades</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{asset('coursedetails.js')}}"></script>
@endsection