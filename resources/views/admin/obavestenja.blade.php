@extends('layouts.okvir')

@section('sadrzaj')
<div class="dashboard-kontejner" style="padding: 20px;">
    <div class="naslov-sekcija" style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: white; font-size: 2rem;">Upravljanje obaveštenjima</h1>
        <p style="color: var(--siva-tekst); opacity: 0.8;">Kreirajte i upravljajte informacijama za kandidate i instruktore</p>
    </div>

  
    @if(session('status'))
        <div class="staklena-kartica" style="background: rgba(72, 187, 120, 0.2); border: 1px solid #48bb78; margin: 0 auto 20px auto; max-width: 800px; text-align: center; padding: 10px;">
            <span style="color: #48bb78; font-weight: bold;">✅ {{ session('status') }}</span>
        </div>
    @endif

    {{-- dodavvanje novog obavestenja --}}
    <div class="staklena-kartica" style="max-width: 800px; margin: 0 auto 40px auto; padding: 25px;">
        <h3 style="color: #f1c40f; margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
             Nova objava
        </h3>
        
        <form action="{{ route('admin.obavestenja.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; color: white; margin-bottom: 8px; font-weight: 600;">Naslov obaveštenja</label>
                <input type="text" name="naslov" placeholder="Npr. Promena radnog vremena ili termini ispita..." required 
                       style="width: 100%; padding: 12px; border-radius: 8px; border: none; background: rgba(255,255,255,0.9); color: #1a202c;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; color: white; margin-bottom: 8px; font-weight: 600;">Tekst poruke</label>
                <textarea name="poruka" rows="4" placeholder="Detaljan opis obaveštenja..." required 
                          style="width: 100%; padding: 12px; border-radius: 8px; border: none; background: rgba(255,255,255,0.9); color: #1a202c; font-family: inherit;"></textarea>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="dugme-primarno" style="width: auto; padding: 10px 30px; background: #2ecc71; text-transform: none;">
                    Objavi odmah 
                </button>
            </div>
        </form>
    </div>

    {{-- tabela sa postojecim obavestenjima --}}
    <div class="staklena-kartica" style="max-width: 1000px; margin: 0 auto; overflow: hidden; padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <h3 style="color: white; margin: 0;">Prethodne objave</h3>
        </div>
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="text-align: left; background: rgba(255, 255, 255, 0.03); border-bottom: 2px solid rgba(255,255,255,0.1);">
                    <th style="padding: 15px; width: 120px; color: white;">Datum</th>
                    <th style="padding: 15px; width: 200px; color: white;">Naslov</th>
                    <th style="padding: 15px; color: white;">Tekst poruke</th>
                    <th style="padding: 15px; width: 100px; text-align: center; color: white;">Akcija</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obavestenja as $o)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; color: var(--siva-tekst); font-size: 0.9em;">
                            {{ $o->created_at->format('d.m.Y.') }}
                        </td>
                        <td style="padding: 15px; color: white; font-weight: bold;">
                            {{ $o->naslov }}
                        </td>
                        <td style="padding: 15px; color: var(--siva-tekst); line-height: 1.5;">
                            {{ $o->poruka }}
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <form action="{{ route('admin.obavestenja.destroy', $o->id) }}" method="POST" onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovo obaveštenje?')" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background: none; border: 1px solid #e74c3c; color: #e74c3c; padding: 6px 12px; cursor: pointer; border-radius: 6px; font-size: 0.8em; font-weight: bold; transition: 0.3s;"
                                        onmouseover="this.style.background='#e74c3c'; this.style.color='white'" 
                                        onmouseout="this.style.background='none'; this.style.color='#e74c3c'">
                                    Obriši
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($obavestenja->isEmpty())
            <div style="padding: 40px; text-align: center; color: var(--siva-tekst);">
                <span style="font-size: 1.2em; opacity: 0.5;"> Trenutno nema objavljenih obaveštenja.</span>
            </div>
        @endif
    </div>
</div>
@endsection