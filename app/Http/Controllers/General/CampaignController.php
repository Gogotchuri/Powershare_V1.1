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
    public function index(Request $request)
    {
        $query = Campaign::where('status_id', CampaignStatus::APPROVED)->where('is_hidden', 0)->orderBy('order', 'asc');

        $category = $request->input('category_id');
        $name = $request->input('name');

        if($category !== null) {
            $query->where('category_id', $category);
        }

        if($name !== null) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $campaigns = $query->paginate(9);
        //Might need for later filters
        $categories = CampaignCategory::all();

        return CampaignsResource::collection($campaigns);
    }

    public function show($id)
    {
        $campaign = Campaign::where('status_id', CampaignStatus::APPROVED)->findOrFail($id);

        return new CampaignResource($campaign);
    }

    public function addComment($id, Request $request)
    {
        $this->validate($request, [
            'body' => 'required|string'
        ]);

        $campaign = Campaign::where('status_id', CampaignStatus::APPROVED)->findOrFail($id);

        $comment = new Comment();
        $comment->author_id = Auth::user()->id;
        $comment->body = $request->input('body');
        $comment->is_public = true;

        $campaign->comments()->save($comment);

        return redirect(route('public.campaign.show', compact('campaign')))->with('submitted_comment_id', $comment->id);
    }
}
