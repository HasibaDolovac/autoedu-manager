<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Dozvoljavamo bazi da upiše ove podatke
    protected $fillable = ['user_id'
    , 'autor',
     'komentar', 
     'ocena'];
}
