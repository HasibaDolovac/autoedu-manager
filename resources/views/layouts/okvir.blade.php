<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoEdu - Sistem za upravljanje</title>
    <link rel="stylesheet" href="{{ asset('css/stil.css') }}">
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
                {{-- LINKOVI ZA ADMINA --}}
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.korisnici') }}"> Korisnici</a>
                    <a href="{{ route('admin.obavestenja') }}"> Obaveštenja</a>
                
                {{-- LINKOVI ZA INSTRUKTORA --}}
                @elseif(Auth::user()->role == 'instruktor')
                    <a href="{{ route('instruktor.termini') }}"> Termini</a>
                    <a href="{{ route('instruktor.evidencija') }}"> Ocene</a>
                @endif

                {{-- ZAJEDNIČKO ZA SVE ULOGOVANE (Ime i Logout) --}}
                <span style="color: #3498db; margin-left: 20px;"> {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dugme-logout">Odjavi se</button>
                </form>
            @endauth

            @guest
                {{-- LINKOVI ZA GOSTE (Neregistrovane) --}}
                <a href="{{ route('login') }}">Prijavi se</a>
                <a href="{{ route('registracija') }}" style="background: #2ecc71; padding: 8px 15px; border-radius: 5px; color: white;">Napravi nalog</a>
            @endguest
        </div>
    </nav>

    <main class="sadrzaj-kontejner">
        @yield('sadrzaj')
    </main>

</body>
</html>