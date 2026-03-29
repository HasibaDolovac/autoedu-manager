@extends('layouts.okvir')

@section('sadrzaj')
<div style="padding: 40px 20px; display: flex; justify-content: center;">
    
    <div class="staklena-kartica" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(15px); padding: 40px; border-radius: 25px; color: white; width: 100%; max-width: 1000px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        
        <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
            <h1 style="font-size: 2.2em; margin-bottom: 5px;"> Moji zakazani termini</h1>
            <p style="opacity: 0.7;">Pregled svih predstojećih vožnji sa kandidatima u vašem kalendaru.</p>
        </div>

        <div style="overflow-x: auto; background: rgba(255,255,255,0.03); border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
            @if($termini->count() > 0)
                <table style="width: 100%; border-collapse: collapse; min-width: 600px; text-align: left;">
                    <thead style="background: rgba(255,255,255,0.05);">
                        <tr>
                            <th style="padding: 18px; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8;">Datum i vreme</th>
                            <th style="padding: 18px; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8;">Kandidat</th>
                            <th style="padding: 18px; font-size: 0.9em; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; text-align: right;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($termini as $t)
                            {{-- -ako korisnik postoji prikazuje se red --}}
                            @if($t->user)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 18px; font-family: monospace; font-size: 1.1em;">
                                        {{ \Carbon\Carbon::parse($t->datum_vreme)->format('d.m.Y | H:i') }}
                                    </td>
                                    <td style="padding: 18px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 35px; height: 35px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8em;">
                                                {{ substr($t->user->name, 0, 1) }}
                                            </div>
                                            <span style="font-weight: 600;">{{ $t->user->name }}</span>
                                        </div>
                                    </td>
                                    <td style="padding: 18px; text-align: right;">
                                        @if(\Carbon\Carbon::parse($t->datum_vreme)->isPast())
                                            <span style="background: rgba(46, 204, 113, 0.15); color: #2ecc71; padding: 6px 15px; border-radius: 30px; font-size: 0.85em; font-weight: bold; border: 1px solid rgba(46, 204, 113, 0.3);">
                                             Obavljeno
                                            </span>
                                        @else
                                            <span style="background: rgba(241, 196, 15, 0.15); color: #f1c40f; padding: 6px 15px; border-radius: 30px; font-size: 0.85em; font-weight: bold; border: 1px solid rgba(241, 196, 15, 0.3);">
                                                Zakazano
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endif 
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 60px 20px; text-align: center;">
                    
                    <p style="opacity: 0.6; font-size: 1.1em;">Trenutno nema zakazanih termina u vašem kalendaru.</p>
                </div>
            @endif
        </div>

        
        <div style="margin-top: 35px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('dashboard') }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.1); padding: 12px 25px; border-radius: 12px; color: white; transition: 0.3s; font-weight: 600; border: 1px solid rgba(255,255,255,0.1);" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                 Nazad na Dashboard
            </a>
            
            <p style="font-size: 0.85em; opacity: 0.5; margin: 0;">Ukupno termina: <strong>{{ $termini->count() }}</strong></p>
        </div>

    </div>
</div>
@endsection