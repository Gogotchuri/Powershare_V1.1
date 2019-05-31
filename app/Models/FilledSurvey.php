<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilledSurvey extends Model
{
   public function campaign(){
       return $this->hasOne(Campaign::class);
   }

   public function participant(){
       return $this->hasOne(User::class);
   }

   public function survey(){
       return $this->belongsTo(Survey::class);
   }
}
