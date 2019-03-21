<?php

namespace Tests\Feature\APITests;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthTest extends APITest
{
    /**
     * Sends a post request to api to test if user can be created successfully and
     * if it returns correct information
     */
    public function testUserCreation()
    {
        $this->registerUser()->assertOk()->assertJsonStructure(["id", "name", "email", "token", "role_id"]);
    }

    /**
     * Sends a post request to api to test if user can be logged in successfully and
     * if it returns correct information
     */
    public function testUserLogin()
    {
        $this->registerUser()->assertOk();
        $this->login()
            ->assertOk()
            ->assertJsonStructure(["id", "name", "email", "token", "role_id"]);
    }


    /**
     * Creates user, send login request for that user and
     * logs out with the returned access token
     */
    public function testLogout()
    {
        $user = $this->registerUser();
        $user->assertOk();
        //dummy logout
        $this->logout("lll")->assertStatus(401);
        //Real deal
        $this->logout($user->json("token"))->assertOk();
    }
}
