<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ["date", "author_id"];
    protected $visible = ["id", "author_name", "body", "date", "is_edited"];
    protected $appends = ["author_name", "date", "is_edited"];
    
    public function campaign(){
        return $this->BelongsTo(Campaign::class);
    }

    public function author(){
        return $this->BelongsTo(User::class);
    }

    public function getDateAttribute(){
        return $this->updated_at;
    }

    public function getAuthorNameAttribute(){
        return $this->author->name;
    }

    public function getIsEditedAttribute(){
        return $this->created_at != $this->updated_at;
    }
}
