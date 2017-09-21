@extends('include_home.main')
@section('page_title')
    Faculties
@endsection
@section('sidebar')
    @include('include_home.sys_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/systemadmin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-institution"></i>&nbsp;Faculties & Departments</h4>
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
                            <h2>Faculties</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <button class="btn btn-dark btn-round">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        New Faculty
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
                                                                            <a>Faculty of Science</a>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-md-7" style="text-align: right">
                                                                        <button class="btn btn-round btn-dark">
                                                                            <span class="fa fa-edit"></span>
                                                                            Edit
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
                                                                        <div class="col-md-1"></div>
                                                                        <div class="col-md-4">
                                                                            <h5>
                                                                                <label for="">Departments</label>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="col-md-7" style="text-align: right">
                                                                            <button class="btn btn-dark btn-round">
                                                                                <span class="glyphicon glyphicon-plus"></span>
                                                                                New Department
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
                                                                                                Computer Science
                                                                                            </h3>
                                                                                        </div>
                                                                                        <div class="col-md-7" style="text-align: right">
                                                                                            <button class="btn btn-round btn-dark">
                                                                                                <span class="fa fa-edit"></span>
                                                                                                Edit
                                                                                            </button>
                                                                                            <button class="btn btn-round btn-dark">
                                                                                                <span class="glyphicon glyphicon-trash"></span>
                                                                                                Delete
                                                                                            </button>
                                                                                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                                                        </div>

                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="row">
                                                                                        <div class="col-md-4">
                                                                                            <label for="">Dept Admin Email:</label>
                                                                                            <input type="email" class="form-control">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <p>&nbsp;</p>
                                                                                            <button class="btn btn-dark btn-round">Add</button>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        {{--<div class="col-md-2"></div>--}}
                                                                                        <div class="col-md-8">
                                                                                            <table class="table table-striped jambo_table bulk_action">
                                                                                                <thead>
                                                                                                <tr class="headings">
                                                                                                    <th>
                                                                                                        <div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>
                                                                                                    </th>
                                                                                                    <th class="column-title">First Name</th>
                                                                                                    <th class="column-title">Last Name</th>
                                                                                                    <th class="column-title">Email</th>
                                                                                                </tr>
                                                                                                </thead>

                                                                                                <tbody>
                                                                                                <tr class="even pointer">
                                                                                                    <td class="a-center ">
                                                                                                        <div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" id="check-all" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute"></ins></div>
                                                                                                    </td>
                                                                                                    <td class=" ">
                                                                                                        First
                                                                                                    </td>
                                                                                                    <td class=" ">
                                                                                                        DepartmentAdmin
                                                                                                    </td>
                                                                                                    <td class=" ">
                                                                                                        firstadmin@cs.uct.ac.za
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                    </div>
                                                                                    <button class="btn btn-dark btn-round">Remove Selected</button>
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
        </div>
    </div>

@endsection

{{--
@extends('layouts.dashboard.main')

@section('title')
    Faculties/Departments
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
                <li id="dashboard_tab">
                    <a href="/systemadmin">
                        <i class="ti-panel"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="active">
                    <a href="/systemadmin/facsanddepts">
                        <i class="ti-panel"></i>
                        <p>Faculties & Departments</p>
                    </a>
                </li>
                <li>
                    <a href="/systemadmin/departmentportal">
                        <i class="ti-panel"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li id="system_admin_tab">
                    <a href="/systemadmin/searchmarks">
                        <i class="ti-panel"></i>
                        <p>Search Marks</p>
                    </a>
                </li>
                <li id="system_admin_tab">
                    <a href="/systemadmin/admin">
                        <i class="ti-panel"></i>
                        <p>System Admin</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

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
                    <a class="navbar-brand" href="#">@yield('nav_title')</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                         <li>
                             <a href="">
                                 <p>+ Add Faculty</p>
                             </a>
                         </li>

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
                    / <a href="">Faculties & Departments</a>
                </div>
            </div>
        </div>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4>1. Faculty of Science</h4>
                            </div>
                            <div class="panel-wrapper collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel" style="border: solid 1px black">
                                                <div class="panel-heading">
                                                    <h5>Existing Departments</h5>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    1.
                                                                </td>
                                                                <td>
                                                                    Department of Computer Science
                                                                </td>
                                                                <td>
                                                                    <a href="">(Remove)</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    2.
                                                                </td>
                                                                <td>
                                                                    Department of Mathematics
                                                                </td>
                                                                <td>
                                                                    <a href="">(Remove)</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    3.
                                                                </td>
                                                                <td>
                                                                    Department of Physics
                                                                </td>
                                                                <td>
                                                                    <a href="">(Remove)</a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="panel" style="border: solid 1px black">
                                                <div class="panel-heading">
                                                    <h5>Add a Department</h5>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <label class="form-control-label" for="name">Name</label>
                                                        <input class="form-control" id="name" style="border: 1px solid black">
                                                        <br/>
                                                        <button type="submit" class="btn btn-danger btn-xl">Add Department</button>
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
</div>
@endsection
--}}
