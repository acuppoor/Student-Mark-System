@extends('layout.main')

@section('title')
        Welcome
@endsection

@section('content')
    <div class="flex-center position-ref full-height">
        Welcome page!!!
        @if (Route::has('login'))
            <div class="top-right links">
                @if (Auth::check())
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                @endif
            </div>
        @endif
    </div>
@endsection