@extends('layouts.default.app')

@section('title')
    Login
@endSection

@section('content')
<div class="container" style="padding-top: 12%">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="panel panel-default" style="opacity: 0.9">
                <div class="panel-heading">
                    <div class="section-heading text-center">
                        <h2>Login</h2>
                        <hr>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="col-md-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 form-control-label">E-Mail Address</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 form-control-label">Password</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div {{--class="col-md-8 col-md-offset-4"--}} style="text-align: center">
                                <button type="submit" class="btn btn-primary btn-outline btn-xl">{{--btn btn-primary">--}}
                                    Login
                                </button>
                                {{--<a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                </a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
</div>
@endsection
