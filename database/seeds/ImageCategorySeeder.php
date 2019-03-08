<?php

use Illuminate\Database\Seeder;
use App\References\Models\ImageCategory;

class ImageCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //currently have 4 image categories
        for ($i=1; $i <= ImageCategory::numCategories(); $i++) { 
            $cat = new ImageCategory();
            $cat->id = $i;
            $cat->name = ImageCategory::nameFromId($i);
        }
    }
}
