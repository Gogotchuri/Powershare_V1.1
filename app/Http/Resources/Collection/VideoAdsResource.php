<?php

namespace App\Http\Resources\Collection;

use App\Models\Advertiser;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoAdsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "video_url" => $this->video_url,
            "forward_url" => $this->forward_url,
            "required_duration" => $this->required_duration,
            "is_active" => ($this->is_active == "1") ? true : false,
            "advertiser" => Advertiser::where("id", $this->advertiser_id)->first()
        ];
    }
}
