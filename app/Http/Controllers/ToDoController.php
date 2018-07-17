<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Session;

class ToDoController extends Controller
{
	public function index(){
		$response = Curl::to(url('api/task'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();
		$result = json_decode($response);

		$tasks = $result->success;

		$response = Curl::to(url('api/task/group'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
		                ->get();
		$result = json_decode($response);
		$tasksGroup = $result->success;

		return view('dashboard', compact('tasks', 'tasksGroup'));
    }
    public function profile(){
	    $response = Curl::to(url('api/profile'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
	                    ->get();
	    $user = json_decode($response);

	    return view('profile', compact('user'));
    }
    public function changePassword(Request $request){
	    $this->validate($request, [
		    'password' => 'required',
		    'new_password' => 'required',
		    'conf_password' => 'required|same:new_password',
	    ]);

	    $response = Curl::to(url('api/change-password'))
		                ->withHeader('Authorization: Bearer ' . Session::get('user.token'))
	                    ->withData( [
		                    'password' => $request->password,
		                    'new_password' => $request->new_password,
		                    'conf_password' => $request->conf_password
	                    ] )
	                    ->post();

	    $result = json_decode($response);

	    if(isset($result->success)){

		    Session::flash('success_msg', 'Password change Successfully!');

		    return redirect('profile');
	    }
	    elseif (isset($result->error)){

		    Session::flash('warning_msg', 'Old Password does not match!');

		    return redirect('profile/change-password')
			    ->withErrors(['error' => $result->error])
			    ->withInput();
	    }
	    else{

		    Session::flash('warning_msg', 'Error!');
		    return redirect('profile/change-password')
			    ->withErrors(['error' => 'error'])
			    ->withInput();
	    }
    }

}
