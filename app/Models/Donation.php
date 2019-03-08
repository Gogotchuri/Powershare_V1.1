<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public function campaign(){
        return $this->BelongsTo(Campaign::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
