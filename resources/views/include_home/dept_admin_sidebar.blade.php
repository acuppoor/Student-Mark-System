@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{route('other_courses')}}"><i class="fa fa-book"></i> Courses</a>
        </li>
        <li>
            <a href="{{route('search_marks')}}"><i class="fa fa-search"></i> Search Marks</a>
        </li>
        <li>
            <a href="{{route('admin')}}"><i class="fa fa-cogs"></i> Admin</a>
        </li>
    </ul>
@endsection