<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\Collection\ImagesResource;
use App\Models\Campaign;
use App\Models\Image;
use App\Models\References\ImageCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class GalleryController extends Controller
{
    public function index($campaign_id){
        $campaign = Campaign::where("id", $campaign_id)->first();
        if($campaign == null)
            return self::responseErrors("Campaign not found!", 404);
        $gallery = $campaign->images->where("category_id", ImageCategory::GALLERY);
        return self::responseData(ImagesResource::collection($gallery));
    }

    public function store($campaign_id, Request $request){
        $campaign = Campaign::where("id", $campaign_id)->where("author_id", auth()->user()->id)->first();
        if($campaign == null)
            return self::responseErrors("Campaign not found or not yours!", 404);

        if(Image::galleryLimitExceeded($campaign))
            return self::responseErrors("Gallery limit exceeded!", 403);

        $validator = Validator::make($request->all(), ["file" => ["required", "image", "max:5000"]]);

        if ($validator->fails())
            return self::responseData($validator->errors(), 422);

        $file = $request->file("file");
        $image = Image::forGallery($file, $campaign);
        return self::responseData(new ImagesResource($image), 201);
    }

    public function destroy($campaign_id, $image_id){
        $campaign = Campaign::where("id", $campaign_id)->where("author_id", auth()->user()->id)->first();
        if($campaign == null)
            return self::responseErrors("Campaign not found or not yours!", 404);
        $image = $campaign->images->where("id", $image_id)->first();
        if($image == null)
            return self::responseErrors("Image not found!", 404);
        $image->remove();
        return self::responseData("Image Deleted!", 200);
    }
}
