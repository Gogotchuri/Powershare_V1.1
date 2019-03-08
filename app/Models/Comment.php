<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $appends = ["author_name"];
    
    public function campaign(){
        return $this->BelongsTo(Campaign::class);
    }

    public function author(){
        return $this->BelongsTo(User::class);
    }

    public function date(){
        return $this->date;
    }

    public function getAuthorNameAttribute(){
        return $this->author->name;
    }
}
