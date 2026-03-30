<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoEdu - Sistem za upravljanje</title>
    <link rel="stylesheet" href="{{ asset('css/glavni.css') }}">

    <style>
       
        .glavna-navigacija {
            background: rgba(26, 37, 47, 0.95);
            backdrop-filter: blur(10px);
            padding: 0 5%;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .nav-linkovi { display: flex; gap: 20px; align-items: center; }
        .nav-linkovi a { color: white; text-decoration: none; opacity: 0.8; font-size: 0.95em; transition: 0.3s; }
        .nav-linkovi a:hover, .nav-linkovi a.aktivno { opacity: 1; color: #3498db; }
        .logo { font-size: 1.5em; font-weight: bold; color: white; text-decoration: none; }
        .sadrzaj-kontejner { padding: 40px 5%; min-height: calc(100vh - 70px); }
        .dugme-logout { background: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body class="pozadina-slika">

    <nav class="glavna-navigacija">
        <a href="{{ route('pocetna') }}" class="logo">AutoEdu</a>

        <div class="nav-linkovi">
            <a href="{{ route('pocetna') }}" class="{{ request()->is('pocetna') ? 'aktivno' : '' }}">Početna</a>

            @auth
                {{-- za admina --}}
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.korisnici') }}"> Korisnici</a>
                    <a href="{{ route('admin.obavestenja') }}"> Obaveštenja</a>
                
                {{-- linkovi za instr --}}
                @elseif(Auth::user()->role == 'instruktor')
                    <a href="{{ route('instruktor.termini') }}"> Termini</a>
                    <a href="{{ route('instruktor.evidencija') }}"> Ocene</a>
                @endif

                {{-- opcija logout --}}
                <span style="color: #3498db; margin-left: 20px;"> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dugme-logout">Odjavi se</button>
                </form>
            @endauth

            @guest
                {{-- linkovi za goste --}}
                <a href="{{ route('login') }}">Prijavi se</a>
                <a href="{{ route('registracija') }}" style="background: #2ecc71; padding: 8px 15px; border-radius: 5px; color: white;">Napravi nalog</a>
            @endguest
        </div>
    </nav>

    <main class="sadrzaj-kontejner">
        @yield('sadrzaj')
    </main>

    <style>
        /*primorana san da ceo css ovde zalepim jer imam problem na railway*/
        
:root {
   
    --primarna-gradijent: linear-gradient(135deg, #4c51bf 0%, #6b46c1 100%);
    --svetla-bela: rgba(255, 255, 255, 0.9);
    --siva-tekst: #d1d5db;
    --tamni-tekst: #1a202c;
}

body, html {
    margin: 0; padding: 0;
    height: 100%;
   
    font-size: 14px; 
    font-family: 'Segoe UI', Arial, sans-serif;
}

.pozadina-slika {
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
             url('/css/photo/heroSlika.png') no-repeat center center fixed;
    background-size: cover;
}


.glavna-struktura {
    display: flex;
    height: 100vh;
}

.nav-linkovi a {
    display: block;
    padding: 8px 12px; 
    color: var(--siva-tekst);
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 3px;
    transition: all 0.3s ease;
}

.nav-linkovi a:hover, .nav-linkovi a.aktivno {
    background: var(--primarna-gradijent);
    color: white !important;
    box-shadow: 0 4px 15px rgba(107, 70, 193, 0.4);
}


.glavni-deo {
    flex: 1;
    overflow-y: auto;
    background: rgba(0, 0, 0, 0.1);
}


.gornja-traka {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 10px 25px; 
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(5px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.ime-korisnika { color: white; font-weight: bold; margin-right: 15px; }


.staklena-kartica {
    background: rgba(0, 0, 0, 0.75); 
    backdrop-filter: blur(15px);
    border-radius: 12px; 
    padding: 20px 25px;  
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: white;
    max-width: 480px;    
    margin: 15px auto;   
}


.staklena-kartica h1, .staklena-kartica h2, .staklena-kartica h3, .staklena-kartica p, .staklena-kartica label {
    color: white;
}

.staklena-kartica h1 { font-size: 1.5rem; margin-bottom: 5px; text-align: center; } 
.staklena-kartica p { font-size: 0.95rem; opacity: 0.9; margin-bottom: 15px; text-align: center; } 
.staklena-kartica label { display:block; margin-bottom: 5px; font-weight: 700; font-size: 0.9em; }


input, select, textarea {
    width: 100%;
    padding: 8px 10px;
    margin-top: 4px;
    border: none;
    border-radius: 8px; 
    background: rgba(255, 255, 255, 0.9);
    color: var(--tamni-tekst);
    font-size: 0.95em;
}

input:focus, select:focus {
    outline: none;
    border-color: #4c51bf;
    box-shadow: 0 0 0 3px rgba(76, 81, 191, 0.2);
}

.dugme-primarno, .dugme-registracija-nav {
    background: var(--primarna-gradijent);
    color: white;
    border: none;
    padding: 10px; 
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    font-size: 0.9rem; 
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(76, 81, 191, 0.3);
    width: 100%;
    margin-top: 15px; 
    text-transform: uppercase;
    letter-spacing: 1px;
}

.dugme-primarno:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(107, 70, 193, 0.4);
}

.dugme-odjava-nav {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid rgba(231, 76, 60, 0.5);
    cursor: pointer;
    font-size: 0.85em;
}


.sadržaj-stranice {
    max-width: 1000px; 
    margin: 0 auto;
    padding: 15px;
}

.sidebar-footer {
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

/*znog hostovanja sam primorana da prekopiram ovo ovde*/
@import 'tailwindcss';

:root {
    
    --primarna-gradijent: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --dugme-hover: linear-gradient(135deg, #5a6fd6 0%, #694291 100%);
    --akcent-plava: #3498db;
    --bela-kartica: rgba(255, 255, 255, 0.95);
    --tamni-tekst: #1a202c;
    --svetla-senka: 0 10px 30px rgba(0, 0, 0, 0.3);
}

body, html {
    margin: 0; padding: 0;
    height: 100%;
    font-size: 18px;
    font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    color: white;
}

.pozadina-slika {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                url('../photo/autoskola1.jpg') no-repeat center center fixed;
    background-size: cover;
}


.glavna-struktura {
    display: flex;
    height: 100vh;
}


.bočni-meni {
    width: 260px;
    background: rgba(15, 15, 15, 0.9);
    backdrop-filter: blur(15px);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    flex-direction: column;
    padding: 25px;
}

.nav-linkovi a {
    display: block;
    padding: 14px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    border-radius: 10px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.nav-linkovi a:hover, .nav-linkovi a.aktivno {
    background: var(--primarna-gradijent);
    color: white !important;
    box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
    transform: translateX(5px);
}


.glavni-deo {
    flex: 1;
    overflow-y: auto;
    background: rgba(0, 0, 0, 0.2);
}

.gornja-traka {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 15px 40px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.ime-korisnika { color: white; font-weight: bold; margin-right: 15px; }


.staklena-kartica {
    background: var(--bela-kartica);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 35px;
    box-shadow: var(--svetla-senka);
    border: 1px solid rgba(255, 255, 255, 0.4);
    color: var(--tamni-tekst) !important;
    max-width: 1000px;
    margin: 40px auto;
}

.staklena-kartica h1, .staklena-kartica h2, .staklena-kartica h3, 
.staklena-kartica p, .staklena-kartica label, .staklena-kartica td {
    color: var(--tamni-tekst) !important;
}


input, select, textarea {
    width: 100%;
    padding: 14px;
    margin-top: 10px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    background: white !important;
    color: #1a202c !important;
    font-size: 1rem;
}

input:focus, select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}


.dugme-primarno, .dugme-registracija-nav {
    background: var(--primarna-gradijent) !important;
    color: white !important;
    border: none;
    padding: 14px 25px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    display: inline-block;
    text-align: center;
    text-decoration: none;
}

.dugme-primarno:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    filter: brightness(1.1);
}


.dugme-logout-sidebar, .dugme-odjava-nav {
    background: rgba(231, 76, 60, 0.1) !important;
    color: #e74c3c !important;
    border: 1px solid rgba(231, 76, 60, 0.4) !important;
    padding: 12px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    width: 100%;
}

.dugme-logout-sidebar:hover {
    background: #e74c3c !important;
    color: white !important;
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
}


.termin-kartica {
    background: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 8px solid #667eea;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.termin-kartica.zavrseno {
    border-left-color: #2ecc71;
    opacity: 0.8;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 800;
    background: #f1c40f;
    color: #1a202c !important;
}

.sidebar-footer {
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
}
    </style>

</body>
</html>