<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page_title') - Mark System</title>

    @include('bootstrap.dashboard')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
    @yield('sidebar')
    @include('include_home.topnav')

    @yield('content')
        <footer style="background-color: whitesmoke">
            <div class="container-fluid">
                <div class="pull-left">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{route('FAQs')}}">
                                FAQs
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{route('privacy_policy')}}">
                                Privacy Policy
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{route('terms_and_conditions')}}">
                                Terms and Conditions
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="copyright pull-right pull-down">
                    &copy; <script>document.write(new Date().getFullYear())</script>, <a target="_blank" href="http://www.uct.ac.za">UCT</a>
                </div>
            </div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

@include('scripts.dashboard')
@yield('scripts')
</body>
</html>