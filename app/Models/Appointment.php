<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

  
    protected $fillable = [
        'user_id',
        'instruktor_id',
        'datum_vreme',
        'status',
        'komentar_instruktora'
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function instruktor()
    {
        return $this->belongsTo(User::class, 'instruktor_id');
    }
}