<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Cookie\CookieJar as Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
        if (Auth::once($credentials)) {
            
            if(Auth::user()->tokens->count() > 4){
                Auth::user()->tokens->last()->delete();
            }
            
            $success = $this->formatUser(Auth::user());
            $success['token'] = Auth::user()->createToken('powershare_token')->accessToken;

            /*
                Set user last login time to this login
            */
            Auth::user()->last_login = Carbon::now();
            Auth::user()->save();

            return response()->json($success);
        }

        return response()->json(['errors' => ['Unauthorised']], 401);
    }

    /**
     * Method to register user via Api.
     * Takes request which should have valid @name, @email and @password.
     * Conditions are checked by validator class.
     * Upon successful registration we give user an access token.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 412);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $answer= $this->formatUser($user);
        $answer["role_id"] = 2;
        $answer['token'] = $user->createToken('powershare_token')->accessToken;

        return response()->json($answer);
    }

    public function logout(Request $request){
        if(Auth::user() && Auth::user()->token()){
            Auth::user()->token()->revoke();
            Auth::user()->token()->delete();
            return response()->json('Logged out successfuly');
        }

        return response()->json(["errors" => ["Couldn't Log out, Access Token missing"]], 401);
    }

    public function logoutFromAll(){
        if(Auth::user() && Auth::user()->tokens){
            Auth::user()->tokens->each(function ($token, $key){
              $token->delete();
            });

            return response()->json('Logged out successfuly');
        }
        return response()->json(["errors" => ["Couldn't Log out, Access Token missing"]], 401);
    }

    public function details()
    {
        return response()->json(Auth::user());
    }

    private function formatUser($user)
    {
        $user_object["id"] = $user->id;
        $user_object["name"] = $user->name;
        $user_object["email"] = $user->email;
        $user_object["role_id"] = $user->role_id;
        return $user_object;
    }
}
