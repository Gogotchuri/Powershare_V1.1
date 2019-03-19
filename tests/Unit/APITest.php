<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    public function testUserCreation()
    {
        $response = $this->json('POST','/api/register', [
            'name' => 'Dummy User',
            'email' => 'Dummy@dummy.com',
            'password' => '123456789',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            "id", "name", "email", "token", "role_id"
        ]);
    }

    public function testUserLogin()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => 'Dummy@dummy.com',
            'password' => '123456789'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            "id", "name", "email", "token", "role_id"
        ]);
    }



    public function testLogout()
    {
        $user = $this->json('POST', '/api/login', [
            'email' => 'Dummy@dummy.com',
            'password' => '123456789'
        ]);

        $user->assertStatus(200);

        $response = $this->json("POST", "/api/logout")->header("Authorization: Bearer ".$user["token"]);
          
        $response->assertStatus(200)->assertExactJson('Logged out successfuly');

        $unauthenticatedReq = $this->json("GET", "/api/user")->header("Authorization: Bearer ".$user["token"]);
        
        $unauthenticatedReq->assertStatus(401);

        User::where("id", $user["id"])->delete();
    }
}
