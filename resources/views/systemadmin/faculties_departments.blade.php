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
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Name</th>
                                        <th class="column-title"> &nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php($count = 1)
                                        @foreach($faculties as $faculty)
                                            <tr><td>{{$count++}}</td>
                                                <td>
                                                    <input type="text" class="form-control" id="facultyNameInput{{str_replace(' ', '', $faculty['name'])}}" value="{{$faculty['name']}}">
                                                </td>
                                                <td>
                                                    <button type="button" data-facultyname="facultyNameInput{{str_replace(' ', '', $faculty['name'])}}" data-facultyid="{{$faculty['id']}}" class="btn btn-dark btn-round saveFacultyButton spinnerNeeded">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-save"></i>
                                                        Save
                                                    </button>
                                                    <button type="button" data-facultyid="{{$faculty['id']}}" class="btn btn-dark btn-round deleteFacultyButton spinnerNeeded">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-trash"></i>
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">#</th>
                                        <th class="column-title">Faculty*:</th>
                                        <th class="column-title">Department Name*:</th>
                                        <th class="column-title">Department Code*:</th>
                                        <th class="column-title">Department Admins:</th>
                                        <th class="column-title">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($count = 1)
                                    @foreach($faculties as $faculty)
                                        @foreach($faculty['depts'] as $department)
                                            <tr><td>{{$count++}}</td>
                                                <td>
                                                    <select class="form-control" id="departmentInfoFaculty{{str_replace(' ', '', $department['name'])}}">
                                                        @foreach($faculties as $f)
                                                            <option value="{{$f['id']}}" {{$f['id']==$faculty['id']?'selected':''}}>{{$f['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="departmentInfoName{{str_replace(' ', '', $department['name'])}}" value="{{$department['name']}}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="departmentInfoCode{{str_replace(' ', '', $department['name'])}}" value="{{$department['code']}}">
                                                </td>
                                                <td>
                                                    <ol>
                                                        @foreach($department['admins'] as $admin)
                                                            <li>{{$admin->email}} ( <input type="checkbox" class="removeDeptAdmin{{str_replace(' ', '', $department['name'])}}" data-departmentid="{{$department['id']}}" data-userid="{{$admin->id}}"> Remove )</li>
                                                        @endforeach
                                                    </ol>
                                                </td>
                                                <td>
                                                    <button type="button" data-departmentname="{{str_replace(' ', '', $department['name'])}}" data-departmentid="{{$department['id']}}" class="btn btn-dark btn-round saveDepartmentButton spinnerNeeded">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-save"></i>
                                                        Save
                                                    </button>
                                                    <button type="button" data-departmentid="{{$department['id']}}" class="btn btn-dark btn-round deleteDepartmentButton spinnerNeeded">
                                                        <i class="spinnerPlaceholder"></i>
                                                        <i class="fa fa-trash"></i>
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                        @endforeach

                                    @endforeach
                                    </tbody>
                                </table>
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

            $('.deleteDepartmentButton').click(function(){
                var departmentId = $(this).data('departmentid');
                var thisElement = $(this);
                var confirmation = confirm('Are you sure you want to delete the department? All its' +
                    ' courses will be deleted!');
                if(!confirmation){
                    nullOperation(thisElement);
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '/deletedepartment',
                    data:{
                        departmentId: departmentId
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                });
            });

            $('.saveDepartmentButton').click(function(){
                var departmentName = $(this).data('departmentname');
                var departmentId = $(this).data('departmentid');

                var newName = document.getElementById('departmentInfoName'+departmentName).value;
                var facultyId = document.getElementById('departmentInfoFaculty'+departmentName).value;
                var code = document.getElementById('departmentInfoCode'+departmentName).value;
                var userIds = [];
                var count = 0;

                var checkboxes = document.getElementsByClassName('removeDeptAdmin'+departmentName);
                for(var i = 0; i < checkboxes.length; i++){
                    if (checkboxes[i].checked){
                        userIds[count++] = checkboxes[i].getAttribute('data-userid');
                    }
                }

                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/updatedepartment',
                    data:{
                        facultyId: facultyId,
                        departmentId: departmentId,
                        name: newName,
                        code: code,
                        userIds: userIds
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                });
            });

            $('.deleteFacultyButton').click(function(){
                var facultyId = $(this).data('facultyid');
                var thisElement = $(this);
                var confirmation = confirm('Are you sure you want to delete the faculty? All its' +
                    ' departments and courses will be deleted!');
                if(!confirmation){
                    nullOperation(thisElement);
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '/deletefaculty',
                    data:{
                        facultyId: facultyId
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                });
            });

            $('.saveFacultyButton').click(function(){
                var facultyName = $(this).data('facultyname');
                var facultyId = $(this).data('facultyid');
                var newName = document.getElementById(facultyName).value;
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/updatefaculty',
                    data:{
                        facultyId: facultyId,
                        name: newName
                    },
                    success: function (data) {
                        successOperation(thisElement);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                });
            });

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

            function nullOperation(element){
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder"></i>');
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