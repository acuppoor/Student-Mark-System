@extends('include_home.main')
@section('page_title')
    FAQs
@endsection
{{--@section('sidebar')
    @include('include_home.student_sidebar')
@endsection--}}

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
            @foreach(\App\FAQuestion::all() as $faq)
                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{$faq->question}}</h2>
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
