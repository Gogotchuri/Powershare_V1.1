<?php

namespace Tests\Feature\APITests\UserFeatures;

use Tests\Feature\APITests\APITest;

class CommentTest extends APITest
{
    private function campaignComments(int $campaign_id)
    {
        return $this->json("GET", "/api/campaigns/".$campaign_id."/comments")->assertOk()->json();
    }
    /**
     * Test fetching comments for every Campaign
     */
    public function testFetchingComments()
    {
        $campaigns = $this->json("GET", "/api/campaigns")->assertOk()->json("data");
        //Check if campaigns are retrieved correctly
        $this->assertTrue(is_array($campaigns));

        foreach($campaigns as $campaign){
            $comments = $this->campaignComments($campaign["id"]);
            $this->assertTrue(is_array($comments));
            foreach ($comments as $comment) {
                $this->assertEquals($campaign["id"], $comment["campaign_id"]);
            }
        }
    }

    public function testFetchingAComment()
    {
        //implement me

    }

    public function testAddingComment()
    {
        //implement me

    }

    public function testUpdatingComment()
    {
        //implement me

    }

    public function testDeletingComment()
    {
        //implement me

    }

}
