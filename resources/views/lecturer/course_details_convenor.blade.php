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
                        <input type="integer" id="subminimumThreshold" class="form-control" name="subminimumThreshold" required="">
                        <br/>
                        <label for="subminimumType">Type*:</label>
                        <select id="subminimumType" class="form-control">
                            <option value="1">DP</option>
                            <option value="0">Final Grade</option>
                        </select>
                        <br/>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round" id="createSubminimumButton" type="button">Create</button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

{{--    @if(Auth::user()->role_id == 5)--}}
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
                                    <label for="courseEndDate">Weighting in Class Record:</label>
                                    <input type="integer" id="courseworkClassWeighting" class="form-control" name="courseworkClassWeighting" required="">
                                </div>
                                <div class="col-md-4">
                                    <label for="courseEndDate">Weighting in Class:</label>
                                    <input type="integer" id="courseworkYearWeighting" class="form-control" name="courseworkYearWeighting" required="">
                                </div>
                                <div class="col-md-4">
                                    <label for="courseworkReleaseDate">Release Date*:</label>
                                    <input type="date" id="courseworkReleaseDate" class="date-picker form-control" value="{{date('Y').'-'.date('m').'-'.date('d')}}">
                                </div>
                            </div>
                            <br/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round" id="createCourseworkButton" type="button">Create</button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--@endif--}}

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
                                <input type="integer" id="subcourseworkMaxMarks" class="form-control" name="subcourseworkMaxMarks" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="subcourseworkWeighting">Weighting in Coursework:</label>
                                <input type="integer" id="subcourseworkWeighting" class="form-control" name="subcourseworkWeighting" required="">
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
                        <button type="button" class="btn btn-dark btn-round" id="createSubcourseworkButtonModal" type="button">Create</button>
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
                        <input type="text" id="sectionMaxMarks" class="form-control" name="sectionMaxMarks" required="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round" id="createSectionButtonModal" type="button">Create</button>
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
                                            {{--<div class="x_title">
                                                <h2>Add Participants</h2>
                                                <div class="clearfix"></div>
                                            </div>--}}
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
                                                            <button id="updateInfoButton" class="btn btn-round btn-dark" type="submit">
                                                                <i id="updateInfoButtonIcon" class="fa fa-save"></i>
                                                                Update</button>
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
                                                                        <button class="btn btn-dark btn-round" type="button" id="addConvenorButton">
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
                                                                        <button class="btn btn-dark btn-round" id="addLecturerButton" type="button">Add</button>
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
                                                                    <form action="">
                                                                        {{csrf_field()}}
                                                                        <div class="col-md-8">
                                                                            <label for="studentFile">File:</label>
                                                                            <input id="studentFile" type="file" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <p>&nbsp;</p>
                                                                            <button class="btn btn-dark btn-round" id="addStudentFileButton" type="button">Add</button>
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
                                                                <form id='studentFileUploadForm' action="">
                                                                    <div class="col-md-6">
                                                                        <input id="taEmailAddress" type="email" class="form-control" placeholder="Email">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="taInvitationCheckbox">Invitation Email:</label>
                                                                        <input id="taInvitationCheckbox" type="checkbox" checked>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button class="btn btn-dark btn-round" type="button" id="addTAButton">Add</button>
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
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" id="participantsStudentNumber" placeholder="student/staff #">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" id="participantsEmail" placeholder="Email">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-dark btn-rounded btn-round" type="button" id="searchParticipantsButton">Search</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-12">
                                                    <div class="x_panel" style="height: auto; display: none"  id="searchParticipantsPanel">
                                                        <div class="x_title" id="searchParticipantsHeader" >
                                                            <h2>Results</h2>
                                                            <ul class="nav navbar-right panel_toolbox">
                                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                                </li>
                                                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                                </li>
                                                            </ul>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="x_content" style="display: block;" id="searchParticipantsResults">
                                                            <div id="participantsContents"></div>


                                                            <button class="btn btn-dark btn-round">Approve Selected</button>
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
                                                                <table class="table table-striped jambo_table bulk_action">
                                                                    <thead>
                                                                    <tr class="headings">
                                                                        <th>
                                                                            <div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>
                                                                        </th>
                                                                        <th class="column-title">First Name</th>
                                                                        <th class="column-title">Last Name</th>
                                                                        <th class="column-title">Staff #</th>
                                                                        <th class="column-title">Employee #</th>
                                                                        <th class="column-title">Email</th>
                                                                        <th class="column-title">Access</th>
                                                                        <th class="bulk-actions" colspan="7">
                                                                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                    <tr class="even pointer">
                                                                        <td class="a-center ">
                                                                            <div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>
                                                                        </td>
                                                                        <td class=" ">Test</td>
                                                                        <td class=" ">Student</td>
                                                                        <td class=" ">stdtes001</td>
                                                                        <td class=" ">7654321</td>
                                                                        <td class=" ">stdtes001@myuct.ac.za</td>
                                                                        <td class=" ">Yes</td>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <button class="btn btn-dark btn-round">Grant Access To Selected</button>
                                                                <button class="btn btn-dark btn-round">Deny Access To Selected</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                                                            <h4 class="panel-title">Lecturers</h4>
                                                        </a>
                                                        <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                                                            <h4 class="panel-title">Students</h4>
                                                        </a>
                                                        <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <div class="btn-toolbar">
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-dark" type="button"><<</button>
                                                                        <button class="btn btn-dark" type="button">1</button>
                                                                        <button class="btn btn-dark active" type="button">2</button>
                                                                        <button class="btn btn-dark" type="button">3</button>
                                                                        <button class="btn btn-dark" type="button">4</button>
                                                                        <button class="btn btn-dark" type="button">>></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingFour1" data-toggle="collapse" data-parent="#accordion" href="#collapseFour1" aria-expanded="false" aria-controls="collapseFour1">
                                                            <h4 class="panel-title">Teaching Assistants</h4>
                                                        </a>
                                                        <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingFour1" data-toggle="collapse" data-parent="#accordion" href="#collapseFour1" aria-expanded="false" aria-controls="collapseFour1">
                                                            <h4 class="panel-title">Unapproved Users</h4>
                                                        </a>
                                                        <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingFour1" data-toggle="collapse" data-parent="#accordion" href="#collapseFour1" aria-expanded="false" aria-controls="collapseFour1">
                                                            <h4 class="panel-title">Denied Users</h4>
                                                        </a>
                                                        <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour1" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">

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
                                                                                        <input type="text" class="form-control" value="{{$coursework['name']}}">
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </h4>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-5" style="text-align: right">
                                                                    <button class="btn btn-dark btn-round createSubcourseworkButton" data-toggle="modal" type="button" data-target="#subcourseworkModal" data-courseworkid="{{$coursework['id']}}"><i class="fa fa-plus"></i> New Subcoursework</button>
                                                                    <button class="btn btn-dark btn-round"><i class="fa fa-save"></i> Save</button>
                                                                    <button class="btn btn-dark btn-round deleteCourseworkButton" data-courseworkid="{{$coursework['id']}}" type="button"><i class="fa fa-trash"></i> Delete</button>
                                                                </div>
                                                            </div>

                                                            <div id="collapseTwo{{$count.''.$count}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo{{$count.''.$count}}" aria-expanded="false" style="height: 0px;">
                                                                <div class="panel-body">
                                                                    <table class="table table-striped jambo_table bulk_action">
                                                                        <tbody>
                                                                        <tr class="even pointer">
                                                                            <td>Type:</td>
                                                                            <td>
                                                                                <select name="" id="" class="form-control">
                                                                                    @foreach(\App\CourseworkType::all() as $courseworkType)
                                                                                        <option {{$courseworkType->name==$coursework['type']?'selected':''}}>{{$courseworkType->name}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td></td><td></td><td></td>
                                                                            <td>Release Date:</td>
                                                                            <td><input type="date" class="calendar-date form-control" value="{{$coursework['display_to_students']}}"></td>
                                                                        </tr>
                                                                        <tr class="even pointer">
                                                                            <td>Weighting in Class Record:</td>
                                                                            <td><input type="integer" class="form-control" value="{{$coursework['weighting_in_classrecord']}}"></td>
                                                                            <td></td><td></td><td></td>
                                                                            <td>Weighting in Year Mark:</td>
                                                                            <td><input type="integer" class="form-control" value="{{$coursework['weighting_in_yearmark']}}"></td>
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
                                                                                            <h4><input type="text" value="{{$subcoursework['name']}}"></h4>
                                                                                            <button class="btn btn-dark btn-round saveSubcoursework" type="button" data-subcourseworkid="{{$subcoursework['id']}}"><i class="fa fa-save"></i> Save</button>
                                                                                            <button class="btn btn-dark btn-round deleteSubcoursework" type="button" data-subcourseworkid="{{$subcoursework['id']}}"><i class="fa fa-trash"></i> Delete</button>
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
                                                                                                                <td><input type="date"  {{--style="width:125px"--}}  class="calendar-date form-control" value="{{$subcoursework['display_to_students']}}"></td>
                                                                                                            </tr>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Display Percentage:</td>
                                                                                                                <td><input type="checkbox" {{$subcoursework['display_percentage']==1?'checked':''}}  style="width:125px" ></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td>Display Marks:</td>
                                                                                                                <td><input type="checkbox" {{$subcoursework['display_marks']==1?'checked':''}}  style="width:125px" ></td>
                                                                                                            </tr>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Max Marks:</td>
                                                                                                                <td><input type="integer" class="form-control" style="width:125px" value="{{$subcoursework['max_marks']}}"></td>
                                                                                                            </tr>
                                                                                                            <tr class="even pointer">
                                                                                                                <td>Weighting in Coursework:</td>
                                                                                                                <td><input type="integer" class="form-control"  style="width:125px" value="{{$subcoursework['weighting']}}"></td>
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
                                                                                                                    <td><input type="text" value="{{$section['name']}}" class="form-control" style="width:125px" ></td>
                                                                                                                    <td></td>
                                                                                                                    <td>Display Marks:</td>
                                                                                                                    <td><input type="integer" value="{{$section['max_marks']}}" class="form-control"  style="width:50px" ></td>
                                                                                                                    <td><button class="btn btn-dark btn-round deleteSection" data-sectionid="{{$section['id']}}"><i class="fa fa-trash"></i></button></td>
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
                                                            <a class="panel-heading collapsed" role="tab" id="{{$count.''.$count}}headingTwo{{$count.''.$count}}" data-toggle="collapse" data-parent="#accordion" href="#{{$count.''.$count}}collapseTwo{{$count.''.$count}}" aria-expanded="false" aria-controls="{{$count.''.$count}}collapseTwo{{$count.''.$count}}">
                                                                <h4 class="panel-title">
                                                                    <div class="row">
                                                                        <div class="col-md-5">
                                                                            {{$count.'. '}}<input type="text" {{--class="inline form-control"--}} value="{{$subminimum['name']}}">
                                                                        </div>
                                                                        <div class="col-md-7" style="text-align: right">
                                                                            <button class="btn btn-dark btn-round"><i class="fa fa-plus"></i> New Row</button>
                                                                            <button class="btn btn-dark btn-round"><i class="fa fa-save"></i> Save</button>
                                                                            <button class="btn btn-dark btn-round"><i class="fa fa-trash"></i> Delete</button>
                                                                        </div>
                                                                    </div>
                                                                </h4>
                                                            </a>

                                                            <div id="{{$count.''.$count}}collapseTwo{{$count.''.$count}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{$count.''.$count}}headingTwo{{$count.''.$count}}" aria-expanded="false" style="height: 0px;">
                                                                <div class="panel-body">
                                                                    <table class="table table-striped jambo_table bulk_action">
                                                                        <tbody>
                                                                        <tr class="even pointer">
                                                                            <td>Type:</td>
                                                                            <td>
                                                                                <select name="" id="" class="form-control">
                                                                                    <option {{$subminimum['for_dp'] == 1?'selected':''}}>DP</option>
                                                                                    <option {{$subminimum['for_dp'] == 1?'':'selected'}}>Final Grade</option>
                                                                                </select>
                                                                            </td>
                                                                            <td></td><td></td><td></td>
                                                                            <td>Threshold:</td>
                                                                            <td><input type="integer" class="form-control" value="{{$subminimum['threshold']}}"></td>
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
                                                                                            <select class="form-control">
                                                                                                @foreach($course['courseworks'] as $coursework)
                                                                                                    <option {{$row['coursework']==$coursework['name']?'selected':''}}>{{$coursework['name']}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select class="form-control">
                                                                                                <option></option>
                                                                                                @foreach($course['courseworks'] as $coursework)
                                                                                                    @foreach($coursework['subcourseworks'] as $subcoursework)
                                                                                                        <option {{$row['subcoursework']==$subcoursework['name']?'selected':''}}>{{$subcoursework['name']}}</option>
                                                                                                    @endforeach
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="integer" class="form-control" value="{{$row['weighting']}}">
                                                                                        </td>
                                                                                        <td>
                                                                                            <button class="btn btn-dark btn-round"><i class="fa fa-trash"></i></button>
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
                                                    <div class="col-md-2">
                                                        <label for="studentFile">Coursework*:</label>
                                                        <select name="" id="uploadCourseworkDropdown" class="form-control">
                                                            <option></option>
                                                            @foreach($course['courseworks'] as $coursework)
                                                                <option>{{$coursework['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="studentFile">Subcoursework*:</label>
                                                        <select name="" id="uploadSubcourseworkDropdown" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="studentFile">Section*:</label>
                                                        <select name="" id="uploadSectionDropdown" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Marks File:</label>
                                                        <input id="studentFile" type="file" class="form-control-file">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>&nbsp;</label><br>
                                                        <button class="btn btn-dark btn-round">Upload</button>
                                                    </div>
                                                    {{--<div class="col-md-3">
                                                        <p>&nbsp;</p>
                                                        <button class="btn btn-dark btn-round">Browse</button>
                                                        <button class="btn btn-dark btn-round">Add</button>
                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="x_panel" style="height: auto;">
                                            <div class="x_title">
                                                <h2>General Search/View</h2>
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
                                                        <label for="searchStudentNumber">Page #:</label>
                                                        <select id="searchResultsPageOffset" class="form-control">
                                                            <option>Max</option>
                                                            @for($i = 1; $i < ($course['students_count']/30)+1; $i++)
                                                                <option {{$i == 1?'selected':''}}>{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p>&nbsp;</p>
                                                        <button class="btn btn-dark btn-round" type="button" id="searchMarkButton" >Search</button>
                                                        <button class="btn btn-dark btn-round">Export</button>
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
                                                <h2>View</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content collapse" style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Coursework:</label>
                                                        <select name="" id="" class="form-control">
                                                            <option>All</option>
                                                            <option>Exam</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Subcategory:</label>
                                                        <select name="" id="" class="form-control">
                                                            <option></option>
                                                            <option>Default</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <p>&nbsp;</p>
                                                        <button class="btn btn-round btn-dark">Display</button>
                                                        <button class="btn btn-round btn-dark">Export</button>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12" style="text-align: center">
                                                        <div class="btn-toolbar">
                                                            <div class="btn-group">
                                                                <button class="btn btn-dark" type="button"><<</button>
                                                                <button class="btn btn-dark active" type="button">1</button>
                                                                <button class="btn btn-dark" type="button">2</button>
                                                                <button class="btn btn-dark" type="button">3</button>
                                                                <button class="btn btn-dark" type="button">4</button>
                                                                <button class="btn btn-dark" type="button">>></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                            <tr class="headings">
                                                                <th class="column-title">Student #</th>
                                                                <th class="column-title">Employee #</th>
                                                                <th class="column-title">Exam</th>
                                                                <th class="column-title">Class Mark</th>
                                                                <th class="column-title">Year Mark</th>
                                                                <th class="column-title">DP</th>
                                                                <th class="column-title">Grade</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr class="even pointer">
                                                                <td class=" ">stdtes001</td>
                                                                <td class=" ">7654321</td>
                                                                <td class=" ">
                                                                    {{--<input type="text" class="form-control" value="75">--}}75
                                                                </td>
                                                                <td class=" ">95{{--<input type="text" class="form-control" value="95">--}}</td>
                                                                <td class=" ">85{{--<input type="text" class="form-control" value="85">--}}</td>
                                                                <td class=" ">
                                                                    <select name="" id="" class="form-control">
                                                                        <option value="">DP</option>
                                                                        <option value="">DPR</option>
                                                                    </select>
                                                                </td>
                                                                <td class=" ">
                                                                    <select name="" id="" class="form-control">
                                                                        <option value="">85</option>
                                                                        <option value="">OSS</option>
                                                                        <option value="">FS</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <button class="btn btn-dark btn-round">Update</button>
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
                                                <h2>Edit</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="x_content collapse" style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Student/Employee #:</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Coursework:</label>
                                                        <select name="" id="" class="form-control">
                                                            <option>Exam</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Subcategory:</label>
                                                        <select name="" id="" class="form-control">
                                                            <option>All</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p>&nbsp;</p>
                                                        <button class="btn btn-dark btn-round">Display</button>
                                                        <button class="btn btn-dark btn-round">Export</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" style="text-align: center">
                                                        <div class="btn-toolbar">
                                                            <div class="btn-group">
                                                                <button class="btn btn-dark" type="button"><<</button>
                                                                <button class="btn btn-dark active" type="button">1</button>
                                                                <button class="btn btn-dark" type="button">2</button>
                                                                <button class="btn btn-dark" type="button">3</button>
                                                                <button class="btn btn-dark" type="button">4</button>
                                                                <button class="btn btn-dark" type="button">>></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-striped jambo_table bulk_action">
                                                            <thead>
                                                            <tr class="headings">
                                                                <th class="column-title">Student #</th>
                                                                <th class="column-title">Employee #</th>
                                                                <th class="column-title">Default</th>
                                                                <th class="column-title">Total</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <tr class="even pointer">
                                                                <td class=" ">stdtes001</td>
                                                                <td class=" ">7654321</td>
                                                                <td class=" ">
                                                                    <input type="text" class="form-control" value="75">
                                                                </td>
                                                                <td class=" "><input type="text" class="form-control" value="75"></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <button class="btn btn-dark btn-round">Update</button>
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

            $('.deleteCourseworkButton').click(function(){
                var courseworkid = $(this).data('courseworkid');
                $.ajax({
                    type: 'POST',
                    url: '/deletecoursework',
                    data:{
                        courseworkId: courseworkid,
                    },
                    success:function(data){
                        console.log(data);
                    }
                });
            });

            $('#createSectionButtonModal').click(function(){
                var maxMarks = $('#sectionMaxMarks').val();
                var name = $('#sectionName').val();
                var subcourseworkId = $('#subcourseworkId').val();

                $.ajax({
                    type: 'POST',
                    url: '/createsection',
                    data:{
                        name: name,
                        maxMarks: maxMarks,
                        subcourseworkId: subcourseworkId
                    },
                    success:function(data){
                        console.log(data);
                    }
                });
            });

            $('.newSectionButton').click(function(){
                alert($(this).data('subcourseworkid'));
                $('#subcourseworkId').val($(this).data('subcourseworkid'));
            });

            $('.deleteSection').click(function(){
                var sectionid = $(this).data('sectionid');
                $.ajax({
                    type: 'POST',
                    url: '/deletesection',
                    data:{
                        sectionId: sectionid,
                    },
                    success:function(data){
                        console.log(data);
                    }
                });
            });

            $('.deleteSubcoursework').click(function(){
                var subcourseworkid = $(this).data('subcourseworkid');
                $.ajax({
                    type: 'POST',
                    url: '/deletesubcoursework',
                    data:{
                        subcourseworkId: subcourseworkid,
                    },
                    success:function(data){
                        console.log(data);
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
                alert(displayMarks + " - " + displayPercentage);

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
                        console.log(data);
                    }
                });
            });

            $('.createSubcourseworkButton').click(function(){
                var courseworkId = $(this).data('courseworkid');
                $('#modalCourseworkId').val(courseworkId);
            });


            $('#searchMarkButton').click(function(){
                var studentNumber = $('#searchStudentNumber').val();
                var courseId = $('#courseId').val();
                var offset = ($('#searchResultsPageOffset').val()=='Max'?-1:$('#searchResultsPageOffset').val()-1);

                $.ajax({
                    type: 'POST',
                    url: '/getstudentsmarks',
                    data:{
                        courseId: courseId,
                        studentNumber: studentNumber,
                        offset: offset
                    },
                    success:function(data){
//                        console.log(data);
                        var dataString = '<tbody id="searchMarkResultsBody">';
                        for(var i = 0; i < data.length; i++){
                            dataString += '<tr class="even pointer">';
                            dataString +=  '<td>'+data[i].student_number+'</td>';
                            dataString +=  '<td>'+data[i].employee_id+'</td>';
                            dataString +=  '<td>'+data[i].class_mark+'</td>';
                            dataString +=  '<td>'+data[i].year_mark+'</td>';
                            dataString +=  '<td>DP</td>';
                            dataString +=  '<td>'+data[i].year_mark+'</td>';
                            dataString +=  '</tr>';
                        }
                        dataString += '</tbody>';

                        $('#searchMarkResultsBody').replaceWith(dataString);
                    }
                });

                $('#searchResultsBody').show();
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
                        sectionDropdown.append(option);
                        for(var i = 0; i < data.length; i++){
                            var option = document.createElement('option');
                            option.text = data[i];
                            sectionDropdown.append(option);
                        }
                    }
                });
            });

            $('#uploadCourseworkDropdown').change(function(){
                var subcourseworkDropdown = $('#uploadSubcourseworkDropdown').empty();
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
                        option.text = "";
                        subcourseworkDropdown.append(option);

                        for(var i = 0; i < data.length; i++){
                            var option = document.createElement('option');
                            option.text = data[i];
                            subcourseworkDropdown.append(option);
                        }
                    }
                });
            });


            $('#createSubminimumButton').click(function(){
                var courseId = $('#courseId').val();
                var token = $('#_token').val();
                var name = $('#subminimumName').val();
                var type = $('#subminimumType').val();
                var threshold = $('#subminimumThreshold').val();

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

                    }
                });
            });

            $('#searchParticipantsButton').click(function(){
                var studentNumber = $('#participantsStudentNumber').val();
                var emailAddress = $('#participantsEmail').val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();

                $.ajax({
                    type: 'POST',
                    url: '/participantslist',
                    data: {
                        _token: token,
                        studentNumber: studentNumber,
                        emailAddress: emailAddress,
                        courseId: courseId
                    },
                    success: function (data) {
                        console.log(data);
                        var dataString =
                            '<table class="table table-striped jambo_table bulk_action">'+
                                '<thead>'+
                                    '<tr class="headings">'+
                                        '<th>'+
                                            '<div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>'+
                                        '</th>'+
                                        '<th class="column-title">First Name</th>'+
                                        '<th class="column-title">Last Name</th>'+
                                        '<th class="column-title">Student #</th>'+
                                        '<th class="column-title">Employee #</th>'+
                                        '<th class="column-title">Email</th>'+
                                        '<th class="column-title">Role</th>'+
                                        '<th class="column-title">Status</th>'+
                                        '<th class="column-title">Approved?</th>'+
                                        '<th class="bulk-actions" colspan="7">'+
                                            '<a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>'+
                                        '</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody>';

                        for(var i = 0; i < data.length; i++){
                            dataString +=   '<tr class="even pointer">'+
                                                '<td class="a-center ">'+
                                                    '<div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>'+
                                                '</td>'+
                                                '<td class=" ">'+data[i].firstName+'</td>'+
                                                '<td class=" ">'+data[i].lastName+'</td>'+
                                                '<td class=" ">'+data[i].studentNumber+'</td>'+
                                                '<td class=" ">'+data[i].employeeId+'</td>'+
                                                '<td class=" ">'+data[i].email+'</td>'+
                                                '<td class=" ">'+data[i].role+'</td>'+
                                                '<td class=" ">'+data[i].status+'</td>'+
                                                '<td class=" ">'+data[i].approved+'</td> </td>'+
                                            '</tr>';
                        }
                        dataString += '</tbody></table>';
                        $('#participantsContents').html(dataString);
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
                        alert('success!');
                    }
                });

            });

            $('#addConvenorButton').click(function(){
                var convenorEmailAddress = $('#convenorEmailAddress').val();
                var courseId = $('#courseId').val();
                var token = $('#_token').val();

                $.ajax({
                    type: 'POST',
                    url: courseId+'/addconvenor',
                    data: {
                        _token: token,
                        email: convenorEmailAddress
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });

            });
            $('#addLecturerButton').click(function(){
                var lecturerEmailAddress = $('#lecturerEmailAddress').val();
                var courseId = $('#courseId').val();
//                var lecturerInvitationCheckbox = $('#lecturerInvitationCheckbox').checked;
                var token = $('#_token').val();

                $.ajax({
                    type: 'POST',
                    url: courseId+'/addlecturer',
                    data: {
                        _token: token,
                        email: lecturerEmailAddress
                    },
                    success: function (data) {
                        alert('success!');
                    }
                });

            });
            $('#addStudentFileButton').click(function(){
                var formData = new FormData($('#studentFileUploadForm')[0]);
               console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: courseId+'/students',
                    data: formData,
                    success: function (data) {
                        alert('success!');
                    }
                });
                alert('form_submitted');
            });
        });
    </script>
@endsection