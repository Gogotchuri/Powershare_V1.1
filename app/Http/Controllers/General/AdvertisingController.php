<?php

namespace App\Http\Controllers\General;

use App\Mail\Advertisers\AdvertiserRequest;
use App\Mail\Contact\ContactMessage;
use App\Mail\Contact\ContactMessageSubmitted;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Validator;

class AdvertisingController extends Controller
{
    public function send(Request $request){
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "phone" => ["required", "min:9", "max:32"]
        ]);

        if($validator->fails())
            return self::responseErrors($validator->errors(), 412);

        $email = $request["email"];
        $phone = $request["phone"];

        Mail::to(config("mail.to_email"))->sendNow(new AdvertiserRequest($email, $phone));

        //TODO mail to advertiser too ??

        return self::responseData("Success!", 201);
    }
}
