<?php

use Illuminate\Database\Seeder;
use App\Models\References\ImageCategory;

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
        for ($id=1; $id <= ImageCategory::numCategories(); $id++) { 
            $cat = new ImageCategory();
            $cat->id = $id;
            $cat->name = ImageCategory::nameFromId($id);
            $cat->save();
        }
    }
}
