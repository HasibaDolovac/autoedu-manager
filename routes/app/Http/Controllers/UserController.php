<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function sviKorisnici() {
        $korisnici = User::where('role', '!=', 'admin')->get();
        return view('admin.korisnici', compact('korisnici'));
    }

    public function destroy($id) {
        $korisnik = User::findOrFail($id);
        if(auth()->id() == $id) {
            return redirect()->back()->with('error', 'Ne možete obrisati sopstveni nalog!');
        }
        $korisnik->delete();
        return redirect()->back()->with('status', 'Korisnik je uspešno obrisan.');
    }

    public function urediKorisnika($id) {
        $korisnik = User::findOrFail($id);
        $instruktori = User::where('role', 'instruktor')->get();
        return view('admin.uredi_korisnika', compact('korisnik', 'instruktori'));
    }

    public function azurirajKorisnika(Request $request, $id) {
        $korisnik = User::findOrFail($id);
        $korisnik->update([
            'odvezeno_casova' => $request->odvezeno_casova,
            'teorija_status' => $request->teorija_status,
            'instruktor_ime' => $request->instruktor_ime,
            'role' => $request->role ?? $korisnik->role
        ]);
        return redirect()->route('admin.korisnici')->with('status', 'Podaci uspešno ažurirani!');
    }

    public function posaljiZahtev(Request $request) {
        $kandidat = auth()->user();
        $kandidat->update([
            'instruktor_ime' => $request->instruktor_name . ' (ČEKA ODOBRENJE)'
        ]);
        return redirect()->back()->with('status', 'Zahtev je uspešno poslat!');
    }

    public function prihvatiKandidata($id) {
        $kandidat = User::findOrFail($id);
        $kandidat->update(['instruktor_ime' => auth()->user()->name]);
        return redirect()->back()->with('status', 'Uspešno ste prihvatili kandidata!');
    }

    public function odbijKandidata($id) {
        $kandidat = User::findOrFail($id);
        $kandidat->update(['instruktor_ime' => null]); 
        return redirect()->back()->with('status', 'Zahtev kandidata je odbijen.');
    }

    public function potvrdiTeoriju($id)
    {
        $kandidat = User::findOrFail($id);
        
      
        $noviStatus = ($kandidat->teorija_status == 1) ? 0 : 1;
        
        $kandidat->update(['teorija_status' => $noviStatus]);

        return back()->with('status', 'Status teorije je promenjen!');
    }

    public function ostaviRecenziju(Request $request) {
        Review::create([
            'user_id' => auth()->id(),
            'autor' => auth()->user()->name,
            'komentar' => $request->komentar,
            'ocena' => $request->ocena ?? 5,
        ]);
        return redirect()->back()->with('status', 'Hvala na recenziji!');
    }

    public function dodajCas($id) {
        $kandidat = User::findOrFail($id);
        $kandidat->increment('odvezeno_casova');
        return redirect()->back()->with('status', 'Čas je uspešno evidentiran.');
    }

    public function zakaziTermin(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'termin' => 'required'
        ]);

        Appointment::create([
            'user_id' => $request->user_id,
            'instruktor_id' => auth()->id(),
            'datum_vreme' => $request->termin,
            'status' => 'zakazano'
        ]);

        return redirect()->back()->with('status', 'Termin uspešno dodat!');
    }

    public function azurirajTeoriju(Request $request, $id) {
        $korisnik = User::findOrFail($id);
        $korisnik->update(['teorija_status' => $request->teorija_status]);
        return redirect()->back()->with('status', 'Status teorije ažuriran.');
    }

    public function sacuvajKomentar(Request $request, $id)
{
    $request->validate(['komentar' => 'required|string|max:500']);
    $termin = Appointment::findOrFail($id);
//da li je termin prosao
    if (!\Carbon\Carbon::parse($termin->datum_vreme)->isPast()) {
        return back()->with('error', 'Ne možete komentarisati termin koji još uvek nije održan.');
    }

    $termin->update(['komentar_instruktora' => $request->komentar]);
    return back()->with('status', 'Beleška je uspešno sačuvana!');
}
    public function obrisiKomentar($id)
{
    $termin = Appointment::findOrFail($id);
    $termin->update(['komentar_instruktora' => null]);
    return back()->with('status', 'Komentar je uspešno obrisan.');
}
}