<?php
namespace Tests\Feature\APITests;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
class APITest extends TestCase
{
    protected $user_data = [
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
     * Created and saves to testing db new user instance
     * with data from $this->user_data
     */
    protected function registerUser(){
        $res = $this->json('POST','/api/register', $this->user_data);
        $this->refreshApplication();
        return $res;
    }

    /**
     * Sends post request to api login route and returns response
     * User data is defined in $this->user_data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function login(){
        $res = $this->json('POST', '/api/login', [
            'email' => $this->user_data["email"],
            'password' => $this->user_data["password"]
        ]);
       $this->refreshApplication();
       return $res;
    }

    /**
     * Sends post request to api logout route and returns response
     * @param string $token user bearer access token
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function logout(string $token){
        return $this->authorizedRequest($token, "POST", "/logout");
    }


    /**
     * Request wrapper
     * @param string $token
     * @param string $method
     * @param string $uri
     * @param array $body
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function authorizedRequest(string $token, string $method, string $uri, array $body = []){
        $res = $this->json($method, "/api".$uri, $body, ["Authorization" => "Bearer ".$token]);
        $this->refreshApplication();
        return $res;
    }


    public function testNothing(){
        $this->assertTrue(true);
    }
}