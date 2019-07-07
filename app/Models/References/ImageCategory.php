<?php

namespace App\Models\References;

use App\Models\References\Category as Category;

class ImageCategory extends Category
{
    public const FEATURED = 1;
    public const GALLERY = 2;
    public const MEMBER = 3;
    public const PROFILE = 4;
    public const ARTICLE_FEATURED = 5;

    protected static $stringRepresentation = [
        self::FEATURED => "Featured",
        self::GALLERY => "Gallery",
        self::MEMBER => "For Member",
        self::PROFILE => "Profile",
        self::ARTICLE_FEATURED => "Article featured image"
    ];

}
