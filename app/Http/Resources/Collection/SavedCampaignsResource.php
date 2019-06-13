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
            "campaign" => [
                "id" => $campaign->id,
                "name" => $campaign->name,
                "description" => $campaign->description,
                "author_name" => $campaign->author_name
            ],
        ];
    }
}
