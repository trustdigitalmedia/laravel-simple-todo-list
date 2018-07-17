@extends('layouts.app')

@section('title', 'Task')

@section('content')
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#all-task">All Tasks</a></li>
        <li><a data-toggle="tab" href="#my-task">My Tasks</a></li>
        <li><a data-toggle="tab" href="#assigned-task">Assigned Tasks</a></li>
        <li><a data-toggle="tab" href="#task-group">Task Group</a></li>
    </ul>

    <div class="tab-content">
        <div id="all-task" class="tab-pane fade in active">
            <h3>All Tasks</h3>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>SL#</th>
                        <th>name</th>
                        <th>status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->name }}</td>
                        @if($task->status == 'processing')
                            <td class="bg-info">Processing</td>
                        @elseif($task->status == 'complete')
                            <td class="bg-success">Complete</td>
                        @elseif($task->status == 'cancel')
                            <td class="bg-danger">Cancel</td>
                        @else
                            <td class="bg-warning">Pending</td>
                        @endif

                        <td>{{ Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ url('task/' . $task->id) }}" class="btn btn-sm btn-default" title="View task"><i class="fa fa-eye"></i> </a>
                            @if($task->user_id == Session::get('user.id'))
                                <a href="{{ url('task/' . $task->id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit task"><i class="fa fa-pencil"></i> </a>
                                <a href="{{ url('task/' . $task->id . '/assign') }}" class="btn btn-sm btn-info" title="Assign task"><i class="fa fa-user-plus"></i> </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="my-task" class="tab-pane fade">
            <h3>My Tasks</h3>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>SL#</th>
                        <th>name</th>
                        <th>status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        @if($task->user_id == Session::get('user.id'))
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->name }}</td>
                                @if($task->status == 'processing')
                                    <td class="bg-info">Processing</td>
                                @elseif($task->status == 'complete')
                                    <td class="bg-success">Complete</td>
                                @elseif($task->status == 'cancel')
                                    <td class="bg-danger">Cancel</td>
                                @else
                                    <td class="bg-warning">Pending</td>
                                @endif
                                <td>{{ Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ url('task/' . $task->id) }}" class="btn btn-sm btn-default" title="View task"><i class="fa fa-eye"></i> </a>
                                    <a href="{{ url('task/' . $task->id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit task"><i class="fa fa-pencil"></i> </a>
                                    <a href="{{ url('task/' . $task->id . '/assign') }}" class="btn btn-sm btn-info" title="Assign task"><i class="fa fa-user-plus"></i> </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="assigned-task" class="tab-pane fade">
            <h3>Assigned Tasks</h3>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>SL#</th>
                        <th>name</th>
                        <th>status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        @if($task->assign_id == Session::get('user.id'))
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->name }}</td>
                                @if($task->status == 'processing')
                                    <td class="bg-info">Processing</td>
                                @elseif($task->status == 'complete')
                                    <td class="bg-success">Complete</td>
                                @elseif($task->status == 'cancel')
                                    <td class="bg-danger">Cancel</td>
                                @else
                                    <td class="bg-warning">Pending</td>
                                @endif
                                <td>{{ Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ url('task/' . $task->id) }}" class="btn btn-sm btn-default" title="View task"><i class="fa fa-eye"></i> </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="task-group" class="tab-pane fade">
            <h3>Task Group</h3>
            <div class="table-responsive">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>SL#</th>
                        <th>name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasksGroup as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ url('task/group/' . $item->id) }}" class="btn btn-sm btn-default" title="View task"><i class="fa fa-eye"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ url('task/group/create') }}" title="Create Task Group" class="btn btn-info pull-right"><i class="fa fa-plus"></i></a>
            <div class="clearfix"></div>
        </div>
    </div>
    <hr/>
    <a href="{{ url('task/create') }}" title="Create Task" class="btn btn-primary pull-right"><i class="fa fa-plus"></i></a>
@endsection