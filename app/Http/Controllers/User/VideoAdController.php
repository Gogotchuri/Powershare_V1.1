<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Collection\VideoAdsResource;
use App\Models\Campaign;
use App\Models\VideoAd;
use App\Models\WatchedVideo;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoAdController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function video(){
        $user = auth()->user();
        if($user->exceedsWatchLimit())
            return self::responseErrors("You have exceeded watch limit today! Come back tomorrow!", 403);
        $watched_videos_today = $user->getWatchedVideosToday();
        $IDs = [];
        foreach($watched_videos_today as $watched_video){
            $IDs[] = $watched_video->video_id;
        }
        $videos = VideoAd::all()->whereNotIn("id",$IDs)->where("is_active", true);
        if($videos->isEmpty()){
            $video = null;
        }else{
            $video = $videos->random();
        }
        if($video == null) $video = VideoAd::all()->where("is_active", true)->random();
        return self::responseData([
            "video" => new VideoAdsResource($video),
            "num_before_limit" => $user->numBeforeWatchLimit()
        ]);
    }

    //TODO Validator
    public function store(int $campaign_id, Request $request){
        if(Campaign::where("id", $campaign_id)->first() == null)
            return self::responseErrors("Campaign with given id wasn't found!", 404);
        if(VideoAd::where("id", $request["video_id"])->first() == null)
            return self::responseErrors("Video with given id wasn't found!", 404);
        $watched = new WatchedVideo();
        $watched->video_id = $request["video_id"];
        $watched->campaign_id = $campaign_id;
        $watched->user_id = Auth::user()->id;
        $watched->save();

        return self::responseData($watched);

    }
}
