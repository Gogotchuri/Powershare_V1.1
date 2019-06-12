<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(){
        //TODO create user resource and handle pagination on both end
        $users = User::all();
        return self::responseData($users);
    }

    public function destroy($user_id){
        $user = User::where("id", $user_id)->first();
        if($user == null)
            return self::responseErrors("User not found!", 404);
        $user->delete();
        return self::responseData("User Deleted successfully!", 200);
    }
}
