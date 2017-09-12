@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{url('/lecturer')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{url('/lecturer/courses')}}"><i class="fa fa-book"></i> Courses</a>
        </li>
        <li>
            <a href="{{url('/lecturer/search')}}"><i class="fa fa-search"></i> Search Marks</a>
        </li>
    </ul>
@endsection