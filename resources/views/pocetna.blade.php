@extends('layouts.okvir')

@section('sadrzaj')

{{-- poruke o greskama --}}
@if (session('status'))
    <div style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 15px; border-radius: 8px; border: 1px solid #2ecc71; margin-bottom: 20px; text-align: center;">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; padding: 15px; border-radius: 8px; border: 1px solid #e74c3c; margin-bottom: 20px; text-align: center;">
        {{ session('error') }}
    </div>
@endif

{{-- ulogovani korisiici --}}
@auth
    <div class="dashboard-wrapper" style="max-width: 1200px; margin: 0 auto;">
        
        <div class="header-dobrodoslica" style="margin-bottom: 30px; color: white;">
            <h1 style="font-size: 2.2em;">Zdravo, {{ Auth::user()->name }}!</h1>
            <p style="opacity: 0.8;">Vaš trenutni status i pregled aktivnosti.</p>
        </div>

    
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            
            {{-- osnovni prikazi statusa --}}
            <div class="staklena-kartica" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); color: white;">
                @if(Auth::user()->role == 'admin')
                    <h3>Sistemska statistika</h3>
                    <p>Registrovanih korisnika: <strong>{{ $statistika['korisnici'] ?? 0 }}</strong></p>
                    <p>Aktivnih termina: <strong>{{ $statistika['termini'] ?? 0 }}</strong></p>
                @elseif(Auth::user()->role == 'instruktor')
                    <h3>Moji Polaznici</h3>
                    <p>Trenutno podučavate: <strong>{{ $mojiKandidati->count() }}</strong> kandidata.</p>
                @else
                    <h3>Status Obuke</h3>
                    <p>Odvezeno časova: <strong>{{ Auth::user()->odvezeno_casova ?? 0 }} / 40</strong></p>
                    <p>Teorijski ispit: <strong style="color: {{ Auth::user()->teorija_status == 'Položeno' ? '#2ecc71' : '#f1c40f' }}">{{ Auth::user()->teorija_status ?? 'U toku' }}</strong></p>
                @endif
            </div>

            {{-- prikaz najnovijih obavesteja --}}
            <div class="staklena-kartica" style="background: rgba(52, 152, 219, 0.2); padding: 25px; border-radius: 15px; border: 1px solid #3498db; color: white;">
                <h3> Poslednje obaveštenje</h3>
                @if($obavestenja->count() > 0)
                    <h4 style="margin-bottom: 5px;">{{ $obavestenja->first()->naslov }}</h4>
                    <p style="font-size: 0.9em; opacity: 0.9;">{{ $obavestenja->first()->poruka }}</p>
                @else
                    <p>Trenutno nema novih obaveštenja.</p>
                @endif
            </div>

        </div>

        {{-- dozvoljene aktivnosti u zavisnosti od uloge --}}
        <div style="margin-top: 30px;">
            @if(Auth::user()->role == 'instruktor')
               
                <a href="{{ route('instruktor.termini') }}" class="dugme-primarno" style="text-decoration: none; display: inline-block;">Pogledaj kompletan raspored vožnji →</a>
            @elseif(Auth::user()->role == 'kandidat')
                 <div class="staklena-kartica" style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 15px; color: white;">
                    <h3>Dodeljen instruktor</h3>
                    <p>{{ Auth::user()->instruktor_ime ?? 'Niste još uvek izabrali instruktora.' }}</p>
                 </div>
            @endif
        </div>
    </div>
@endauth

{{-- deo koji se prikazuje neregistrovanim korisnicima --}}
@guest
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 60vh; text-align: center; color: white;">
        <h1 style="font-size: 3.5em; margin-bottom: 10px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5);">Auto-škola na dlanu.</h1>
        <p style="font-size: 1.2em; max-width: 600px; opacity: 0.9; margin-bottom: 30px;">
            Pratite svoje časove vožnje, zakazujte termine i komunicirajte sa instruktorima na najlakši način.
        </p>
        
        <div style="display: flex; gap: 15px;">
            <a href="{{ route('login') }}" style="background: white; color: #1a252f; padding: 15px 35px; border-radius: 30px; text-decoration: none; font-weight: bold; transition: 0.3s;">Prijavi se</a>
            <a href="{{ route('registracija') }}" style="background: #2ecc71; color: white; padding: 15px 35px; border-radius: 30px; text-decoration: none; font-weight: bold; transition: 0.3s;">Napravi nalog</a>
        </div>

        {{-- obavestenja admina pocetna strana --}}
        <div style="margin-top: 50px; width: 100%; max-width: 800px;">
            <h3 style="margin-bottom: 20px; opacity: 0.7;">Vesti iz auto-škole</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                @foreach($obavestenja->take(2) as $o)
                    <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 10px; text-align: left; border-left: 3px solid #3498db;">
                        <h4 style="margin: 0;">{{ $o->naslov }}</h4>
                        <p style="font-size: 0.85em; opacity: 0.8;">{{ $o->poruka }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endguest

@endsection