@extends('include_home.common_sidebar')
@section('sidebar_content')
    <ul class="nav side-menu">
        @if(Auth::check())
        <li>
            <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
        </li>
        @endif
    </ul>
@endsection