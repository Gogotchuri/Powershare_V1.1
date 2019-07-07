<?php

namespace App\Models;

use App\Models\References\ImageCategory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $casts = ["created_at" => "datetime:d-m-Y"];

    public function author(){
        return $this->belongsTo(User::class);
    }

    public function images(){
        return $this->hasMany(Image::class, "article_id", "id");
    }

    public function getFeaturedImageUrlAttribute(){
        return $this->images->Where("category_id", ImageCategory::ARTICLE_FEATURED)->first()->url;
    }
}
