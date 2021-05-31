<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public function serie(){
        return $this->belongsTo('\App\Models\User', 'user_id','user_id');
    }
}
