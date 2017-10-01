@extends('include_home.main')
@section('page_title')
    Faculties
@endsection
@section('sidebar')
    @include('include_home.sys_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/systemadmin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-home"></i>&nbsp;Faculties & Departments</h4>
            </a>
        </li>
    </ul>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="row">

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel" style="height: auto;">
                        <div class="x_title">
                            <h2>Add Department Admin</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: none;">
                            <div class="row">
                                {{csrf_field()}}
                                <div class="col-md-3">
                                    <label for="">Faculty*:</label>
                                    <select id="deptAdminFacultyDropdown" class="form-control">
                                        <option value="-1"></option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{$faculty['id']}}">{{$faculty['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Department*:</label>
                                    <select id="deptAdminDepartmentDropdown" class="form-control">
                                        <option value="-1"></option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Email*:</label>
                                    <input type="email" id="deptAdminEmailAddress" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label><br>
                                    <button type="button" id="addDepartmentAdminButton" class="btn btn-dark btn-round spinnerNeeded">
                                        <i class="spinnerPlaceholder"></i>
                                        <i class="fa fa-plus"></i>
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel" style="height: auto;">
                        <div class="x_title">
                            <h2>Create Faculty</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Name*:</label>
                                    <input type="text" class="form-control" id="createFacultyName">
                                </div>
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label><br>
                                    <button id="createFacultyButton" type="button" class="btn btn-dark btn-round spinnerNeeded">
                                        <i class="spinnerPlaceholder"></i>
                                        <i class="fa fa-plus"></i>
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel" style="height: auto;">
                        <div class="x_title">
                            <h2>Create Department</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Faculty*:</label>
                                    <select id="createDepartmentFacultyDropdown" class="form-control">
                                        <option value="-1"></option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{$faculty['id']}}">{{$faculty['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Name*:</label>
                                    <input type="text" class="form-control" id="createDepartmentName">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Code*:</label>
                                    <input type="text" class="form-control" id="createDepartmentCode">
                                </div>
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label><br>
                                    <button id="createDepartmentButton" type="button" class="btn btn-dark btn-round spinnerNeeded">
                                        <i class="spinnerPlaceholder"></i>
                                        <i class="fa fa-plus"></i>
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel" style="height: auto;">
                        <div class="x_title">
                            <h2>View/Edit Faculties</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: none;">
                            <div class="row">
                                <i><h5>Admin Features to be determined and added here
                                    </h5></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel" style="height: auto;">
                        <div class="x_title">
                            <h2>View/Edit Departments</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: none;">
                            <div class="row">
                                <i><h5>Admin Features to be determined and added here
                                    </h5></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

            $('#createDepartmentButton').click(function(){
                var name = $('#createDepartmentName').val();
                var code = $('#createDepartmentCode').val();
                var facultyId = $('#createDepartmentFacultyDropdown').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/adddepartment',
                    data:{
                        name: name,
                        code: code,
                        facultyId: facultyId
                    },
                    success:function (data) {
                        successOperation(thisElement);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                });
            });

            $('#createFacultyButton').click(function(){
                var name = $('#createFacultyName').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/addfaculty',
                    data:{
                        facultyName:name
                    },
                    success:function (data) {
                        successOperation(thisElement);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                });
            });

            $('#addDepartmentAdminButton').click(function(){
                var departmentId = $('#deptAdminDepartmentDropdown').val();
                var email = $('#deptAdminEmailAddress').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/adddepartmentadmin',
                    data:{
                        departmentId: departmentId,
                        email:email
                    },
                    success: function(data){
                        successOperation(thisElement);
                    },
                    error: function(data){
                        failOperation(thisElement);
                    }
                })
            });

            function successOperation(element){
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-check-circle"></i>');
            }

            function failOperation(element){
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-times-circle"></i>');
            }

            $('.spinnerNeeded').click(function(){
                $(this).children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-spinner fa-spin"></i>');

            });

            $('#deptAdminFacultyDropdown').change(function(){
                var departmentsDropdown = $('#deptAdminDepartmentDropdown');
                departmentsDropdown.empty();
                var facultyId = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '/getdepartments',
                    data: {
                        facultyId: facultyId
                    },
                    success:function(data){
                        var option = document.createElement('option');
                        option.value=-1;
                        option.text = "";
                        departmentsDropdown.append(option);

                        for(var i = 0; i < data.length; i++){
                            var option = document.createElement('option');
                            option.value = data[i].id;
                            option.text = data[i].name;
                            departmentsDropdown.append(option);
                        }
                    }
                });
            });
        });
    </script>
    
@endsection