<?php

namespace Tests\Feature\APITests\UserFeatures;

use App\Models\Campaign;
use App\Models\References\CampaignStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Feature\APITests\APITest;

class CommentTest extends APITest
{
    const commentText = "Comment it is...";
    private function campaignComments(string $token, int $campaign_id) : array
    {
        return self::unwrapResponse($this->authorizedRequest($token,"GET", "/api/campaigns/".$campaign_id."/comments")->assertOk());
    }
    /**
     * Test fetching comments for every Campaign
     */
    public function testFetchingComments() : void
    {
        $user = self::unwrapResponse($this->login());
        $campaigns = self::unwrapResponse($this->json("GET","/api/campaigns?pagination=0")->assertOk());
        //Check if campaigns are retrieved correctly
        $this->assertTrue(is_array($campaigns));

        foreach($campaigns as $campaign){
            $comments = $this->campaignComments($user["token"], $campaign["id"]);
            $this->assertTrue(is_array($comments));
            foreach ($comments as $comment) {
                $this->assertEquals($campaign["id"], $comment["campaign_id"]);
            }
        }
    }


    private function addCommentTo(string $token, int $campaign_id): int
    {
        return self::unwrapResponse($this->authorizedRequest($token, "POST", "/api/campaigns/".$campaign_id."/comments", ["body" => self::commentText])->assertStatus(201))["id"];
    }

    public function testAddingComment()
    {
        $user_tok = self::unwrapResponse($this->login())["token"];
        $campaign_id = Campaign::where("status_id", CampaignStatus::APPROVED)->inRandomOrder()->first()->id;
        $comment_id = $this->addCommentTo($user_tok, $campaign_id);
        $comments = $this->campaignComments($user_tok,$campaign_id);
        $inComments = false;
        foreach($comments as $comment) {
            $inComments = $comment["id"] == $comment_id;
            if($inComments) break;
        }
        $this->assertTrue($inComments);
    }

    public function testFetchingAComment()
    {
        $user_tok = self::unwrapResponse($this->login())["token"];
        $campaign_id = Campaign::where("status_id", CampaignStatus::APPROVED)->inRandomOrder()->first()->id;
        $comment_id = $this->addCommentTo($user_tok, $campaign_id);
        $comment = self::unwrapResponse($this->authorizedRequest($user_tok, "GET", "/api/user/comments/".$comment_id)->assertOk());
        $this->assertEquals(self::commentText, $comment["body"]);
    }

    public function testUpdatingComment()
    {
        $newComment = "newly updated comment";
        $user_tok = self::unwrapResponse($this->login())["token"];
        $campaign_id = Campaign::where("status_id", CampaignStatus::APPROVED)->inRandomOrder()->first()->id;
        $comment_id = $this->addCommentTo($user_tok, $campaign_id);
        $comment = self::unwrapResponse($this->authorizedRequest($user_tok, "PUT", "/api/user/comments/".$comment_id,
            ["body" => $newComment])->assertOk());
        $this->assertEquals($newComment, $comment["body"]);
    }

    public function testDeletingComment()
    {
        $user_tok = self::unwrapResponse($this->login())["token"];
        $campaign_id = Campaign::where("status_id", CampaignStatus::APPROVED)->inRandomOrder()->first()->id;
        $comment_id = $this->addCommentTo($user_tok, $campaign_id);
        $this->authorizedRequest($user_tok, "DELETE", "/api/user/comments/".$comment_id)->assertOk();
        $this->authorizedRequest($user_tok, "GET", "/api/user/comments/".$comment_id)->assertStatus(404);
    }
}
