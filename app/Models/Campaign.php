<?php

namespace App\Models;

use App\Models\References\CampaignCategory;
use App\Models\References\CampaignStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\References\ImageCategory;

class Campaign extends Model
{
    use SoftDeletes;
    
    protected $with = [
        "status"
    ];

    protected $visible = [ "id", "name", "featured_image_thumbnail_url", "category_id", 
                            "required_funding", "realized_funding", "category_name", 
                            "video_url", "ethereum_address", "details"];
                            
    protected $appends = [ "featured_image_url", "featured_image_thumbnail_url", "category_name"];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $last = Campaign::orderBy("id", "desc")->first();
            $model->attributes["order"] = optional($last)->id * 10 + 10;
        });
    }

    public static function createPath()
    {
        return Auth::user() && Auth::user()->role_id === 1
            ? route("admin.campaigns.create")
            : route("user.campaigns.create");
    }

    public static function baseRules()
    {
        return [
            "name" => "required|string|max:30",
            "target_audience" => "required|string|max:50",
            "details" => "required|string|max:3000",
        ];
    }
    public static function updateRules()
    {
        return array_merge(Campaign::baseRules(), [
            "category" => "required|exists:campaign_categories,id",
            "initiator" => "required|string|max:40",
            "required_funding" => "required|numeric",
            //TODO: Conditionally add required rule here if campaign have no image
            "featured-image" => "image|mimes:jpeg,png,jpg,gif",
            "ethereum_address" => "nullable|string|max:255",
            "video_url" => "nullable|url",
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

    public function getYoutubeIdAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        $parts = parse_url($this->video_url);
        parse_str($parts["query"], $query);

        return Arr::get($query, "v");
    }

    public function getFeaturedImageAttribute()
    {
        $images = $this->images;
        //might need to add default campaign image
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
        return str_limit($this->details, 13);
    }

    public function getAuthorNameAttribute()
    {
        return optional($this->author)->name;
    }

}