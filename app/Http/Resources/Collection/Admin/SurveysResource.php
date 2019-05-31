<?php

namespace App\Http\Resources\Collection\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveysResource extends JsonResource
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
            "json_body" => $this->json_body,
            "advertiser" => $this->advertiser,
            "creation_date" => $this->created_at
        ];
    }
}
