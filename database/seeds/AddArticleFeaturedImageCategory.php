<?php

use App\Models\References\ImageCategory;
use Illuminate\Database\Seeder;

class AddArticleFeaturedImageCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = new ImageCategory();
        $cat->id = ImageCategory::ARTICLE_FEATURED;
        $cat->name = ImageCategory::nameFromId($cat->id);
        $cat->save();
    }
}
