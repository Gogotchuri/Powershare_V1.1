<?php

use Illuminate\Database\Seeder;
use App\Models\References\CampaignCategory;

class CampaignCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //currently have 3 categories
        for ($id = 1; $id <= CampaignCategory::numCategories(); $id++) { 
            $cat = new CampaignCategory();
            $cat->id = $id;
            $cat->name = CampaignCategory::nameFromId($id);
            $cat->save();
        }
    }
}
