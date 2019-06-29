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
        $categories = [
            "გარემოს დაცვა", 
            "განათლება",
            "სოციალური",
            "პირადი",
            "სამედიცინო",
            "ცხოველები",
            "ინოვაცია",
            "სხვა"
        ];

        foreach($categories as $category) { 
            $cat = new CampaignCategory();
            $cat->name = $category;
            $cat->save();
        }
    }
}
