@extends('dashboard.main')
@section('page_title')
    My Marks
@endsection
@section('sidebar')
    @include('dashboard.ta_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/teachingassistant')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-building-o"></i>&nbsp;My Marks</h4>
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
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>1. CSC1015F (2017)</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse">
                            <!-- start accordion -->
                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <h4 class="panel-title">Final Mark</h4>
                                    </a>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: 84</h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Marks</th>
                                                    <th>Out Of</th>
                                                    <th>Weighting</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td scope="row">Class Record</td>
                                                    <td>80</td>
                                                    <td>100</td>
                                                    <td>50</td>
                                                    <td>40</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Exam</td>
                                                    <td>70</td>
                                                    <td>80</td>
                                                    <td>50</td>
                                                    <td>43.8</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h4 class="panel-title">DP Status</h4>
                                    </a>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: DP</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title">Class Record</h4>
                                    </a>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: 80</h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Marks</th>
                                                    <th>Out Of</th>
                                                    <th>Weighting</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td scope="row">Test</td>
                                                    <td>80</td>
                                                    <td>100</td>
                                                    <td>35</td>
                                                    <td>28</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignments</td>
                                                    <td>95</td>
                                                    <td>100</td>
                                                    <td>50</td>
                                                    <td>47.5</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Prac Tests</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>15</td>
                                                    <td>15</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        <h4 class="panel-title">Assignments</h4>
                                    </a>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: 95</h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Marks</th>
                                                    <th>Out Of</th>
                                                    <th>Weighting</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td scope="row">Assignment 1</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 2</td>
                                                    <td>75</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>15</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 3</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 4</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 5</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>2. CSC10XX (2017)</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse">
                            <!-- start accordion -->
                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                                        <h4 class="panel-title">Final Mark</h4>
                                    </a>
                                    <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: 84</h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="column-title">Name</th>
                                                    <th>Marks</th>
                                                    <th>Out Of</th>
                                                    <th>Weighting</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td scope="row">Class Record</td>
                                                    <td>80</td>
                                                    <td>100</td>
                                                    <td>50</td>
                                                    <td>40</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Exam</td>
                                                    <td>70</td>
                                                    <td>80</td>
                                                    <td>50</td>
                                                    <td>43.8</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo1">
                                        <h4 class="panel-title">DP Status</h4>
                                    </a>
                                    <div id="collapseTwo1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: DP</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                                        <h4 class="panel-title">Class Record</h4>
                                    </a>
                                    <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: 80</h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Marks</th>
                                                    <th>Out Of</th>
                                                    <th>Weighting</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td scope="row">Test</td>
                                                    <td>80</td>
                                                    <td>100</td>
                                                    <td>35</td>
                                                    <td>28</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignments</td>
                                                    <td>95</td>
                                                    <td>100</td>
                                                    <td>50</td>
                                                    <td>47.5</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Prac Tests</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>15</td>
                                                    <td>15</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingFour1" data-toggle="collapse" data-parent="#accordion" href="#collapseFour1" aria-expanded="false" aria-controls="collapseFour1">
                                        <h4 class="panel-title">Assignments</h4>
                                    </a>
                                    <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour1" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <h3>Result: 95</h3>
                                            <br>
                                            <h5>Marks Breakdown:</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Marks</th>
                                                    <th>Out Of</th>
                                                    <th>Weighting</th>
                                                    <th>Weighted Marks</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td scope="row">Assignment 1</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 2</td>
                                                    <td>75</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>15</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 3</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 4</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Assignment 5</td>
                                                    <td>100</td>
                                                    <td>100</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
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
    </div>
@endsection



{{--
@extends('layouts.dashboard.main')

@section('title')
    My Marks
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
                <li class="active">
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

    @include('include.dashboard.marksbody')
</div>
@endsection
--}}
