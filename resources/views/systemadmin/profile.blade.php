@extends('include_home.main')
@section('page_title')
    Profile
@endsection
@section('sidebar')
    @include('include_home.sys_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/systemadmin/admin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-user"></i>&nbsp;Profile</h4>
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
                    <div class="x_panel" style="height: auto;">
                        <div class="x_title">
                            <h2>Personal Details</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: block;">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">First Name*:</label>
                                        <input type="text" class="form-control" id="firstName">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Last Name*:</label>
                                        <input type="text" class="form-control" id="lastName">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Student/Staff Number*:</label>
                                        <input type="text" class="form-control" id="studentNumber">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Employee Id*:</label>
                                        <input type="text" class="form-control" id="employeeId">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Email*:</label>
                                        <input type="email" class="form-control" id="emailAddress">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Role*:</label>
                                        <input type="text" class="form-control" value="{{\App\Role::where('id', Auth::user()->role_id)->first()->role}}" disabled="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">&nbsp;</label><br>
                                        <button class="btn btn-dark btn-round spinnerNeeded" id="updateUserInfoButton" type="button">
                                            <i class="spinnerPlaceholder"></i>
                                            <i class="fa fa-save"></i>
                                            Save
                                        </button>
                                    </div>
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
                            <h2>Update Password</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="display: none;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Old Password*:</label>
                                        <input type="password" class="form-control" id="oldPassword">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">New Password*:</label>
                                        <input type="password" class="form-control" id="newPasswordOne">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">New Password Again*:</label>
                                        <input type="password" class="form-control" id="newPasswordTwo">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">&nbsp;</label><br>
                                        <button class="btn btn-dark btn-round spinnerNeeded" data-id="{{Auth::user()->id}}" id="updatePasswordButton" type="button">
                                            <i class="spinnerPlaceholder"></i>
                                            Update
                                        </button>
                                    </div>
                                </div>
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

        $(document).ready(function() {

            $('#updateUserInfoButton').click(function () {
                

                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/changepassword',
                    data: {
                        oldPassword: oldPassword,
                        newPasswordOne: newPasswordOne,
                        newPasswordTwo: newPasswordTwo,
                        userId: userId
                    },
                    success: function (data) {
                        successOperation(thisElement, false);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                })
            });
        $(document).ready(function() {

            $('#updatePasswordButton').click(function () {
                var oldPassword = $('#oldPassword').val();
                var newPasswordOne = $('#newPasswordOne').val();
                var newPasswordTwo = $('#newPasswordTwo').val();
                var userId = $(this).data('id');

                if(newPasswordOne != newPasswordTwo){
                    $('#newPasswordOne').val('');
                    $('#newPasswordTwo').val('');
                    alert('Passwords do not match. Please enter Again');
                    $('#newPasswordOne').focus();
                }

                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/changepassword',
                    data: {
                        oldPassword: oldPassword,
                        newPasswordOne: newPasswordOne,
                        newPasswordTwo: newPasswordTwo,
                        userId: userId
                    },
                    success: function (data) {
                        successOperation(thisElement, false);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                })
            });

            function successOperation(element, showReload) {
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-check-circle"></i>');
                if (showReload) {
                    document.getElementById('reloadPageButton').style.display = 'block';
                }
            }

            function failOperation(element) {
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-times-circle"></i>');
            }
        });


    </script>
@endsection