<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
    
    public function image() {
        return $this->hasOne(Image::class);
    }

    public function getImageUrlAttribute() {
        return $this->image->url;
    }

    public function getThumbnailUrlAttribute() {
        return $this->image->thumbnail_url;
    }

    /**optionally can be implemented function, to add team members as powershare users */
    public function realUser(){
        return optional($this->belongsTo(User::class));
    }
}
