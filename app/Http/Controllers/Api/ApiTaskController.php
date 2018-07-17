<?php

namespace App\Http\Controllers\Api;

use App\Task;
use App\TaskAssign;
use App\TaskGroup;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;

class ApiTaskController extends Controller
{
	public function task(){

		$tasks = DB::table('tasks')
		    ->select('tasks.id', 'tasks.name', 'tasks.status', 'tasks.created_at', 'u.id as user_id', 'u.name as user_name',  'users.id as assign_id', 'users.name as assign_name')
			->leftJoin('users as u', 'tasks.user_id', '=', 'u.id')
			->leftJoin('task_assigns', 'task_assigns.task_id', '=', 'tasks.id')
			->leftJoin('users', 'task_assigns.user_id', '=', 'users.id')
			->orderBy('tasks.id', 'desc')
			->where('tasks.user_id', Auth::user()->id)
			->orWhere('task_assigns.user_id', Auth::user()->id)
			->get();
		return response()->json(['success'=> $tasks], 200);
	}
	public function createTask(Request $request){
		$request->request->add(['user_id' => Auth::user()->id]);
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:100',
			'description' => 'max:1000000'
		]);
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}


		$task = Task::create($request->all());

		return response()->json(['success'=> 'Task Created'], 200);

	}
	public function taskGroup(){
		$tasksGroup = TaskGroup::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
		return response()->json(['success'=> $tasksGroup], 200);
	}
	public function view($id){
		$task = DB::table('tasks')
		           ->select('tasks.id', 'tasks.name', 'tasks.description', 'tasks.status', 'tasks.created_at', 'u.id as user_id', 'u.name as user_name',  'users.id as assign_id', 'users.name as assign_name')
		           ->leftJoin('users as u', 'tasks.user_id', '=', 'u.id')
		           ->leftJoin('task_assigns', 'task_assigns.task_id', '=', 'tasks.id')
		           ->leftJoin('users', 'task_assigns.user_id', '=', 'users.id')
		           ->orderBy('tasks.id', 'desc')
		           ->where('tasks.id', $id)
		           ->where('tasks.user_id', Auth::user()->id)
		           ->orWhere('task_assigns.user_id', Auth::user()->id)
		           ->first();
		return response()->json($task, 200);
	}
	public function update($id, Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:100',
			'description' => 'max:1000000'
		]);
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}

		$task = Task::find($id);
		if(!empty($task) && $task->user_id == Auth::user()->id){
			$task->update(['name' => $request->name, 'description' => $request->description]);
			return response()->json(['success'=> 'Task Updated'], 200);
		}

		return response()->json(['error' => 'Error!'], 401);
	}
	public function assigned($id, Request $request){
		$validator = Validator::make($request->all(), [
			'assign_by' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}

		$task = Task::find($id);
		$taskAssign = TaskAssign::where('task_id', $id)->where('user_id', $request->assign_by)->first();
		if(!empty($task) && empty($taskAssign)){
			TaskAssign::create(['task_id' => $id, 'user_id' => $request->assign_by]);
			return response()->json(['success'=> 'Task Updated'], 200);
		}

		return response()->json(['error' => 'Error!'], 401);
	}
	public function users(){
		$users = User::whereNotIn('id', [Auth::user()->id])->get();
		return response()->json($users, 401);
	}
	public function myTask(){
		$tasks = Task::where('user_id', Auth::user()->id)->get();
		return response()->json($tasks, 401);
	}

	public function groupStore(Request $request){
		$request->request->add(['user_id' => Auth::user()->id]);
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:100',
			'description' => 'max:1000000',
			'tasks' => 'required|max:1000000'
		]);
		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}


		$taskGroup = TaskGroup::create($request->all());

		return response()->json(['success'=> 'Task Group Created'], 200);

	}
	public function viewGroup($id){
		$taskGroup = TaskGroup::where('user_id', Auth::user()->id)->find($id);
		$tasks = Task::whereIn('id', json_decode($taskGroup->tasks))->get();
		$taskName = [];
		foreach($tasks as $task){
			$taskName[] =  ['id' => $task->id, 'name' => $task->name];
		}
		$newTaskGroup = [
			'id' => $taskGroup->id,
			'name' => $taskGroup->name,
			'description' => $taskGroup->description,
			'created_at' => $taskGroup->created_at,
			'tasks' => $taskName

		];

		return response()->json($newTaskGroup, 200);
	}

	public function cancel($id){

		$task = Task::find($id);
		if(!empty($task)){
			$task->update(['status' => 'cancel']);
			return response()->json(['success'=> 'Task Canceled'], 200);
		}

		return response()->json(['error' => 'Error!'], 401);
	}
	public function complete($id){

		$task = Task::find($id);
		if(!empty($task)){
			$task->update(['status' => 'complete']);
			return response()->json(['success'=> 'Task Complete'], 200);
		}

		return response()->json(['error' => 'Error!'], 401);
	}
	public function processing($id){

		$task = Task::find($id);
		if(!empty($task)){
			$task->update(['status' => 'processing']);
			return response()->json(['success'=> 'Task Processing'], 200);
		}

		return response()->json(['error' => 'Error!'], 401);
	}



}
