@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        <li>
            <a href="{{url('/student')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        <li>
            <a href="{{url('/student/mymarks')}}"><i class="fa fa-building-o"></i> My Marks</a>
        </li>
    </ul>
@endsection