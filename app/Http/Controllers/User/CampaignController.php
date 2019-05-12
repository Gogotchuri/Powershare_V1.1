<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\CampaignCreateRequest;
use App\Http\Requests\CampaignUpdateRequest;
use App\Http\Resources\Collection\CampaignsResource;
use App\Http\Resources\Entity\CampaignResource;
use App\Models\Campaign;
use App\Models\References\CampaignStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user_campaigns = Auth::user()->campaigns;
        return self::responseData(CampaignsResource::collection($user_campaigns));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *  must contain fields: name, category_id, details
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CampaignCreateRequest $request)
    {
        $campaign = new Campaign();
        $campaign->status_id = CampaignStatus::DRAFT;
        $campaign->name = $request["name"];
        $campaign->category_id = $request["category_id"];
        $campaign->details = $request["details"];
        $campaign->author_id = Auth::user()->id;
        $campaign->save();

        return self::responseData(new CampaignResource($campaign),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user_campaigns = Auth::user()->campaigns;
        $campaign = $user_campaigns->firstWhere("id", $id);
        if($campaign == null)
            return self::responseErrors("Campaign with id ".$id." not found or doesn't belong to you", 404);
        return self::responseData(new CampaignResource($campaign));
    }

    /**
     * Update existing campaign in storage. Request should have old stats too
     * HTTP Method: PUT (Need to attach property _method => PUT)
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CampaignUpdateRequest $request, $id)
    {
        $campaign = Auth::user()->campaigns
            ->whereIn("status_id", [CampaignStatus::DRAFT, CampaignStatus::PROPOSAL])->firstWhere("id", $id);

        if($campaign == null)
            return self::responseErrors("Campaign with id ".$id." not found or doesn't belong to you", 404);

        $campaign->name = $request["name"];
        $campaign->required_funding = $request["required_funding"];
        $campaign->category_id = $request["category_id"];
        $campaign->details = $request["details"];
        $campaign->video_url = $request["video_url"];
        $campaign->ethereum_address = $request["ethereum_address"];
        //Avoiding injections of status, campaign can only be published by admin
        $campaign->status_id = $request["status_id"];
        $campaign->save();

        return self::responseData(new CampaignResource($campaign));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $campaign = Auth::user()->campaigns->where('id', $id)
            ->whereIn('status_id', [CampaignStatus::DRAFT, CampaignStatus::PROPOSAL])->first();

        if($campaign == null)
            return self::responseErrors("Campaign with id ".$id." not found or doesn't belong to you", 404);

        $campaign->delete();

        return self::responseData("Campaign has been deleted successfully");
    }
}
