@extends('include_home.main')
@section('page_title')
    Admin
@endsection
@section('sidebar')
    @include('include_home.sys_admin_sidebar')
@endsection

@section('navbar_title')
    <ul class="nav navbar-nav navbar-left">
        <li class="">
            <a href="{{url('/systemadmin/admin')}}" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <h4><i class="fa fa-cogs"></i>&nbsp;Admin</h4>
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
                            <h2>Reset Password</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: block;">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Email*:</label>
                                    <input type="email" class="form-control" id="emailAddressPwdReset">
                                </div>
                                <div class="col-md-3">
                                    <label for="">New Password*:</label>
                                    <input type="password" class="form-control" id="passwordPwdReset">
                                </div>
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label><br>
                                    <button class="btn btn-dark btn-round spinnerNeeded" id="resetButtonPwdReset" type="button">
                                        <i class="spinnerPlaceholder"></i>
                                        Reset
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
                            <h2>Approve Account</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content collapse" style="display: block;">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Email*:</label>
                                    <input type="email" class="form-control" id="emailAddressApprove">
                                </div>
                                <div class="col-md-3">
                                    <label for="">&nbsp;</label><br>
                                    <button class="btn btn-dark btn-round spinnerNeeded" id="approveAccountButton" type="button">
                                        <i class="spinnerPlaceholder"></i>
                                        <i class="fa fa-check-square-o"></i>
                                        Approve
                                    </button>
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

            $('#approveAccountButton').click(function () {
                var email = $('#emailAddressApprove').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/approveaccount',
                    data: {
                        email: email
                    },
                    success: function (data) {
                        successOperation(thisElement, false);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                })
            });

            $('#resetButtonPwdReset').click(function () {
                var email = $('#emailAddressPwdReset').val();
                var password = $('#passwordPwdReset').val();
                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/resetpassword',
                    data: {
                        email: email,
                        password: password
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