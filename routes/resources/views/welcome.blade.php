@extends('layouts.okvir')



@section('sadrzaj')

<div class="welcome-sekcija" style="padding: 40px 20px;">
    <div class="staklena-kartica" style="background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(15px); padding: 40px; border-radius: 25px; color: white; max-width: 550px; margin: 0 auto; border: 1px solid rgba(255,255,255,0.1);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="font-size: 1.5em; margin-bottom: 10px;">Dobrodošli u <span style="color: #3498db;">AutoEdu</span></h1>
            <p style="opacity: 0.8;">Vaš centar za sigurnu i brzu obuku vozača.</p>
        </div>

        @auth
            <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 12px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
                <p style="margin: 0;">Korisnik: <strong>{{ Auth::user()->name }}</strong></p>
                <span style="background: #3498db; padding: 5px 15px; border-radius: 20px; font-size: 0.85em; font-weight: bold;">{{ strtoupper(Auth::user()->role) }}</span>
            </div>

            {{-- biranje instruktora --}}
            @if(Auth::user()->role == 'kandidat' && !Auth::user()->instruktor_ime)
                <div style="background: rgba(255, 255, 255, 0.05); padding: 30px; border-radius: 20px; border: 1px solid #f1c40f; margin-bottom: 30px;">
                    <h3 style="color: #f1c40f; margin-bottom: 20px;">🚀 Započni obuku</h3>
                    <form action="{{ route('kandidat.posalji-zahtev') }}" method="POST">
                        @csrf
                        <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                            <div style="width: 60px; height: 60px; background: #f1c40f; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5em; color: black;">🚗</div>
                            <div style="flex: 1; min-width: 250px;">
                                <label style="display: block; margin-bottom: 8px; opacity: 0.8;">Izaberi svog instruktora:</label>
                                <select name="instruktor_name" required style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: white; color: black; font-weight: bold;">
                                    <option value="">-- Lista dostupnih instruktora --</option>
                                    @foreach($sviInstruktori as $inst)
                                        <option value="{{ $inst->name }}">{{ $inst->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" style="background: #6c5ce7; color: white; border: none; padding: 15px 30px; border-radius: 10px; font-weight: bold; cursor: pointer;">POŠALJI ZAHTEV</button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- pracenje progresa kod kandidata sa obavljenim casovima --}}
@if(Auth::user()->role == 'kandidat' && Auth::user()->instruktor_ime && !str_contains(Auth::user()->instruktor_ime, '(ČEKA)'))
    <div style="background: rgba(46, 204, 113, 0.1); padding: 25px; border-radius: 20px; border: 1px solid rgba(46, 204, 113, 0.3); margin-bottom: 30px; text-align: center;">
        <h3 style="margin-bottom: 15px; color: #2ecc71;">Tvoj napredak obuke</h3>
        
        <div style="font-size: 1.2em; font-weight: bold; margin-bottom: 10px;">
            {{ Auth::user()->odvezeno_casova }} / 40 <span style="font-size: 0.8em; opacity: 0.7;">obavljenih časova</span>
        </div>

        
        <div style="width: 100%; height: 12px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden; margin: 10px 0;">
            <div style="width: {{ min((Auth::user()->odvezeno_casova / 40) * 100, 100) }}%; height: 100%; background: #2ecc71; box-shadow: 0 0 15px rgba(46, 204, 113, 0.5); transition: 0.5s;"></div>
        </div>

        <p style="font-size: 0.85em; opacity: 0.6; margin-top: 5px;">
            @if(Auth::user()->odvezeno_casova >= 40)
                 Čestitamo! Ispunili ste fond časova.
            @else
                Preostalo vam je još {{ 40 - Auth::user()->odvezeno_casova }} časova do polaganja vožnje.
            @endif
        </p>
    </div>
@endif
                    
            {{-- kandidat TERMINI I KOMENTARI INSTR --}}
            @if(Auth::user()->role == 'kandidat' && Auth::user()->instruktor_ime && !str_contains(Auth::user()->instruktor_ime, '(ČEKA)'))
                <div style="margin-bottom: 40px; background: rgba(52, 152, 219, 0.05); padding: 25px; border-radius: 20px; border: 1px solid rgba(52, 152, 219, 0.2);">
                    <h3 style="color: #3498db; margin-bottom: 20px;"> Moji termini i saveti instruktora</h3>

                    <div style="display: grid; gap: 15px;">
                        @forelse($mojiTermini as $termin)
                            <div style="background: rgba(255, 255, 255, 0.07); padding: 18px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <span style="font-size: 1.1em; font-weight: bold;">{{ \Carbon\Carbon::parse($termin->datum_vreme)->format('d.m.Y.') }}</span>
                                        <span style="margin-left: 15px; color: #3498db; font-weight: bold;"> {{ \Carbon\Carbon::parse($termin->datum_vreme)->format('H:i') }}h</span>
                                    </div>
                                    
                                    <div style="font-size: 0.85em;">
                                        @if(\Carbon\Carbon::parse($termin->datum_vreme)->isPast())
                                            <span style="color: #2ecc71; background: rgba(46, 204, 113, 0.1); padding: 4px 10px; border-radius: 10px; border: 1px solid #2ecc71;"> Obavljeno</span>
                                        @else
                                            <span style="color: #f1c40f; background: rgba(241, 196, 15, 0.1); padding: 4px 10px; border-radius: 10px; border: 1px solid #f1c40f;"> Zakazano</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- prikaz komentara --}}
                                @if($termin->komentar_instruktora)
                                    <div style="margin-top: 12px; padding: 12px; background: rgba(52, 152, 219, 0.1); border-left: 4px solid #3498db; border-radius: 4px; font-style: italic; font-size: 0.95em; color: #ecf0f1;">
                                        <span style="display: block; font-size: 0.75em; text-transform: uppercase; letter-spacing: 1px; color: #3498db; margin-bottom: 5px; font-style: normal; font-weight: bold;">💡 Savet instruktora:</span>
                                        "{{ $termin->komentar_instruktora }}"
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p style="text-align: center; opacity: 0.5;">Trenutno nemate zakazanih vožnji.</p>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- STATUS TEROIJE KOJU MENJA ISNTR I ODREDJENIM SLUCAJEVIMA ADMIN --}}
<div style="background: rgba(255, 255, 255, 0.03); padding: 25px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 30px;">
    <h3 style="color: #f1c40f; margin-bottom: 15px;"> Status teorijskog ispita</h3>
    <table style="width: 100%; border-collapse: collapse; color: white;">
    <thead>
        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left; opacity: 0.7; font-size: 0.9em;">
            <th style="padding: 10px;">Kandidat</th>
            <th style="padding: 10px;">Teorija</th>
            <th style="padding: 10px; text-align: right;">Akcija</th>
        </tr>
    </thead>
    <tbody>
    @if(Auth::user()->role == 'instruktor' || Auth::user()->role == 'admin')
       
        @php 
           
            $prikazKandidata = (Auth::user()->role == 'admin') 
                ? \App\Models\User::where('role', 'kandidat')->get() 
                : \App\Models\User::where('instruktor_ime', Auth::user()->name)->get(); 
        @endphp

        @foreach($prikazKandidata as $kand)
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <td style="padding: 12px;"><strong>{{ $kand->name }}</strong></td>
                <td style="padding: 12px;">
                    @if($kand->teorija_status == 1)
                        <span style="color: #2ecc71; font-weight: bold;"> Položio</span>
                    @else
                        <span style="color: #e74c3c; font-weight: bold;"> Nije položio</span>
                    @endif
                </td>
                <td style="padding: 12px; text-align: right;">
                    @if(Auth::user()->role == 'instruktor')
                        {{-- samo instruktor ima dugme na pocetnoj str --}}
                        <form action="{{ route('instruktor.potvrdi-teoriju', $kand->id) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: {{ $kand->teorija_status ? '#95a5a6' : '#f1c40f' }}; color: black; border: none; padding: 5px 12px; border-radius: 5px; cursor: pointer; font-size: 0.8em; font-weight: bold;">
                                {{ $kand->teorija_status ? 'Poništi' : 'Potvrdi polaganje' }}
                            </button>
                        </form>
                    @else
                        {{-- admin vidi samo info tekst na ovoj strani --}}
                        <span style="font-size: 0.8em; opacity: 0.5;">Status dodeljuje instruktor</span>
                    @endif
                </td>
            </tr>
        @endforeach

    @elseif(Auth::user()->role == 'kandidat')
        {{-- kandidat vidi sebe --}}
        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
            <td style="padding: 12px;"><strong>{{ Auth::user()->name }}</strong></td>
            <td style="padding: 12px;">
                @if(Auth::user()->teorija_status == 1)
                    <span style="color: #2ecc71; font-weight: bold;"> Položeno</span>
                @else
                    <span style="color: #f1c40f; font-weight: bold;"> U toku / Nije položeno</span>
                @endif
            </td>
            <td style="padding: 12px; text-align: right;">
                <span style="font-size: 0.8em; opacity: 0.5;">Status dodeljuje instruktor</span>
            </td>
        </tr>
    @endif
</tbody>
</table>
</div>

           {{-- INSTR UPRAVLJANJE ZAHTEVIMA I TERMINIMA --}}
@if(Auth::user()->role == 'instruktor')
    <div style="margin-bottom: 35px;">
        <h3 style="border-left: 4px solid #2ecc71; padding-left: 15px;"> Zahtevi kandidata na čekanju</h3>
        
        @php 
            $zahtevi = \App\Models\User::where('instruktor_ime', Auth::user()->name . ' (ČEKA SE ODOBRENJE)')->get(); 
        @endphp

        @forelse($zahtevi as $z)
            
            <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 12px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center; border: 1px solid rgba(255,255,255,0.1);">
                
                
                <span>
                    <strong>{{ $z->name }}</strong> 
                    <span style="opacity: 0.6; font-size: 0.9em; margin-left: 5px;">(Tel: {{ $z->telefon }})</span>
                </span>
                
    
                <div style="display: flex; gap: 8px; align-items: center;">
    
                    <form action="{{ route('instruktor.prihvati', $z->id) }}" method="POST" style="margin:0;"> 
                        @csrf 
                        <button type="submit" style="background: #2ecc71; color: white; border:none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 0.9em; transition: 0.2s; white-space: nowrap;" 
                            onmouseover="this.style.background='#27ae60'" onmouseout="this.style.background='#2ecc71'">
                            Prihvati
                        </button>
                    </form>

                    <form action="{{ route('instruktor.odbij', $z->id) }}" method="POST" onsubmit="return confirm('Odbiti ovog kandidata?')" style="margin:0;"> 
                        @csrf 
                        <button type="submit" style="background: #e74c3c; color: white; border:none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 0.9em; transition: 0.2s; white-space: nowrap;"
                            onmouseover="this.style.background='#c0392b'" onmouseout="this.style.background='#e74c3c'">
                            Odbij
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p style="opacity: 0.5; font-size: 0.9em; margin-top: 10px;">Nema novih zahteva.</p>
        @endforelse
    </div>

    {{-- FORMA ZA ZAKAZIVANJE --}}
    <div style="background: rgba(52, 152, 219, 0.1); border: 1px solid #3498db; padding: 25px; border-radius: 15px; margin-bottom: 40px;">
        <h3 style="color: #3498db;"> Zakaži novi termin</h3>
        <form action="{{ route('instruktor.zakazi-cas') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
               
                    <select name="user_id" required style="padding: 10px; width: 100%; color: black;">
    <option value="">-- Izaberi kandidata (samo položena teorija) --</option>
    
    @php 
        // uzimamo samo kandidate ovog instruktora 
        $spremniKandidati = app\Models\User::where('instruktor_ime', Auth::user()->name)
                                ->where('teorija_status', 1)
                                ->get(); 
    @endphp

    @foreach($spremniKandidati as $k)
        <option value="{{ $k->id }}">{{ $k->name }}</option>
    @endforeach
</select>
                <input type="datetime-local" name="termin" required style="padding: 10px; border-radius: 8px; color: black;">
            </div>
            <button type="submit" style="background: #3498db; color: white; border: none; padding: 12px; border-radius: 8px; width: 100%; margin-top: 15px; font-weight: bold; cursor: pointer;">POTVRDI TERMIN</button>
        </form>
    </div>
@endif
           {{--  RECENZIJE --}}
<div style="margin-top: 50px;">
    <h3 style="color: #f1c40f; margin-bottom: 20px;">💬 Šta kažu naši kandidati?</h3>
    @foreach($recenzije as $r)
        <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 15px; margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <strong>{{ $r->autor }}</strong>: {{ $r->komentar }}
            </div>
{{-- samo admin brise recenzije  --}}
            @if(Auth::check() && Auth::user()->role == 'admin')
                <form action="{{ route('recenzija.obrisi', $r->id) }}" method="POST" onsubmit="return confirm('Obrisati ovu recenziju?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.8em;">
                        Obriši 
                    </button>
                </form>
            @endif
        </div>
    @endforeach

                @if(Auth::user()->role == 'kandidat')
                    <form action="{{ route('recenzija.store') }}" method="POST" style="margin-top: 20px;">
                        @csrf
                        <textarea name="komentar" placeholder="Napišite vaše iskustvo sa obuke..." required style="width: 100%; padding: 15px; border-radius: 10px; margin-bottom: 10px; border: none; background: rgba(255,255,255,0.9); color: black;"></textarea>
                        <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">Pošalji recenziju</button>
                    </form>
                @endif
            </div>

        @else
            <div style="text-align: center; padding: 40px 0;">
                <p style="margin-bottom: 20px;">Prijavite se da biste upravljali svojom obukom.</p>
                <a href="{{ route('login') }}" style="background: #3498db; color: white; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: bold;">Prijavi se</a>
            </div>
        @endauth

        <div style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
    
    <h3 style="color: #f1c40f; text-align: center; margin-bottom: 25px; font-size: 1.6rem; text-shadow: 2px 2px 10px rgba(0,0,0,0.8);">
        Aktuelna obaveštenja škole
    </h3>

    @if(isset($obavestenja) && $obavestenja->count() > 0)
        @foreach($obavestenja as $o)
            <div class="staklena-kartica" style="margin-bottom: 20px; padding: 25px; text-align: left; border-left: 6px solid #f1c40f; background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(10px);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 8px;">
                    <strong style="color: white; font-size: 1.2rem; letter-spacing: 0.5px;">{{ $o->naslov }}</strong>
                    <span style="font-size: 0.85rem; color: rgba(255,255,255,0.5); font-weight: bold; background: rgba(255,255,255,0.05); padding: 2px 8px; border-radius: 4px;">
                        {{ $o->created_at->format('d.m.Y.') }}
                    </span>
                </div>
                <p style="color: rgba(255,255,255,0.9); margin: 0; line-height: 1.6; font-size: 1rem;">
                    {{ $o->poruka }}
                </p>
            </div>
        @endforeach
    @else
        <div class="staklena-kartica" style="text-align: center; padding: 20px; opacity: 0.8;">
            <p style="margin: 0; color: white; font-style: italic;">Trenutno nema novih obaveštenja.</p>
        </div>
    @endif

</div>

    </div>

</div>

@endsection