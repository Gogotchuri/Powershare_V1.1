<?php

namespace Tests\Feature\APITests\UserFeatures;

use Tests\Feature\APITests\APITest;

class UserCampaignTest extends APITest
{
    public function testUserCampaigns(){
        //incorrect fetch
        $this->getUserCampaigns("bla")->assertStatus(401);
        $user = self::unwrapResponse($this->login());
        $this->getUserCampaigns($user["token"])->assertOk();
        $this->logout($user["token"], true);
        //Shouldn't be able to access after logout
        $this->getUserCampaigns($user["token"])->assertStatus(401);

    }

    public function testCampaignCreation(){
        //Shouldn't be able to access without authorization
        $this->createCampaign("bla", $this->campaign_data)->assertStatus(401);
        $user = self::unwrapResponse($this->login());
        $this->createCampaign($user["token"], $this->campaign_data)->assertStatus(201);
    }

    public function testCampaignUpdateDeleteShow(){
        //Logged in as an user And created Campaign
        $user_token = self::unwrapResponse($this->login())["token"];
        //getting one of user's campaign
        $campaign = $this->userCampaign($user_token);
        $campaign_id = $campaign["id"];
        //Changed fields
        $newName = "Name of number ".$campaign_id;
        $campaign["name"] = $newName;
        $campaign["category_id"] = 2;
        //Submitted change
        $this->authorizedRequest($user_token, "PUT", "/api/user/campaigns/".$campaign_id, $campaign)->assertOk();
        $campaign= self::unwrapResponse($this->getUserCampaign($user_token, $campaign_id)->assertOk());
        //Make sure change is persistent
        $this->assertEquals($newName, $campaign["name"]);
        //Now deleting campaign as an unauthenticated user
        $this->refreshApplication();
        $this->authorizedRequest("bla", "DELETE", "/api/user/campaigns/".$campaign_id)->assertStatus(401);
        //Now trying as authorized user
        $this->authorizedRequest($user_token, "DELETE", "/api/user/campaigns/".$campaign_id)->assertOk();
        //Campaign shouldn't be accessible after delete
        $this->getUserCampaign($user_token, $campaign_id)->assertStatus(404);
    }

    //Implement me!
    public function testUnauthorizedAccess(){
        $this->assertTrue(true);
    }

    /**
     * Creates campaign, fetches all campaigns, chooses one,
     * fetches a single campaign and returns it as an campaign object
     * @param string $user_token
     * @return mixed one of user campaigns
     */
    private function userCampaign(string $user_token){
        $this->createCampaign($user_token, $this->campaign_data)->assertStatus(201);
        //Got all the campaigns and picked first one
        $campaigns = self::unwrapResponse($this->getUserCampaigns($user_token)->assertOk());
        $this->assertTrue(is_array($campaigns));
        $this->assertTrue(!!count($campaigns));
        $first_id = $campaigns[0]["id"];

        //Got first campaign details
        return self::unwrapResponse($this->getUserCampaign($user_token, $first_id)->assertOk());
    }
}
