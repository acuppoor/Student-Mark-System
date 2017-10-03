@extends('include_home.main')
@section('page_title')
    Search Marks
@endsection
@section('sidebar')
    @include('include_home.student_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/teachingassistant')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-search"></i>&nbsp;Search Marks</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <form action="/searchmarks" method="POST">
                                {{ csrf_field() }}
                                <div class="col-md-3">
                                    <label for="fullname">Student/Employee Number *:</label>
                                        <input type="text" class="form-control" name="studentNumber" value="{{request('studentNumber')}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Course Code:</label>
                                        <input type="text" class="form-control" name="courseCode" value="{{request('courseCode')}}">
                                </div>
                                <div class="col-md-2">
                                    <label for="year_dropdown">Year:</label>
                                    <select class="form-control" name="courseYear">
                                        <?php
                                            $currentYear = (int) date("Y");
                                            for ($i = $currentYear; $i >= 2015; $i--){
                                                echo("<option ".(request("courseYear")==$i?"selected":"").">".$i."</option>");
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group pull-left top_search">
                                    <label>&nbsp;</label><br>
                                    <button class="btn btn-round btn-dark btn-xl" type="submit"><i class="fa fa-search"></i>Search</button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('include_home.searchmarksbody')
        </div>
    </div>
@endsection

@section('scripts')

@endsection