<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as IntImage;
use App\References\Models\ImageCategory;


class Image extends Model
{
    public $visible = ["id", "url", "thumbnail_url", "name"];

    /*Called when image is ploaded for Gallery
        @param $file uploaded image
        @param $name general name
        @param $dims dimmension to which image should be cropped
    */
    public static function forGallery(UploadedFile $file, Campaign $campaign, $dims = null)
    {
        $image = new static();
        $image->name = $campaign->name;
        $image->storeNormal($file, $dims);
        $image->storeThumbnail($file, $dims);
        $image->campaign_id = $campaign->id;
        $image->category = ImageCategory::GALLERY;
        $image->save();

        return $image;
    }

    /*Called when image is set for featured
        @param $file uploaded image
        @param $name general name
        @param $dims dimmension to which image should be cropped
    */
    public static function forFeatured(UploadedFile $file, Campaign $campaign, $dims = null)
    {
        $image = new static();
        $image->name = $campaign->name;
        //Assigns $image->url to upload url
        $image->storeNormal($file, $dims);
        //Assigns $image->thumbnail_url to upload url
        $image->storeThumbnail($file, $dims);
        $image->campaign_id = $campaign->id;
        $image->category = ImageCategory::FEATURED;
        $image->save();

        return $image;
    }

    public static function forProfile(UploadedFile $file, User $user, $dims = null)
    {
        $image = new static();
        $image->name = $user->name;
        $image->storeNormal($file, $dims);
        $image->storeThumbnail($file, $dims);
        $image->user_id = $user->id;
        $image->category = ImageCategory::PROFILE;
        $image->save();

        return $image;
    }

    public static function forTeamMember(UploadedFile $file, TeamMember $member, $dims = null)
    {
        $image = new static();
        $image->name = $member->name;
        $image->storeNormal($file, $dims);
        $image->category = ImageCategory::MEMBER;
        $image->save();

        return $image;
    }

    public function campaign() {
        return $this->belongsTo(Campaign::class, "campaign_id");
    }

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function category(){
        return $this->belongsTo(ImageCategory::class, "category_id");
    }

    public function getCategoryNameAttribute(){
        return optional($this->category)->name;
    }

    public function getCampaignIdAttribute(){
        return optional($this->campaign)->id;
    }

    protected function storeNormal(UploadedFile $file, $dims)
    {
        $content = IntImage::make($file->path());

        if($dims != null && !($dims["width"] == null || $dims["height"] == null)){
            $content = $content->crop($dims["width"], $dims["height"], $dims["x1"], $dims["y1"]);
        }
        
        $content = $content->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
        })
        ->stream()->detach();

        $this->url = $this->upload("powershare-".$file->hashName(), $content);
    }

    protected function storeThumbnail(UploadedFile $file, $dims)
    {
        $content = IntImage::make($file->path());
        
        if($dims != null && !($dims["width"] == null || $dims["height"] == null)){
            $content = $content->crop($dims["width"], $dims["height"], $dims["x1"], $dims["y1"]);
        }

        $content = $content->fit(320, 240)->stream()->detach();

        $this->thumbnail_url = $this->upload("powershare-thumbnail-".$file->hashName(), $content);
    }

    protected function upload($name, $content)
    {
        Storage::disk("s3")->put($name, $content, "public");

        return Storage::disk("s3")->url($name);
    }
}