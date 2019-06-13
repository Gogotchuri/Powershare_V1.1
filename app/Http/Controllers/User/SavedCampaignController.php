<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Collection\CampaignsResource;
use App\Http\Resources\Collection\SavedCampaignsResource;
use App\Models\Campaign;
use App\Models\References\CampaignStatus;
use App\Models\SavedCampaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

class SavedCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $savedCampaigns = SavedCampaign::where("user_id", auth()->user()->id)->get();
        return self::responseData(SavedCampaignsResource::collection($savedCampaigns));
    }

    public function show($campaign_id){
        $favourite = SavedCampaign::where("campaign_id", $campaign_id)
            ->where("user_id",auth()->user()->id)->first();
        return self::responseData($favourite != null, 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["campaign_id" => ["required", "numeric"]]);
        if($validator->fails())
            return self::responseErrors($validator->errors(), 422);
        $campaign = Campaign::where("id", $request["campaign_id"])
            ->where("status_id", CampaignStatus::APPROVED)->first();
        if($campaign == null)
            return self::responseErrors("Campaign not found!", 404);

        //Already existed
        if(SavedCampaign::where("user_id", auth()->user()->id)
            ->where("campaign_id", $request["campaign_id"])->first() != null)
            return self::responseData("Campaign already saved!",200);

        $saved = new SavedCampaign();
        $saved->campaign_id = $request["campaign_id"];
        $saved->user_id = auth()->user()->id;
        $saved->save();
        return self::responseData(new SavedCampaignsResource($saved), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $campaign_id
     * @return JsonResponse
     */
    public function destroy($campaign_id)
    {
        $favourite = SavedCampaign::where("campaign_id", $campaign_id)
            ->where("user_id", auth()->user()->id)->first();
        if($favourite == null)
            return self::responseErrors("Saved Campaign not found!", 404);
        $favourite->delete();
        return self::responseData("Saved Campaign deleted!");

    }
}
