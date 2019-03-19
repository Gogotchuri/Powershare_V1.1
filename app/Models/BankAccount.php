<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
}
