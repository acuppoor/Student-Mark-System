@extends('layouts.app')

@section('title')
    Contact
@endSection

@section('content')
<div class="container" style="padding-top: 5%;">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="panel panel-default" style="opacity: 0.9">
                <div class="panel-heading">
                    <div class="section-heading text-center">
                        <h2>Contact Us</h2>
                        <hr>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div>
                            <ul class="nav nav-pills nav-tabs justify-content-center">
                                <li  class="nav-item">
                                    <label id="new_email" class="nav-link active">Enter New Email Address</label>
                                </li>
                                <li class="nav-item">
                                    <label id="existing_email" class="nav-link">Use Account Email Address</label>
                                </li>
                            </ul>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 form-control-label">E-Mail</label>
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="col-md-4 form-control-label">Subject</label>

                            <div class="col-md-12">
                                <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject') }}" required autofocus>

                                @if ($errors->has('subject'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 form-control-label">Message</label>

                            <div class="col-md-12">
                                <textarea id="message" rows="6" type="text" class="form-control" name="message" value="{{ old('message') }}" required autofocus></textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first(message) }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div {{--class="col-md-8 col-md-offset-4"--}} style="text-align: center">
                                <button type="submit" class="btn btn-primary btn-outline btn-xl">{{--btn btn-primary">--}}
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('mybootstrap2/js/ContactForm.js')}}"></script>
@endsection
