<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Campaigns extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "featured_image_thumbnail_url" => $this->featured_image_thumbnail_url, 
            "category_name" => $this->category_name,
            "category_id" => $this->category_id,
            "required_funding" => $this->required_funding,
            "realized_funding" => $this->realized_funding
        ];
    }
}
