<?php


namespace App\Traits;

use GuzzleHttp\Client;

trait UsesRecaptcha
{
    public function validateRecaptchaToken(string $token) : bool {
        $secret = config("services.recaptcha.client_secret");
        $http = new Client();
        $resp = $http->post("https://www.google.com/recaptcha/api/siteverify", [
            "form_params" => [
                "secret" => $secret,
                "response" => $token
            ]
        ]);
        $data = json_decode($resp->getBody()->getContents());
        return $data->success;
    }
}