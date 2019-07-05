<?php

namespace App\Http\Resources\Entity\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $comments = $this->public_comments;
        $comments = ($comments->count() == 0) ? null : $comments;
        $realized_funding = $this->get_realized_funding();
        return [
            "id" => $this->id,
            "name" => $this->name,
            "author_id" => $this->author_id,
            "author_name" => $this->author_name,
            "featured_image_url" => $this->featured_image_url,
            "featured_image_thumbnail_url" => $this->featured_image_thumbnail_url,
            "category_name" => $this->category_name,
            "category_id" => $this->category_id,
            "status_id" => $this->status_id,
            "required_funding" => $this->required_funding,
            "realized_funding" => $realized_funding,
            "date" => $this->created_at,
            "description" => $this->description,
            "video_url" => $this->video_url,
            "details" => $this->details,
            "comments" => $comments
        ];
    }
}
