<?php
namespace Tests\Feature\APITests;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
class APITest extends TestCase
{
    private $initialized = false;
    protected $user_data = [
        'name' => 'Dummy User',
        'email' => 'Dummy@dummy.com',
        'password' => '123456789',
    ];
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
        $res->assertOk();
        $this->refreshApplication();
        return $res;
    }

    /**
     * Universal logout function, given an access token,
     * deletes and invalidates token, then refreshes application
     * @param string $token
     * @param bool $valid
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function logout(string $token, bool $valid=true){
        $res = $this->authorizedRequest($token, "POST", "/logout");
        if($valid)
            $res->assertOk();
        else
            $res->assertStatus(401);
        $this->refreshApplication();
        return $res;
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


    /**
     * This method should go first to initialize db and registers user
     **/
    public function testRegistrationAndInitialize(){
        if(!$this->initialized) {
            Artisan::call("migrate:fresh --seed --env=testing");
            Artisan::call("passport:install --env=testing");
            $this->registerUser()->assertStatus(201)->assertJsonStructure(["id", "name", "email", "token", "role_id"]);
        }else
            $this->assertTrue(true);
    }
}