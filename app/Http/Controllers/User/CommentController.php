<?php

namespace App\Http\Controllers\User;

use App\Models\References\CampaignStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:api")->except(["index", "show"]);
    }

    public function index($campaign_id)
    {
        //Need to create resources for it
        return response()->json(Comment::where("is_public", true)->where("campaign_id",$campaign_id)->get());
    }

    public function show($campaign_id, $comment_id)
    {
        $comment = Comment::where("id", $comment_id)->where("is_public", true)->first();
        if(!$comment)
            return response()->json(["errors" => ["Comment with id ".$comment_id." not found, or not public"]], 404);

        return response()->json($comment);
    }

    /**
     * Given a campaign adds comment if user is authorized
     * @param $campaign_id
     * @param Request $request Consisting of body, should be authorized
     * @return \Illuminate\Http\JsonResponse Added Comment
     */
    public function store($campaign_id, Request $request)
    {
        $campaign = Campaign::where("status_id", CampaignStatus::APPROVED)->where("id", $campaign_id)->first();

        if(!$campaign)
            return response()->json(["errors" => ["Campaign with id ".$campaign_id." not found, or not public"]], 404);

        $validator = Validator::make($request->all(), [
            "body" => ["required", "string"]
        ]);

        if ($validator->fails())
            return response()->json(["errors" => $validator->errors()], 422);

        $comment = new Comment();
        $comment->author_id = Auth::user()->id;
        $comment->body = $request["body"];
        $comment->campaign_id = $campaign_id;

        $comment->save();

        return response()->json($comment);
    }

    /**
     * Updates comment if it exists and user is authorized
     * @param $comment_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Updated Comment
     */
    public function update($campaign_id, $comment_id, Request $request) {
        //Getting comment
        $comment = Comment::where("id", $comment_id)->first();
        if(!$comment || $comment->author->id != Auth::user()->id)
            return response()->json(["errors" => ["Comment with id ".$comment_id." not found, or not yours"]], 404);

        //Validating request
        $validator = Validator::make($request->all(), [
            "body" => ["required", "string"]
        ]);

        if ($validator->fails())
            return response()->json(["errors" => $validator->errors()], 422);

        $comment->body = $request["body"];
        $comment->save();

        return response()->json($comment);
    }

    public function destroy($campaign_id, $comment_id)
    {
        //Getting comment
        $comment = Comment::where("id", $comment_id)->first();
        if(!$comment || $comment->author->id != Auth::user()->id)
            return response()->json(["errors" => ["Comment with id ".$comment_id." not found, or not yours"]], 404);

        $comment->delete();
        return response()->json("Comment deleted successfully");
    }
}
