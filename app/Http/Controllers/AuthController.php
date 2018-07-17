<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Session;

class AuthController extends Controller
{
	public function login(Request $request){
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required'
		]);

	    $response = Curl::to(url('api/login'))
		                ->withData( [ 'email' => $request->email, 'password' => $request->password] )
	                    ->post();
	    $result = json_decode($response);


	    if(isset($result->success->id) && isset($result->success->token)){
		    $request->session()->flush('user');
		    $request->session()->put('user', ['id' => $result->success->id, 'name' => $result->success->name, 'token' => $result->success->token]);

		    Session::flash('success_msg', 'Login Successfully!');

		    return redirect('/');
	    }
	    elseif (isset($result->error)){

		    Session::flash('warning_msg', 'Error!');

		    return redirect('login')
			    ->withErrors(['error' => $result->error])
			    ->withInput();
	    }
	    else{

		    Session::flash('warning_msg', 'Error!');
		    return redirect('login')
			    ->withErrors(['error' => 'error'])
			    ->withInput();
	    }
	}
	public function logout(Request $request){
		$request->session()->flush('user');

		Session::flash('success_msg', 'Logout successfully!');
		return redirect('/login');
	}
	public function register(Request $request){
		$this->validate($request, [
			'name' => 'required|max:100',
			'email' => 'required|email|max:100',
			'password' => 'required',
			'conf_password' => 'required|same:password',
		]);

		$response = Curl::to(url('api/register'))
		                ->withData( [
		                	'name' => $request->name,
			                'email' => $request->email,
			                'password' => $request->password,
			                'conf_password' => $request->conf_password
		                ] )
		                ->post();
		$result = json_decode($response);

		if(isset($result->success->id) && isset($result->success->token)){
			$request->session()->flush('user');
			$request->session()->put('user', ['id' => $result->success->id, 'name' => $result->success->name, 'token' => $result->success->token]);

			Session::flash('success_msg', 'Register Successfully!');

			return redirect('/');
		}
		elseif (isset($result->error)){

			Session::flash('warning_msg', 'Error!');

			return redirect('register')
				->withErrors(['error' => $result->error])
				->withInput();
		}
		else{

			Session::flash('warning_msg', 'Error!');
			return redirect('register')
				->withErrors(['error' => 'error'])
				->withInput();
		}

	}
}
