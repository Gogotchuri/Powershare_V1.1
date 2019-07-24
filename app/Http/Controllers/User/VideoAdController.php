<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Collection\VideoAdsResource;
use App\Models\Campaign;
use App\Models\VideoAd;
use App\Models\WatchedVideo;
use App\Traits\UsesRecaptcha;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoAdController extends Controller
{
    use UsesRecaptcha;
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function video(Request $request){
        //Captcha validation
        $token = $request["token"];
        if($token == null || $token == "")
            return self::responseErrors("Captcha token not found!", 400);
        if(!$this->validateRecaptchaToken($token))
            return self::responseErrors("Captcha validation failed!", 400);

        $user = auth()->user();
        if($user->exceedsWatchLimit())
            return self::responseErrors("You have exceeded watch limit today! Come back tomorrow!", 403);

        /*Try to give user video, which he haven't seen today*/
        $watched_videos_today = $user->getWatchedVideosToday();
        $IDs = [];
        foreach($watched_videos_today as $watched_video){
            $IDs[] = $watched_video->video_id;
        }
        $videos = VideoAd::all()->whereNotIn("id",$IDs)->where("is_active", true);
        if($videos->isEmpty() || $videos->count() == 0){
            $video = null;
        }else{
            $video = $videos->random();
        }

        /*If all user has watched all videos, we give him one randomly from all videos*/
        if($video == null) {
            $videos = VideoAd::all()->where("is_active", true);

            if($videos->isEmpty() || $videos->count() == 0){
                $video = null;
            }else{
                $video = $videos->random();
            }
        }
        if($video == null)
            return self::responseErrors(["no videos are available"], 404);

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
