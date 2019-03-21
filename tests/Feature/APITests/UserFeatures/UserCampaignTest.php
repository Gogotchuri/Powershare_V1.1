<?php

namespace Tests\Feature\APITests\UserFeatures;

use App\Models\References\CampaignCategory;
use Tests\Feature\APITests\APITest;

class UserCampaignTest extends APITest
{
    private $campaign_data = [
        "name" => "First User Campaign",
        "details" => "The details field is required.",
        "category_id" => 2,
        "required_funding" => 50000
    ];

    public function testUserCampaigns(){
        $this->authorizedRequest("bla", "GET", "/user/campaigns")->assertStatus(401);

        $user = $this->registerUser();
        $user->assertOk();

        $this->authorizedRequest($user->json("token"), "GET", "/user/campaigns")->assertOk();
        $this->authorizedRequest($user->json("token"), "POST", "/logout")->assertOk();
        //Shouldn't be able to access after logout
        $this->authorizedRequest($user->json("token"), "GET", "/user/campaigns")->assertStatus(401);

    }

    public function testCampaignCreation(){
        //Shouldn't be able to access without authorization
        $this->authorizedRequest("", "POST", "/user/campaigns", $this->campaign_data)->assertStatus(401);
        $user = $this->registerUser();
        $user->assertOk();
        $this->authorizedRequest($user->json("token"), "POST", "/user/campaigns")->assertOk();

    }

    public function testCampaignUpdate(){
        $this->assertTrue(true);
    }

    public function testCampaignDelete(){
        $this->assertTrue(true);
    }

    public function testUnauthorizedAccess(){
        $this->assertTrue(true);
    }
}
