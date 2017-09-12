@extends('dashboard.main')
@section('page_title')
    Admin
@endsection
@section('sidebar')
    @include('dashboard.dept_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/departmentadmin/admin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-cogs "></i>&nbsp;Admin</h4>
            </a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel" style="height: auto;">
                        <div class="x_title">
                            <h2>Features</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: block;">
                            <div class="row">
                                <i><h5>Admin Features to be determined and added here
                                    </h5></i>
                            </div>
                            {{--<div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="card">
                                        <div class="header" style="border-bottom: 1px solid black">
                                            <h5 class="title">Add User</h5>
                                        </div>
                                        <div class="content">
                                            <div class="header"><h5>Course Convenor</h5></div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for=""><font color="black">Email</font></label>
                                                    <input type="email" class="form-control" style="border: solid 1px black">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for=""><font color="black">Staff #</font></label>
                                                    <input type="text" class="form-control" style="border: solid 1px black">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for=""><font color="black">Course</font></label>
                                                    <select class="form-control" style="border: solid 1px black">
                                                        <option selected>CSC1016S</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3" style="text-align: center">
                                                    <p>&nbsp;</p>
                                                    <button class="btn btn-danger btn-xl">Add</button> </div>
                                            </div>
                                            <div class="row">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{--<div class="wrapper">
    <div class="main-panel">
        <div class="row" style="background-color: whitesmoke">
            <div class="card">
                <div class="col-md-12">
                    / <a href="">Admin</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="header" style="border-bottom: 1px solid black">
                                <h5 class="title">Add User</h5>
                            </div>
                            <div class="content">
                                <div class="header"><h5>Course Convenor</h5></div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Email</font></label>
                                        <input type="email" class="form-control" style="border: solid 1px black">
                                    </div>
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Staff #</font></label>
                                        <input type="text" class="form-control" style="border: solid 1px black">
                                    </div>
                                    <div class="col-md-3">
                                        <label for=""><font color="black">Course</font></label>
                                        <select class="form-control" style="border: solid 1px black">
                                            <option selected>CSC1016S</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="text-align: center">
                                        <p>&nbsp;</p>
                                        <button class="btn btn-danger btn-xl">Add</button> </div>
                                </div>
                                <div class="row">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="header" style="border-bottom: solid 1px black">
                                <h5 class="title">Approve Accounts</h5>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-control-label" for="course_code">Filter by Student Number</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input class="form-control" style="border: solid 1px black" placeholder="<none>">
                                            </div>
                                            <div class="col-md-3">
                                                <button id="search_btn_table" class="btn btn-danger btn-xl">Search</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div id="table_results_div" class="row">
                                    <div class="row" style="text-align: right">
                                        <div class="col-md-12">
                                            <button id="search_btn_table" class="btn btn-danger btn-xl">Approve</button>
                                        </div>
                                    </div>
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
                                            <th>Approve</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>John</td>
                                            <td>Doe</td>
                                            <td>1234567</td>
                                            <td>john@example.com</td>
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Another</td>
                                            <td>Doe</td>
                                            <td>1234567</td>
                                            <td>another@example.com</td>
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Other</td>
                                            <td>Doe</td>
                                            <td>1234567</td>
                                            <td>other@example.com</td>
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox">
                                                </div>
                                            </td>
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
        @include('include.dashboard.footer')
    </div>
</div>--}}
@endsection
