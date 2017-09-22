@extends('include_home.main')
@section('page_title')
    My Marks
@endsection
@section('sidebar')
    @include('include_home.student_sidebar')
@endsection

@section('navbar_title')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/student')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-building-o"></i>&nbsp;My Marks</h4>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <form action="#" method="">
                                {{ csrf_field() }}
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <div class="col-md-2 form-group pull-left top_search">
                                    <label for="courseCode">Course Code:</label>
                                    <div class="input-group">
                                        <input type="text" id="courseCode" class="form-control" placeholder="Course Code">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="coursetype">Type:</label>
                                    <select class="form-control" id="courseType">
                                        <option></option>
                                        @foreach(\App\CourseType::all() as $courseType)
                                            <option><?=$courseType->name?></option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="year_dropdown">Year:</label>
                                    <select class="form-control" id="courseYear">
                                        <option selected><?php echo(date("Y"));?></option>
                                        <?php
                                            $currentYear = (int) date("Y");
                                            for ($i = $currentYear-1; $i >= 2015; $i--){
                                                echo('<option>'.$i.'</option>');
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="department">Department:</label>
                                    <select id="department" class="form-control" id="department">
                                        <option></option>
                                        @foreach(\App\Department::all() as $department)
                                            <option><?=$department->code . " - " . $department->name?></option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group pull-left top_search">
                                    <p>&nbsp;</p>
                                    <button class="btn btn-round btn-dark" type="submit" id="searchButton">Search</button>
                                    <a href="">Reset Results</a>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <h4>Results:</h4>
            @php ($courseCount = count($courses))
            <?php
//                print_r($courses); die();
            ?>
            @php ($counter = 0)
            @for($i = 0; $i < $courseCount; $i+=2)
                <div class="row">
                    @for($j = $i; $j < ($i+2<=$courseCount? $i+2 : $courseCount); $j++)
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><?=($j+1) . '. ' . $courses[$j]['courseName']. ' (' . $courses[$j]['year'] .')'?></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content collapse">
                                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                        @php ($courseworks = $courses[$j]['courseworks'])

                                        <div class="panel">
                                            <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <h4 class="panel-title">Final Mark</h4>
                                            </a>
                                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <h3>Result: 84</h3>
                                                    <br>
                                                    <h5>Marks Breakdown:</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Marks</th>
                                                            <th>Out Of</th>
                                                            <th>Weighting</th>
                                                            <th>Weighted Marks</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td scope="row">Class Record</td>
                                                            <td>80</td>
                                                            <td>100</td>
                                                            <td>50</td>
                                                            <td>40</td>
                                                        </tr>
                                                        <tr>
                                                            <td scope="row">Exam</td>
                                                            <td>70</td>
                                                            <td>80</td>
                                                            <td>50</td>
                                                            <td>43.8</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel">
                                            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <h4 class="panel-title">DP Status</h4>
                                            </a>
                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <h3>Result: DP</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel">
                                            <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <h4 class="panel-title">Class Record</h4>
                                            </a>
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <h3>Result: <?=$courses[$j]['classrecord']?></h3>
                                                    <br>
                                                    <h5>Marks Breakdown:</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Marks</th>
                                                            <th>Out Of</th>
                                                            <th>Weighting</th>
                                                            <th>Weighted Marks</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($courseworks as $key=>$coursework)
                                                            <tr>
                                                                <td scope="row"><?=$coursework['name']?></td>
                                                                <td><?=$coursework['total']?></td>
                                                                <td>100</td>
                                                                <td><?=$coursework['weighting']?></td>
                                                                <td><?=$coursework['weighted_marks']?></td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach($courseworks as $key=>$coursework)
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingFour<?=$key?>" data-toggle="collapse" data-parent="#accordion" href="#collapseFour<?=$key?>" aria-expanded="false" aria-controls="collapseFour<?=$key?>">
                                                    <h4 class="panel-title"><?=$coursework['name']?></h4>
                                                </a>
                                                <div id="collapseFour<?=$key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour<?=$key?>" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <h3>Result: <?=$coursework['total']?></h3>
                                                        <br>
                                                        <h5>Marks Breakdown:</h5>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Marks</th>
                                                                <th>Out Of</th>
                                                                <th>Weighting</th>
                                                                <th>Weighted Marks</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($coursework['contents'] as $subcoursework)
                                                                    <tr>
                                                                        <td scope="row"><?=$subcoursework['name']?></td>
                                                                        <td><?=$subcoursework['marks']?></td>
                                                                        <td><?=$subcoursework['max_marks']?></td>
                                                                        <td><?=$subcoursework['weighting']?></td>
                                                                        <td><?=$subcoursework['weighted_marks']?></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
{{--    <script src="{{asset('gentelella/vendors/jquery/dist/jquery.min.js')}}"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function(){
            $('#searchButton').click(function(){
                var courseCode = $('#courseCode').val();
                var courseType = $('#courseType').val();
                var courseYear = $('#courseYear').val();
                var courseDepartment = $('#department').val();
                var token = $('#_token').val();

                $.ajax({
                    type: 'POST',
                    url: 'mymarks/xyz',
                    data: {
                        _token: token,
                        courseCode: courseCode,
                        courseType: courseType,
                        courseYear: courseYear,
                        courseDepartment: courseDepartment
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });

            });
        });
    </script>

@endsection