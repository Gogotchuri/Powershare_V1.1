<?php

namespace App\Http\Controllers\General;

use App\Http\Resources\Collection\ImagesResource;
use App\Models\Campaign;
use App\Models\References\ImageCategory;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index($campaign_id){
        $campaign = Campaign::where("id", $campaign_id)->first();
        if($campaign == null)
            return self::responseErrors("Campaign not found!", 404);
        $gallery = $campaign->images->where("category_id", ImageCategory::GALLERY);
        return self::responseData(ImagesResource::collection($gallery));
    }
}
