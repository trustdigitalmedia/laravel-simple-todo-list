<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class APIAuthController extends Controller
{
	public function login(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|max:100',
			'password' => 'required|max:100'
		]);

		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}

		if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
			$user = Auth::user();
			$success['token'] =  $user->createToken('MyApp')->accessToken;
			$success['name'] =  $user->name;
			$success['id'] =  $user->id;

			return response()->json(['success' => $success], 200);
		}
		else{
			return response()->json(['error'=>'Unauthorised'], 401);
		}
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:100',
			'email' => 'required|email|max:100',
			'password' => 'required',
			'conf_password' => 'required|same:password',
		]);

		if ($validator->fails()) {
			return response()->json(['error'=>$validator->errors()], 401);
		}

		$input = $request->all();
		$input['password'] = Hash::make($input['password']);
		$input['remember_token'] = bcrypt(str_random(10));
		$user = User::create($input);
		$success['token'] =  $user->createToken('MyApp')->accessToken;
		$success['name'] =  $user->name;
		$success['id'] =  $user->id;
		return response()->json(['success'=>$success], 200);
	}
}
