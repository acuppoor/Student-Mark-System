@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{url('/systemadmin')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{url('/systemadmin/faculties')}}"><i class="fa fa-institution"></i> Faculties & Depts</a>
        </li>
        <li>
            <a href="{{url('/systemadmin/courses')}}"><i class="fa fa-book"></i> Courses</a>
        </li>
        <li>
            <a href="{{url('/systemadmin/search')}}"><i class="fa fa-search"></i> Search Marks</a>
        </li>
        <li>
            <a href="{{url('/systemadmin/admin')}}"><i class="fa fa-cogs"></i> Admin</a>
        </li>
    </ul>
@endsection