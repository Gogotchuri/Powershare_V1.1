<?php

namespace App\Http\Controllers\General;

use App\Mail\Contact\ContactMessage;
use App\Mail\Contact\ContactMessageSubmitted;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Validates request of contact message
     * Queues email to send to admin and user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => ["required", "min:3", "max:50"],
            "email" => "required",
            "subject" => ["required", "min:3", "max:30"],
            "text" => ["required", "min:15"]
        ]);

        if($validator->fails())
            return self::responseErrors($validator->errors(), 412);

        $info = $request->all();

        \Mail::to($info["email"])->queue(
            new ContactMessageSubmitted()
        );

        \Mail::to(config("mail.to_email"))->queue(
            new ContactMessage($info)
        );

        return self::responseData("Success!", 201);
    }
}
