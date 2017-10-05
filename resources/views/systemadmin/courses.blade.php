@extends('include_home.main')
@section('page_title')
    Courses
@endsection
@section('sidebar')
    @include('include_home.sys_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{route("home")}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-book"></i>&nbsp;Courses</h4>
            </a>
        </li>
    </ul>
@endsection
@section('additional_nav_contents')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <li class="">
        <a>
            <button class="btn btn-dark btn-round" data-toggle="modal" data-target="#courseworkModal">
                <span class="glyphicon glyphicon-plus"></span>
                New Course
            </button>
        </a>
    </li>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="courseworkModal" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">New Course</h4>
                </div>
                <form method="" action="">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="courseName">Name*:</label>
                                <input type="text" id="courseName" class="form-control" name="courseName" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="courseCode">Course Code*:</label>
                                <input type="text" id="courseCode" class="form-control" name="courseCode" required="">
                            </div>

                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="courseType">Course Type* :</label>
                                <select id="courseType" class="form-control" required="">
                                    @foreach(\App\CourseType::all() as $type)
                                        <option value="{{$type->id}}" >{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Department*:</label>
                                <select id="createCourseDepartment" class="form-control" name="courseDepartment">
                                    <option {{request('courseDepartment')?'':'selected'}}></option>
                                    @foreach(\App\Department::all() as $department)
                                        @php($value = $department->code . " - " . $department->name)
                                        <option {{$department->id}} {{request('courseDepartment')==$value?'selected':''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="courseTerm">Term*:</label>
                                <input type="text" id="courseTerm" class="form-control" name="courseTerm" required="">
                            </div>

                            <div class="col-md-4">
                                <label for="courseStartDate">Start Date*:</label>
                                <input type="date" id="courseStartDate" class="date-picker form-control" value="{{date('Y-m-d')}}">
                            </div>
                            <div class="col-md-4">
                                <label for="courseEndDate">End Date:</label>
                                <input type="date" id="courseEndDate" class="date-picker form-control">
                            </div>
                        </div>
                        <br/>
                        <label for="courseDescription">Description:</label>
                        <textarea id="courseDescription" class="form-control" rows="3"></textarea>
                        <br>
                        <br/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-round spinnerNeeded" id="createCourseButton" type="button">
                            <i class="spinnerPlaceholder"></i>
                            Create
                        </button>
                        <button type="button" class="btn btn-default btn-round" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <form action="/courses" method="POST">
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
                                    <select class="form-control" id="courseDepartment" name="courseDepartment">
                                        <option {{request('courseDepartment')?'':'selected'}}></option>
                                        @foreach(\App\Department::all() as $department)
                                            @php($value = $department->code . " - " . $department->name)
                                            <option {{request('courseDepartment')==$value?'selected':''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="courseDepartmentInput" value="{{request('courseDepartment')}}">
                                </div>
                                <div class="col-md-3 form-group pull-left top_search">
                                    <label for="">&nbsp;</label><br>
                                    <button class="btn btn-round btn-dark" id="searchButton"><i class="fa fa-search"></i>Search</button>
                                    <a href="{{route('other_courses')}}">Reset Results</a>
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
                                    <a href="{{url('/admincourses/'.$courses[$j]['id'])}}"><h2><u>{{($j+1) . '. ' . $courses[$j]['code']. ' (' . $courses[$j]['year'] .')'}}</u></h2></a>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li>
                                            <button type='button' data-courseid="{{$courses[$j]['id']}}" class="deleteCourse btn btn-dark btn-round spinnerNeeded">
                                                <i class="spinnerPlaceholder"></i>
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </li>
                                        <li>&nbsp;</li>
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
        $(document).ready(function(){


            $('.deleteCourse').click(function(){
                var courseId = $(this).data('courseid');
                var thisElement = $(this);
                var confirmation = confirm('Are you sure you want to delete the course? All its courseworks, subcourseworks and ' +
                    'sections will be deleted permanently.');

                if(confirmation) {
                    $.ajax({
                        type: 'POST',
                        url: '/deletecourse',
                        data: {courseId: courseId},
                        success: function (data) {
                            successOperation(thisElement);
                        },
                        error: function (data) {
                            failOperation(thisElement);
                        }
                    });
                } else {
                    nullOperation(this);
                }
            });

            $('#createCourseButton').click(function(){
                var courseName = $('#courseName').val();
                var courseCode = $('#courseCode').val();
                var courseType = $('#courseType').val();
                var startDate = $('#courseStartDate').val();
                var endDate = $('#courseEndDate').val();
                var courseDescription = $('#courseDescription').val();
                var courseTerm = $('#courseTerm').val();
                var department = $('#createCourseDepartment').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/createcourse',
                    data: {
                        name: courseName,
                        code: courseCode,
                        type: courseType,
                        startDate: startDate,
                        endDate: endDate,
                        description: courseDescription,
                        term: courseTerm,
                        department: department
                    },
                    success: function (data) {
                        successOperation(thisElement, true);
                        $('#courseName').val('');
                        $('#courseCode').val('');
                        $('#courseStartDate').val("{{date('Y-m-d')}}");
                        $('#courseEndDate').val('');
                        $('#courseDescription').val('');
                        $('#courseTerm').val('');
                        $('#createCourseDepartment').val('');
                    },
                    error: function (data){
                        failOperation(thisElement);
                    }
                });
            });

            function successOperation(element){
                document.getElementById('reloadPageButton').style.display = 'block';
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-check-circle"></i>');
            }

            function failOperation(element){
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-times-circle"></i>');
            }

            function nullOperation(element){
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder"></i>');
            }

            $('.spinnerNeeded').click(function(){
                $(this).children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-spinner fa-spin"></i>');

            });
        });
    </script>

@endsection