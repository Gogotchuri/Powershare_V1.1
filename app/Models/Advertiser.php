<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    public function surveys(){
        return $this->hasMany(Survey::class);
    }
}
