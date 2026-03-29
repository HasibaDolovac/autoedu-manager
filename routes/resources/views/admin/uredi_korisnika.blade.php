@extends('layouts.okvir')

@section('sadrzaj')
<div style="display: flex; justify-content: center; align-items: center; min-height: 90vh; padding: 40px 20px;">
    
    <div class="staklena-kartica" style="background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(20px); padding: 45px; border-radius: 25px; border: 1px solid rgba(255,255,255,0.1); width: 100%; max-width: 650px; box-shadow: 0 25px 50px rgba(0,0,0,0.5); color: white;">
        
        <div style="text-align: center; margin-bottom: 35px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
            <h1 style="font-size: 2.2em; margin-bottom: 10px;"> Uredi profil</h1>
            <p style="opacity: 0.9; font-size: 1.1em; color: #3498db; font-weight: bold;">{{ $korisnik->name }}</p>
        </div>

        <form action="{{ route('admin.korisnici.update', $korisnik->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                {{-- registr --}}
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display:block; margin-bottom: 10px; font-weight: 700; color: white;">Uloga korisnika:</label>
                        <select name="role" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.9); border: none; border-radius: 10px; color: #2c3e50; font-weight: 600;">
                            <option value="kandidat" {{ $korisnik->role == 'kandidat' ? 'selected' : '' }}>Kandidat</option>
                            <option value="instruktor" {{ $korisnik->role == 'instruktor' ? 'selected' : '' }}>Instruktor</option>
                            <option value="admin" {{ $korisnik->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display:block; margin-bottom: 10px; font-weight: 700; color: white;">Status teorije:</label>
                        <select name="teorija_status" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.9); border: none; border-radius: 10px; color: #2c3e50; font-weight: 600;">
                            <option value="Nije položio" {{ $korisnik->teorija_status == 'Nije položio' ? 'selected' : '' }}> Nije položio</option>
                            <option value="Položeno" {{ $korisnik->teorija_status == 'Položeno' ? 'selected' : '' }}> Položeno</option>
                        </select>
                    </div>
                </div>

                
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display:block; margin-bottom: 10px; font-weight: 700; color: white;">Odvezeno časova:</label>
                        <input type="number" name="odvezeno_casova" value="{{ $korisnik->odvezeno_casova }}" min="0" max="40" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.9); border: none; border-radius: 10px; color: #2c3e50; font-weight: bold;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display:block; margin-bottom: 10px; font-weight: 700; color: white;">Dodeli instruktora:</label>
                        <select name="instruktor_ime" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.9); border: none; border-radius: 10px; color: #2c3e50; font-weight: 600;">
                            <option value="">-- Bez instruktora --</option>
                            @foreach($instruktori as $i)
                                <option value="{{ $i->name }}" {{ $korisnik->instruktor_ime == $i->name ? 'selected' : '' }}>{{ $i->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" style="width: 100%; padding: 15px; background: #2ecc71; color: white; border: none; border-radius: 12px; font-weight: bold; font-size: 1.1em; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);">
                    Sačuvaj sve izmene
                </button>
                
                <a href="{{ route('admin.korisnici') }}" style="display: block; text-align: center; margin-top: 20px; color: white; opacity: 0.6; text-decoration: none; font-weight: 600;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
                     Nazad na listu korisnika
                </a>
            </div>
        </form>
    </div>
</div>
@endsection