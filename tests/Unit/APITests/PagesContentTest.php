<?php

namespace Tests\Unit\APITests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesContentTest extends TestCase
{
    private function sendRequest(string $method, string $apiPath){
        return $this->json($method, "/api/".$apiPath);
    }
    public function testHome()
    {
        //should add more assertions as functions grow
            $this->sendRequest("GET", "home")->assertOk();
    }

    public function testAbout()
    {
        $this->sendRequest("GET", "about")->assertOk();
    }

    public function testFAQ()
    {
        $this->sendRequest("GET", "faq")->assertOK();
    }

    public function testTerms()
    {
        $this->sendRequest("GET", "terms")->assertOK();
    }

    public function testPP()
    {
        $this->sendRequest("GET", "privacy-policy")->assertOK();
    }
}
