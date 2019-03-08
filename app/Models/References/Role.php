<?php

namespace App\Models\References;

class Role extends Category
{
    public const ADMIN = 1;
    public const USER = 2;

    protected static $stringRepresentation = [
        self::ADMIN => "Admin",
        self::USER => "User"
    ];
}
