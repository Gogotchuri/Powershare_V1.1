<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        
        $credentials = [
            'email' => $request->email, 
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $success['token'] = Auth::user()->createToken('powershare_token')->accessToken;

            return response()->json(['success' => $success]);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('powershare_token')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success' => $success]);
    }

    public function logout(){
        Auth::user()->tokens->each(function ($token, $key){
            $token->delete();
        });

        return response()->json('Logged out successfuly');
    }

    public function details()
    {
        return response()->json(['success' => Auth::user()]);
    }
}
