<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedCampaign extends Model
{
    public function campaign(){
        return $this->hasOne(Campaign::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
