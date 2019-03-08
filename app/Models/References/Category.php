<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected static $stringRepresentation = [];

    public static function nameFromId(int $id) : string {
        if(isset(static::$stringRepresentation[$id]))
            return static::$stringRepresentation[$id];
        return "Not Defined";
    }

    public static function idFromName(string $name) : int {
        foreach (self::$stringRepresentation as $id => $itemName) {
            if($itemName === $name) {
                return $id;
            }
        }

        return -1;
    }
}
