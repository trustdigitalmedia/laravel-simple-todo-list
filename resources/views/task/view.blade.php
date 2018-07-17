@extends('layouts.app')

@section('title', 'Task | ' . $task->id)

@section('content')
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
            <tr>
                <th>
                    @if(($task->user_id == Session::get('user.id') || $task->assign_id == Session::get('user.id')) && $task->status != 'cancel' && $task->status != 'complete' )

                        <a href="#" onclick="event.preventDefault();document.getElementById('task-cancel-form').submit();" class="btn btn-sm btn-danger" title="Cancel task"><i class="fa fa-ban"></i> </a>
                        <form id="task-cancel-form" action="{{ url('task/' . $task->id . '/cancel') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        <a href="#" onclick="event.preventDefault();document.getElementById('task-processing-form').submit();" class="btn btn-sm btn-default" title="Processing task"><i class="fa fa-spinner fa-spin"></i> </a>
                        <form id="task-processing-form" action="{{ url('task/' . $task->id . '/processing') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        <a href="#" onclick="event.preventDefault();document.getElementById('task-complete-form').submit();" class="btn btn-sm btn-default" title="Complete task"><i class="fa fa-check"></i> </a>
                        <form id="task-complete-form" action="{{ url('task/' . $task->id . '/complete') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    @endif
                </th>
                <th >
                    @if($task->user_id == Session::get('user.id'))
                        <a href="{{ url('task/' . $task->id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit task"><i class="fa fa-pencil"></i> </a>
                        <a href="{{ url('task/' . $task->id . '/assign') }}" class="btn btn-sm btn-info" title="Assign task"><i class="fa fa-user-plus"></i> </a>
                    @endif

                <th>
            </tr>
            <tr>
                <th>Name</th>
                <th>{{ $task->name }}<th>
            </tr>
            <tr>
                <th>Description</th>
                <th>{{ $task->description }}<th>
            </tr>
            <tr>
                <th>Description</th>
                @if($task->status == 'processing')
                    <th class="bg-info">Processing</th>
                @elseif($task->status == 'complete')
                    <th class="bg-success">Complete</th>
                @elseif($task->status == 'cancel')
                    <th class="bg-danger">Cancel</th>
                @else
                    <th class="bg-warning">Pending</th>
                @endif
            </tr>
            </thead>
        </table>
    </div>
@endsection