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
        for ($i = 1; $i < CampaignCategory::numCategories(); $i++) { 
            $cat = new CampaignCategory();
            $cat->id = $i;
            $cat->name = CampaignCategory::nameFromId($i);
            $cat->save();
        }
    }
}
