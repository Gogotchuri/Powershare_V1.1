<?php

namespace App\Http\Controllers\User;

use App\Models\Campaign;
use App\Models\References\CampaignStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DonatedCampaignController extends Controller
{
    public function index()
    {
        $filled_surveys = auth()->user()->filledSurveys;
        $campaigns = $this->getDonatedCampaigns($filled_surveys);
        $campaigns_with_num = [];
        foreach($campaigns as $campaign){
            $campaigns_with_num[] = [
                "id" => $campaign->id,
                "name" => $campaign->name,
                "description" => $campaign->description,
                "author_name" => $campaign->author_name,
                "num_donated" => $filled_surveys->where("campaign_id", $campaign->id)->count()
            ];
        }
        return self::responseData($campaigns_with_num);
    }

    private function getDonatedCampaigns($filled_surveys)
    {
        $campaign_IDs = [];
        foreach($filled_surveys as $survey){ $campaign_IDs[] = $survey->campaign_id;}
        $campaigns = Campaign::whereIn("id", $campaign_IDs)->where("status_id", CampaignStatus::APPROVED)->get();
        return $campaigns;
    }
}
