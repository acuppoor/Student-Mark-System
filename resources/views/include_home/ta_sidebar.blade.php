@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{url('/teachingassistant')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{url('/teachingassistant/marks')}}"><i class="fa fa-building-o"></i> My Marks</a>
        </li>
        <li>
            <a href="{{url('/teachingassistant/ta_courses')}}"><i class="fa fa-book"></i> TA Courses</a>
        </li>
        <li>
            <a href="{{url('/teachingassistant/search')}}"><i class="fa fa-search"></i> Search Marks</a>
        </li>
    </ul>
@endsection