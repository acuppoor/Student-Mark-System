@extends('include_home.main')
@section('page_title')
    FAQs
@endsection
@section('sidebar')
    @include('include_home.FAQ_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{route("home")}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="glyphicon glyphicon-question-sign"></i>&nbsp;FAQs</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
            @php ($count = 1)
            @foreach(\App\FAQuestion::all() as $faq)
                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{$count++}}.  {{$faq->question}}</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" style="display: none">
                                {{$faq->answer}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

{{--
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FAQs - Mark System--}}
{{--{{ config('app.name', 'Mark System') }}--}}{{--
</title>

    @include('include.default.bootstrap')
</head>
<body id="page-top">
<div id="main_div" class="masthead">
    @include('include.default.nav_2')
    <div class="container" style="padding-top: 10%">
        @php ($count = 1)
        @foreach(\App\FAQuestion::all() as $faq)
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <div class="panel panel-default" style="opacity: 0.9">
                        <div class="panel-heading">
                            <div class="section-heading">
                                <h2>{{$count++}}.  {{$faq->question}}</h2>
                                <hr>
                            </div>
                        </div>
                        <div class="panel-body">
                            {{$faq->answer}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@include('include.default.footer')
@include('include.default.scripts')
</body>
</html>--}}
