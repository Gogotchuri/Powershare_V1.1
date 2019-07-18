<?php

namespace App\Http\Controllers\Auth;

use App\Models\SocialAuth;
use App\Models\User;
use App\Traits\TokenResponses;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    use AuthenticatesUsers, TokenResponses;

    public function __construct()
    {
        config([
            "services.facebook.redirect" => route("oauth.callback", "facebook"),
            "services.google.redirect" => route("oauth.callback", "google"),
        ]);
    }


    /**
     * Send redirect url as the json response
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider)
    {
        return self::responseData(
            [
                "url" => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()
            ]
        );
    }

    public function handleCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $user = $this->findOrCreateUser($provider, $user);
        $resp = $this->tokenAndUser($user);
        return view('auth.OauthCallback', $resp);
    }

    private function findOrCreateUser($provider, $user)
    {
        $socialAuth = SocialAuth::where('provider', $provider)
            ->where('provider_user_id', $user->getId())
            ->first();

        if ($socialAuth) {
            $socialAuth->update([
                'access_token' => $user->token,
            ]);
            return $socialAuth->user;
        }

        return $this->createUser($provider, $user);
    }

    /**
     * @param $provider
     * @param \Laravel\Socialite\Contracts\User $sUser
     * @return User
     */
    private function createUser($provider, $sUser)
    {
        $user = new User();
        $user->name = $sUser->getName();
        $user->email = $sUser->getEmail();
        $user->email_verified_at = Carbon::now();
        $user->save();

        $socialAuth = new SocialAuth();
        $socialAuth->user_id = $user->id;
        $socialAuth->provider = $provider;
        $socialAuth->provider_user_id = $sUser->getId();
        $socialAuth->token = $sUser->token;
        $socialAuth->save();

        return $user;


    }
}
