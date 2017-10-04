@extends('include_home.main')
@section('page_title')
    Profile
@endsection
@section('sidebar')
    @include('include_home.dept_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/home')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-user"></i>&nbsp;Profile</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    @include('include_home.profile_body')
@endsection

@section('scripts')
    @include('include_home.profile_js');
@endsection