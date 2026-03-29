<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termin extends Model
{
    protected $table = 'termini';

    protected $fillable = ['instructor_id', 'candidate_id', 'start_time', 'end_time', 'tip_casa'];


    public function instruktor() {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    
    public function kandidat() {
        return $this->belongsTo(User::class, 'candidate_id');
    }
}
