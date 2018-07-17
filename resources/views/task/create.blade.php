@extends('layouts.app')

@section('title', 'Create Task')

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
    <form action="{{ url('/task/create') }}" method="post">
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
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" placeholder="Enter description" name="description"></textarea>
            @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection