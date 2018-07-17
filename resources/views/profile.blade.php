@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
            <tr>
                <th>Name</th>
                <th>{{ $user->name }}<th>
            </tr>
            <tr>
                <th>Email</th>
                <th>{{ $user->email }}<th>
            </tr>
            <tr>
                <th></th>
                <th ><a href="{{ url('profile/change-password') }}" class="btn btn-primary pull-right">Change Password</a><th>
            </tr>
            </thead>
        </table>
    </div>
@endsection