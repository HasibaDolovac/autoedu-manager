<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Polja koja Laravel sme da popuni odjednom (Mass Assignment)
    protected $fillable = [
        'user_id',
        'instruktor_id',
        'datum_vreme',
        'status',
        'komentar_instruktora'
    ];

    /**
     * Relacija: Termin pripada korisniku (kandidatu)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relacija: Termin pripada instruktoru
     */
    public function instruktor()
    {
        return $this->belongsTo(User::class, 'instruktor_id');
    }
}