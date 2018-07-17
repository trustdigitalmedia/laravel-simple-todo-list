<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Session;

class TaskController extends Controller
{
	public function create(Request $request){
		$this->validate($request, [
			'name' => 'required|max:100',
			'description' => 'max:1000000'
		]);

		$response = Curl::to(url('api/task/create'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->withData( [
			                'name' => $request->name,
			                'description' => $request->description
		                ] )
		                ->post();

		$result = json_decode($response);

		if(isset($result->success)){

			Session::flash('success_msg', 'Task Created!');

			return redirect('task');
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('task/create')
				->withErrors(['error' => $result->error])
				->withInput();
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('task/create')
				->withErrors(['error' => 'error'])
				->withInput();
		}
	}
	public function view($id){
		$response = Curl::to(url('api/task/' . $id))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();

		$task = json_decode($response);

		return view('task.view', compact('task'));
	}
	public function edit($id){
		$response = Curl::to(url('api/task/' . $id))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();

		$task = json_decode($response);

		return view('task.edit', compact('task'));
	}
	public function update($id, Request $request){
		$this->validate($request, [
			'name' => 'required|max:100',
			'description' => 'max:1000000'
		]);

		$response = Curl::to(url('api/task/' . $id . '/update'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->withData( [
			                'name' => $request->name,
			                'description' => $request->description
		                ] )
		                ->post();

		$result = json_decode($response);

		if(isset($result->success)){

			Session::flash('success_msg', 'Task Updated!');

			return redirect('task');
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('task/' . $id .'/edit')
				->withErrors(['error' => $result->error])
				->withInput();
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('task/' . $id .'/edit')
				->withErrors(['error' => 'error'])
				->withInput();
		}
	}
	public function assign($id){
		$response = Curl::to(url('api/task/' . $id))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();

		$task = json_decode($response);

		$response = Curl::to(url('api/users'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();

		$users = json_decode($response);

		return view('task.assign', compact('task', 'users'));
	}
	public function assigned($id, Request $request){
		$this->validate($request, [
			'assign_by' => 'required'
		]);

		$response = Curl::to(url('api/task/' . $id . '/assigned'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
						->withData( [
							'assign_by' => $request->assign_by
						] )
						->post();
		$result = json_decode($response);


		if(isset($result->success)){

			Session::flash('success_msg', 'Task Assigned!');

			return redirect('task');
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('task/' . $id .'/assign')
				->withErrors(['error' => $result->error])
				->withInput();
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('task/' . $id .'/assign')
				->withErrors(['error' => 'error'])
				->withInput();
		}
	}
	public function createGroup(){
		$response = Curl::to(url('api/task/my'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();

		$tasks = json_decode($response);

		return view('task.group.create', compact('tasks'));
	}
	public function storeGroup(Request $request){
		$this->validate($request, [
			'name' => 'required|max:100',
			'description' => 'max:1000000',
			'tasks' => 'required|max:1000000'
		]);

		$response = Curl::to(url('api/task/group/store'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->withData( [
			                'name' => $request->name,
			                'description' => $request->description,
			                'tasks' => json_encode($request->tasks)
		                ] )
		                ->post();

		$result = json_decode($response);

		if(isset($result->success)){

			Session::flash('success_msg', 'Task Group Created!');

			return redirect('task');
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('task/group/create')
				->withErrors(['error' => $result->error])
				->withInput();
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('task/group/create')
				->withErrors(['error' => 'error'])
				->withInput();
		}
	}
	public function viewGroup($id){
		$response = Curl::to(url('api/task/group/' . $id))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();

		$taskGroup = json_decode($response);

		return view('task.group.view', compact('taskGroup'));
	}

	public function cancel($id){

		$response = Curl::to(url('api/task/' . $id . '/cancel'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->post();

		$result = json_decode($response);

		if(isset($result->success)){

			Session::flash('success_msg', 'Task Canceled!');

			return redirect('task/' . $id);
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('task/' . $id);
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('task/' . $id);
		}
	}

	public function complete($id){

		$response = Curl::to(url('api/task/' . $id . '/complete'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->post();

		$result = json_decode($response);

		if(isset($result->success)){

			Session::flash('success_msg', 'Task Completed!');

			return redirect('task/' . $id);
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('task/' . $id);
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('task/' . $id);
		}
	}

	public function processing($id){

		$response = Curl::to(url('api/task/' . $id . '/processing'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->post();

		$result = json_decode($response);

		if(isset($result->success)){

			Session::flash('success_msg', 'Task Processing!');

			return redirect('task/' . $id);
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('task/' . $id);
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('task/' . $id);
		}
	}

}
