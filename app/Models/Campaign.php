<?php

namespace App\Models;

use App\Models\References\CampaignCategory;
use App\Models\References\CampaignStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\References\ImageCategory;

class Campaign extends Model
{
    use SoftDeletes;

    protected $visible = ["id", "name", "description", "author_name"];
    protected $fillable = [
        "name",
        "description",
        "details",
        "video_url",
        "category_id",
        "required_funding"
    ];

    protected $with = [
        "status",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $last = Campaign::orderBy("id", "desc")->first();
            $model->attributes["order"] = optional($last)->id * 10 + 10;
        });
    }

    public static function baseRules()
    {
        return [
            "name" => ["required", "string", "max:30"],
            "category_id" => ["required", "integer", "min:1", "max:".CampaignCategory::getNumCategories()],
            "description" => ["required", "string", "min:5", "max:200"],
        ];
    }
    public static function updateRules()
    {
        return array_merge(Campaign::baseRules(), [
            "required_funding" => ["required", "numeric"],
            "video_url" => ["nullable", "url"],
            "due_date" => ["nullable"],
            "status_id" => ["nullable", "numeric", "max:".CampaignStatus::numCategories(), "min:1"],
            "details" => ["required", "string", "min:10", "max:3000"]
        ]);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(CampaignStatus::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function public_comments()
    {
        return $this->comments()->where("is_public", true);
    }

    public function social_links()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function category()
    {
        return $this->belongsTo(CampaignCategory::class);
    }

    public function bankAccount(){
        
        return $this->hasOne(BankAccount::class);
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class);
    }

    public function getIsApprovedAttribute()
    {
        return $this->status_id == CampaignStatus::APPROVED;
    }

    public function setIsApprovedAttribute($value)
    {
        $this->status_id = $value ? CampaignStatus::APPROVED : CampaignStatus::PROPOSAL;
    }

    public function getIsDraftAttribute()
    {
        return $this->status_id == CampaignStatus::DRAFT;
    }

    public function getIsProposalAttribute()
    {
        return $this->status_id == CampaignStatus::PROPOSAL;
    }

    public function getStatusNameAttribute()
    {
        return CampaignStatus::nameFromId($this->status_id);
    }


    public function getFeaturedImageAttribute()
    {
        $images = $this->images;
        if(isset($images)){
            return $images->firstWhere("category_id", ImageCategory::FEATURED);
        }
        return null;
    }

    public function getGalleryImagesAttribute()
    {
        return optional($this->images)->Where("category_id", ImageCategory::GALLERY);
    }

    public function getFeaturedImageThumbnailUrlAttribute()
    {
        return optional($this->featured_image)->thumbnail_url;
    }

    public function getFeaturedImageUrlAttribute()
    {
        return optional($this->featured_image)->url;
    }

    public function getCategoryNameAttribute()
    {
        return optional($this->category)->name;
    }

    public function getExcerptAttribute()
    {
        return substr($this->details, 0, 100);
    }

    public function getAuthorNameAttribute()
    {
        return optional($this->author)->name;
    }

    public function filled_surveys(){
        return $this->hasMany(FilledSurvey::class);
    }

    public function num_filled_surveys(){
        return $this->filled_surveys->count();
    }

    public function watched_videos(){
        return $this->hasMany(WatchedVideo::class);
    }

    public function num_watched_videos(){
        return $this->watched_videos->count();
    }

    public function get_realized_funding(){
        $realized_from_surveys =
            DB::table("surveys")
                ->join("filled_surveys", "filled_surveys.survey_id", "=", "surveys.id")
                ->where("filled_surveys.campaign_id", "=", $this->id)
                ->sum("surveys.unit_price");
        $realized_from_video =
            DB::table("video_ads")
                ->join("watched_videos", "watched_videos.video_id", "=", "video_ads.id")
                ->where("watched_videos.campaign_id", "=", $this->id)
                ->sum("video_ads.unit_price");
        return $realized_from_surveys + $realized_from_video;
    }

}