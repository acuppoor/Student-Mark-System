@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{url('/courseconvenor')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{url('/courseconvenor/convening_courses')}}"><i class="fa fa-book"></i> Convening Courses</a>
        </li>
        <li>
            <a href="{{url('/courseconvenor/other_courses')}}"><i class="fa fa-book"></i> Other Courses</a>
        </li>
        <li>
            <a href="{{url('/courseconvenor/search')}}"><i class="fa fa-search"></i> Search Marks</a>
        </li>
    </ul>
@endsection