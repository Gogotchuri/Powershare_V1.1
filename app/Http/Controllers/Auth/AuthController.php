<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Entity\UserResource;
use App\Traits\TokenResponses;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    use TokenResponses;

    /**
     * Method to authenticate user via Api and give away password grant token;
     * Request should have valid @email and @password of existing user;
     * Method removes first access token after 4 token has been issued from user
     * At maximum, every user can have 5 access tokens.
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){
        
        $credentials = [
            "email" => $request["email"],
            "password" => $request["password"]
        ];

        $user = User::where("email", $credentials["email"])->first();
        if(!isset($user))
            return self::responseErrors("Wrong email", 401);

        if(!Hash::check($request["password"], $user->password))
            return self::responseErrors("Wrong password", 401);

        $data = $this->tokenAndUser($user);

        if(auth()->user()->tokens->count() > 4)
            auth()->user()->tokens->last()->delete();

        $user->last_login = Carbon::now();
        $user->save();

        return self::responseData($data, 200);
    }

    /**
     * Method to register user via Api.
     * Takes request which should have valid
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request){
        $input = [
            "email" => $request["email"],
            "name" => $request["name"],
            "password" => Hash::make($request["password"]),
        ];

        $user = User::create($input);
        event(new Registered($user));
        $answer = $this->tokenAndUser($user);
        $answer["role_id"] = 2;
        return self::responseData($answer, 201);
    }

    public function logout(){
        if(auth()->user() && auth()->user()->token()){
            auth()->user()->token()->revoke();
            auth()->user()->token()->delete();
            event(new Logout('api', auth()->user()));
            return self::responseData("Logged out successfully");
        }

        return self::responseErrors("Couldn't Log out, Access Token missing", 401);
    }

    public function logoutFromAll(){
        if(auth()->user() && count(auth()->user()->tokens) > 0){
            auth()->user()->tokens->each(function ($token, $key){
                $token->revoke();
                $token->delete();
            });
            return self::responseData("Logged out successfully");
        }
        return self::responseErrors("Couldn't Log out, Access Token missing", 401);
    }

    public function details()
    {
        if(auth()->user())
            return self::responseData((new UserResource(auth()->user()))->toArray(null));
        else
            return self::responseErrors("Couldn't get details, Access Token missing", 401);
    }

    public function checkAdmin(){
        if(auth()->user()->is_admin)
            return self::responseData("User is an admin! let him through!");
        return self::responseErrors("User isn't an admin", 401);
    }

}
