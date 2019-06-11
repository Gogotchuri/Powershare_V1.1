<?php

namespace App\Models;


use App\Models\References\ImageCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as IntImage;

class Image extends Model
{
    private const galleryLimit = 6;
    public $visible = ["id", "url", "thumbnail_url", "name"];

    /*Called when image is uploaded for Gallery
        @param $file uploaded image
        @param $name general name
    */
    public static function forGallery(UploadedFile $file, Campaign $campaign)
    {
        $image = new static();
        $image->name = "powershare-gallery-".$campaign->name."-".$file->hashName();
        $image->storeNormal($file);
        $image->storeThumbnail($file);
        $image->campaign_id = $campaign->id;
        $image->category_id = ImageCategory::GALLERY;
        $image->save();

        return $image;
    }

    /*Called when image is set for featured
        @param $file uploaded image
        @param $name general name
    */
    public static function forFeatured(string $base64_file, Campaign $campaign)
    {
        $featured_images = $campaign->images->where("category_id", ImageCategory::FEATURED);
        foreach($featured_images as $featured_image){
            $featured_image->remove();
        }
        $image = new static();
        $image->name = "powershare-".$campaign->name.$campaign->id."-".self::getImageName($base64_file);
        //Assigns $image->url to upload url
        $image->storeNormalBase64($base64_file, $image->name);
        //Assigns $image->thumbnail_url to upload url
        $image->storeThumbnailBase64($base64_file, $image->name);
        $image->campaign_id = $campaign->id;
        $image->category_id = ImageCategory::FEATURED;
        $image->save();
        return $image;
    }

    /**
     * Used to upload photo as a profile picture for a given user
     * @param UploadedFile $file
     * @param User $user
     * @return Image
     */
    public static function forProfile(UploadedFile $file, User $user)
    {
        $image = new static();
        $image->name = $user->name;
//        $image->storeNormal($file, $dims);
//        $image->storeThumbnail($file, $dims);
        $image->user_id = $user->id;
        $image->category = ImageCategory::PROFILE;
        $image->save();

        return $image;
    }

    /**
     * Uploads image for team member, and returns that image
     * Image id should be saved to team-members row manually
     * @param UploadedFile $file
     * @param TeamMember $member
     * @param null $dims
     * @return Image
     */
    public static function forTeamMember(UploadedFile $file, TeamMember $member, $dims = null)
    {
        $image = new static();
        $image->name = $member->name;
        $image->storeNormalBase64($file, $dims);
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

    public static function galleryLimitExceeded(Campaign $campaign){
        $gallery = $campaign->images->where("category_id", ImageCategory::GALLERY);
        return $gallery->count() >= self::galleryLimit;
    }

    /**
     * Removes image from s3 bucket and from the database,
     * returns true if it was successfully deleted
     * @return bool
     * @throws \Exception
     */
    public function remove(){
        $uriStarting = strpos($this->url, "/", 10);
        $imageName = substr($this->url, $uriStarting+1);
        $thumbName = substr($this->thumbnail_url, $uriStarting+1);
        $this->delete();
        return Storage::disk("s3")->delete($imageName) && Storage::disk("s3")->delete($thumbName);
    }

    /**
     * This method stores given image as a normal image
     * @param string $file base64 encoded image
     * @param $name
     */
    protected function storeNormalBase64(string $file, $name)
    {
        $content = IntImage::make($file);

        $content = $content->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
        })
        ->stream()->detach();
        $this->url = $this->upload($name, $content);
    }

    /**
     * This method stores given image as a thumbnail image
     * @param string $file base64 encoded image
     * @param $name
     */
    protected function storeThumbnailBase64(string $file, $name)
    {
        $content = IntImage::make($file);
        $content = $content->fit(320, 240)->stream()->detach();
        $this->thumbnail_url = $this->upload("thumbnail-".$name, $content);
    }

    protected function storeNormal(UploadedFile $file)
    {
        $content = IntImage::make($file->path());
        $content = $content->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->stream()->detach();

        $this->url = $this->upload("powershare-".$file->hashName(), $content);
    }

    protected function storeThumbnail(UploadedFile $file)
    {
        $content = IntImage::make($file->path());
        $content = $content->fit(320, 240)->stream()->detach();
        $this->thumbnail_url = $this->upload("powershare-thumbnail-".$file->hashName(), $content);
    }
    /**
     * Uploads IntImage object to the s3 service and returns url
     * Name on the server is specified through $name parameter
     * @param string $name
     * @param $content
     * @return string
     */
    protected function upload(string $name, $content) : string
    {
        Storage::disk("s3")->put($name, $content, "public");

        return Storage::disk("s3")->url($name);
    }

    private static function getImageName(string $file)
    {
        $file_length = strlen($file);
        $randmax = getrandmax();
        $hash_from = rand(10, ($file_length - 150 < $randmax) ? ($file_length - 150) : $randmax);
        $ext_first_char = strpos($file, "/") + 1;
        $ext_length = strpos($file, ";") - $ext_first_char;
        $extension = substr($file, $ext_first_char, $ext_length);
        return hash("md5", substr($file, $hash_from, 150)).".".$extension;
    }
}