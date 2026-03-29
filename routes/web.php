<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PocetnaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;


// GOSTI
Route::get('/', [PocetnaController::class, 'index'])->name('pocetna');

// Registracija
Route::get('/napravi-nalog', [AuthController::class, 'otvoriRegistraciju'])->name('registracija');
Route::post('/sacuvaj-korisnika', [AuthController::class, 'sacuvajKorisnika'])->name('sacuvaj.korisnika');

// Prijava
Route::get('/prijava', [AuthController::class, 'prikaziLogin'])->name('login');
Route::get('/uloguj-se', [AuthController::class, 'prikaziLogin'])->name('prijava');
Route::post('/provera-prijave', [AuthController::class, 'login'])->name('provera.prijave');

// ---  RUTE ZA SVE KORISNIKE ---
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PocetnaController::class, 'index'])->name('dashboard');
    
    // Recenzije
    Route::post('/ostavi-recenziju', [UserController::class, 'ostaviRecenziju'])->name('recenzija.store');
});

// ---  ADMIN RUTE ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/svi-korisnici', [UserController::class, 'sviKorisnici'])->name('admin.korisnici');
    Route::delete('/admin/korisnici/{id}', [UserController::class, 'destroy'])->name('admin.korisnici.destroy');
    Route::get('/admin/korisnik/{id}/uredi', [UserController::class, 'urediKorisnika'])->name('admin.korisnici.edit');
    Route::put('/admin/korisnik/{id}/azuriraj', [UserController::class, 'azurirajKorisnika'])->name('admin.korisnici.update');
    
    Route::get('/obavestenja-sistema', [AnnouncementController::class, 'index'])->name('admin.obavestenja');
    Route::post('/sacuvaj-obavestenje', [AnnouncementController::class, 'store'])->name('admin.obavestenja.store');
    Route::delete('/obavestenja/{id}', [AnnouncementController::class, 'destroy'])->name('admin.obavestenja.destroy');
    Route::delete('/recenzija/{id}', [PocetnaController::class, 'obrisiRecenziju'])->name('recenzija.obrisi')->middleware('auth');
});

// ---  INSTRUKTOR RUTE ---
Route::middleware(['auth'])->group(function () {

    Route::get('/moji-termini', [PocetnaController::class, 'mojiTermini'])->name('instruktor.termini');
    
    Route::get('/evidencija-voznji', [PocetnaController::class, 'evidencijaVoznji'])->name('instruktor.evidencija');
    Route::post('/prihvati-kandidata/{id}', [UserController::class, 'prihvatiKandidata'])->name('instruktor.prihvati');
    Route::post('/odbij-kandidata/{id}', [UserController::class, 'odbijKandidata'])->name('instruktor.odbij');
    Route::post('/dodaj-cas/{id}', [UserController::class, 'dodajCas'])->name('instruktor.dodaj-cas');
    Route::post('/zakazi-termin', [UserController::class, 'zakaziTermin'])->name('instruktor.zakazi-cas'); 
    Route::post('/azuriraj-teoriju/{id}', [UserController::class, 'azurirajTeoriju'])->name('instruktor.teorija.update');
    Route::post('/sacuvaj-komentar/{id}', [UserController::class, 'sacuvajKomentar'])->name('instruktor.komentar.sacuvaj');
    Route::get('/obrisi-komentar/{id}', [UserController::class, 'obrisiKomentar'])->name('instruktor.komentar.obrisi');
   Route::post('/instruktor/teorija/{id}', [UserController::class, 'potvrdiTeoriju'])->name('instruktor.potvrdi-teoriju');
    });

// ---  KANDIDAT RUTE ---
Route::middleware(['auth'])->group(function () {

    Route::post('/posalji-zahtev', [UserController::class, 'posaljiZahtev'])->name('kandidat.posalji-zahtev');
});