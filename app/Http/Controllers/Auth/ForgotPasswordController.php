<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetEmail(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }


    protected function sendResetLinkResponse(Request $request, $response)
    {
        return self::responseData("Reset email has been sent successfully");
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return self::responseErrors("Can't send password reset link to this email!", 400);

    }
}
