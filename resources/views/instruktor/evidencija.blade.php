@extends('layouts.okvir')

@section('sadrzaj')
<div style="padding: 40px 20px; display: flex; justify-content: center;">
    <div class="staklena-kartica" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(15px); padding: 40px; border-radius: 25px; color: white; width: 100%; max-width: 1100px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        
        <div style="margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
            <h1 style="font-size: 2.2em; margin-bottom: 5px;"> Evidencija i Saveti</h1>
            <p style="opacity: 0.7;">Upravljajte progresom i ostavite povratne informacije kandidatima.</p>
        </div>

        @foreach($mojiKandidati as $kand)
            <div style="background: rgba(255,255,255,0.03); border-radius: 20px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 20px; overflow: hidden;">
                {{-- GLAVNI RED KANDIDATA --}}
                <div style="padding: 20px; display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02);">
                    <div style="flex: 1;">
                        <div style="font-weight: 600; font-size: 1.2em;">{{ $kand->name }}</div>
                        <div style="font-size: 0.85em; opacity: 0.5;">{{ $kand->telefon }}</div>
                    </div>

                    <div style="flex: 1; text-align: center;">
                        <div style="font-size: 0.9em; margin-bottom: 5px;">Teorija: 
                            <span style="color: {{ $kand->teorija_status == 'Položeno' ? '#2ecc71' : '#f1c40f' }}">
                                {{ $kand->teorija_status }}
                            </span>
                        </div>
                        <div style="width: 120px; height: 6px; background: rgba(255,255,255,0.1); border-radius: 10px; margin: 0 auto; overflow: hidden;">
                            <div style="width: {{ min(($kand->odvezeno_casova / 40) * 100, 100) }}%; height: 100%; background: #2ecc71;"></div>
                        </div>
                        <small>{{ $kand->odvezeno_casova }}/40 časova</small>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('instruktor.dodaj-cas', $kand->id) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 0.85em;">+ Upis časa</button>
                        </form>
                    </div>
                </div>

                {{-- sekcija za komentar --}}
                <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.2);">
                    <h4 style="font-size: 0.9em; color: #3498db; margin-bottom: 15px;"> Istorija termina i saveti:</h4>
                    
                    @php 
                        $svitermini = \App\Models\Appointment::where('user_id', $kand->id)
                                        ->orderBy('datum_vreme', 'desc')
                                        ->get();
                    @endphp

                    @forelse($svitermini as $termin)
                        @php $jeProslost = \Carbon\Carbon::parse($termin->datum_vreme)->isPast(); @endphp
                        
                        <div style="background: rgba(255,255,255,0.03); padding: 15px; border-radius: 12px; margin-bottom: 10px; border: 1px solid {{ $jeProslost ? 'rgba(46, 204, 113, 0.2)' : 'rgba(255,255,255,0.05)' }};">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; align-items: center;">
                                <span style="font-size: 0.85em; opacity: 0.7;"> {{ \Carbon\Carbon::parse($termin->datum_vreme)->format('d.m.Y. H:i') }}h</span>
                                
                                @if($jeProslost)
                                    <span style="color: #2ecc71; font-size: 0.75em; font-weight: bold; letter-spacing: 1px;">✅ OBAVLJENO</span>
                                @else
                                    <span style="color: #f1c40f; font-size: 0.75em; font-weight: bold; letter-spacing: 1px;">⏳ ZAKAZANO</span>
                                @endif
                            </div>

                            {{-- prikaz komentara ako je cas prosao --}}
                            @if($jeProslost)
                                <form action="{{ route('instruktor.komentar.sacuvaj', $termin->id) }}" method="POST">
                                    @csrf
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <input type="text" name="komentar" value="{{ $termin->komentar_instruktora }}" placeholder="Upišite zapažanje ili savet..." 
                                               style="flex: 1; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 8px 12px; border-radius: 8px; color: white; font-size: 0.9em;">
                                        
                                        <button type="submit" style="background: #3498db; border: none; color: white; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-size: 0.85em; font-weight: bold;">Sačuvaj</button>
                                        
                                        @if($termin->komentar_instruktora)
                                            <a href="{{ route('instruktor.komentar.obrisi', $termin->id) }}" 
                                               style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; padding: 8px 12px; border-radius: 8px; text-decoration: none; font-size: 0.8em; border: 1px solid rgba(231, 76, 60, 0.3);"
                                               onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj savet?')">
                                               Obriši
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            @else
                                <div style="font-size: 0.85em; opacity: 0.5; font-style: italic; padding: 5px 0;">
                                    Komentarisanje će biti dostupno nakon što se termin završi.
                                </div>
                            @endif
                        </div>
                    @empty
                        <p style="font-size: 0.85em; opacity: 0.4;">Trenutno nema zakazanih termina za ovog kandidata.</p>
                    @endforelse
                </div>
            </div>
        @endforeach

        <div style="margin-top: 35px;">
            <a href="{{ route('pocetna') }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.1); padding: 12px 25px; border-radius: 12px; color: white; transition: 0.3s; font-weight: 600; border: 1px solid rgba(255,255,255,0.1);">
                 Nazad na Dashboard
            </a>
        </div>
    </div>
</div>
@endsection