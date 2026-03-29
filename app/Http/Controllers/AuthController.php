<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function otvoriRegistraciju() {
        return view('autentifikacija.registracija');
    }

    
    public function sacuvajKorisnika(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
            'telefon' => 'required',
            
            'kategorija' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'telefon' => $request->telefon,
            'kategorija' => $request->kategorija,
            'odvezeno_casova' => 0, 
            'teorija_status' => 'Nije položeno' 
        ]);

        Auth::login($user);
        
        return redirect()->route('pocetna')->with('status', 'Uspešno ste napravili nalog!');
    }

    
    public function prikaziLogin() {
        return view('autentifikacija.prijava');
    }

    
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('pocetna')->with('status', 'Dobrodošli nazad!');
        }

        return back()->withErrors(['email' => 'Pogrešni podaci za pristup.']);
    }

    
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('pocetna');
    }
}