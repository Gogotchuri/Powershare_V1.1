<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SPAController extends Controller
{
    public function index(){
        return view('blades.landing');
    }
}
