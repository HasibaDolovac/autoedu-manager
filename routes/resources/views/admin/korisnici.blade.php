@extends('layouts.okvir')

@section('sadrzaj')
<div class="dashboard-kontejner">
    <div class="naslov-sekcija" style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: white; font-size: 2rem;">Upravljanje korisnicima</h1>
        <p style="color: var(--siva-tekst);">Pregled svih registrovanih instruktora i kandidata u sistemu.</p>
    </div>

    @if(session('error'))
        <div style="background: rgba(231, 76, 60, 0.2); border: 1px solid #e74c3c; color: white; padding: 15px; margin-bottom: 20px; border-radius: 8px; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    <div class="staklena-kartica" style="max-width: 1000px; width: 95%; margin: 0 auto; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid rgba(255,255,255,0.1);">
                    <th style="padding: 15px; color: white;">Ime i prezime</th>
                    <th style="padding: 15px; color: white;">Email</th>
                    <th style="padding: 15px; color: white;">Telefon</th>
                    <th style="padding: 15px; color: white;">Uloga</th>
                    <th style="padding: 15px; color: white; text-align: center;">Akcija</th>
                </tr>
            </thead>
            <tbody>
                @foreach($korisnici as $k)
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.03)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; color: white;"><strong>{{ $k->name }}</strong></td>
                    <td style="padding: 15px; color: var(--siva-tekst);">{{ $k->email }}</td>
                    <td style="padding: 15px; color: var(--siva-tekst);">{{ $k->telefon }}</td>
                    <td style="padding: 15px;">
                        <span style="background: rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 6px; font-size: 0.8em; color: white; text-transform: capitalize;">
                            {{ $k->role }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        {{-- Flexbox kontejner koji sprečava preklapanje --}}
                        <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
                            
                            {{-- Dugme Uredi --}}
                            <a href="{{ route('admin.korisnici.edit', $k->id) }}" 
                               style="text-decoration: none; border: 1px solid #3498db; color: #3498db; padding: 6px 14px; border-radius: 6px; font-size: 0.85em; font-weight: bold; transition: 0.3s; white-space: nowrap;"
                               onmouseover="this.style.background='#3498db'; this.style.color='white'" 
                               onmouseout="this.style.background='none'; this.style.color='#3498db'">
                                Uredi
                            </a>

                            {{-- Dugme Obriši (unutar svoje forme, ispravno pozicionirano) --}}
                            <form action="{{ route('admin.korisnici.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Da li ste sigurni?')" style="margin: 0;">
                                @csrf
                                @method('DELETE') 
                                <button type="submit" 
                                        style="background: none; border: 1px solid #e74c3c; color: #e74c3c; padding: 6px 14px; border-radius: 6px; cursor: pointer; font-size: 0.85em; font-weight: bold; transition: 0.3s; white-space: nowrap;"
                                        onmouseover="this.style.background='#e74c3c'; this.style.color='white'" 
                                        onmouseout="this.style.background='none'; this.style.color='#e74c3c'">
                                    Obriši
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection