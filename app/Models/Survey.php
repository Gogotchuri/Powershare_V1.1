<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = [];
    public function advertiser(){
        return $this->belongsTo(Advertiser::class);
    }

    public function filledSurveys(){
        return $this->hasMany(FilledSurvey::class);
    }
}
