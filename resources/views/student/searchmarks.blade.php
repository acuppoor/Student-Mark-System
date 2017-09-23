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
                            <form action="/searchmarks/search" method="POST">
                                {{ csrf_field() }}
                                <div class="col-md-2 form-group">
                                    <label for="fullname">Student/Employee #:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="studentNumber" value="{{request('studentNumber')}}">
                                    </div>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="">Course Code:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="courseCode" value="{{request('courseCode')}}">
                                    </div>
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
                                    <p>&nbsp;</p>
                                    <button class="btn btn-round btn-dark btn-xl" type="submit">Search</button>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <h4>Results:</h4>
            @php ($courseCount = count($courses))
            @php ($counter = 0)
            @for($i = 0; $i < $courseCount; $i+=2)
                <div class="row">
                    @for($j = $i; $j < ($i+2<=$courseCount? $i+2 : $courseCount); $j++)
                        @php($counter++)
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><?=($j+1) . '. ' . $courses[$j]['code']. ' (' . $courses[$j]['year'] .')'?></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content collapse">
                                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            @endfor
        </div>
    </div>
@endsection

@section('scripts')

@endsection