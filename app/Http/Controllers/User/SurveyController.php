<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Collection\Admin\SurveysResource;
use App\Models\Campaign;
use App\Models\FilledSurvey;
use App\Models\Survey;
use Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Returns randomly picked survey for the user
     * out of the surveys that hasn't filled by him
     * If limit has been exceeded returns appropriate message
     * @return JsonResponse
     */
    public function survey(){
        $user = Auth::user();
        $filled_surveys = $user->filledSurveys;
        $IDs = array(0);
        foreach ($filled_surveys as $surv){
            $IDs[] = $surv->survey_id;
        }
        $surveys_to_choose = Survey::all()->whereNotIn("id", $IDs)->where("is_active", true);
        if($surveys_to_choose == null || $surveys_to_choose->isEmpty())
            return self::responseErrors("No more surveys are available for the time being. Come back later", 404);
        $survey = $surveys_to_choose->random();

        return self::responseData(new SurveysResource($survey));
    }

    //TODO Validator!
    //TODO resource formatter for filled survey
    public function store(int $campaign_id, Request $request){
        if(Campaign::all()->where("id", $campaign_id)->first() == null)
            return self::responseErrors("Campaign with given id wasn't found!", 404);
        $filledSurvey = new FilledSurvey();
        $filledSurvey->survey_data = $request["survey_data"];
        $filledSurvey->campaign_id = $campaign_id;
        $filledSurvey->user_id = Auth::user()->id;
        $filledSurvey->survey_id = $request["survey_id"];
        $filledSurvey->save();
        return self::responseData($filledSurvey);
    }
}
