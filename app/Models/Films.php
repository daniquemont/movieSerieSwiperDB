<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Films extends Model
{
    
    public function film(){
        return $this->belongsTo('\App\Models\User', 'user_id','user_id');
    }
}
