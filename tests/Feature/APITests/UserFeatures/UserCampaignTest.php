<?php

namespace Tests\Feature\APITests\UserFeatures;

use App\Models\References\CampaignCategory;
use phpDocumentor\Reflection\Types\Array_;
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

        $user = $this->login();
        $this->authorizedRequest($user->json("token"), "GET", "/user/campaigns")->assertOk();
        $this->logout($user->json("token"), true);
        //Shouldn't be able to access after logout
        $this->authorizedRequest($user->json("token"), "GET", "/user/campaigns")->assertStatus(401);

    }

    public function testCampaignCreation(){
        //Shouldn't be able to access without authorization
        $this->authorizedRequest("", "POST", "/user/campaigns", $this->campaign_data)->assertStatus(401);
        $user = $this->login();
        $this->authorizedRequest($user->json("token"), "POST", "/user/campaigns", $this->campaign_data)->assertStatus(201);
    }

    public function testCampaignUpdateDeleteShow(){
        //Logged in as an user And created Campaign
        $user_token = $this->login()->json("token");
        $this->authorizedRequest($user_token, "POST", "/user/campaigns", $this->campaign_data)->assertStatus(201);
        //Got all the campaigns and picked first one
        $campaigns = $this->authorizedRequest($user_token, "GET", "/user/campaigns")->assertOk()->json();
        $this->assertTrue(is_array($campaigns));
        $this->assertTrue(!!count($campaigns));
        $first_id = $campaigns[0]["id"];

        //Got first campaign details
        $campaign = $this->authorizedRequest($user_token, "GET", "/user/campaigns/".$first_id)->assertOk()->json();
        //Changed fields
        $campaign["name"] = "Name of number ".$first_id;
        $campaign["category_id"] = 2;
        //Submitted change
        $this->authorizedRequest($user_token, "PUT", "/user/campaigns/".$first_id, $campaign)->assertOk();
        $campaign_fetched = $this->authorizedRequest($user_token, "GET", "/user/campaigns/".$first_id)->assertOk()->json();
        //Make sure change is persistent
        $this->assertEquals($campaign["name"], $campaign_fetched["name"]);
        //Now deleting campaign as an unauthenticated user
        $this->refreshApplication();
        $this->authorizedRequest("bla", "DELETE", "/user/campaigns/".$first_id)->assertStatus(401);
        //Now trying as authorized user
        $this->authorizedRequest($user_token, "DELETE", "/user/campaigns/".$first_id)->assertOk();
    }

    public function testUnauthorizedAccess(){
        $this->assertTrue(true);
    }
}
