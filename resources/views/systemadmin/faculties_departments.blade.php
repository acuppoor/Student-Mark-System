@extends('layouts.dashboard.main')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="wrapper">
    {{--    @include('include.dashboard.sidepanel')--}}


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
