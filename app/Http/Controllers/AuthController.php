<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
        Method to authenticate user via Api and give away password grant token;
        Request should have valid @email and @password of existing user;
        Method removes first access token after 4 token has been issued from user
        At maximum, every user can have 5 access tokens.
    */
    public function login(Request $request){
        
        $credentials = [
            'email' => $request->email, 
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            
            if(Auth::user()->tokens->count() > 4){
                Auth::user()->tokens->last()->delete();
            }
            
            $success = $this->getUser(Auth::user());
            $success['token'] = Auth::user()->createToken('powershare_token')->accessToken;

            return response()->json($success);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    /**
        Method to register user via Api.
        Takes request which should have valid @name, @email and @password.
        Conditions are checked by validator class.
        Upon successful registration we give user an access token.
    */
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
        $answer= $this->getUser($user);
        $answer['token'] = $user->createToken('powershare_token')->accessToken;

        return response()->json($answer);
    }

    public function logout(){
        Auth::user()->token()->delete();

        return response()->json('Logged out successfuly');
    }

    public function logoutFromAll(){
        Auth::user()->tokens->each(function ($token, $key){
            $token->delete();
        });

        return response()->json('Logged out successfuly');
    }

    public function details()
    {
        return response()->json(Auth::user());
    }

    private function getUser($user)
    {
        $user_object["id"] = $user->id;
        $user_object["name"] = $user->name;
        $user_object["email"] = $user->email;
        return $user_object;
    }
}
