@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        @if(Auth::user()->role_id == 4)
            <li>
                <a href="{{route('convening_courses')}}"><i class="fa fa-book"></i> Convening Courses</a>
            </li>
        @endif
        <li>
            <a href="{{route('lecturer_courses')}}"><i class="fa fa-book"></i> Lecturing Courses</a>
        </li>
        <li>
            <a href="{{route('other_courses')}}"><i class="fa fa-book"></i> Other Courses</a>
        </li>
        <li>
            <a href="{{route('search_marks')}}"><i class="fa fa-search"></i> Search Marks</a>
        </li>
    </ul>
@endsection