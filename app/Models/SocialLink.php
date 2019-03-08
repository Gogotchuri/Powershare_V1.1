<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\References\SocialPlatform;

class SocialLink extends Model
{
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function platform(){
        return $this->belongsTo(SocialPlatform::class);
    }
}
