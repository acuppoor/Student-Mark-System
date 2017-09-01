@extends('layouts.default.app')

@section('title')
    Register
@endSection

@section('content')
<div class="container" style="padding-top: 5%">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="panel panel-default" style="opacity: 0.9">
                <div class="panel-heading">
                    <div class="section-heading text-center">
                        <h2>Register</h2>
                        <hr>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div>
                            <div style="float: left" class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                                <div style="width:100%; text-align: left">
                                    <label for="firstName" class="col-md-6 form-control-label">First Name</label>
                                </div>
                                <div class="col-md-12" style="width: 100%">
                                    <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required autofocus>

                                    @if ($errors->has('firstName'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div style="float: right" class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                                <div style="width:100%; text-align: left">
                                    <label for="lastName" class="col-md-6 form-control-label">Last Name</label>
                                </div>
                                <div class="col-md-12" style="width: 100%">
                                    <input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus>

                                    @if ($errors->has('lastName'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div>
                            <div style="float: left" class="form-group{{ $errors->has('studentNumber') ? ' has-error' : '' }}">
                                <div style="width:100%; text-align: left">
                                    <label for="studentNumber" class="col-md-10 form-control-label">Student/Staff Number</label>
                                </div>
                                <div class="col-md-12" style="width: 100%">
                                    <input id="studentNumber" type="text" class="form-control" name="studentNumber" value="{{ old('studentNumber') }}" required autofocus>
                                </div>
                            </div>

                            <div style="float: right" class="form-group{{ $errors->has('employeID') ? ' has-error' : '' }}">
                                <div style="width:100%; text-align: left">
                                    <label for="employeeID" class="col-md-10 form-control-label">Employee ID</label>
                                </div>
                                <div class="col-md-12" style="width: 100%">
                                    <input id="employeeID" type="text" class="form-control" name="employeeID" value="{{ old('employeeID') }}" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div>
                            @if ($errors->has('studentNumber'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('studentNumber') }}</strong>
                                        </span>
                            @endif

                            @if ($errors->has('employeeID'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('employeeID') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div style="width:100%; text-align: left">
                                <label for="email" class="col-md-4 form-control-label">E-Mail Address</label>
                            </div>
                            <div class="col-md-12" style="width: 100%">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div style="width:100%; text-align: left">
                                <label for="password" class="col-md-4 form-control-label">Password</label>
                            </div>
                            <div class="col-md-12" style="width: 100%">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div style="width:100%; text-align: left">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            </div>
                            <div class="col-md-12" style="width: 100%">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div {{--class="col-md-6 col-md-offset-4"--}} style="text-align: center">
                                <button type="submit" class="btn btn-primary btn-outline btn-xl">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="thankyouModal" tabindex="1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Thank you for pre-registering!</h4>
            </div>
            <div class="modal-body">
                <p>Thanks for getting in touch!</p>
            </div>
        </div>
    </div>
</div>

@endsection
