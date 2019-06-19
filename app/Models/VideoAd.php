<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoAd extends Model
{
    public function advertiser(){
        return $this->belongsTo(Advertiser::class);
    }
}
