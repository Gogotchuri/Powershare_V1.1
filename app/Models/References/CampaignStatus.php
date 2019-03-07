<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class CampaignStatus extends Model
{
    public const APPROVED = 1;
    public const PROPOSAL = 2;
    public const DRAFT = 3;
}
