<!DOCTYPE html>
<html lang="en">
<head>
    <title>Todo list | @yield('title') </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div id="loading-area" class="text-center" style="display: none; position: fixed; width: 100%; height: 100%; z-index: 999; background-color: rgba(100, 100, 100, 1);"><i class="fa fa-spinner fa-spin" style="font-size:70px;padding: 20%"></i></div>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Todo List</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right" id="navbar-auth">
                @if (Session::has('user.id') && Session::has('user.token'))
                    <li><a href="{{ url('/profile') }}" >{{ session()->get('user.name') }}</a></li>
                    <li><a href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @else
                    <li><a href="{{ url('register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                    <li><a href="{{ url('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if (Session::has('success_msg'))
    <div class="alert alert-success" align="center" id="success-alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success_msg') }}
    </div>
@elseif(Session::has('warning_msg'))
    <div class="alert alert-warning" align="center" id="warning-alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('warning_msg') }}
    </div>
@endif


<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading lead text-center">
                    @yield('title')
                </div>
                <div class="panel-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<script> var baseURL = "{{ url('/') }}";</script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
