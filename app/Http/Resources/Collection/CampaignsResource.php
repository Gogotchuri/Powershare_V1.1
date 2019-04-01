<?php

namespace App\Http\Resources\Collection;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignsResource extends JsonResource
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
            "author_id" => $this->author_id,
            "author_name" => $this->author_name,
            "featured_image_url" => $this->featured_image_url,
            "featured_image_thumbnail_url" => $this->featured_image_thumbnail_url,
            "category_name" => $this->category_name,
            "required_funding" => $this->required_funding,
            "realized_funding" => $this->realized_funding,
            "date" => $this->created_at,
            "video_url" => $this->video_url,
            "ethereum_address" => $this->ethereum_address,
            "details" => $this->details,
        ];
    }
}