<?php

namespace App\Models\References;

class CampaignStatus extends Category
{
    public const APPROVED = 1;
    public const PROPOSAL = 2;
    public const DRAFT = 3;

    protected static $stringRepresentation = [
        self::DRAFT => "Draft",
        self::PROPOSAL => "Proposal",
        self::APPROVED => "Approved"
    ];

}
