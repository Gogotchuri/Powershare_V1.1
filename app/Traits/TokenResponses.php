<?php

namespace App\Traits;

use App\Http\Resources\Entity\UserResource;
use Illuminate\Auth\Events\Login;
use App\Models\User;

trait TokenResponses
{
    /**
     * @param User $user
     * @return array
     */
    protected function tokenAndUser(User $user)
    {
        // login user
        if ((!auth()->user() && $user) || (auth()->user() && auth()->id() !== $user->id)) {
            auth()->login($user);
            event(new Login('api', $user, false)); // false - its remember
        }

        $token =  auth()->user()->createToken('powershare_token')->accessToken;
        return array_merge(["token" => $token], $this->userData());
    }

    protected function userData()
    {
        return (new UserResource(auth()->user()))->toArray(null);
    }
}
