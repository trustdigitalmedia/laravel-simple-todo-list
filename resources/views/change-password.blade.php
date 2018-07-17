@extends('layouts.app')

@section('title', 'Change Password')

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
    <form action="{{ url('/profile/change-password') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Old Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter old password" name="password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <hr/>
        <div class="form-group {{ $errors->has('new_password') ? ' has-error' : '' }}">
            <label for="new_password">New Password:</label>
            <input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password" required>
            @if ($errors->has('new_password'))
                <span class="help-block">
                    <strong>{{ $errors->first('new_password') }}</strong>
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