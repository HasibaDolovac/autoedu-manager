@extends('layouts.okvir')

@section('sadrzaj')
<div style="display: flex; justify-content: center; align-items: center; min-height: 85vh; padding: 20px;">
    
    <div class="staklena-kartica" style="background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(20px); padding: 25px 30px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); width: 100%; max-width: 380px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); color: white;">
        
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="font-size: 1.8em; margin-bottom: 5px; letter-spacing: 1px;">Prijava</h1>
            <p style="opacity: 0.9; font-size: 0.95em;">Dobrodošli nazad u AutoEdu sistem</p>
        </div>

        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid #e74c3c; color: #ff9f94; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.85em;">
                 Pogrešan email ili lozinka.
            </div>
        @endif

        <form action="{{ route('provera.prijave') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom: 5px; font-weight: 700; color: white; font-size: 0.7em;">Email adresa</label>
                <input type="email" name="email" placeholder="vas@email.com" required 
                       style="width: 93%; padding: 12px; background: rgba(255,255,255,0.9); border: none; border-radius: 8px; color: #2c3e50; font-size: 0.95em; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom: 5px; font-weight: 700; color: white; font-size: 0.7em;">Lozinka</label>
                <input type="password" name="password" placeholder="password" required 
                       style="width: 93%; padding: 12px; background: rgba(255,255,255,0.9); border: none; border-radius: 8px; color: #2c3e50; font-size: 0.95em; outline: none;">
            </div>

            <button type="submit" style="width: 100%; padding: 14px; background: #3498db; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3); letter-spacing: 1px;">
                Uloguj se 
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
            <p style="opacity: 1; font-size: 0.9em; margin: 0;">
                Nemaš nalog? 
                <a href="/napravi-nalog" style="color: #2ecc71; text-decoration: none; font-weight: bold;">Registruj se ovde</a>
            </p>
        </div>

    </div>
</div>
@endsection