<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Campaigns as CampaignsResource;
use App\Http\Resources\Campaign as CampaignResource;
use App\Models\Campaign;
use App\Models\References\CampaignStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    /**
     * CampaignController constructor.
     * Makes sure user is authenticated
     */
    public function __construct(){
        $this->middleware("auth:api");
    }
    /**
     * Display a listing of the resource.
     * Every campaign current logged in user owns
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        //might need search functionality later
        $user_campaigns = Auth::user()->campaigns;
        return CampaignsResource::collection($user_campaigns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *  must contain fields: name, category_id, details
     * @return CampaignResource
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Campaign::baseRules());
        if ($validator->fails())
            return response()->json(["errors" => $validator->errors()], 422);

        $campaign = new Campaign();
        $campaign->status_id = CampaignStatus::DRAFT;
        $campaign->name = $request["name"];
        $campaign->category_id = $request["category_id"];
        $campaign->details = $request["details"];
        $campaign->author_id = Auth::user()->id;
        $campaign->save();

        return new CampaignResource($campaign);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CampaignResource
     */
    public function show($id)
    {
        $user_campaigns = Auth::user()->campaigns;
        $campaign = $user_campaigns->firstWhere("id", $id);
        if($campaign == null)
            return response()->json(["errors" => ["Campaign with id ".$id." not found or doesn't belong to you"]], 404);
        return new CampaignResource($campaign);
    }

    /**
     * Update existing campaign in storage.
     * HTTP Method: PATCH
     * @param Request $request
     * @param  int $id
     * @return CampaignResource
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Campaign::updateRules());
        if ($validator->fails())
            return response()->json(["errors" => $validator->errors()], 422);

        $campaign = Auth::user()->campaigns
            ->whereIn("status_id", [CampaignStatus::DRAFT, CampaignStatus::PROPOSAL])->firstWhere("id", $id);

        if($campaign == null)
            return response()->json(["errors" => ["Campaign with id ".$id." not found or doesn't belong to you"]], 404);

        $campaign->name = $request["name"];
        $campaign->required_funding = $request["required_funding"];
        $campaign->category_id = $request["category_id"];
        $campaign->details = $request["details"];
        $campaign->video_url = $request["video_url"];
        $campaign->ethereum_address = $request["ethereum_address"];
        //Avoiding injections of status, campaign can only be published by admin
        if($request["status_id"] != CampaignStatus::APPROVED)
            $campaign->status_id = $request["status_id"];
        $campaign->save();

        return new CampaignResource($campaign);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaign = Auth::user()->campaigns->where('id', $id)
            ->whereIn('status_id', [CampaignStatus::DRAFT, CampaignStatus::PROPOSAL])->first();

        if($campaign == null)
            return response()->json(["errors" => ["Campaign with id ".$id." not found or doesn't belong to you"]], 404);

        $campaign->delete();

        return response()->json("Campaign has been deleted successfully");
    }
}
