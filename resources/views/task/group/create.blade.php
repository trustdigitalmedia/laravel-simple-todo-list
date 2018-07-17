@extends('layouts.app')

@section('title', 'Create Task Group')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

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
    <form action="{{ url('/task/group') }}" method="post">
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
        <div class="form-group {{ $errors->has('tasks') ? ' has-error' : '' }}">
            <label for="tasks">Assign:</label>
            <select class="form-control" id="tasks" placeholder="Select Tasks" multiple="multiple" name="tasks[]" required>
                <option value="">Select Task</option>
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}" >{{ $task->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('tasks'))
                <span class="help-block">
                    <strong>{{ $errors->first('tasks') }}</strong>
                </span>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('script')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('#tasks').select2({
                'placeholder': 'Select task',
                maximumSelectionLength: 100
            });
        });
    </script>
@endsection