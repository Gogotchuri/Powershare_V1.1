<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Collection\VideoAdsResource;
use App\Models\Advertiser;
use App\Models\VideoAd;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class VideoAdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        //TODO pagination
        $ads = VideoAd::all();
        return self::responseData(VideoAdsResource::collection($ads));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required"],
            "video_url" => ["required"],
            "forward_url" => ["required", "url"],
            "unit_price" => ["required", "numeric"],
            //TODO create one validator
            "required_duration" => ["required", "numeric", "min:0", "max:120"],
            "advertiser_id" => ["numeric", "min:1"]
        ]);

        if($validator->fails())
            return self::responseErrors($validator->errors(), 422);
        if($request["advertiser_id"] != null
            && Advertiser::where("id", $request["advertiser_id"])->first() == null)
            return self::responseErrors("Advertiser with id wasn't found!", 404);

        $ad = new VideoAd();
        $ad->name = $request["name"];
        $ad->video_url = $request["video_url"];
        $ad->unit_price = $request["unit_price"];
        $ad->forward_url = $request["forward_url"];
        $ad->required_duration = $request["required_duration"];
        $ad->advertiser_id = $request["advertiser_id"];
        $ad->save();

        return self::responseData(new VideoAdsResource($ad), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $ad = VideoAd::where("id", $id)->first();
        if($ad == null)
            return self::responseErrors("Ad Not Found!", 404);
        return self::responseData(new VideoAdsResource($ad));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $ad = VideoAd::where("id", $id)->first();
        if($ad == null)
            return self::responseErrors("Video Ad not found!", 404);

        $validator = Validator::make($request->all(), [
            "video_url" => ["required"],
            "forward_url" => ["required", "url"],
            "unit_price" => ["required", "numeric"],
            "required_duration" => ["required", "numeric", "min:0", "max:120"],
            "advertiser_id" => ["numeric", "min:1"]
        ]);

        if($validator->fails())
            return self::responseErrors($validator->errors(), 422);

        if($request["advertiser_id"] != null
            && Advertiser::where("id", $request["advertiser_id"])->first() == null)
            return self::responseErrors("Advertiser with id wasn't found!", 404);

        $ad->name = $request["name"];
        $ad->video_url = $request["video_url"];
        $ad->forward_url = $request["forward_url"];
        $ad->unit_price = $request["unit_price"];
        $ad->required_duration = $request["required_duration"];
        $ad->advertiser_id = $request["advertiser_id"];
        $ad->save();

        return self::responseData(new VideoAdsResource($ad));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $ad = VideoAd::where("id", $id)->first();
        if($ad == null)
            return self::responseErrors("Video Ad not found!", 404);
        $ad->delete();
        return self::responseData("Deleted successfully!");
    }

    public function changeStatus($id){
        $ad = VideoAd::where("id", $id)->first();
        if($ad == null) return self::responseErrors("Video not found!", 404);
        $ad->is_active = !$ad->is_active;
        $ad->save();
        return self::responseData("video status changed!");
    }
}
