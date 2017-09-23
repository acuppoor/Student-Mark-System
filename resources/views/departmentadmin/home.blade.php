@extends('include_home.main')
@section('page_title')
    Home
@endsection
@section('sidebar')
    @include('include_home.dept_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/departmentadmin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-home"></i>&nbsp;Home</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
        </div>
    </div>
@endsection