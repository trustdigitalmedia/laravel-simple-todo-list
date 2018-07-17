@extends('layouts.app')

@section('title', 'Task | Group | ' . $taskGroup->id)

@section('content')
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
            <tr>
                <th>Name</th>
                <th>{{ $taskGroup->name }}<th>
            </tr>
            <tr>
                <th>Description</th>
                <th>{{ $taskGroup->description }}<th>
            </tr>
            <tr>
                <th>Tasks</th>
                <th>
                @foreach($taskGroup->tasks as $task)
                        <a href="{{ url('task/' . $task->id) }}">{{ $task->name }}</a>,
                @endforeach
                <th>
            </tr>
            </thead>
        </table>
    </div>
@endsection