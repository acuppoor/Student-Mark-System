@extends('dashboard.main')
@section('page_title')
    CSC1016S
@endsection
@section('sidebar')
    @include('dashboard.convenor_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/courseconvenor/convening_courses')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-book"></i>&nbsp;CSC1016S</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
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
                                                <form id="demo-form" data-parsley-validate="" novalidate="">
                                                    <label for="courseCode">Course Code*:</label>
                                                    <input type="text" id="courseCode" class="form-control" name="courseCode" required="">
                                                    <br/>
                                                    <label for="courseType">Course Type* :</label>
                                                    <select id="courseType" class="form-control" required="">
                                                        <option value="">First Semester</option>
                                                        <option>Half Year</option>
                                                        <option value="press">Second Semester</option>
                                                        <option>Summer</option>
                                                        <option>Whole Year</option>
                                                        <option>Winter</option>
                                                    </select>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="startDate">Start Date*:</label>
                                                            <input type="date" class="date-picker form-control" value="2017-08-14">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="startDate">End Date:</label>
                                                            <input type="date" class="date-picker form-control" value="2017-11-10">
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <label for="courseType">Description:</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-4" style="text-align: center">
                                                            <button class="btn btn-rounded btn-round btn-primary">Update</button>
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
                                                                <div class="col-md-6">
                                                                    <input id="convenorEmailAddress" type="email" class="form-control" placeholder="Email">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="invitationCheckbox">Invitation Email:</label>
                                                                    <input id="invitationCheckbox" type="checkbox" checked>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-dark btn-round">Add</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="panel">
                                                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            <h4 class="panel-title">Lecturer</h4>
                                                        </a>
                                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">
                                                                <div class="col-md-6">
                                                                    <input id="convenorEmailAddress" type="email" class="form-control" placeholder="Email">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="invitationCheckbox">Invitation Email:</label>
                                                                    <input id="invitationCheckbox" type="checkbox" checked>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-dark btn-round">Add</button>
                                                                </div>
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
                                                                    <div class="col-md-8">
                                                                        <label for="studentFile">File:</label>
                                                                        <input id="studentFile" type="text" class="form-control">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <p>&nbsp;</p>
                                                                        <button class="btn btn-dark btn-round">Browse</button>
                                                                        <button class="btn btn-dark btn-round">Add</button>
                                                                    </div>
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
                                                                <div class="col-md-6">
                                                                    <input id="convenorEmailAddress" type="email" class="form-control" placeholder="Email">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="invitationCheckbox">Invitation Email:</label>
                                                                    <input id="invitationCheckbox" type="checkbox" checked>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-dark btn-round">Add</button>
                                                                </div>
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
                                                        <input type="text" class="form-control" value="stdtes001" placeholder="student/staff #">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" placeholder="Email">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-dark btn-rounded btn-round">Search</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-12">
                                                    {{--List and export--}}
                                                    <div class="x_panel" style="height: auto;">
                                                        <div class="x_title">
                                                            <h2>Results</h2>
                                                            <ul class="nav navbar-right panel_toolbox">
                                                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                                </li>
                                                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                                </li>
                                                            </ul>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="x_content" style="display: none;">
                                                            <table class="table table-striped jambo_table bulk_action">
                                                                <thead>
                                                                <tr class="headings">
                                                                    <th>
                                                                        <div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>
                                                                    </th>
                                                                    <th class="column-title">First Name</th>
                                                                    <th class="column-title">Last Name</th>
                                                                    <th class="column-title">Student #</th>
                                                                    <th class="column-title">Employee #</th>
                                                                    <th class="column-title">Role</th>
                                                                    <th class="column-title">Email</th>
                                                                    <th class="column-title">Access</th>
                                                                    <th class="column-title">Approved?</th>
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
                                                                    <td class=" ">Student</td>
                                                                    <td class=" ">7654321</td>
                                                                    <td class=" ">stdtes001@myuct.ac.za</td>
                                                                    <td class=" ">Yes</td>
                                                                    <td class=" ">No</td>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <button class="btn btn-dark btn-round">Approve Selected</button>
                                                            <button class="btn btn-dark btn-round">Grant Access To Selected</button>
                                                            <button class="btn btn-dark btn-round">Deny Access To Selected</button>
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
                                                <h2>List</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li>
                                                        <button class="btn btn-dark btn-round">
                                                            <span class="glyphicon glyphicon-plus"></span>
                                                            New Coursework
                                                        </button>
                                                    </li>
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content" style="display: none;">
                                                <div class="row">
                                                    <ul class="nav side-menu" style="">
                                                        <li>
                                                            <ul class="nav child_menu" style="display: block;">
                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="panel">
                                                                                <a class="panel-heading collapsed" role="tab" id="headingTwo3" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                                                                                    <div class="row panel-title">
                                                                                        <div class="col-md-5">
                                                                                            <h4 class="panel-title">
                                                                                                <a>Exam</a>
                                                                                            </h4>
                                                                                        </div>
                                                                                        <div class="col-md-7" style="text-align: right">
                                                                                            <button class="btn btn-round btn-dark">
                                                                                                <span class="glyphicon glyphicon-floppy-save"></span>
                                                                                                Save
                                                                                            </button>
                                                                                            <button class="btn btn-round btn-dark">
                                                                                                <span class="glyphicon glyphicon-trash"></span>
                                                                                                Delete
                                                                                            </button>
                                                                                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                                                        </div>

                                                                                    </div>
                                                                                </a>
                                                                                <div id="collapseTwo3" class="panel-collapse" role="tabpanel" aria-labelledby="headingTwo3" aria-expanded="false" style="height: 0px;">
                                                                                    <div class="panel-body">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <div class="icheckbox_flat-green" style="position: relative;">
                                                                                                    <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                                                                                    <ins class="iCheck-helper" style="position: absolute"></ins>
                                                                                                </div>
                                                                                                Display Percentage
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="icheckbox_flat-green" style="position: relative;">
                                                                                                    <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                                                                                    <ins class="iCheck-helper" style="position: absolute"></ins>
                                                                                                </div>
                                                                                                Display Marks
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="icheckbox_flat-green" style="position: relative;">
                                                                                                    <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                                                                                    <ins class="iCheck-helper" style="position: absolute"></ins>
                                                                                                </div>
                                                                                                Display To Students
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="row">
                                                                                            <div class="col-md-3">
                                                                                                <div class="col-md-10">
                                                                                                    <label class="control-label">Include In Class Mark:</label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <div class="icheckbox_flat-green" style="position: relative;">
                                                                                                        <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                                                                                        <ins class="iCheck-helper" style="position: absolute"></ins>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1"></div>
                                                                                            <div class="col-md-3">
                                                                                                <div class="col-md-4">
                                                                                                    <label class="control-label">Weighting:</label>
                                                                                                </div>
                                                                                                <div class="col-md-8">
                                                                                                    <input class="form-control">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="row">
                                                                                            <div class="col-md-3">
                                                                                                <div class="col-md-10">
                                                                                                    <label class="control-label">Include In Year Mark:</label>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <div class="icheckbox_flat-green" style="position: relative;">
                                                                                                        <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                                                                                        <ins class="iCheck-helper" style="position: absolute"></ins>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-1"></div>
                                                                                            <div class="col-md-3">
                                                                                                <div class="col-md-4">
                                                                                                    <label class="control-label">Weighting:</label>
                                                                                                </div>
                                                                                                <div class="col-md-8">
                                                                                                    <input class="form-control">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr>
                                                                                        <div class="row">
                                                                                            <div class="col-md-1"></div>
                                                                                            <div class="col-md-4">
                                                                                                <h5>
                                                                                                    <label for="">Subcategories</label>
                                                                                                </h5>
                                                                                            </div>
                                                                                            <div class="col-md-7" style="text-align: right">
                                                                                                <button class="btn btn-dark btn-round">
                                                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                                                    New Subcat
                                                                                                </button>
                                                                                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="row">
                                                                                            <div class="col-md-1"></div>
                                                                                            <div class="col-md-11">
                                                                                                <ul class="nav child_menu" style="display: block;">
                                                                                                    <li class="sub_menu current-page">
                                                                                                        <div class="row panel-title" style="border-bottom: 1px solid black;">
                                                                                                            <div class="col-md-5">
                                                                                                                <h3 class="panel-title">
                                                                                                                Default
                                                                                                                </h3>
                                                                                                            </div>
                                                                                                            <div class="col-md-7" style="text-align: right">
                                                                                                                <button class="btn btn-round btn-dark">
                                                                                                                    <span class="glyphicon glyphicon-floppy-save"></span>
                                                                                                                    Save
                                                                                                                </button>
                                                                                                                <button class="btn btn-round btn-dark">
                                                                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                                                                    Delete
                                                                                                                </button>
                                                                                                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                                                                            </div>

                                                                                                        </div>
                                                                                                        <br>
                                                                                                        {{--<h2 class="title">
                                                                                                            Default
                                                                                                            <button class="btn btn-round btn-dark">
                                                                                                                <span class="glyphicon glyphicon-trash"></span>
                                                                                                                Delete
                                                                                                            </button>
                                                                                                        </h2>--}}
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-4">
                                                                                                                <div class="icheckbox_flat-green" style="position: relative;">
                                                                                                                    <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                                                                                                    <ins class="iCheck-helper" style="position: absolute"></ins>
                                                                                                                </div>
                                                                                                                Display To Students
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <div class="icheckbox_flat-green" style="position: relative;">
                                                                                                                    <input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;">
                                                                                                                    <ins class="iCheck-helper" style="position: absolute"></ins>
                                                                                                                </div>
                                                                                                                Include In Coursework
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <div class="col-md-5">
                                                                                                                    <label class="control-label">Weighting:</label>
                                                                                                                </div>
                                                                                                                <div class="col-md-7">
                                                                                                                    <input class="form-control" value="100">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-4">
                                                                                                                <label for="">Max Points:</label>
                                                                                                                <input type="text" class="form-control" value="100">
                                                                                                            </div>
                                                                                                            <div class="col-md-5">
                                                                                                                <label for="studentFile">Marks File:</label>
                                                                                                                <input id="studentFile" type="text" class="form-control">
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <p>&nbsp;</p>
                                                                                                                <button class="btn btn-dark btn-round">Browse</button>
                                                                                                                <button class="btn btn-dark btn-round">Add</button>
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
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="x_panel" style="height: auto;">
                                            <div class="x_title">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <h2>Subminimum</h2>
                                                    </div>
                                                    <div class="col-md-8" style="text-align: right">
                                                        <ul class="nav navbar-right panel_toolbox">
                                                            <li>
                                                                <button class="btn btn-round btn-dark">
                                                                    <span class="glyphicon glyphicon-plus"></span>New
                                                                </button>
                                                            </li>
                                                            <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content collapse" style="display: none;">
                                                <div class="row">
                                                    <ul class="nav side-menu" style="">
                                                        <li>
                                                            <ul class="nav child_menu" style="display: block;">
                                                                <li>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="panel">
                                                                                <a class="panel-heading collapsed" role="tab" id="headingTwo3" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <h4 class="panel-title">
                                                                                                <a>1. Subminimum 1</a>
                                                                                            </h4>
                                                                                        </div>
                                                                                        <div class="col-md-8" style="text-align: right">
                                                                                            <h4 class="panel-title">
                                                                                                <button class="btn btn-round btn-dark">
                                                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                                                    Add Row
                                                                                                </button>
                                                                                                <button class="btn btn-round btn-dark">
                                                                                                    <span class="glyphicon glyphicon-floppy-save"></span>
                                                                                                    Save
                                                                                                </button>
                                                                                                <button class="btn btn-round btn-dark">
                                                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                                                    Delete
                                                                                                </button>
                                                                                                <span class="fa fa-chevron-up"></span>
                                                                                            </h4>
                                                                                        </div>
                                                                                    </div>




                                                                                </a>
                                                                                <div id="collapseTwo3" class="panel-collapse" role="tabpanel" aria-labelledby="headingTwo3" aria-expanded="false" style="height: 0px;">
                                                                                    <div class="panel-body">
                                                                                        <div class="row">
                                                                                            <div class="col-md-4">
                                                                                                <div id="Type" class="btn-group" data-toggle="buttons">
                                                                                                    <label class="btn btn-default" data-toggle-class="btn-dark" data-toggle-passive-class="btn-default">
                                                                                                        <input type="radio" name="dp" value="DP" data-parsley-multiple="gender" data-parsley-id="12"> &nbsp; DP &nbsp;
                                                                                                    </label>
                                                                                                    <label class="btn btn-dark active" data-toggle-class="btn-dark" data-toggle-passive-class="btn-default">
                                                                                                        <input type="radio" name="" value="final" data-parsley-multiple="gender"> Final Grade
                                                                                                    </label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-3">
                                                                                                <div class="col-md-4">
                                                                                                    <label class="control-label">Threshold:</label>
                                                                                                </div>
                                                                                                <div class="col-md-8">
                                                                                                    <input class="form-control" value="45">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <h4>Subminimum Breakdown:</h4>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <table class="table table-striped jambo_table bulk_action">
                                                                                                    <thead>
                                                                                                    <tr class="headings">
                                                                                                        <th>
                                                                                                            <div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>
                                                                                                        </th>
                                                                                                        <th class="column-title">Coursework</th>
                                                                                                        <th class="column-title">Subcategory</th>
                                                                                                        <th class="column-title">Percentage</th>
                                                                                                    </tr>
                                                                                                    </thead>

                                                                                                    <tbody>
                                                                                                    <tr class="even pointer">
                                                                                                        <td class="a-center ">
                                                                                                            <div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>
                                                                                                        </td>
                                                                                                        <td class=" ">
                                                                                                            <select name="" id="" class="form-control">
                                                                                                                <option value="">Exam</option>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                        <td class=" ">
                                                                                                            <select name="" id="" class="form-control">
                                                                                                                <option value="">Default</option>
                                                                                                            </select>
                                                                                                        </td>
                                                                                                        <td class=" ">
                                                                                                            <input type="text" class="form-control" value="100"></td>
                                                                                                    </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <button class="btn btn-dark btn-round">Remove Selected</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
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
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Coursework:</label>
                                                        <select name="" id="" class="form-control">
                                                            <option>Exam</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Subcategory:</label>
                                                        <select name="" id="" class="form-control">
                                                            <option>Default</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="studentFile">Marks File:</label>
                                                        <input id="studentFile" type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p>&nbsp;</p>
                                                        <button class="btn btn-dark btn-round">Browse</button>
                                                        <button class="btn btn-dark btn-round">Add</button>
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
                                                <h2>Search</h2>
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
                                                        <input id="studentFile" type="text" class="form-control">
                                                    </div>
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

                                                    <div class="col-md-3">
                                                        <p>&nbsp;</p>
                                                        <button class="btn btn-dark btn-round">Search</button>
                                                        <button class="btn btn-dark btn-round">Export</button>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <br>
                                                <h4>Results:</h4>
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
                                                                <td class=" ">75{{--<input type="text" class="form-control" value="75">--}}</td>
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


{{--
@extends('layouts.dashboard.main')

@section('title')
    Course Details
@endsection

@section('content')
    <div class="wrapper">
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

        @include('include.dashboard.coursedetails')

    </div>
@endsection
--}}
