@extends('include_home.main')
@section('page_title')
    Access Denied
@endsection
@section('sidebar')
    @include('include_home.student_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="glyphicon glyphicon-ban-circle"></i>&nbsp;Access Denied</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12">
                <div class="col-middle">
                    <div class="text-center text-center">
                        <h1 class="error-number">403</h1>
                        <h2>Access denied/Bad Operation</h2>
                        <p>You don't have permission to access this page or the operation does not exist!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
