<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Termin;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class GlavniSeeder extends Seeder
{
    
    public function run(): void
    {
        User::create([
        'name' => 'Admin Administrator',
        'email' => 'admin@autoedu.com',
        'password' => Hash::make('password'),
        'telefon' => '011/111-222',
        'role' => 'admin',
    ]);

    $ins1 = User::create([
        'name' => 'Ana A',
        'email' => 'ana@autoedu.com',
        'password' => Hash::make('password'),
        'telefon' => '064/111-111',
        'role' => 'instruktor',
    ]);

    $ins2 = User::create([
        'name' => 'Iva I',
        'email' => 'iva@autoedu.com',
        'password' => Hash::make('password'),
        'telefon' => '064/222-222',
        'role' => 'instruktor',
    ]);

    $kan1 = User::create([
        'name' => 'Ema E',
        'email' => 'ema@gmail.com',
        'password' => Hash::make('password'),
        'telefon' => '065/333-333',
        'role' => 'kandidat',
    ]);

    Termin::create([
        'instructor_id' => $ins1->id,
        'candidate_id' => $kan1->id,
        'start_time' => Carbon::now()->startOfWeek()->addHours(10), // Ponedeljak u 10h
        'end_time' => Carbon::now()->startOfWeek()->addHours(11),
        'tip_casa' => 'vožnja',
    ]);

    Termin::create([
        'instructor_id' => $ins2->id,
        'candidate_id' => $kan1->id,
        'start_time' => Carbon::now()->startOfWeek()->addDays(2)->addHours(14), // Sreda u 14h
        'end_time' => Carbon::now()->startOfWeek()->addDays(2)->addHours(15),
        'tip_casa' => 'teorija',
    ]);
    }
}
