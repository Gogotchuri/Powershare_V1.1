<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class TransactionPlatform extends Category
{
    public const PAYPAL = 1;
    public const TBC = 2;
    public const OTHER = 3;

    protected static $stringRepresentation = [
        self::PAYPAL => "Paypal",
        self::TBC => "TBC",
        self::OTHER => "Other"
    ];

}
