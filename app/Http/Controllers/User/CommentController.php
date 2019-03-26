<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Collection\CommentsResource;
use App\Http\Resources\Entity\CommentResource;
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
        $this->middleware("auth:api");
    }

    public function all()
    {
        $comments = Comment::where("is_public", true)->get();
        return self::responseData(CommentsResource::collection($comments));
    }
    /**
     * Returns all comment for the campaign with given id
     * if not found return 404
     * @param int $campaign_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $campaign_id)
    {
        $campaign = Campaign::where("id", $campaign_id)->where("status_id", CampaignStatus::APPROVED)->first();
        if($campaign == null) return self::responseErrors("Campaign not found", 404);
        $comments = Comment::where("is_public", true)->where("campaign_id",$campaign_id)->get();
        return self::responseData(CommentsResource::collection($comments));
    }

    /**
     * Displays a comment with given id
     * if not found return 404
     * @param int $comment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $comment_id)
    {
        $comment = Comment::where("id", $comment_id)->where("is_public", true)->first();
        if(!$comment)
            return self::responseErrors("Comment with id ".$comment_id." not found, or not public", 404);

        return self::responseData(new CommentResource($comment));
    }

    /**
     * Given a campaign, adds comment if user is authorized
     * if Campaign not found returns 404
     * if validation fails return 422
     * @param $campaign_id
     * @param Request $request Consisting of body, should be authorized
     * @return \Illuminate\Http\JsonResponse Added Comment
     */
    public function store($campaign_id, Request $request)
    {
        $campaign = Campaign::where("status_id", CampaignStatus::APPROVED)->where("id", $campaign_id)->first();

        if(!$campaign)
            return self::responseErrors("Campaign with id ".$campaign_id." not found, or not public", 404);

        $validator = Validator::make($request->all(), [
            "body" => ["required", "string", "min:3", "max:500"]
        ]);

        if ($validator->fails())
            return self::responseErrors($validator->errors(), 422);

        $comment = new Comment();
        $comment->author_id = Auth::user()->id;
        $comment->body = $request["body"];
        $comment->campaign_id = $campaign_id;

        $comment->save();

        return self::responseData(new CommentsResource($comment), 201);
    }

    /**
     * Updates comment if it exists and user is authorized
     * @param $comment_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse Updated Comment
     */
    public function update($comment_id, Request $request) {
        //Getting comment
        $comment = Comment::where("id", $comment_id)->first();
        if(!$comment || $comment->author->id != Auth::user()->id)
            return self::responseErrors("Comment with id ".$comment_id." not found, or not yours", 404);

        //Validating request
        $validator = Validator::make($request->all(), [
            "body" => ["required", "string", "min:3", "max:500"]
        ]);

        if ($validator->fails())
            return self::responseErrors($validator->errors(), 422);

        $comment->body = $request["body"];
        $comment->save();

        return self::responseData(new CommentResource($comment));
    }

    public function destroy($comment_id)
    {
        //Getting comment
        $comment = Comment::where("id", $comment_id)->first();
        if(!$comment || $comment->author->id != Auth::user()->id)
            return self::responseErrors("Comment with id ".$comment_id." not found, or not yours", 404);

        $comment->delete();
        return self::responseData("Comment deleted successfully");
    }
}
