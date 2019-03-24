<?php
namespace Tests\Feature\APITests;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
class APITest extends TestCase
{
    private static $initialized = false;
    protected $user_data = [
        'name' => 'Dummy User',
        'email' => 'Dummy@dummy.com',
        'password' => '123456789',
    ];
    protected $campaign_data = [
        "name" => "First User Campaign",
        "details" => "The details field is required.",
        "category_id" => 2,
        "required_funding" => 50000
    ];

    /**
     * This method should go first to initialize db and registers user
     **/
    public function testRegistrationAndInitialize(){
        if(!self::$initialized) {
            Artisan::call("migrate:fresh --seed --env=testing");
            Artisan::call("passport:install --env=testing");
            $this->registerUser()->assertStatus(201)->assertJsonStructure(["id", "name", "email", "token", "role_id"]);
            self::$initialized = true;
        }else
            $this->assertTrue(true);
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
     * Asserts upon unsuccessful login
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
     * Request wrapper, for token base auth requests
     * @param string $token
     * @param string $method
     * @param string $uri uri address after *./api
     * @param array $body
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function authorizedRequest(string $token, string $method, string $uri, array $body = []){
        $res = $this->json($method, "/api".$uri, $body, ["Authorization" => "Bearer ".$token]);
        $this->refreshApplication();
        return $res;
    }

    /**
     * Creates campaign with api request given user access token and campaign data
     * @param string $token
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function createCampaign(string $token, array $data) {
        return $this->authorizedRequest($token, "POST", "/user/campaigns", $data);
    }

    /**
     * Returns TestResponse with user campaigns, given a access token
     * @param string $token
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function getUserCampaigns(string $token){
        return $this->authorizedRequest($token, "GET", "/user/campaigns");
    }

    /**
     * Retrieves a campaign with $id based on given token
     * @param string $token
     * @param int $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function getUserCampaign(string $token, int $id){
        return $this->authorizedRequest($token, "GET", "/user/campaigns/".$id);
    }
}