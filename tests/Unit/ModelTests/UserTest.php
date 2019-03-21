<?php

namespace Tests\Unit\ModelTests;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    private function prepareDatabases(){
        Artisan::call("migrate:fresh --seed --env=testing");
        Artisan::call("passport:install --env=testing");
    }
    public function testUserCampaigns(){
        $this->prepareDatabases();
        $campaign = Campaign::first();
        $author_id = $campaign->author_id;
        $author = User::where("id", $author_id)->first();
        $this->assertNotNull($author);
        $this->assertTrue($author->ownsCampaign($campaign->id));
    }

    public function testIsAdmin(){
        $admin = User::where("role_id", 1)->first();
        if($admin != null)
            $this->assertTrue($admin->is_admin);
        else
            $this->assertTrue(true);

    }
}
