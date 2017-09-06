<div class="main-panel">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar bar1"></span>
                    <span class="icon-bar bar2"></span>
                    <span class="icon-bar bar3"></span>
                </button>
                <a class="navbar-brand" href="#">CSC1016S</a>

            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ /*Auth::user()->firstName?Auth::user()->firstName:*/'Kushal' }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="">Profile</a>
                            </li>
                            <li>
                                <a href="">Request Account Upgrade</a>
                            </li>
                            <li>
                                <a href="{{url('/contact')}}">Contact</a>
                            </li>
                            <hr/>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>



    <div class="row" style="background-color: whitesmoke">
        <div class="card">
            <div class="col-md-12">
                / <a href="#">Convening Courses </a> / <a href="#"> CSC1016S</a>
            </div>
        </div>
    </div>
    <br/>
    <div class="content" style="padding-top: 0px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 card">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="coursetabs"><a href="#">Course Details</a></li>
                        <li role="presentation" class="active"><a href="#">Participants</a></li>
                        <li role="presentation"><a href="#">Courseworks</a></li>
                        <li role="presentation"><a href="#">View/Update Marks</a></li>
                        <li role="presentation"><a href="#">Import Marks</a></li>
                        <li role="presentation"><a href="#">Export Marks</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                Columns to Export:
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="1"><font color="black">Tests</font></label>
                                        <input id="1" type="checkbox">
                                    </div>
                                    <div class="checkbox">
                                        <div class="col-md-1"></div>
                                        <label for="1"><font color="black">|__Test 1</font></label>
                                        <input id="1" type="checkbox">
                                    </div>
                                    <div class="checkbox">
                                        <div class="col-md-1"></div>
                                        <label for="1"><font color="black">|__Test 2</font></label>
                                        <input id="1" type="checkbox">
                                    </div>
                                    <div class="checkbox">
                                        <div class="col-md-1"></div>
                                        <label for="1"><font color="black">|__Total</font></label>
                                        <input id="1" type="checkbox" checked>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="1"><font color="black">Assignments</font></label>
                                        <input id="1" type="checkbox">
                                    </div>
                                    <div class="checkbox">
                                        <div class="col-md-1"></div>
                                        <label for="1"><font color="black">|__Assignment 1</font></label>
                                        <input id="1" type="checkbox">
                                    </div>
                                    <div class="checkbox">
                                        <div class="col-md-1"></div>
                                        <label for="1"><font color="black">|__Assignment 2</font></label>
                                        <input id="1" type="checkbox">
                                    </div>
                                    <div class="checkbox">
                                        <div class="col-md-1"></div>
                                        <label for="1"><font color="black">|__Total</font></label>
                                        <input id="1" type="checkbox" checked>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="1"><font color="black">Class Mark</font></label>
                                        <input id="1" type="checkbox" checked>
                                    </div>
                                    <div class="checkbox">
                                        <label for="1"><font color="black">Year Mark</font></label>
                                        <input id="1" type="checkbox" checked>
                                    </div>
                                    <div class="checkbox">
                                        <label for="1"><font color="black">DP Status</font></label>
                                        <input id="1" type="checkbox" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="text-align: center">
                                <button class="btn btn-danger btn-xl">Export</button>
                            </div>
                            <hr/>
                            <div class="row">
                                Quick Export:
                            </div>
                            <div class="row">
                                <div class="col-md-4"><a href="">DP List</a></div>
                                <div class="col-md-4"><a href="">Final Result</a></div>
                                <div class="col-md-4"><a href="">Class Record</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="header">
                            <h5 class="title">DP</h5>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header row">
                                        <strong>New Combined Subminimum Requirement</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="1">1st</label>
                                            <select class="form-control" style="border: solid 1px black">
                                                <option selected>--</option>
                                                <option>Tests</option>
                                                <option>Practests</option>
                                                <option>Assignments</option>
                                                <option>Exams</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="1">2nd</label>
                                            <select class="form-control" style="border: solid 1px black">
                                                <option selected>--</option>
                                                <option>Tests</option>
                                                <option>Practests</option>
                                                <option>Assignments</option>
                                                <option>Exams</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="1">3rd</label>
                                            <select class="form-control" style="border: solid 1px black">
                                                <option selected>--</option>
                                                <option>Tests</option>
                                                <option>Practests</option>
                                                <option>Assignments</option>
                                                <option>Exams</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="1">Min %</label>
                                            <input id="1" class="form-control" style="border: 1px solid black" value="33.3">
                                        </div>
                                        <div class="col-md-1">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-danger btn-xl">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header row">
                                        <strong>Existing Combined Subminimum Requirement</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            1.
                                        </div>
                                        <div class="col-md-2">
                                            <label for="1">1st</label>
                                            <select class="form-control" style="border: solid 1px black">
                                                <option>--</option>
                                                <option selected>Tests</option>
                                                <option>Practests</option>
                                                <option>Assignments</option>
                                                <option>Exams</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="1">2nd</label>
                                            <select class="form-control" style="border: solid 1px black">
                                                <option>--</option>
                                                <option>Tests</option>
                                                <option>Practests</option>
                                                <option selected>Assignments</option>
                                                <option>Exams</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="1">3rd</label>
                                            <select class="form-control" style="border: solid 1px black">
                                                <option selected>--</option>
                                                <option>Tests</option>
                                                <option>Practests</option>
                                                <option>Assignments</option>
                                                <option>Exams</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="1">Min %</label>
                                            <input id="1" class="form-control" style="border: 1px solid black" value="50">
                                        </div>
                                        <div class="col-md-1">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-danger btn-xl">Save</button>
                                        </div>
                                        <div class="col-md-1">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-danger btn-xl">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="header">
                            <h5 class="title">View/Update Marks</h5>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="course_code">Student/Employee #</label>
                                    <input type="text" class="form-control" style="border: solid black 1px">
                                </div>
                                <div class="col-md-8" style="text-align: right">
                                    <p>&nbsp;</p>
                                    <button class="btn btn-danger btn-xl">Save</button>
                                </div>
                            </div>
                            <hr>
                            <div id="table_results_div" class="row">
                                <div style="text-align: center">
                                    <nav aria-label="Page navigation">
                                        <div style="text-align: right">
                                            <button class="btn btn-danger btn-xl">Update Marks</button>
                                        </div>
                                        <ul class="pagination">
                                            <li>
                                                <a href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li>
                                                <a href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <table class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th rowspan="2">Std #</th>
                                        <th>
                                            <a href="">Test 1 (/35)</a>
                                        </th>
                                        <th>
                                            <a href="">Test 2 (/35)</a>
                                        </th>
                                        <th>
                                            Total marks (/70)
                                        </th>
                                        <th>
                                            Total Percentage
                                        </th>
                                        <th>
                                            Subminimum Met?
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1234567</td>
                                        <td><input class="form-control" style="border: solid 1px black; width:65px;" value="30"></td>
                                        <td><input class="form-control" style="border: solid 1px black; width:65px;" value="35"></td>
                                        <td>65</td>
                                        <td>92.85</td>
                                        <td>Y</td>
                                    </tr>
                                    <tr>
                                        <td>7654321</td>
                                        <td><input class="form-control" style="border: solid 1px black; width:65px;" value="30"></td>
                                        <td><input class="form-control" style="border: solid 1px black; width:65px;" value="35"></td>
                                        <td>65</td>
                                        <td>92.85</td>
                                        <td>Y</td>
                                    </tr>
                                    <tr>
                                        <td>1234567</td>
                                        <td><input class="form-control" style="border: solid 1px black; width:65px;" value="30"></td>
                                        <td><input class="form-control" style="border: solid 1px black; width:65px;" value="35"></td>
                                        <td>65</td>
                                        <td>92.85</td>
                                        <td>Y</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="header">
                            <h5 class="title">View/Update Marks</h5>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="course_code">Student/Employee #</label>
                                    <input type="text" class="form-control" style="border: solid black 1px">
                                </div>
                                <div class="col-md-8" style="text-align: right">
                                    <p>&nbsp;</p>
                                    <button class="btn btn-danger btn-xl">Save</button>
                                </div>
                            </div>
                            <hr>
                            <div id="table_results_div" class="row">
                                <div style="text-align: center">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li>
                                                <a href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li>
                                                <a href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Std #</th>
                                            <th>
                                                <a href="">Tests</a>
                                                {{--<table style="boder:1px solid black; padding-top: 0px; padding-right: 0px">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="2" align="center">Tests</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr style="border: 1px solid black">
                                                            <td style="border: 1px solid black">
                                                                Test 1
                                                            </td>
                                                            <td style="border: 1px solid black">
                                                                Test 2
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>--}}
                                            </th>
                                            <th>
                                                <a href="">Assignments</a>
                                                {{--<table style="boder:1px solid black; padding-top: 0px; padding-right: 0px">
                                                    <thead>
                                                    <tr>
                                                        <td colspan="3" align="center">Assignments</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr style="border: 1px solid black">
                                                        <td style="border: 1px solid black">
                                                            A. 1
                                                        </td>
                                                        <td style="border: 1px solid black">
                                                            A. 2
                                                        </td>
                                                        <td style="border: 1px solid black">
                                                            A. 3
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>--}}
                                            </th>
                                            <th>
                                                <a href="">Quizzes</a>
                                            </th>
                                            <th>
                                                <a href="">Exam</a>
                                            </th>
                                            <th>
                                                Class Mark
                                            </th>
                                            <th>
                                                DP
                                            </th>
                                            <th>
                                                Final Mark
                                            </th>
                                            <th>
                                                Grade
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1234567</td>
                                            <td>90</td>
                                            <td>95</td>
                                            <td>75</td>
                                            <td>75</td>
                                            <td>87</td>
                                            <td>DP</td>
                                            <td>85</td>
                                            <td>P</td>
                                        </tr>
                                        <tr>
                                            <td>7654321</td>
                                            <td>90</td>
                                            <td>95</td>
                                            <td>75</td>
                                            <td>75</td>
                                            <td>30</td>
                                            <td>DP</td>
                                            <td>60</td>
                                            <td>F</td>
                                        </tr>
                                        <tr>
                                            <td>1234567</td>
                                            <td>90</td>
                                            <td>95</td>
                                            <td>75</td>
                                            <td>75</td>
                                            <td>87</td>
                                            <td>DP</td>
                                            <td>85</td>
                                            <td>P</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="content">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-control-label" for="course_code">Course Code</label>
                                    <input id="course_code" style="border: 1px solid black" value="CSC1016S" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="start">Start Date</label>
                                    <input id="start" type="date" style="border: 1px solid black" value="2017-08-14" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="end">End Date</label>
                                    <input id="end" type="date" value="2017-11-10" style="border: 1px solid black" class="form-control">
                                </div>
                            </div>
                            <br/>
                            <label class="form-control-label" for="description">Description</label>
                            <textarea style="border: 1px solid black" class="form-control">A 1st year 2nd semester course...</textarea>
                            <hr/>
                            <div>
                                <button class="btn btn-danger btn-xl">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="header">
                            <h5 class="title">Add/Remove Participants</h5>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="header"><h5>Add Teaching Assistant</h5></div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="ta_email">Email</label>
                                    <input id="ta_email" type="email" style="border: 1px solid black" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-control-label" for="invitation_mail">Send Invitation Mail</label><br/>
                                    <div class="checkbox">
                                        <input id="invitation_mail" type="checkbox" checked>
                                    </div>
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <br/>
                                    <button class="btn btn-danger btn-xl">Add TA</button>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="header"><h5>Add Lecturer</h5></div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="ta_email">Email</label>
                                    <input class="form-control" style="border: solid 1px black" type="text" list="lecturers" />
                                    <datalist id="lecturers">
                                        <option>lecturer1@cs.uct.ac.za</option>
                                        <option>lecturer2@cs.uct.ac.za</option>
                                        <option>lecturer3@cs.uct.ac.za</option>
                                    </datalist>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-control-label" for="invitation_mail">Send Invitation Mail</label><br/>
                                    <div class="checkbox">
                                        <input id="invitation_mail" type="checkbox" checked>
                                    </div>
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <br/>
                                    <button class="btn btn-danger btn-xl">Add Lecturer</button>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="header"><h5>Remove Teaching Assistant/Lecturer</h5></div>
                                <div class="col-md-4">
                                    <label class="form-control-label" for="ta_email">Email</label>
                                    <input class="form-control" style="border: solid 1px black" type="text" list="participants" />
                                    <datalist id="participants">
                                        <option>lecturer1@cs.uct.ac.za</option>
                                        <option>lecturer2@cs.uct.ac.za</option>
                                        <option>lecturer3@cs.uct.ac.za</option>
                                        <option>ta_1@cs.uct.ac.za</option>
                                        <option>ta_2@cs.uct.ac.za</option>
                                    </datalist>
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3" style="text-align: center">
                                    <br/>
                                    <button class="btn btn-danger btn-xl">Remove User</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="header"><h5>Update Students' List</h5></div>
                                    <div class="col-md-4">
                                        <label for="2">File Containing Students' Details</label>
                                        <div class="form-control-file">
                                            <input id="1" class="form-control" type="file" style="border: 1px solid black">
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3" style="text-align: center">
                                        <p>&nbsp;</p>
                                        <button class="btn btn-danger btn-xl">Update</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="header">
                            <h5 class="title">Participants List</h5>
                        </div>
                        <div class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label" for="course_code">Select Participants</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <input id="checkbox1" type="checkbox">
                                                <label for="checkbox1">
                                                    All Users
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <input id="checkbox1" type="checkbox">
                                                <label for="checkbox1">
                                                    Lecturers
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <input id="checkbox1" type="checkbox">
                                                <label for="checkbox1">
                                                    Students
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <input id="checkbox1" type="checkbox">
                                                <label for="checkbox1">
                                                    Teaching Assistants
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <br/>
                                    <button id="search_btn_table" class="btn btn-danger btn-xl">Search</button>
                                    <button class="btn btn-danger btn-xl">Export</button>
                                </div>
                            </div>
                            <hr>

                            <div id="table_results_div" class="row">
                                <div style="text-align: center">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <li>
                                                <a href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li>
                                                <a href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Student/Staff Number</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>1234567</td>
                                        <td>john@example.com</td>
                                        <td>Lecturer</td>
                                        <td>Registered</td>
                                    </tr>
                                    <tr>
                                        <td>Another</td>
                                        <td>Doe</td>
                                        <td>1234567</td>
                                        <td>another@example.com</td>
                                        <td>Lecturer</td>
                                        <td>Deregistered</td>
                                    </tr>
                                    <tr>
                                        <td>Other</td>
                                        <td>Doe</td>
                                        <td>1234567</td>
                                        <td>other@example.com</td>
                                        <td>Lecturer</td>
                                        <td>Registered</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="content" style="border: 1px solid black">
                            <div class="row">
                                <div>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h5 class="title"><strong>List of Courseworks</strong></h5>
                                            </div>
                                            <div class="col-md-9" style="text-align: right">
                                                <button class="btn btn-danger btn-xl">Add Coursework</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="content">
                            <div class="row">
                                <div class="panel" style="border-bottom: 1px solid black">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h5>|__ <a href="/courseconvenor/courseworkedit">1. Tests</a></h5>
                                            </div>
                                            <div class="col-md-9" style="text-align: right">
                                                <button class="btn btn-danger btn-xl">Edit</button>
                                                <button class="btn btn-danger btn-xl">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-wrapper collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        Visible to Students
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Percentage
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Marks
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="1">Percentage of Final Mark</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="33.3%">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>&nbsp;</p>
                                                    <div class="checkbox">
                                                        Include in Class/Year Record
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel" style="border-bottom: 1px solid black">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h5>|__ <a href="/courseconvenor/courseworkedit">2. Assignments</a></h5>
                                            </div>
                                            <div class="col-md-9" style="text-align: right">
                                                <button class="btn btn-danger btn-xl">Edit</button>
                                                <button class="btn btn-danger btn-xl">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-wrapper collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        Visible to Students
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Percentage
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Marks
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="1">Percentage of Final Mark</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="33.3%">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>&nbsp;</p>
                                                    <div class="checkbox">
                                                        Include in Class/Year Record
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel" style="border-bottom: 1px solid black">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h5>|__ <a href="/courseconvenor/courseworkedit">3. Practest</a></h5>
                                            </div>
                                            <div class="col-md-9" style="text-align: right">
                                                <button class="btn btn-danger btn-xl">Edit</button>
                                                <button class="btn btn-danger btn-xl">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-wrapper collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        Visible to Students
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Percentage
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Marks
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="1">Percentage of Final Mark</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="33.3">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="1">Percentage Minimum For DP</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="-1">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>&nbsp;</p>
                                                    <div class="checkbox">
                                                        Include in Class/Year Record
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel" style="border-bottom: 1px solid black">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h5>|__ <a href="/courseconvenor/courseworkedit">4. Exams</a></h5>
                                            </div>
                                            <div class="col-md-9" style="text-align: right">
                                                <button class="btn btn-danger btn-xl">Edit</button>
                                                <button class="btn btn-danger btn-xl" disabled>Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-wrapper collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        Visible to Students
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Percentage
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        Display Marks
                                                        <input type="checkbox" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="1">Percentage of Final Mark</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="33.3%">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="1">Subminimum</label>
                                                    <input id="1" class="form-control" style="border: 1px solid black" value="45%">
                                                </div>
                                            </div>
                                            <div class="row">

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel" style="border-bottom: 1px solid black">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h5>|__ <a href="/courseconvenor/courseworkedit">5. DP</a></h5>
                                            </div>
                                            <div class="col-md-9" style="text-align: right">
                                                <button class="btn btn-danger btn-xl">Edit</button>
                                                <button class="btn btn-danger btn-xl" disabled>Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-wrapper collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        Visible to Students
                                                        <input type="checkbox" checked>
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
    </div>
    @include('include.dashboard.footer')




</div>