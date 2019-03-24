<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\References\CampaignCategory;
use App\Models\References\CampaignStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Campaign as CampaignResource;
use App\Http\Resources\Campaigns as CampaignsResource;


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
        else if(is_numeric($pagination) && $pagination <= 0)
            $campaigns = $query->get();
        else
            $campaigns = $query->paginate($pagination);

        //Might need for later filters
        $categories = CampaignCategory::all();

        return CampaignsResource::collection($campaigns);
    }

    public function show($id)
    {
        $campaign = Campaign::where("status_id", CampaignStatus::APPROVED)->findOrFail($id);

        return new CampaignResource($campaign);
    }

    public function addComment($id, Request $request)
    {
        $this->validate($request, [
            "body" => "required|string"
        ]);

        $campaign = Campaign::where("status_id", CampaignStatus::APPROVED)->findOrFail($id);

        $comment = new Comment();
        $comment->author_id = Auth::user()->id;
        $comment->body = $request->input("body");
        $comment->is_public = true;

        $campaign->comments()->save($comment);

        return redirect(route("public.campaign.show", compact("campaign")))->with("submitted_comment_id", $comment->id);
    }
}
