<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Review;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PocetnaController extends Controller
{
    /**
     * Glavni Dashboard / Welcome strana
     */
    public function index()
    {
        $obavestenja = Announcement::latest()->get();
        $recenzije = Review::latest()->get();
        
        if (!Auth::check()) {
            return view('welcome', compact('obavestenja', 'recenzije'));
        }

        $user = Auth::user();
        $mojiTermini = collect(); 
        $statistika = [];
        $mojiKandidati = collect();
        $sviInstruktori = User::where('role', 'instruktor')->get();

        if ($user->role == 'admin') {
            $statistika['korisnici'] = User::count();
            $statistika['termini'] = Appointment::count();
        } 
        elseif ($user->role == 'instruktor') {
            // Uzimamo kandidate kojima je ovaj korisnik dodeljen kao instruktor
            $mojiKandidati = User::where('instruktor_ime', $user->name)->get();
        } 
        elseif ($user->role == 'kandidat') {
            // Uzimamo SVE termine kandidata (poređane od najnovijeg ka najstarijem)
            // kako bi mogao da vidi savete instruktora sa završenih časova
            $mojiTermini = Appointment::where('user_id', $user->id)
                ->orderBy('datum_vreme', 'desc')
                ->get();
        }

        return view('welcome', compact(
            'obavestenja', 'recenzije', 'user', 'mojiTermini', 
            'statistika', 'mojiKandidati', 'sviInstruktori'
        ));
    }

    /**
     * Lista termina za instruktora (ako ikada napraviš termini.blade.php)
     */
    public function mojiTermini()
    {
        $termini = Appointment::with('user')
            ->where('instruktor_id', Auth::id())
            ->orderBy('datum_vreme', 'asc')
            ->get();

        return view('instruktor.termini', compact('termini'));
    }

    /**
     * Prikaz stranice za evidenciju vožnji
     */
    public function evidencijaVoznji()
    {
        // Izvlačimo kandidate za ulogovanog instruktora
        $mojiKandidati = User::where('instruktor_ime', Auth::user()->name)
                     ->whereNotNull('name') // Ovo će sakriti "duhove" u tabeli
                     ->get();
        // Ovo gađa tvoj fajl resources/views/evidencija.blade.php
        return view('instruktor.evidencija', compact('mojiKandidati'));
    }

    public function obrisiRecenziju($id)
{
    // Provera da li je korisnik admin
    if (auth()->user()->role !== 'admin') {
        return back()->with('error', 'Nemate ovlašćenje za ovu akciju.');
    }

    $recenzija = Review::findOrFail($id);
    $recenzija->delete();

    return back()->with('status', 'Recenzija je uspešno obrisana.');
}
}
