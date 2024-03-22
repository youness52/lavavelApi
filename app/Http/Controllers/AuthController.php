<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function save(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
		]);

		if($validator->fails()){
			return response()->json(['status' => false, 'error' => $validator->errors() ]);
		}else{
			
            $user= User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
			
            if($user){
                $token=$user->createToken('main')->plainTextToken;
				return response()->json(['status' => true,'user' =>$user,'token'=>$token, 'message' => 'user saved successfully!']);
			}
			
		}
	}

    public function login(Request $request){
		$validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
		]);

		if($validator->fails()){
			return response()->json(['status' => false, 'error' => $validator->errors() ]);
		}else{
			

            if(!Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])){
                return response()->json(['status' => false, 'message' => 'Email or password incorrect']);
            }

           $user=Auth::user();
			
            if($user){
                $token=$user->createToken('main')->plainTextToken;
				return response()->json(['status' => true,'user' =>$user,'token'=>$token, 'message' => 'user saved successfully!']);
			}
			
		}
	}
    public function logout(){
         $user=Auth::user();
         $user->currentAccessToken()->delete();
        //$request->user()->token()->revoke();
		return response()->json(['status' => true]);		
	}

}
