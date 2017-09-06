@extends('layouts.dashboard.main')

@section('title')
    My Marks
@endsection

@section('nav_title')
    View Marks
@endsection

@section('content')
<div class="wrapper">
{{--    @include('include.dashboard.sidepanel')--}}

    <div class="sidebar" data-background-color="black" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="/" class="simple-text">
                    <img src="{{url('images/uct.png')}}" style="width: 50px; height: 50px">
                    &nbsp;
                    Mark System
                </a>
            </div>
            <ul class="nav">
                <li class="active">
                    <a href="/student">
                        <i class="ti-panel"></i>
                        <p>My Marks</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @include('include.dashboard.marksbody')
</div>
@endsection
