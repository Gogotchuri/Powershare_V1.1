<?php

namespace App\Http\Resources\Collection;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
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
            "author_id" => $this->author_id,
            "author_name" => $this->author_name,
            "body" => $this->body,
            "date" => $this->date,
            "is_edited" => $this->is_edited,
            "campaign_id" => $this->campaign_id,
            "is_public" => $this->is_public
        ];
    }
}
