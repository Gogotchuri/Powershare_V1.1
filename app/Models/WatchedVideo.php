<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchedVideo extends Model
{
    public function user(){
        return $this->hasOne(User::class);
    }

    public function campaign(){
        return $this->hasOne(Campaign::class);
    }

    public function video(){
        return $this->belongsTo(VideoAd::class);
    }
}
