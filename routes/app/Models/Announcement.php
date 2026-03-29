<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // Ovo rešava grešku - dozvoljavamo upis naslova i poruke
    protected $fillable = ['naslov', 'poruka'];
}
