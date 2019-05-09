<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
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

    use ResetsPasswords;
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

    //Sending part!
    public function sendResetEmail(Request $request)
    {
        $this->sendResetLinkEmail($request);
    }


    protected function sendResetLinkResponse(Request $request, $response)
    {
        return self::responseData("Reset email has been sent successfully");
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return self::responseErrors("Can't send password reset link to this email!", 400);

    }

    //Reset part
    public function callReset(Request $request)
    {
        return $this->reset($request);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();

        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return self::responseData("Password reset was a success!");
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return self::responseErrors("Bad Token! try again...", 401);
    }
}
