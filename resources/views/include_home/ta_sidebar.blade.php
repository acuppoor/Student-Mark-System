@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{url('/home')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{url('/mymarks')}}"><i class="fa fa-building-o"></i> My Marks</a>
        </li>
        <li>
            <a href="{{url('/tacourses')}}"><i class="fa fa-book"></i> TA Courses</a>
        </li>
        <li>
            <a href="{{url('/searchmarks')}}"><i class="fa fa-search"></i> Search Marks</a>
        </li>
    </ul>
@endsection