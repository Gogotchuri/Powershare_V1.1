<?php

namespace App\References\Models;

use App\Models\References\Category;

class ImageCategory extends Category
{
    public const FEATURED = 1;
    public const GALLERY = 2;
    public const MEMBER = 3;
    public const PROFILE = 4;

    protected static $stringRepresentation = [
        self::FEATURED => "Featured",
        self::GALLERY => "Gallery",
        self::MEMBER => "For Member",
        self::PROFILE => "Profile"
    ];

}
