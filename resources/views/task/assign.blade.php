@extends('layouts.app')

@section('title', 'Task | ' . $task->id . ' | Assign')

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
    <form action="{{ url('/task/' . $task->id . '/assigned') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('assign_by') ? ' has-error' : '' }}">
            <label for="assign_by">Assign:</label>
            <select class="form-control" id="assign_by" placeholder="Select sser" name="assign_by" required>
                <option value="">Select Task</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ !empty(old('assign_by')) && old('assign_by') == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection