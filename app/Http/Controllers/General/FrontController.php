<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FaqQuestion;

class FrontController extends Controller
{


    /**
     * Returns Content that should be displayed on Home page
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(){
        //This is just a dummy
        return response()->json("Home content!",200);
    }


    /**
     * Returns FAQ questions array
     * @return \Illuminate\Http\JsonResponse
     */
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


    /**
     * Returns privacy policy text
     * @return \Illuminate\Http\JsonResponse
     */
    public function privacyPolicy(){
        return response()->json("PrivacyPolicy Text");
    }

    /**
     * Returns terms and conditions text
     * @return \Illuminate\Http\JsonResponse
     */
    public function terms(){
        return response()->json("Terms!");
    }

    /**
     * Returns About page content
     * @return \Illuminate\Http\JsonResponse
     */
    public function about(){
        return response()->json("This is a about page content");
    }
}
