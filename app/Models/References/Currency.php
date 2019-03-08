<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class Currency extends Category
{
    public const USD = 1;
    public const EUR = 2;
    public const GEL = 3;
    public const GBP = 4;

    protected static $stringRepresentation = [
        self::USD => "USD",
        self::EUR => "EUR",
        self::GEL => "GEL",
        self::GBP => "GBP"
    ];

    protected static $fullStringRepresentation = [
        self::USD => "United States Dollar",
        self::EUR => "Euro",
        self::GEL => "Georgian Lari",
        self::GBP => "Great Britain Pound"
    ];

    public static function fullNameFromId(int $id) : string {
        if(isset(self::$fullStringRepresentation[$id]))
            return self::$fullStringRepresentation[$id];
        return null;
    }

}
