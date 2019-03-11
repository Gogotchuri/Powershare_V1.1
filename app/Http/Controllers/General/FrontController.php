<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FaqQuestion;

class FrontController extends Controller
{
    public function home(){

    }


    public function FAQ(){
        static $NUM_TO_SHOW = 20;
        //sorting by frequency descending
        $questions = FaqQuestion::all()
            ->where('frequency', '>', 0)
            ->sortByDesc(
                function ($q){
                    return $q->frequency;
                })
            ->take($NUM_TO_SHOW);

        return response()->json($questions);
    }

    public function privacyPolicy(){

    }
}
