<?php

namespace App\Models\References;

class CampaignCategory extends Category
{
    public const CHARITY = 1;
    public const INOVATION = 2;
    public const OTHER = 3;

    protected static $stringRepresentation = [
        self::CHARITY => "Charity",
        self::INOVATION => "Inovation",
        self::OTHER => "Other"
    ];
}
