@extends('layouts.app')

@section('title', 'Register')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger" align="center" id="error-alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul style="list-style-type: none;">
                @foreach ($errors->all() as $error)
                    <li >{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ url('/register') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('conf_password') ? ' has-error' : '' }}">
            <label for="conf_password">Confirm Password:</label>
            <input type="password" class="form-control" id="conf_password" placeholder="Enter confirm password" name="conf_password" required>
            @if ($errors->has('conf_password'))
                <span class="help-block">
                    <strong>{{ $errors->first('conf_password') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection