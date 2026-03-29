<div class="staklena-kartica" style="background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(15px); padding: 30px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1); color: white; margin-top: 25px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">
        <h3 style="margin: 0; font-size: 1.5em; display: flex; align-items: center; gap: 10px;">
             Nedeljni raspored časova
        </h3>
        <span style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 5px 12px; border-radius: 15px; font-size: 0.8em; font-weight: bold; border: 1px solid rgba(46, 204, 113, 0.3);">
            Ažurirano danas
        </span>
    </div>

    {{-- PORUKA AKO NEMA TERMINA --}}
    <p style="opacity: 0.7; font-size: 0.95em; margin-bottom: 20px;">
        Pregled dostupnih i zakazanih termina za vaš profil u tekućoj nedelji.
    </p>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 400px;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid rgba(255,255,255,0.1);">
                    <th style="padding: 15px; font-size: 0.85em; text-transform: uppercase; letter-spacing: 1px; opacity: 0.6;">Dan</th>
                    <th style="padding: 15px; font-size: 0.85em; text-transform: uppercase; letter-spacing: 1px; opacity: 0.6;">Vreme</th>
                    <th style="padding: 15px; font-size: 0.85em; text-transform: uppercase; letter-spacing: 1px; opacity: 0.6;">Status</th>
                </tr>
            </thead>
           
    </div>

</div>