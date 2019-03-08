<?php

use Illuminate\Database\Seeder;

use App\Models\References\SocialPlatform;

class SocialPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        for ($id = 1; $id <= SocialPlatform::numCategories(); $id++) { 
            $projectStatus = new SocialPlatform();
            $projectStatus->id = $id;
            $projectStatus->name = SocialPlatform::nameFromId($id);
            $projectStatus->save();
        }
    }
}
