<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\References\CampaignCategory;
use App\Models\References\CampaignStatus;
use App\Models\References\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Entity\CampaignResource;
use App\Http\Resources\Collection\CampaignsResource;


class CampaignController extends Controller
{
    private const DEFAULT_PAGINATION = 10;
    public function index(Request $request)
    {
        $query = Campaign::where("status_id", CampaignStatus::APPROVED)->where("is_hidden", 0)->orderBy("order", "asc");

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

    public function show(int $id)
    {
        $campaign = Campaign::where("status_id", CampaignStatus::APPROVED)->where("id", $id)->first();
        if($campaign == null) return self::responseErrors("Campaign not found",404);
        return self::responseData(new CampaignResource($campaign));
    }

    public function getCategories()
    {
        $categories = CampaignCategory::all();
        return self::responseData($categories);
    }
}
