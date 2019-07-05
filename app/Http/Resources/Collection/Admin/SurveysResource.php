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
        $date = date_format(date_create($this->created_at), "Y-m-d");
        return [
            "id" => $this->id,
            "name" => $this->name,
            "json_body" => $this->json_body,
            "advertiser" => $this->advertiser,
            "num_filled" => $this->numFilled(),
            "unit_price" => $this->unit_price,
            "is_active" => $this->is_active,
            "creation_date" => $date
        ];
    }
}
