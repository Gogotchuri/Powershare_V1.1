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
    public function testFailedUserCreation()
    {
        $this->registerUser()->assertStatus(412);
    }

    /**
     * Sends a post request to api to test if user can be logged in successfully and
     * if it returns correct information
     */
    public function testUserLogin()
    {
        $this->login()->assertJsonStructure(["data" => ["id", "name", "email", "token", "role_id"]]);
    }


    /**
     * Creates user, send login request for that user and
     * logs out with the returned access token
     */
    public function testLogout()
    {
        $user = $this->login();
        //dummy logout
        $this->logout("lll", false);
        //Real deal
        $this->logout($user->json("token"), true);
    }
}