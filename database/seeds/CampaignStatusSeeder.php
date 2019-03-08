<?php

use Illuminate\Database\Seeder;
use App\Models\References\CampaignStatus;

class CampaignStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //currently have 2 roles
        for($id = 1; $id <= CampaignStatus::numCategories(); $id++){
            $projectStatus = new CampaignStatus();
            $projectStatus->id = $id;
            $projectStatus->name = CampaignStatus::nameFromId($id);
            $projectStatus->save();
        }
    }
}
