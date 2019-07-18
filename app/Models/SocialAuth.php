<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAuth extends Model
{
    protected $table = "social_auths";

    protected $guarded = ["id", "created_at", "updated_at"];

    protected $hidden = [ "access_token", "refresh_token"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
