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
                <a class="navbar-brand" href="#">CSC1016S Tests</a>

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
                / <a href="#">Convening Courses </a> / <a href="#"> CSC1016S</a> / <a href=""> Courseworks</a> / <a
                        href="">Tests</a>
            </div>
        </div>
    </div>
    <br/>
    <div class="content" style="padding-top: 0px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 card">
                    <ul class="nav nav-pills">
                        <li role="presentation"><a href="/course/details">Course Details</a></li>
                        <li role="presentation"><a href="/course/participants">Participants</a></li>
                        <li role="presentation" class="active"><a href="/course/coursework">Courseworks</a></li>
                        <li role="presentation"><a href="/course/marks">View/Update Marks</a></li>
                        <li role="presentation"><a href="/course/export">Export Marks</a></li>
                    </ul>
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
                                                <h5 class="title"><strong>Tests Category</strong></h5>
                                            </div>
                                            <div class="col-md-9" style="text-align: right">
                                                <button class="btn btn-danger btn-xl">Add Subcategory</button>
                                                <button class="btn btn-danger btn-xl">Delete</button>
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
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <h5>|__ 1. Test 1</h5>
                                                        </div>
                                                        <div class="col-md-5" style="text-align: right">
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
                                                            <div class="col-md-3">
                                                                <label for="1">Maximum Points</label>
                                                                <input id="1" class="form-control" style="border: 1px solid black" value="35">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="1">Weightage</label>
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
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <label for="2">Marks File</label>
                                                                <div class="form-control-file">
                                                                    <input id="1" class="form-control" type="file" style="border: 1px solid black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p>&nbsp;</p>
                                                                <button class="btn btn-danger btn-xl">Upload</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="panel" style="border-bottom: 1px solid black">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <h5>|__ 2. Test 2</h5>
                                                        </div>
                                                        <div class="col-md-5" style="text-align: right">
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
                                                            <div class="col-md-3">
                                                                <label for="1">Maximum Points</label>
                                                                <input id="1" class="form-control" style="border: 1px solid black" value="35">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="1">Weightage</label>
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
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <label for="2">Marks File</label>
                                                                <div class="form-control-file">
                                                                    <input id="1" class="form-control" type="file" style="border: 1px solid black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <p>&nbsp;</p>
                                                                <button class="btn btn-danger btn-xl">Upload</button>
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
        </div>
    </div>
    @include('include.dashboard.footer')
</div>