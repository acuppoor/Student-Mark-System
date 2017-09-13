@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{route('my_marks')}}"><i class="fa fa-building-o"></i> My Marks</a>
        </li>
        @if(Auth::user()->role_id == 2)
            <li>
                <a href="{{route('ta_courses')}}"><i class="fa fa-book"></i> TA Courses</a>
            </li>
            <li>
                <a href="{{route('search_marks')}}"><i class="fa fa-search"></i> Search Marks</a>
            </li>
        @endif
    </ul>
@endsection