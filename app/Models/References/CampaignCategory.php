<?php

namespace App\Models\References;

class CampaignCategory extends Category
{
    protected $visible = ["id", "name"];
    public const CHARITY = 1;
    public const INOVATION = 2;
    public const OTHER = 3;

    protected static $stringRepresentation = [
        self::CHARITY => "Charity",
        self::INOVATION => "Inovation",
        self::OTHER => "Other"
    ];

    public static function getNumCategories()
    {
        return CampaignCategory::all()->count();
    }
}
