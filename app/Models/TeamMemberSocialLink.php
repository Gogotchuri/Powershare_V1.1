<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\References\SocialPlatform;

class TeamMemberSocialLink extends Model
{
    public function platform(){
        return $this->belongsTo(SocialPlatform::class);
    }

    public function teamMember(){
        return $this->belongsTo(TeamMember::class);
    }
}
