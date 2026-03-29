@extends('layouts.okvir')

@section('sadrzaj')
<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 10px;">
    
    
    <div class="staklena-kartica" style="background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(15px); padding: 20px 25px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); width: 100%; max-width: 500px; box-shadow: 0 15px 30px rgba(0,0,0,0.5); color: white;">
        
        <div style="text-align: center; margin-bottom: 15px;">
            
            <h1 style="font-size: 1.5rem; margin-bottom: 3px; letter-spacing: 0px;">Napravi svoj nalog</h1>
            <p style="opacity: 0.9; font-size: 0.9rem;">Pridruži se AutoEdu timu i kreni sa obukom</p>
        </div>

        <form action="/sacuvaj-korisnika" method="POST">
            @csrf
            
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
               
                <div>
                   
                    <div style="margin-bottom: 10px;">
                       
                        <label style="display:block; margin-bottom: 3px; font-weight: 700; color: white; font-size: 0.85em;">Ime i prezime</label>
                        
                        <input type="text" name="name" placeholder="ime i prezime" required style="width: 100%; padding: 8px; background: rgba(255,255,255,0.9); border: none; border-radius: 6px; color: #2c3e50; font-size: 0.9em;">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label style="display:block; margin-bottom: 3px; font-weight: 700; color: white; font-size: 0.85em;">Email adresa</label>
                        <input type="email" name="email" placeholder="ime@example.com" required style="width: 100%; padding: 8px; background: rgba(255,255,255,0.9); border: none; border-radius: 6px; color: #2c3e50; font-size: 0.9em;">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label style="display:block; margin-bottom: 3px; font-weight: 700; color: white; font-size: 0.85em;">Broj telefona</label>
                        <input type="text" name="telefon" placeholder="06x/xxxx-xxx" required style="width: 100%; padding: 8px; background: rgba(255,255,255,0.9); border: none; border-radius: 6px; color: #2c3e50; font-size: 0.9em;">
                    </div>
                </div>

              
                <div>
                    <div style="margin-bottom: 10px;">
                        <label style="display:block; margin-bottom: 3px; font-weight: 700; color: white; font-size: 0.85em;">Uloga u školi</label>
                        <select name="role" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.9); border: none; border-radius: 6px; color: #2c3e50; font-size: 0.9em; appearance: none;">
                            <option value="kandidat">Kandidat</option>
                            <option value="instruktor">Instruktor</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label style="display:block; margin-bottom: 3px; font-weight: 700; color: white; font-size: 0.85em;">Kategorija (A, B, C, D)</label>
                        <select name="kategorija" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.9); border: none; border-radius: 6px; color: #2c3e50; font-size: 0.9em; appearance: none;">
                            <option value="B">B kategorija (Automobil)</option>
                            <option value="A">A kategorija (Motor)</option>
                            <option value="C">C kategorija (Kamion)</option>
                            <option value="D">D kategorija (Autobus)</option>
                        </select>
                    </div>

                    
                    <div style="margin-bottom: 10px;">
                        <label style="display:block; margin-bottom: 3px; font-weight: 700; color: white; font-size: 0.85em;">Lozinka</label>
                        <input type="password" name="password" required style="width: 100%; padding: 8px; background: rgba(255,255,255,0.9); border: none; border-radius: 6px; color: #2c3e50;">
                    </div>
                    
                    <div style="margin-bottom: 10px;">
                        <label style="display:block; margin-bottom: 3px; font-weight: 700; color: white; font-size: 0.85em;">Potvrda</label>
                        <input type="password" name="password_confirmation" required style="width: 100%; padding: 8px; background: rgba(255,255,255,0.9); border: none; border-radius: 6px; color: #2c3e50;">
                    </div>
                </div>
            </div>

            <button type="submit" style="width: 100%; margin-top: 15px; padding: 12px; background: #2ecc71; color: white; border: none; border-radius: 8px; font-weight: bold; font-size: 0.95rem; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3); letter-spacing: 0.5px;">
                Registruj se 
            </button>
        </form>

        <div style="text-align: center; margin-top: 15px;">
            <p style="opacity: 1; font-size: 0.9em; margin-top: 0px;">Već imaš nalog? <a href="{{ route('login') }}" style="color: #3498db; text-decoration: none; font-weight: bold; border-bottom: 1px solid #3498db; padding-bottom: 2px;">Prijavi se</a></p>
        </div>
    </div>
</div>
@endsection