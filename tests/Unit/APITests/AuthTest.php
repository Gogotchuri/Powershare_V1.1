<?php

namespace Tests\Unit\APITests;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private $user_data = [
        'name' => 'Dummy User',
        'email' => 'Dummy@dummy.com',
        'password' => '123456789',
    ];
    /**
     * Is called before every test and sets up stage for the test
     * Seeds database
     */
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call("migrate:fresh --seed --env=testing");
        Artisan::call("passport:install --env=testing");
    }

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
     * Created and saves to testing db new user instance
     * with data from $this->user_data
     */
    private function registerUser(){
        return $this->json('POST','/api/register', $this->user_data);
    }

    /**
     * Sends post request to api login route and returns response
     * User data is defined in $this->user_data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function login(){
        return $this->json('POST', '/api/login', [
            'email' => $this->user_data["email"],
            'password' => $this->user_data["password"]
        ]);
    }

    /**
     * Creates user, send login request for that user and
     * logs out with the returned access token
     */
    public function testLogout()
    {
        $this->registerUser()->assertOk();
        $user = $this->login();
        $user->assertOk();
        $response = $this->json("POST", "/api/logout", [], ["Authorization" => "Bearer ".$user->json("token")]);
        $response->assertOk();
    }
}
