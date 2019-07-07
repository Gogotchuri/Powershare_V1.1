<?php

namespace App\Http\Resources\Collection;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = date_format(date_create($this->created_at), "d-m-Y");
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image_url" => $this->featured_image_url,
            "date" => $date,
            "body" => $this->body,
        ];
    }
}
