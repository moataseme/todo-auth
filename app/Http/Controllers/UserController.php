<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request){
        $validated = Validator::make($request->only(['name', 'email', 'password', 'password_confirmation']), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3:max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ], [
            'name.regex' => 'Name accepts characters and spaces only',
        ]);
        
        $status = true;
        $data = [];
        $errors = [];

        if ($validated->fails()) {
            $status = false;
            $errors = $validated->errors();

        }else{
            $user = User::make($validated->validated());
            $user->password = Hash::make($validated->safe()->only(['password'])['password']);
            $user->save();
        }

        $response = array(
            'status' => $status,
            'data' => $data,
            'errors' => $errors
        );

        return response()->json($response);
    }

    public function login(Request $request){
        $validated = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $status = true;
        $data = [];
        $errors = [];

         if ($validated->fails()) {
            $status = false;
            $errors = $validated->errors();

        }else{
            $user = User::where('email', $validated->safe()->only(['email'])['email'])->first();

            if (!$user || !Hash::check($validated->safe()->only(['password'])['password'], $user->password)) {
                $status = false;
                $errors = array(array('Invalid email or password'));
                $response = array(
                    'status' => $status,
                    'data' => $data,
                    'errors' => $errors
                );
                
                return response()->json($response);
            }
            $token = $user->createToken('token_name');
            $data = ['token' => $token->plainTextToken];
        }

        $response = array(
            'status' => $status,
            'data' => $data,
            'errors' => $errors
        );

        return response()->json($response);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
    }
}
