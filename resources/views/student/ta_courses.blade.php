@extends('include_home.main')
@section('page_title')
    TA Courses
@endsection
@section('sidebar')
    @include('include_home.student_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/teachingassistant/ta_courses')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-book"></i>&nbsp;TA Courses</h4>
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
                            <form action="/tacourses" method="POST">
                                {{ csrf_field() }}
                                <div class="col-md-2 form-group pull-left top_search">
                                    <label for="courseCode">Course Code:</label>
                                    <div class="input-group">
                                        <input type="text" id="courseCode" name="courseCode" class="form-control" placeholder="Course Code"
                                               value="{{request('courseCode')}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="coursetype">Type:</label>
                                    <select class="form-control" id="courseType" name="courseType">
                                        <option {{request('courseType')?'':'selected'}}></option>
                                        @foreach(\App\CourseType::all() as $courseType)
                                            <option {{request('courseType') == $courseType->name? 'selected':''}}><?=$courseType->name?></option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="year_dropdown">Year:</label>
                                    <select class="form-control" id="courseYear" name="courseYear">
                                        <option {{request('courseYear')?'':'selected'}}><?php echo(date("Y"));?></option>
                                        @php
                                            $currentYear = (int) date("Y");
                                            for ($i = $currentYear-1; $i >= 2015; $i--){
                                                echo('<option '.(request('courseYear') == $i?'selected':'').'>'.$i.'</option>');
                                            }
                                        @endphp
                                    </select>
                                    <input type="hidden" id="courseYearInput" value="{{request('courseYear')}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="department">Department:</label>
                                    <select id="department" class="form-control" id="courseDepartment" name="courseDepartment">
                                        <option {{request('courseDepartment')?'':'selected'}}></option>
                                        @foreach(\App\Department::all() as $department)
                                            @php($value = $department->code . " - " . $department->name)
                                            <option {{request('courseDepartment')==$value?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="courseDepartmentInput" value="{{request('courseDepartment')}}">
                                </div>
                                <div class="col-md-3 form-group pull-left top_search">
                                    <label>&nbsp;</label><br>
                                    <button class="btn btn-round btn-dark" id="searchButton"><i class="fa fa-search"></i>Search</button>
                                    <a href="{{route('ta_courses')}}">Reset Results</a>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            @php ($courseCount = count($courses))
            <h4>Results: {{$courseCount <= 0? 'None Found!':''}}</h4>
            @for($i = 0; $i < $courseCount; $i+=2)
                <div class="row">
                    @for($j = $i; $j < ($i+2<=$courseCount? $i+2 : $courseCount); $j++)
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <a href="{{url('/tacourses/'.$courses[$j]['id'])}}"><h2><u>{{($j+1) . '. ' . $courses[$j]['code']. ' (' . $courses[$j]['year'] .')'}}</u></h2></a>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content collapse">
                                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td scope="row">Name: </td>
                                                    <td><strong>{{$courses[$j]['name']}}</strong></td>
                                                    <td>&nbsp;|&nbsp;</td>
                                                    <td scope="row">Code: </td>
                                                    <td><strong>{{$courses[$j]['code']}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Description: </td>
                                                    <td colspan="4"><strong>{{$courses[$j]['description']}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Type: </td>
                                                    <td><strong>{{$courses[$j]['type']}}</strong></td>
                                                    <td>&nbsp;|&nbsp;</td>
                                                    <td scope="row">Term Number: </td>
                                                    <td><strong>{{$courses[$j]['term_number']}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Start: </td>
                                                    <td><strong>{{$courses[$j]['start_date']}}</strong></td>
                                                    <td>&nbsp;|&nbsp;</td>
                                                    <td scope="row">End: </td>
                                                    <td><strong>{{$courses[$j]['end_date']}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td scope="row">Department: </td>
                                                    <td><strong>{{$courses[$j]['department']}}</strong></td>
                                                    <td>&nbsp;|&nbsp;</td>
                                                    <td scope="row">Faculty: </td>
                                                    <td><strong>{{$courses[$j]['faculty']}}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*var courseCode = $('#courseCode').val();
        var courseType = $('#courseType').val();
        var courseYear = $('#courseYear').val();
        var courseDepartment = $('#courseDepartment').val();
        var token = $('#_token').val();

        $(document).ready(function(){
            $('#searchButton').click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'tacourses/filter',
                    data: {
                        _token: token,
                        courseCode: courseCode,
                        courseType: courseType,
                        courseYear: courseYear,
                        courseDepartment: courseDepartment
                    },
                    success: function (data) {
                        loadContent(data);
                    }
                });
            });

            function loadContent(data){
                console.log(data);
            }
        });*/
    </script>
@endsection