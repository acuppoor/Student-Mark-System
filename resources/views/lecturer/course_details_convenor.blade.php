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
    <li class="">
        <a>
            <button class="btn btn-dark btn-round" data-toggle="modal" data-target="#subminimumModal">
                <span class="glyphicon glyphicon-plus"></span>
                New Subminimum
            </button>
        </a>
    </li>
    <input type="hidden" id="gradeTypes">

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="subminimumModal" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">New Subminimum</h4>
                </div>
                <form method="" action="">
                    <div class="modal-body">

                        {{csrf_field()}}
                        <label for="subminimumName">Name*:</label>
                        <input type="text" id="subminimumName" class="form-control" name="subminimumName" required="">
                        <br/>
                        <label for="subminimumThreshold">Threshold*:</label>
                        <input type="number" min="0" max="100" id="subminimumThreshold" class="form-control" name="subminimumThreshold" required="">
                        <br/>
                        <label for="subminimumType">Type*:</label>
                        <select id="subminimumType" class="form-control">
                            <option value="1">DP</option>
                            <option value="0">Final Grade</option>
                        </select>
                        <br/>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round spinnerNeeded" id="createSubminimumButton" type="button">
                            <i class="spinnerPlaceholder"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <li class="">
        <a>
            <button class="btn btn-dark btn-round" data-toggle="modal" data-target="#courseworkModal">
                <span class="glyphicon glyphicon-plus"></span>
                New Coursework
            </button>
        </a>
    </li>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="courseworkModal" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">New Coursework</h4>
                </div>
                <form method="" action="">
                    <div class="modal-body">

                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="courseworkName">Name*:</label>
                                    <input type="text" id="courseworkName" class="form-control" name="courseworkName" required="">
                                </div>
                                <div class="col-md-6">
                                    <label for="courseworkType">Type*:</label>
                                        <select class="form-control" id="courseworkType">
                                            @foreach(\App\CourseworkType::all() as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="courseEndDate">Weighting in Class Record*:</label>
                                    <input type="number" min="-1" max="100" id="courseworkClassWeighting" class="form-control" name="courseworkClassWeighting" required="">
                                </div>
                                <div class="col-md-4">
                                    <label for="courseEndDate">Weighting in Year Record*:</label>
                                    <input type="number" min="-1" max="100" id="courseworkYearWeighting" class="form-control" name="courseworkYearWeighting" required="">
                                </div>
                                <div class="col-md-4">
                                    <label for="courseworkReleaseDate">Release Date*:</label>
                                    <input type="date" id="courseworkReleaseDate" class="date-picker form-control" value="{{date('Y').'-'.date('m').'-'.date('d')}}">
                                </div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round spinnerNeeded" id="createCourseworkButton" type="button">
                            <i class="spinnerPlaceholder"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="subcourseworkModal" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">New Subcoursework</h4>
                </div>
                <form method="" action="">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="row">
                            <input type="hidden" id="modalCourseworkId">
                            <div class="col-md-6">
                                <label for="subcourseworkName">Name*:</label>
                                <input type="text" id="subcourseworkName" class="form-control" name="subcourseworkName" required="">
                            </div>

                            <div class="col-md-6">
                                <label for="subcourseworkReleaseDate">Release Date*:</label>
                                <input type="date" id="subcourseworkReleaseDate" class="date-picker form-control" value="{{date('Y').'-'.date('m').'-'.date('d')}}">
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="subcourseworkMaxMarks">Max Marks*:</label>
                                <input type="number" min="0" max="100" id="subcourseworkMaxMarks" class="form-control" name="subcourseworkMaxMarks" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="subcourseworkWeighting">Weighting in Coursework:</label>
                                <input type="number" min="-1" max="100" id="subcourseworkWeighting" class="form-control" name="subcourseworkWeighting" required="">
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="subcourseworkDisplayMarks">Display Marks:</label>
                                <input type="checkbox" id="subcourseworkDisplayMarks" checked>
                            </div>
                            <div class="col-md-6">
                                <label for="subcourseworkDisplayPercentage">Display Percentage:</label>
                                <input type="checkbox" id="subcourseworkDisplayPercentage">
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round spinnerNeeded" id="createSubcourseworkButtonModal" type="button">
                            <i class="spinnerPlaceholder"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="sectionModal" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">New Section</h4>
                </div>
                <form method="" action="">
                    <input type="hidden" id="subcourseworkId">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <label for="sectionName">Name*:</label>
                        <input type="text" id="sectionName" class="form-control" name="sectionName" required="">
                        <br>
                        <label for="sectionMaxMarks">Max Marks*:</label>
                        <input type="number" min="0" max="100" id="sectionMaxMarks" class="form-control" name="sectionMaxMarks" required="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round spinnerNeeded" id="createSectionButtonModal" type="button">
                            <i class="spinnerPlaceholder"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="newRowModal" style="display: none;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">New Subminimum Row</h4>
                </div>
                <form method="" action="">
                    <input type="hidden" id="subminimumId">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <label for="courseworkSubminimumDropdown">Coursework*:</label>
                        <select name="" id="courseworkSubminimumDropdown" class="form-control">
                            <option></option>
                            @foreach(\App\Coursework::all() as $cwrk)
                                <option value="{{$cwrk->id}}">{{$cwrk->name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <label for="subcourseworkSubminimumDropdown">Subcoursework:</label>
                        <select name="" id="subcourseworkSubminimumDropdown" class="form-control">
                            <option></option>
                        </select>
                        <br>
                        <label for="subminimumRowWeighting">Weighting:</label>
                        <input type="number" min="0" max="100" id="subminimumRowWeighting" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round spinnerNeeded" id="createSubminimumButtonModal" type="button">
                            <i class="spinnerPlaceholder"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <input type="hidden" id="courseId" value="{{$course['id']}}">
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
                            <li role="presentation" class="">
                                <a href="#tab_content_export" role="tab" id="export-tab" data-toggle="tab" aria-expanded="false">
                                    Export
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
                                                            <input type="text" id="courseName" class="form-control" name="courseName" required="" value="{{$course['name']}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="courseCode">Course Code*:</label>
                                                            <input type="text" id="courseCode" class="form-control" name="courseCode" required="" value="{{$course['code']}}">
                                                        </div>

                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="courseType">Course Type* :</label>
                                                            <select id="courseType" class="form-control" required="">
                                                                @foreach(\App\CourseType::all() as $type)
                                                                    <option {{$type->name==$course['type']?'selected':''}}>{{$type->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="courseTerm">Term:</label>
                                                            <input type="text" id="courseTerm" class="form-control" name="courseTerm" required="" value="{{$course['term']}}">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="courseStartDate">Start Date*:</label>
                                                            <input type="date" id="courseStartDate" class="date-picker form-control" value="{{$course['start_date']}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="courseEndDate">End Date:</label>
                                                            <input type="date" id="courseEndDate" class="date-picker form-control" value="{{$course['end_date']}}">
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <label for="courseDescription">Description:</label>
                                                    <textarea id="courseDescription" class="form-control" rows="3">{{$course['description']}}</textarea>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-4" style="text-align: center">
                                                            <button id="updateInfoButton" class="btn btn-round btn-dark spinnerNeeded" type="button">
                                                                <i id="updateInfoSpinner" class="spinnerPlaceholder"></i>
                                                                <i id="updateInfoButtonIcon" class="fa fa-save"></i>
                                                                Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tab_content_participants" aria-labelledby="participants-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{--Add Participants--}}
                                        <div class="x_panel" style="height: auto;">
                                            <div class="x_title">
                                                <h2>Add Participants</h2>
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
                                                        <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                            <h4 class="panel-title">Course Convenor</h4>
                                                        </a>
                                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <form action="" method="#">
{{--                                                                    {{csrf_field()}}--}}
                                                                    <div class="col-md-6">
                                                                        <input id="convenorEmailAddress" type="email" class="form-control" placeholder="Email">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="invitationCheckbox">Invitation Email:</label>
                                                                        <input id="convenorInvitationCheckbox" type="checkbox" checked>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="addConvenorButton">
                                                                            <i class="spinnerPlaceholder"></i>
                                                                            <i class="fa fa-plus"></i>
                                                                            Add</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            <h4 class="panel-title">Lecturer</h4>
                                                        </a>
                                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <form>
                                                                    <div class="col-md-6">
                                                                        <input id="lecturerEmailAddress" type="email" class="form-control" placeholder="Email">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="invitationCheckbox">Invitation Email:</label>
                                                                        <input id="lecturerInvitationCheckbox" type="checkbox" checked>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="btn btn-dark btn-round spinnerNeeded" id="addLecturerButton" type="button">
                                                                            <i class="spinnerPlaceholder"></i>
                                                                            <i class="fa fa-plus"></i>
                                                                            Add
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            <h4 class="panel-title">Students</h4>
                                                        </a>
                                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <form action="/updatestudentslist" method="POST" enctype="multipart/form-data" id="studentListUpdateForm">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="courseId" value="{{$course['id']}}">
                                                                        <div class="col-md-8">
                                                                            <label for="studentFile">File:</label>
                                                                            <input type="file" name="file" id="studentsFile">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label>&nbsp;</label><br>
                                                                            <button class="btn btn-dark btn-round spinnerNeeded" id="addStudentFileButton" type="submit">
                                                                                <i class="spinnerPlaceholder"></i>
                                                                                <i class="fa fa-plus"></i>
                                                                                Add
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                            <h4 class="panel-title">Teaching Assistant</h4>
                                                        </a>
                                                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <form action="">
                                                                    <div class="col-md-6">
                                                                        <input id="taEmailAddress" type="email" class="form-control" placeholder="Email">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="taInvitationCheckbox">Invitation Email:</label>
                                                                        <input id="taInvitationCheckbox" type="checkbox" checked>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="addTAButton">
                                                                            <i class="spinnerPlaceholder"></i>
                                                                            <i class="fa fa-plus"></i>
                                                                            Add
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

                                                            <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="approveParticipantsButton">
                                                                <i class="spinnerPlaceholder"></i>
                                                                Approve Selected
                                                            </button>
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
                                                            <h4 class="panel-title">Course Convenors</h4>
                                                        </a>
                                                        <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshConvenorsList">
                                                                    <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                    Refresh
                                                                </button>
                                                                <button class="btn btn-dark btn-round convenorsAccessButton spinnerNeeded" type="button" data-access="1">
                                                                    <i class="spinnerPlaceholder"></i>
                                                                    Grant Access To Selected</button>
                                                                <button class="btn btn-dark btn-round convenorsAccessButton spinnerNeeded" type="button" data-access="0">
                                                                    <i class="spinnerPlaceholder"></i>
                                                                    Deny Access To Selected</button>
                                                                <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="approveConvenorsButton">
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
                                                            <h4 class="panel-title">Lecturers</h4>
                                                        </a>
                                                        <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshLecturersList">
                                                                    <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                    Refresh
                                                                </button>
                                                                <button class="btn btn-dark btn-round lecturersAccessButton spinnerNeeded" type="button" data-access="1">
                                                                    <i class="spinnerPlaceholder"></i>
                                                                    Grant Access To Selected</button>
                                                                <button class="btn btn-dark btn-round lecturersAccessButton spinnerNeeded" type="button" data-access="0">
                                                                    <i class="spinnerPlaceholder"></i>
                                                                    Deny Access To Selected</button>
                                                                <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="approveLecturersButton">
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
                                                            <h4 class="panel-title">Students</h4>
                                                        </a>
                                                        <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshStudentsList">
                                                                    <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                    Refresh
                                                                </button>
                                                                <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="approveStudentsButton">
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
                                                            <h4 class="panel-title">Teaching Assistants</h4>
                                                        </a>
                                                        <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <button type="button" class="btn btn-round btn-dark refreshSpin" id="refreshTAsList">
                                                                    <i class="glyphicon glyphicon-refresh" id="refreshPlaceholder"></i>
                                                                    Refresh
                                                                </button>
                                                                <button class="btn btn-dark btn-round TAsAccessButton spinnerNeeded" type="button" data-access="1">
                                                                    <i class="spinnerPlaceholder"></i>
                                                                    Grant Access To Selected</button>
                                                                <button class="btn btn-dark btn-round TAsAccessButton spinnerNeeded" type="button" data-access="0">
                                                                    <i class="spinnerPlaceholder"></i>
                                                                    Deny Access To Selected</button>
                                                                <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="approveTAsButton">
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
                                                                <div class="col-md-7">
                                                                    <a class="" role="tab" id="headingTwo{{$count.''.$count}}" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo{{$count.''.$count}}" aria-expanded="false" aria-controls="collapseTwo{{$count.''.$count}}">
                                                                        <h4 class="panel-title">
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        {{$count.'. '}}
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control {{str_replace(' ', '', $coursework['name'])}}" data-type="name" value="{{$coursework['name']}}">
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </h4>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-5" style="text-align: right">
                                                                    <button class="btn btn-dark btn-round createSubcourseworkButton" data-toggle="modal" type="button" data-target="#subcourseworkModal" data-courseworkid="{{$coursework['id']}}"><i class="fa fa-plus"></i> New Subcoursework</button>
                                                                    <button class="btn btn-dark btn-round spinnerNeeded saveCourseworkButton" data-courseworkname='{{$coursework['name']}}' data-courseworkid="{{$coursework['id']}}" type="button"><i class="spinnerPlaceholder"></i> <i class="fa fa-save"></i> Save</button>
                                                                    <button class="btn btn-dark btn-round deleteCourseworkButton spinnerNeeded" data-courseworkid="{{$coursework['id']}}" type="button">
                                                                        <i class="spinnerPlaceholder"></i>
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div id="collapseTwo{{$count.''.$count}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$count.''.$count}}" aria-expanded="false" style="height: 0px;">
                                                                <div class="panel-body">
                                                                    <table class="table table-striped jambo_table bulk_action">
                                                                        <tbody>
                                                                        <tr class="even pointer">
                                                                            <td>Type:</td>
                                                                            <td>
                                                                                <select name="" id="" data-type="type" class="form-control {{str_replace(' ', '', $coursework['name'])}}">
                                                                                    @foreach(\App\CourseworkType::all() as $courseworkType)
                                                                                        <option {{$courseworkType->name==$coursework['type']?'selected':''}}>{{$courseworkType->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td></td><td></td><td></td>
                                                                            <td>Release Date:</td>
                                                                            <td><input type="date" data-type="releasedate" class="calendar-date form-control {{str_replace(' ', '', $coursework['name'])}}" value="{{$coursework['display_to_students']}}"></td>
                                                                        </tr>
                                                                        <tr class="even pointer">
                                                                            <td>Weighting in Class Record:</td>
                                                                            <td><input type="number" min="-1" max="100" data-type="weightingclass" class="form-control {{str_replace(' ', '', $coursework['name'])}}" value="{{$coursework['weighting_in_classrecord']}}"></td>
                                                                            <td></td><td></td><td></td>
                                                                            <td>Weighting in Year Mark:</td>
                                                                            <td><input type="number" min="-1" max="100" data-type="weightingyear" class="form-control {{str_replace(' ', '', $coursework['name'])}}" value="{{$coursework['weighting_in_yearmark']}}"></td>
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
                                                                                            <h4><input type="text" data-type="name" class="{{str_replace(' ', '', $subcoursework['name'])}}" value="{{$subcoursework['name']}}"></h4>
                                                                                            <button class="btn btn-dark btn-round saveSubcoursework spinnerNeeded" type="button" data-subcourseworkname="{{str_replace(' ', '', $subcoursework['name'])}}" data-subcourseworkid="{{$subcoursework['id']}}"><i class="spinnerPlaceholder"></i> <i class="fa fa-save"></i> Save</button>
                                                                                            <button class="btn btn-dark btn-round deleteSubcoursework spinnerNeeded" type="button" data-subcourseworkid="{{$subcoursework['id']}}"><i class="spinnerPlaceholder"></i> <i class="fa fa-trash"></i> Delete</button>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="panel">
                                                                                                <a class="panel-heading collapsed" role="tab" id="headingTwo{{$count.''.$count.$subcoursework['id']}}" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo{{$count.''.$count.$subcoursework['id']}}" aria-expanded="false" aria-controls="collapseTwo{{$count.''.$count.$subcoursework['id']}}">
                                                                                                    <h4 class="panel-title">Settings</h4>
                                                                                                </a>
                                                                                                <div id="collapseTwo{{$count.''.$count.$subcoursework['id']}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$count.''.$count.$subcoursework['id']}}" aria-expanded="false" style="height: 0px;">
                                                                                                    <div class="panel-body">
                                                                                                        <table class="table table-striped jambo_table bulk_action">
                                                                                                            <tbody>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Release Date:</td>
                                                                                                                <td><input type="date" class="{{str_replace(' ', '', $subcoursework['name'])}}" data-type="releasedate" style="width:125px"  class="calendar-date form-control" value="{{$subcoursework['display_to_students']}}"></td>
                                                                                                            </tr>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Display Percentage:</td>
                                                                                                                <td><input type="checkbox" class="{{str_replace(' ', '', $subcoursework['name'])}}" data-type="displaypercentage" {{$subcoursework['display_percentage']==1?'checked':''}}  style="width:125px" ></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td>Display Marks:</td>
                                                                                                                <td><input type="checkbox" class="{{str_replace(' ', '', $subcoursework['name'])}}" data-type="displaymarks" {{$subcoursework['display_marks']==1?'checked':''}}  style="width:125px" ></td>
                                                                                                            </tr>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Max Marks:</td>
                                                                                                                <td><input type="number" min="0" max="100" class="form-control {{str_replace(' ', '', $subcoursework['name'])}}" data-type="maxmarks" style="width:125px" value="{{$subcoursework['max_marks']}}"></td>
                                                                                                            </tr>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Weighting in Coursework:</td>
                                                                                                                <td><input type="number" min="-1" max="100" class="form-control {{str_replace(' ', '', $subcoursework['name'])}}" data-type="weightingcourse" style="width:125px" value="{{$subcoursework['weighting']}}"></td>
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
                                                                                                    <h4 class="panel-title">Sections</h4>
                                                                                                </a>
                                                                                                <div id="collapseTwo{{$count.''.$count.$subcoursework['id'].$subcount}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$count.''.$count.$subcoursework['id'].$subcount}}" aria-expanded="false" style="height: 0px;">
                                                                                                    <div class="panel-body">
                                                                                                        @foreach($subcoursework['sections'] as $section)
                                                                                                            <table class="table table-striped jambo_table bulk_action">
                                                                                                                <tbody>
                                                                                                                <tr class="even pointer">
                                                                                                                    <td>Name:</td>
                                                                                                                    <td><input type="text" data-type="name" value="{{$section['name']}}" class="{{str_replace(' ','', $section['name'])}} form-control" style="width:125px" ></td>
                                                                                                                    <td></td>
                                                                                                                    <td>Max Marks:</td>
                                                                                                                    <td><input type="number" min="-1" max="100" data-type="maxmarks" value="{{$section['max_marks']}}" class="{{str_replace(' ','', $section['name'])}} form-control"  style="width:75px" ></td>
                                                                                                                    <td>
                                                                                                                        <button class="btn btn-dark btn-round saveSectionButton spinnerNeeded" data-sectionid="{{$section['id']}}" type="button" data-sectionname="{{str_replace(' ','', $section['name'])}}"><i class="spinnerPlaceholder"></i> <i class="fa fa-save"></i></button>
                                                                                                                        <button class="btn btn-dark btn-round deleteSection spinnerNeeded" data-sectionid="{{$section['id']}}" type="button"><i class="spinnerPlaceholder"></i> <i class="fa fa-trash"></i></button>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        @endforeach
                                                                                                        <button class="btn btn-dark btn-round newSectionButton" type="button" data-target="#sectionModal" data-toggle="modal" data-subcourseworkid="{{$subcoursework['id']}}"><i class="fa fa-plus"></i> New Section</button>
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
                                                                <div class="col-md-8">
                                                                    <a role="tab" id="{{$count.''.$count}}headingTwo{{$count.''.$count}}" data-toggle="collapse" data-parent="#accordion" href="#{{$count.''.$count}}collapseTwo{{$count.''.$count}}" aria-expanded="false" aria-controls="{{$count.''.$count}}collapseTwo{{$count.''.$count}}">
                                                                        <h4 class="panel-title">
                                                                            <table>
                                                                                <tr>
                                                                                    <td>
                                                                                        {{$count.'. '}}
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control {{str_replace(' ', '', $subminimum['name'])}}" data-type="name" value="{{$subminimum['name']}}">
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </h4>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-4" style="text-align: right">
                                                                    <button class="btn btn-dark btn-round" data-subminimumid="{{$subminimum['id']}}" data-target="#newRowModal" id="newRowButton" data-toggle="modal"><i class="fa fa-plus"></i> New Row</button>
                                                                    <button class="btn btn-dark btn-round saveSubminimumButton spinnerNeeded" data-subminimumid="{{$subminimum['id']}}" data-subminimumname="{{str_replace(' ', '', $subminimum['name'])}}" type="button"><i class="spinnerPlaceholder"></i> <i class="fa fa-save"></i> Save</button>
                                                                    <button class="btn btn-dark btn-round deleteSubminimumButton spinnerNeeded" type="button" data-subminimumid="{{$subminimum['id']}}"><i class="spinnerPlaceholder"></i> <i class="fa fa-trash"></i> Delete</button>
                                                                </div>
                                                            </div>

                                                            <div id="{{$count.''.$count}}collapseTwo{{$count.''.$count}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$count.''.$count}}headingTwo{{$count.''.$count}}" aria-expanded="false" style="height: 0px;">
                                                                <div class="panel-body">
                                                                    <table class="table table-striped jambo_table bulk_action">
                                                                        <tbody>
                                                                        <tr class="even pointer">
                                                                            <td>Type:</td>
                                                                            <td>
                                                                                <select name="" id="" class="form-control {{str_replace(' ', '', $subminimum['name'])}}" data-type="type">
                                                                                    <option value="1" {{$subminimum['for_dp'] == 1?'selected':''}}>DP</option>
                                                                                    <option value="0" {{$subminimum['for_dp'] == 1?'':'selected'}}>Final Grade</option>
                                                                                </select>
                                                                            </td>
                                                                            <td></td><td></td><td></td>
                                                                            <td>Threshold:</td>
                                                                            <td><input type="number" min="-1" max="100" class="form-control {{str_replace(' ', '', $subminimum['name'])}}" data-type="threshold" value="{{$subminimum['threshold']}}"></td>
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
                                                                                    <th class="column-title"></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @php($subcount = 0)
                                                                                @foreach($subminimum['rows'] as $row)
                                                                                    <tr class="even pointer">
                                                                                        <td>
                                                                                            <select data-type="coursework" class="form-control {{str_replace(' ', '', $row['coursework']).''.$row['id']}}">
                                                                                                @foreach($course['courseworks'] as $coursework)
                                                                                                    <option value="{{$coursework['id']}}" {{$row['coursework']==$coursework['name']?'selected':''}}>{{$coursework['name']}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select data-type="subcoursework" class="form-control {{str_replace(' ', '', $row['coursework']).''.$row['id']}}">
                                                                                                <option></option>
                                                                                                @foreach($course['courseworks'] as $coursework)
                                                                                                    @foreach($coursework['subcourseworks'] as $subcoursework)
                                                                                                        <option value="{{$subcoursework['id']}}" {{$row['subcoursework']==$subcoursework['name']?'selected':''}}>{{$subcoursework['name']}}</option>
                                                                                                    @endforeach
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="number" min="-1" max="100" data-type="weighting" class="form-control {{str_replace(' ', '', $row['coursework']).''.$row['id']}}" value="{{$row['weighting']}}">
                                                                                        </td>
                                                                                        <td>
                                                                                            <button data-rowid="{{$row['id']}}" class="btn btn-dark btn-round spinnerNeeded saveRowButton" data-rowname="{{str_replace(' ', '', $row['coursework']).''.$row['id']}}" type="button"><i class="spinnerPlaceholder"></i> <i class="fa fa-save"></i></button>
                                                                                            <button data-rowid="{{$row['id']}}" class="btn btn-dark btn-round spinnerNeeded deleteRowButton" type="button"><i class="spinnerPlaceholder"></i> <i class="fa fa-trash"></i></button>
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
                                                <h2>Upload</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content collapse" style="display: none;">
                                                <div class="row">
                                                    <form action="/uploadsectionmarks" method="POST" enctype="multipart/form-data" id="studentListUpdateForm">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="courseId" value="{{$course['id']}}">
                                                        <div class="col-md-2">
                                                            <label for="studentFile">Coursework*:</label>
                                                            <select name="uploadCoursework" id="uploadCourseworkDropdown" class="form-control">
                                                                <option></option>
                                                                <option value="0"><i>Final Marks</i></option>
                                                                @foreach($course['courseworks'] as $coursework)
                                                                    <option value="{{$coursework['id']}}">{{$coursework['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="studentFile">Subcoursework*:</label>
                                                            <select name="uploadSubcoursework" id="uploadSubcourseworkDropdown" class="form-control">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="studentFile">Section*:</label>
                                                            <select name="uploadSection" id="uploadSectionDropdown" class="form-control">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="studentFile">Marks File:</label>
                                                            <input name="marksFile" id="studentFile" type="file" class="form-control-file">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>&nbsp;</label><br>
                                                            <button class="btn btn-dark btn-round" type="submit">
                                                                <i class="fa fa-upload"></i>
                                                                Upload</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                                            Search
                                                        </button>
                                                        <button class="btn btn-dark btn-round">Export</button>
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
                                                        <button class="btn btn-dark btn-round spinnerNeeded" type="button" id="searchSubcourseworkMarkButton" >
                                                            <i class="spinnerPlaceholder"></i>
                                                            Search
                                                        </button>
                                                        <button class="btn btn-dark btn-round">Export</button>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <br>
                                                <div class="div" id="subcourseworkSearchResultsBody" hidden>
                                                    <h4>Results:</h4>
                                                    <button type="button" class="btn btn-round btn-dark updateSectionMarksButton spinnerNeeded"><i class="spinnerPlaceholder"></i> Update</button>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table id="subcourseworkSearchResultsTable" class="table table-striped jambo_table bulk_action">
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

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tab_content_export" aria-labelledby="profile-tab">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="x_panel" style="height: auto;">
                                            <div class="x_title">
                                                <h2>Quick Export</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content collapse" style="display: block;">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <button class="btn btn-dark btn-round">DP List</button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn btn-dark btn-round">Students' List</button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn btn-dark btn-round">Participants' List</button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn btn-dark btn-round">Final Results</button>
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
                                               <h2>Custom Export</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content collapse" style="display: block;">
                                                <div class="row">
                                                    <i><h5>A list of columns will be displayed which the user can choose to
                                                        include in the exported file.
                                                        </h5></i>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(){
/*
            $('#addStudentFileButton').click(function(){
                var thisElement = $(this);

                var input = document.getElementById("studentsFile");

               var file = input.files[0];

               var formData = new FormData();
               formData.append('file', file.size);
               console.log(file);

                $.ajax({
                   type: 'POST',
                   url: '/updatestudentslist',
                   data: formData,
                   processData: false,
                   contentType: false,
                   success: function(data){
                       successOperation(thisElement);
                   },
                    error: function(data){
                       failOperation(thisElement);
                    }
                });
            });*/

            $('.saveRowButton').click(function(){
                var rowId = $(this).data('rowid');
                var rowName = $(this).data('rowname');
                var thisElement = $(this);

                var coursework = "";
                var subcoursework = '';
                var weighting = '';

                var elements = $('.'+ rowName);
                for(var i = 0; i < elements.length; i++){
                    if(elements[i].getAttribute('data-type')=='coursework'){coursework = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='subcoursework'){subcoursework = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='weighting'){weighting = elements[i].value;}
                }
                $.ajax({
                    type: 'POST',
                    url: '/updatesubminimumrow',

                    data:{
                        rowId: rowId,
                        coursework: coursework,
                        subcoursework: subcoursework,
                        weighting: weighting
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.saveSubminimumButton').click(function(){
                var subminimumId = $(this).data('subminimumid');
                var subminimumName = $(this).data('subminimumname');
                var thisElement = $(this);

                var type = "";
                var name = '';
                var threshold = '';

                var elements = $('.'+subminimumName);
                for(var i = 0; i < elements.length; i++){
                    if(elements[i].getAttribute('data-type')=='type'){type = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='threshold'){threshold = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
                }
                $.ajax({
                    type: 'POST',
                    url: '/updatesubminimum',

                    data:{
                        subminimumId: subminimumId,
                        name: name,
                        threshold: threshold,
                        type: type
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.saveSectionButton').click(function(){
                var sectionId = $(this).data('sectionid');
                var sectionName = $(this).data('sectionname');
                var thisElement = $(this);

                var name = "";
                var maxMarks = '';

                var elements = $('.'+sectionName);
                for(var i = 0; i < elements.length; i++){
                    if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='maxmarks'){maxMarks = elements[i].value;}
                }
                $.ajax({
                    type: 'POST',
                    url: '/updatesection',

                    data:{
                        sectionId: sectionId,
                        name: name,
                        maxMarks: maxMarks
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.saveSubcoursework').click(function(){
                var subcourseworkId = $(this).data('subcourseworkid');
                var subcourseworkName = $(this).data('subcourseworkname');
                var thisElement = $(this);

                var name = "";
                var releaseDate = '';
                var displayPercentage = '';
                var displayMarks = '';
                var maxMarks = '';
                var weightingCourse = '';

                var elements = $('.'+subcourseworkName);
                for(var i = 0; i < elements.length; i++){
                    if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='displaypercentage'){displayPercentage = elements[i].checked?1:0;}
                    if(elements[i].getAttribute('data-type')=='displaymarks'){displayMarks =  elements[i].checked?1:0;}
                    if(elements[i].getAttribute('data-type')=='weightingcourse'){weightingCourse = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='releasedate'){releaseDate = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='maxmarks'){maxMarks = elements[i].value;}
                }
                $.ajax({
                    type: 'POST',
                    url: '/updatesubcoursework',

                    data:{
                        subcourseworkId: subcourseworkId,
                        name: name,
                        displayPercentage: displayPercentage,
                        displayMarks: displayMarks,
                        weightingCourse: weightingCourse,
                        maxMarks: maxMarks,
                        releaseDate: releaseDate
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });


            });

            $('.saveCourseworkButton').click(function(){
                var courseworkId = $(this).data('courseworkid');
                var courseworkName = $(this).data('courseworkname');
                var thisElement = $(this);

                var name = "";
                var type = '';
                var weightingYear = '';
                var weightingClass = '';
                var releaseDate = '';

                var elements = $('.'+courseworkName);
                for(var i = 0; i < elements.length; i++){
                    if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='type'){type = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='weightingyear'){weightingYear = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='weightingclass'){weightingClass = elements[i].value;}
                    if(elements[i].getAttribute('data-type')=='releasedate'){releaseDate = elements[i].value;}
                }
                $.ajax({
                    type: 'POST',
                    url: '/updatecoursework',

                    data:{
                        courseworkId: courseworkId,
                        name: name,
                        type: type,
                        weightingYear: weightingYear,
                        weightingClass: weightingClass,
                        releaseDate: releaseDate
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });

            });

            $('.approveTAsButton').click(function(){
                var userIds = [];
                var count = 0;
                var thisElement = $(this);

                var checkboxes = $('.TAsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '/approveusers',

                    data:{
                        userIds:userIds
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#approveStudentsButton').click(function(){
                var userIds = [];
                var count = 0;
                var thisElement = $(this);

                var checkboxes = $('.studentsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '/approveusers',

                    data:{
                        userIds:userIds
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#approveLecturersButton').click(function(){
                var userIds = [];
                var count = 0;
                var thisElement = $(this);

                var checkboxes = $('.lecturersListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '/approveusers',

                    data:{
                        userIds:userIds
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#approveConvenorsButton').click(function(){
                var userIds = [];
                var count = 0;
                var thisElement = $(this);

                var checkboxes = $('.convenorsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '/approveusers',

                    data:{
                        userIds:userIds
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.TAsAccessButton').click(function(){
                var userIds = [];
                var count = 0;
                var access = $(this).data('access');
                var courseId = $('#courseId').val();
                var thisElement = $(this);

                var checkboxes = $('.TAsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '/tasaccess',

                    data:{
                        userIds:userIds,
                        access: access,
                        courseId: courseId
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#checkAllTAsList').click(function(){
                var checkboxes = $('.TAsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    checkboxes[i].checked = $(this).is(':checked');
                }
            });

            $('#checkAllStudentsList').click(function(){
                var checkboxes = $('.studentsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    checkboxes[i].checked = $(this).is(':checked');
                }
            });

            $('.lecturersAccessButton').click(function(){
                var userIds = [];
                var count = 0;
                var access = $(this).data('access');
                var courseId = $('#courseId').val();
                var thisElement = $(this);

                var checkboxes = $('.lecturersListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }
                console.log(userIds);

                $.ajax({
                    type: 'POST',
                    url: '/lecturersaccess',

                    data:{
                        userIds:userIds,
                        access: access,
                        courseId: courseId
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#checkAllLecturersList').click(function(){
                var checkboxes = $('.lecturersListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    checkboxes[i].checked = $(this).is(':checked');
                }
            });

            $('.convenorsAccessButton').click(function(){
                var userIds = [];
                var count = 0;
                var access = $(this).data('access');
                var courseId = $('#courseId').val();
                var thisElement = $(this);

                var checkboxes = $('.convenorsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '/convenorsaccess',

                    data:{
                        userIds:userIds,
                        access: access,
                        courseId: courseId
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#checkAllConvenorsList').click(function(){
                var checkboxes = $('.convenorsListCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    checkboxes[i].checked = $(this).is(':checked');
                }
            });

            $('#approveParticipantsButton').click(function(){
                var userIds = [];
                var count = 0;
                var thisElement = $(this);

                var checkboxes = $('.searchParticipantsResultsCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '/approveusers',

                    data:{
                        userIds:userIds
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#checkAllSearchParticipantsResults').click(function(){
                var checkboxes = $('.searchParticipantsResultsCheckbox');
                for(var i = 0; i < checkboxes.length; i++){
                    checkboxes[i].checked = $(this).is(':checked');
                }
            });

            $('.updateSectionMarksButton').click(function(){
                var inputBoxes = $('.sectionMarkInput');
                var sections = [];
                var thisElement = $(this);

                for(var i = 0; i < inputBoxes.length; i++){
                    var section = {
                        section_id: inputBoxes[i].getAttribute('data-sectionid'),
                        student_number: inputBoxes[i].getAttribute('data-studentnumber'),
                        marks: inputBoxes[i].value
                    };
                    sections[i] = section;
                }
                console.log(sections);
                $.ajax({
                    type: 'POST',
                    url: '/updatesectionmarks',

                    data:{
                        data:sections
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#searchSubcourseworkMarkButton').click(function(){
                var courseworkId = $('#subcourseworkCourseworkDropdown').val();
                var subcourseworkId = $('#subcourseworkSubcourseworkDropdown').val();
                var studentNumber = $('#subcourseworkSearchStudentNumber').val();
                var courseId = $('#courseId').val();
                var offset = ($('#subcourseworkSearchPageLimit').val()=='Max'?-1:$('#subcourseworkSearchPageOffset').val()-1);
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/getstudentssubcourseworkmarks',
                    data:{
                        courseworkId: courseworkId,
                        subcourseworkId: subcourseworkId,
                        courseId: courseId,
                        studentNumber: studentNumber,
                        offset: offset
                    },
                    success:function(data){
                        $('#subcourseworkSearchResultsTable').parent().parent().parent().show();
                        var dataString =    '<table id="subcourseworkSearchResultsTable" class="table table-striped jambo_table bulk_action">'+
                            '<thead>'+
                            '<tr class="headings">'+
                            '<th class="column-title">Student #</th>'+
                            '<th class="column-title">Employee #</th>';
                        for(var i = 0; i < data.columns.length; i++){
                            dataString += '<th class="column-title">'+data.columns[i]+'</th>';
                        }
                        dataString += '<th class="column-title">Total Marks</th>';
                        dataString += '<th class="column-title">Total Marks(%)</th>';
                        dataString += '<th class="column-title">Weighted Marks</th>';
                        dataString += '</tr></thead>';
                        dataString += '<tbody id="courseworkSearchResultsBody">';
                        for(var i = 0; i < data.marks.length; i++){
                            var record = data.marks[i];
                            dataString += '<tr class="even pointer">';
                            dataString +=  '<td>'+record.student_number+'</td>';
                            dataString +=  '<td>'+record.employee_id+'</td>';
                            for(var j = 0; j < record.sections.length; j++){
                                dataString +=  '<td><input type="number" min="0" max="'+record.sections[j].denominator+'" data-studentnumber="'+record.student_number+'" data-sectionid="'+record.sections[j].id+'" style="width:50px"class="sectionMarkInput" value="'+record.sections[j].numerator + '"> / ' + record.sections[j].denominator +'</td>';
                            }
                            dataString +=  '<td>'+record.total_num + ' / ' + record.total_den +'</td>';
                            dataString +=  '<td>'+record.percentage +'</td>';
                            dataString +=  '<td>'+record.weighted_marks +'</td>';
                            dataString +=  '</tr>';
                        }
                        dataString += '</tbody>';

                        $('#subcourseworkSearchResultsTable').replaceWith(dataString);
                        $('#subcourseworkSearchResultsTable').show();
                        successOperation(thisElement);
                    },
                    error: function(data) {
                        failOperation(thisElement);
//                        $('#courseworkSearchResultsBody').hide();
                    }
                });
            });

            $('#subcourseworkCourseworkDropdown').change(function(){
                var subcourseworkDropdown = $('#subcourseworkSubcourseworkDropdown');
                subcourseworkDropdown.empty();

                var selectedCoursework = $(this).val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();

                $.ajax({
                    type: 'POST',
                    url: '/getsubcourseworks',
                    data:{
                        _token:token,
                        coursework: selectedCoursework,
                        courseId: courseId
                    },
                    success:function(data){
                        var option = document.createElement('option');
                        option.value=-1;
                        option.text = "";
                        subcourseworkDropdown.append(option);

                        for(var i = 0; i < data.length; i++){
                            var option = document.createElement('option');
                            option.value = data[i].id;
                            option.text = data[i].name;
                            subcourseworkDropdown.append(option);
                        }
                    }
                });
            });

            $('#searchCourseworkMarkButton').click(function(){
                var courseworkId = $('#courseworkSearchDropdown').val();
                var studentNumber = $('#courseworkSearchStudentNumber').val();
                var courseId = $('#courseId').val();
                var offset = ($('#courseworkSearchPageLimit').val()=='Max'?-1:$('#courseworkSearchPageOffset').val()-1);
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/getstudentscourseworkmarks',
                    data:{
                        courseworkId: courseworkId,
                        courseId: courseId,
                        studentNumber: studentNumber,
                        offset: offset
                    },
                    success:function(data){
                        $('#courseworkSearchResultsTable').parent().parent().parent().show();
                        var dataString =    '<table id="courseworkSearchResultsTable" class="table table-striped jambo_table bulk_action">'+
                                            '<thead>'+
                                            '<tr class="headings">'+
                                            '<th class="column-title">Student #</th>'+
                                            '<th class="column-title">Employee #</th>';
                        for(var i = 0; i < data.columns.length; i++){
                            dataString += '<th class="column-title">'+data.columns[i]+'</th>';
                        }
                        dataString += '<th class="column-title">Total</th></tr></thead>';
                        dataString += '<tbody id="courseworkSearchResultsBody">';
                        for(var i = 0; i < data.marks.length; i++){
                            var record = data.marks[i];
                            dataString += '<tr class="even pointer">';
                            dataString +=  '<td>'+record.student_number+'</td>';
                            dataString +=  '<td>'+record.employee_id+'</td>';
                            for(var j = 0; j < record.subcourseworks.length; j++){
                                dataString +=  '<td>'+record.subcourseworks[j]+'</td>';
                            }
                            dataString +=  '<td>'+record.total_marks+'</td>';
                            dataString +=  '</tr>';
                        }
                        dataString += '</tbody>';

                        $('#courseworkSearchResultsTable').replaceWith(dataString);
                        $('#courseworkSearchResultsTable').show();
                        successOperation(thisElement);
                    },
                    error: function(data) {
                        failOperation(thisElement);
                        $('#courseworkSearchResultsTable').hide();
                    }
                });
            });

            $('.deleteSubminimumButton').click(function(){
                var rowId = $(this).data('subminimumid');
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/deletesubminimum',
                    data:{
                        id: rowId
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.deleteRowButton').click(function(){
                var rowId = $(this).data('rowid');
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/deletesubminimumrow',
                    data:{
                        id: rowId
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#newRowButton').click(function(){
                $('#subminimumId').val($(this).data('subminimumid'));
            });

            $('#createSubminimumButtonModal').click(function(){
                var subminimumId = $('#subminimumId').val();
                var coursework = $('#courseworkSubminimumDropdown').val();
                var subcoursework = $('#subcourseworkSubminimumDropdown').val();
                var weighting = $('#subminimumRowWeighting').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/createsubminimumrow',
                    data:{
                        subminimumId: subminimumId,
                        coursework: coursework,
                        subcoursework: subcoursework,
                        weighting: weighting
                    },
                   success:function(data){
                       $('#courseworkSubminimumDropdown').val('');
                       $('#subcourseworkSubminimumDropdown').val('');
                       $('#subminimumRowWeighting').val('');
                       successOperation(thisElement);
                   },
                   error: function(data){
                       failOperation(thisElement);
                   }
                });
            });

            $('#courseworkSubminimumDropdown').change(function() {
                var subcourseworkDropdown = $('#subcourseworkSubminimumDropdown').empty();

                var selectedCoursework = $(this).val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();

                $.ajax({
                    type: 'POST',
                    url: '/getsubcourseworks',
                    data: {
                        _token: token,
                        coursework: selectedCoursework,
                        courseId: courseId
                    },
                    success: function (data) {
                        var option = document.createElement('option');
                        option.text = "";
                        option.value = -1;
                        subcourseworkDropdown.append(option);

                        for (var i = 0; i < data.length; i++) {
                            var option = document.createElement('option');
                            option.value = data[i].id;
                            option.text = data[i].name;
                            subcourseworkDropdown.append(option);
                        }
                    }
                });
            });

            $('#refreshTAsList').click(function(){
                var courseId = $('#courseId').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: 'getteachingassistants',
                    data:{
                        courseId: courseId
                    },
                    success: function(data){
                        var dataString = '<tbody id="TAsListResultsBody">';
                        for(var i = 0; i < data.length; i++){
                            var element = data[i];
                            dataString += '<tr class="even pointer">' +
                                '<td class="a-center ">' +
                                '<input type="checkbox" class="TAsListCheckbox" data-userid='+element.id+'>' +
                                '</td>' +
                                '<td class=" ">' + element.first_name + '</td>' +
                                '<td class=" ">' + element.last_name + '</td>' +
                                '<td class=" ">' + element.staff_number + '</td>' +
                                '<td class=" ">' + element.employee_id + '</td>' +
                                '<td class=" ">' + element.email + '</td>' +
                                '<td class=" ">' + element.access + '</td>' +
                                '<td class=" ">' + element.approved + '</td>' +
                                '</tr>';
                        }
                        dataString += '</tbody>';
                        $('#TAsListResultsBody').replaceWith(dataString);
                    },
                    error: function(data){
//                    console.log(data);
                    }
                });
                refreshDone(thisElement);
            });

            $('#refreshStudentsList').click(function(){
                var courseId = $('#courseId').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: 'getstudents',
                    data:{
                        courseId: courseId
                    },
                    success: function(data){
                        var dataString = '<tbody id="studentsListResultsBody">';
                        for(var i = 0; i < data.length; i++){
                            var element = data[i];
                            dataString += '<tr class="even pointer">' +
                                '<td class="a-center ">' +
                                '<input type="checkbox" class="studentsListCheckbox" data-userid='+element.id+'>' +
                                '</td>' +
                                '<td class=" ">' + element.first_name + '</td>' +
                                '<td class=" ">' + element.last_name + '</td>' +
                                '<td class=" ">' + element.staff_number + '</td>' +
                                '<td class=" ">' + element.employee_id + '</td>' +
                                '<td class=" ">' + element.email + '</td>' +
                                '<td class=" ">' + element.access + '</td>' +
                                '<td class=" ">' + element.approved + '</td>' +
                                '</tr>';
                        }
                        dataString += '</tbody>';
                        $('#studentsListResultsBody').replaceWith(dataString);
                    },
                    error: function(data){
//                    console.log(data);
                    }
                });
                refreshDone(thisElement);
            });

            $('#refreshLecturersList').click(function(){
                var courseId = $('#courseId').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: 'getlecturers',
                    data:{
                        courseId: courseId
                    },
                    success: function(data){
                        var dataString = '<tbody id="lecturersListResultsBody">';
                        for(var i = 0; i < data.length; i++){
                            var element = data[i];
                            dataString += '<tr class="even pointer">' +
                                '<td class="a-center ">' +
                                '<input type="checkbox" class="lecturersListCheckbox" data-userid="'+element.id+'">' +
                                '</td>' +
                                '<td class=" ">' + element.first_name + '</td>' +
                                '<td class=" ">' + element.last_name + '</td>' +
                                '<td class=" ">' + element.staff_number + '</td>' +
                                '<td class=" ">' + element.employee_id + '</td>' +
                                '<td class=" ">' + element.email + '</td>' +
                                '<td class=" ">' + element.access + '</td>' +
                                '<td class=" ">' + element.approved + '</td>' +
                                '</tr>';
                        }
                        dataString += '</tbody>';
                        $('#lecturersListResultsBody').replaceWith(dataString);
                    },
                    error: function(data){
//                    console.log(data);
                    }
                });
                refreshDone(thisElement);
            });

            $('.refreshSpin').click(function(){
                $(this).children('#refreshPlaceholder').replaceWith('<i id="refreshPlaceholder" class="glyphicon glyphicon-refresh fa-spin"></i>');
            });

            function refreshDone(element){
                element.children('#refreshPlaceholder').replaceWith('<i class="fa fa-check-circle"></i>');
            }

            $('#refreshConvenorsList').click(function(){
                var courseId = $('#courseId').val();
                var thisElement = $(this);
                $('#checkAllConvenorsList').attr('checked', false);

                $.ajax({
                   type: 'POST',
                   url: 'getconvenors',
                   data:{
                       courseId: courseId
                   },
                   success: function(data){
                        var dataString = '<tbody id="convenorsListResultsBody">';
                        for(var i = 0; i < data.length; i++){
                            var element = data[i];
                            dataString += '<tr class="even pointer">' +
                                '<td class="a-center ">' +
                                '<input type="checkbox" class="convenorsListCheckbox" data-userid='+element.id+'>' +
                                '</td>' +
                                '<td class=" ">' + element.first_name + '</td>' +
                                '<td class=" ">' + element.last_name + '</td>' +
                                '<td class=" ">' + element.staff_number + '</td>' +
                                '<td class=" ">' + element.employee_id + '</td>' +
                                '<td class=" ">' + element.email + '</td>' +
                                '<td class=" ">' + element.access + '</td>' +
                                '<td class=" ">' + element.approved + '</td>' +
                                '</tr>';
                        }
                        dataString += '</tbody>';
                       $('#convenorsListResultsBody').replaceWith(dataString);
                   },
                   error: function(data){
//                    console.log(data);
                   }
                });
                refreshDone(thisElement);
            });

            $('.spinnerNeeded').click(function(){
               $(this).children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-spinner fa-spin"></i>');

            });

            $('.deleteCourseworkButton').click(function(){
                var courseworkid = $(this).data('courseworkid');
                var thisElement = $(this);
                $.ajax({
                    type: 'POST',
                    url: '/deletecoursework',
                    data:{
                        courseworkId: courseworkid,
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#createSectionButtonModal').click(function(){
                var maxMarks = $('#sectionMaxMarks').val();
                var name = $('#sectionName').val();
                var subcourseworkId = $('#subcourseworkId').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/createsection',
                    data:{
                        name: name,
                        maxMarks: maxMarks,
                        subcourseworkId: subcourseworkId
                    },
                    success:function(data){
                        successOperation(thisElement);
                        $('#sectionMaxMarks').val("");
                        $('#sectionName').val("");
                        $('#subcourseworkId').val("");
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.newSectionButton').click(function(){
                $('#subcourseworkId').val($(this).data('subcourseworkid'));
            });

            $('.deleteSection').click(function(){
                var sectionid = $(this).data('sectionid');
                var thisElement = $(this);
                $.ajax({
                    type: 'POST',
                    url: '/deletesection',
                    data:{
                        sectionId: sectionid,
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.deleteSubcoursework').click(function(){
                var subcourseworkid = $(this).data('subcourseworkid');
                var thisElement = $(this);
                $.ajax({
                    type: 'POST',
                    url: '/deletesubcoursework',
                    data:{
                        subcourseworkId: subcourseworkid,
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#createSubcourseworkButtonModal').click(function(){
                var courseworkId = $('#modalCourseworkId').val();
                var name = $('#subcourseworkName').val();
                var releaseDate = $('#subcourseworkReleaseDate').val();
                var maxMarks = $('#subcourseworkMaxMarks').val();
                var weighting = $('#subcourseworkWeighting').val();
                var displayMarks = $('#subcourseworkDisplayMarks').is(':checked')?1:0;
                var displayPercentage = $('#subcourseworkDisplayPercentage').is(':checked')? 1:0;
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/createsubcoursework',
                    data:{
                        courseworkId: courseworkId,
                        name: name,
                        releaseDate: releaseDate,
                        maxMarks: maxMarks,
                        weighting: weighting,
                        displayMarks: displayMarks,
                        displayPercentage: displayPercentage
                    },
                    success:function(data){
                        $('#modalCourseworkId').val("");
                        $('#subcourseworkName').val("");
                        $('#subcourseworkMaxMarks').val("");
                        $('#subcourseworkWeighting').val("");
                        $('#subcourseworkDisplayMarks').val("");
                        $('#subcourseworkDisplayPercentage').val("");
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('.createSubcourseworkButton').click(function(){
                var courseworkId = $(this).data('courseworkid');
                $('#modalCourseworkId').val(courseworkId);
            });

            $.ajax({
                type: 'POST',
                url:'/getfinalgradetypes',
                data:{},
                success:function(data){
                    var optionString = '';
                    for(var i = 1; i < data.length; i++){
                        optionString += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $('#gradeTypes').val(optionString);
                }
            });

            $('#searchMarkButton').click(function(){
                var studentNumber = $('#searchStudentNumber').val();
                var courseId = $('#courseId').val();
                var offset = ($('#searchResultsPageLimit').val()=='Max'?-1:$('#searchResultsPageOffset').val()-1);
                var thisElement = $(this);


                $.ajax({
                    type: 'POST',
                    url: '/getstudentsmarks',
                    data:{
                        courseId: courseId,
                        studentNumber: studentNumber,
                        offset: offset
                    },
                    success:function(data){
                        var originalData = data;
                        var types = data[1];
                        data = data[0];

                        var dataString = '<tbody id="searchMarkResultsBody">';
                        for(var i = 0; i < data.length; i++){
                            var optionString = '';
                            for(var j = 1; j < types.length; j++){
                                optionString += '<option value="'+types[j].id+'" '+(data[i].final_grade==types[j].name?'selected':'')+'>'+types[j].name+'</option>';
                            }

                            dataString += '<tr class="even pointer">';
                            dataString +=  '<td>'+data[i].student_number+'</td>';
                            dataString +=  '<td>'+data[i].employee_id+'</td>';
                            dataString +=  '<td>'+data[i].class_mark+'</td>';
                            dataString +=  '<td>'+data[i].year_mark+'</td>';
                            dataString +=  '<td>DP</td>';
                            dataString +=  '<td>'+
                                '<select class="studentFinalGradeDropdown" data-index="'+i+'" data-userid="'+data[i].id+'">' +
                                '<option value="1">'+data[i].year_mark+'</option>'+
                                optionString+
                                '</select>'+
                                '</td>';
                            dataString +=  '</tr>';
                        }
                        dataString += '</tbody>';

                        $('#searchMarkResultsBody').replaceWith(dataString);
                        $('#searchResultsBody').show();
                        successOperation(thisElement);

                        var elements = $('.studentFinalGradeDropdown');
                        for(var i = 0; i < elements.length; i++){
                            var index = elements[i].getAttribute('data-index');
                            elements.value = 5;
                        }

                    },
                    error: function(data){
                        failOperation(thisElement);
                        $('#searchResultsBody').hide();

                    }
                });
            });

            $('#exportMarkButton').click(function(){
                var studentNumber = $('#searchStudentNumber').val();
                var courseId = $('#courseId').val();
                var offset = ($('#searchResultsPageLimit').val()=='Max'?-1:$('#searchResultsPageOffset').val()-1);
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/getstudentsmarks',
                    data:{
                        courseId: courseId,
                        studentNumber: studentNumber,
                        offset: offset,
                        download:true
                    },
                    success:function(data){
                        successOperation(thisElement);
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#uploadSubcourseworkDropdown').change(function(){
                var sectionDropdown = $('#uploadSectionDropdown').empty();
                var selectedSubcoursework = $(this).val();
                var token = $('#_token').val();

                $.ajax({
                    type: 'POST',
                    url: '/getsections',
                    data:{
                        _token:token,
                        subcoursework: selectedSubcoursework
                    },
                    success:function(data){
                        var option = document.createElement('option');
                        option.text = "";
                        option.value = -1;
                        sectionDropdown.append(option);
                        for(var i = 0; i < data.length; i++){
                            var option = document.createElement('option');
                            option.text = data[i].name;
                            option.value = data[i].id;
                            sectionDropdown.append(option);
                        }
                    }
                });
            });

            $('#uploadCourseworkDropdown').change(function() {
                var subcourseworkDropdown = $('#uploadSubcourseworkDropdown').empty();
                $('#uploadSectionDropdown').empty();
                var selectedCoursework = $(this).val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();

                if(selectedCoursework == 0){
                    subcourseworkDropdown.prop('disabled', true);
                    $('#uploadSectionDropdown').prop('disabled', true);
                } else {
                    subcourseworkDropdown.prop('disabled', false);
                    $('#uploadSectionDropdown').prop('disabled', false);
                    $.ajax({
                        type: 'POST',
                        url: '/getsubcourseworks',
                        data: {
                            _token: token,
                            coursework: selectedCoursework,
                            courseId: courseId
                        },
                        success: function (data) {
                            var option = document.createElement('option');
                            option.text = "";
                            option.value = -1;
                            subcourseworkDropdown.append(option);

                            for (var i = 0; i < data.length; i++) {
                                var option = document.createElement('option');
                                option.text = data[i].name;
                                option.value = data[i].id;
                                subcourseworkDropdown.append(option);
                            }
                        }
                    });
                }
            });

            $('#createSubminimumButton').click(function(){
                var courseId = $('#courseId').val();
                var token = $('#_token').val();
                var name = $('#subminimumName').val();
                var type = $('#subminimumType').val();
                var threshold = $('#subminimumThreshold').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/createsubminimum',
                    data:{
                        _token:token,
                        name: name,
                        type: type,
                        threshold: threshold,
                        courseId: courseId
                    },
                    success:function(data){
                        $('#subminimumName').val('');
                        $('#subminimumType').val('');
                        $('#subminimumThreshold').val('');
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#createCourseworkButton').click(function(){
                var name = $('#courseworkName').val();
                var type = $('#courseworkType').val();
                var releaseDate = $('#courseworkReleaseDate').val();
                var classWeighting = $('#courseworkClassWeighting').val();
                var yearWeighting = $('#courseworkYearWeighting').val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();
                var thisElement = $(this);


                $.ajax({
                    type: 'POST',
                    url: '/createcoursework',
                    data:{
                        _token:token,
                        name: name,
                        type: type,
                        releaseDate:releaseDate,
                        classWeighting: classWeighting,
                        yearWeighting: yearWeighting,
                        courseId: courseId
                    },
                    success:function(data){
                        $('#courseworkName').val("");
                        $('#courseworkType').val("");
                        $('#courseworkClassWeighting').val("");
                        $('#courseworkYearWeighting').val("");
                        successOperation(thisElement);
                    },
                    error:function(data){
                        failOperation(thisElement);
                    }
                });
            });

            $('#searchParticipantsButton').click(function(){
                var studentNumber = $('#participantsStudentNumber').val();
                var emailAddress = $('#participantsEmail').val();
                var limit = $('#participantsPageLimit').val();
                var offset = $('#participantsPageOffset').val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/participantslist',
                    data: {
                        _token: token,
                        limit: limit,
                        offset: offset,
                        studentNumber: studentNumber,
                        emailAddress: emailAddress,
                        courseId: courseId
                    },
                    success: function (data) {
                        var dataString ='<tbody id="searchParticipantsResultsBody">';
                        for(var i = 0; i < data.length; i++) {
//                            if (data[i].firstName == 'undefined') {
//                                break;
//                            }
                            dataString += '<tr class="even pointer">' +
                                '<td class="a-center table-row">' +
                                    '<input type="checkbox" class="searchParticipantsResultsCheckbox" data-userid="' + data[i].id + '">' +
                                '</td>' +
                                '<td class="table-row">' + data[i].firstName + '</td>' +
                                '<td class="table-row">' + data[i].lastName + '</td>' +
                                '<td class="table-row">' + data[i].studentNumber + '</td>' +
                                '<td class="table-row">' + data[i].employeeId + '</td>' +
                                '<td class="table-row">' + data[i].email + '</td>' +
                                '<td class="table-row">' + data[i].role + '</td>' +
                                '<td class="table-row">' + data[i].status + '</td>' +
                                '<td class="table-row">' + data[i].approved + '</td>' +
                                '</tr>';
                        }
                        dataString += '</tbody>';
                        $('#searchParticipantsResultsBody').replaceWith(dataString);
                        successOperation(thisElement);
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                });
                $('#searchParticipantsPanel').show();
            });

            $('#updateInfoButton').click(function(){
                var courseName = $('#courseName').val();
                var courseCode = $('#courseCode').val();
                var courseType = $('#courseType').val();
                var startDate = $('#courseStartDate').val();
                var endDate = $('#courseEndDate').val();
                var courseDescription = $('#courseDescription').val();
                var courseTerm = $('#courseTerm').val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: courseId+'/update',
                    data: {
                        _token: token,
                        name: courseName,
                        code: courseCode,
                        type: courseType,
                        startDate: startDate,
                        endDate: endDate,
                        description: courseDescription,
                        term: courseTerm
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function (data){
                        failOperation(thisElement);
                    }
                });
            });

            function successOperation(element){
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-check-circle"></i>');
            }
            function failOperation(element){
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-times-circle"></i>');
            }

            $('#addConvenorButton').click(function(){
                var convenorEmailAddress = $('#convenorEmailAddress').val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();
                var convenorInvitationCheckbox = $('#convenorInvitationCheckbox').is(':checked')?1:0;
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: courseId+'/addconvenor',
                    data: {
                        _token: token,
                        email: convenorEmailAddress,
                        invitation: convenorInvitationCheckbox
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                });

            });

            $('#addLecturerButton').click(function(){
                var lecturerEmailAddress = $('#lecturerEmailAddress').val();
                var courseId = $('#courseId').val();
                var lecturerInvitationCheckbox = $('#lecturerInvitationCheckbox').is(':checked')?1:0;
                var token = $('#_token').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: courseId+'/addlecturer',
                    data: {
                        _token: token,
                        email: lecturerEmailAddress,
                        invitation: lecturerInvitationCheckbox
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                });

            });

            $('#addTAButton').click(function(){
                var taEmailAddress = $('#taEmailAddress').val();
                var courseId = $('#courseId').val();
                var taInvitationCheckbox = $('#taInvitationCheckbox').is(':checked')?1:0;
                var token = $('#_token').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: courseId+'/addta',
                    data: {
                        _token: token,
                        email: taEmailAddress,
                        invitation: taInvitationCheckbox
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                });

            });
        })
    </script>
@endsection