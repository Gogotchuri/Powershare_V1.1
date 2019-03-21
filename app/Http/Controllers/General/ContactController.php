<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Validates request of contact message
     * Queues email to send to admin and user
     * @param Request $request
     */
    public function store(Request $request){
       //Implement me!
    }
}
