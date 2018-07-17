<?php

namespace App\Http\Controllers\Api;

use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;


class APIToDoController extends Controller
{
    public function profile(){
    	return (Auth::user());
    }
    public function changePassword(Request $request){
	    $validator = Validator::make($request->all(), [
		    'password' => 'required',
		    'new_password' => 'required',
		    'conf_password' => 'required|same:new_password',
	    ]);

	    if ($validator->fails()) {
		    return response()->json(['error'=>$validator->errors()], 401);
	    }

	    $user = User::find(Auth::user()->id);
	    if(!empty($user)){
		    if(Hash::check($request->password, $user->password)){
			    $user->update(['password' => Hash::make($request->new_password)]);
			    return response()->json(['success' => 'password update successfully!'], 200);
		    }
		    return response()->json(['error'=>'Old password does not match'], 401);
	    }

	    return response()->json(['error'=>'Error!!'], 401);

    }
}
