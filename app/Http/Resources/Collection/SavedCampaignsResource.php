<?php

namespace App\Http\Resources\Collection;

use App\Models\Campaign;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedCampaignsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $campaign = Campaign::where("id", $this->campaign_id)->first();
        return [
            "id" => $this->id,
            "campaign" => $campaign
        ];
    }
}
