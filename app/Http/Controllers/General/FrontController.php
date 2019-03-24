<?php

namespace App\Http\Controllers\General;

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
        return self::responseData("Home content!");
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

        return self::responseData($questions);
    }


    /**
     * Returns privacy policy text
     * @return \Illuminate\Http\JsonResponse
     */
    public function privacyPolicy(){
        return self::responseData("PrivacyPolicy Text");
    }

    /**
     * Returns terms and conditions text
     * @return \Illuminate\Http\JsonResponse
     */
    public function terms(){
        return self::responseData("Terms!");
    }

    /**
     * Returns About page content
     * @return \Illuminate\Http\JsonResponse
     */
    public function about(){
        return self::responseData("This is a about page content");
    }
}
