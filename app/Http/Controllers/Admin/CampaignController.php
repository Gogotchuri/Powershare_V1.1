<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CampaignCreateRequest;
use App\Http\Requests\CampaignUpdateRequest;
use App\Http\Resources\Collection\CampaignsResource;
use App\Http\Resources\Entity\CampaignResource;
use App\Models\Campaign;
use App\Http\Controllers\Controller;
use App\Models\References\CampaignStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function __construct(){
        $this->middleware("admin");
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    private const DEFAULT_PAGINATION = 10;

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Campaign::where("id", ">", "-1")->orderBy("order", "asc");
        $category = $request["category_id"];
        $name = $request["name"];
        $pagination = $request["pagination"];

        if($category !== null)
            $query->where("category_id", $category);

        if($name !== null)
            $query->where("name", "like", "%" . $name . "%");

        //Default pagination if not provided
        if($pagination === null)
            $campaigns = $query->paginate(self::DEFAULT_PAGINATION);
        else if(is_numeric($pagination) && $pagination <= 0) {
            $campaigns = $query->get();
            return self::responseData(CampaignsResource::collection($campaigns));
        }
        else
            $campaigns = $query->paginate($pagination);

        return CampaignsResource::collection($campaigns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CampaignCreateRequest $request
     * @return JsonResponse
     */
    public function store(CampaignCreateRequest $request)
    {
        $campaign = new Campaign();
        $campaign->status_id = CampaignStatus::DRAFT;
        $campaign->name = $request["name"];
        $campaign->category_id = $request["category_id"];
        $campaign->description = $request["description"];
        $campaign->author_id = Auth::user()->id;
        $campaign->save();

        return self::responseData(new CampaignResource($campaign),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $campaign = Campaign::all()->firstWhere("id", $id);
        if($campaign == null)
            return self::responseErrors("Campaign with id ".$id." not found",404);
        return self::responseData(new CampaignResource($campaign));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param CampaignUpdateRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(CampaignUpdateRequest $request, $id)
    {
        $campaign = Campaign::all()->firstWhere("id", $id);
        if($campaign == null)
            return self::responseErrors("Campaign with id ".$id." not found",404);
        $campaign->name = $request["name"];
        $campaign->category_id = $request["category_id"];
        $campaign->description = $request["description"];
        $campaign->required_funding = $request["required_funding"];
        $campaign->details = $request["details"];
        $campaign->video_url = $request["video_url"];
        $campaign->status_id = $request["status_id"];
        $campaign->due_date = $request["due_date"];
        $campaign->save();

        return self::responseData(new CampaignResource($campaign));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $campaign = Campaign::all()->firstWhere("id", $id);
        if($campaign == null)
            return self::responseErrors("Campaign with id ".$id." not found",404);
        return self::responseData("Campaign has been deleted successfully");
    }
}
