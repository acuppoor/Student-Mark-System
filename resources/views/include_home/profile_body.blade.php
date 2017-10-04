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
                                        <input type="text" class="form-control" id="firstName" value="{{Auth::user()->first_name}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Last Name*:</label>
                                        <input type="text" class="form-control" id="lastName" value="{{Auth::user()->last_name}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Student/Staff Number*:</label>
                                        <input type="text" class="form-control" id="studentNumber" value="{{Auth::user()->student_number}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Employee Id*:</label>
                                        <input type="text" class="form-control" id="employeeId" value="{{Auth::user()->employee_id}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Email*:</label>
                                        <input type="email" class="form-control" id="emailAddress" value="{{Auth::user()->email}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Role*:</label>
                                        <input type="text" class="form-control" value="{{\App\Role::where('id', Auth::user()->role_id)->first()->role}}" disabled="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center">
                                        <label for="">&nbsp;</label><br>
                                        <button class="btn btn-dark btn-round spinnerNeeded" data-id="{{Auth::user()->id}}" id="updateUserInfoButton" type="button">
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