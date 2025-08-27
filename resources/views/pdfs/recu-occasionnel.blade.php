<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu Occasionnel KBM_{{ date('Ymd') }}.{{ $recu->reference }}</title>
    <style>
        @page {size: 58mm auto; margin: 0;}
        body {
            width: 58mm; margin: 0; padding: 0;
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #000;
        }
        .receipt { padding: 4mm; }
        .center { text-align: center; }
        .logo { font-size: 14px; font-weight: bold; margin-bottom: 2mm; border-bottom: 1px dashed #000; padding-bottom: 1mm; }
        .title { font-weight: bold; margin: 1mm 0; font-size: 11px; }
        .subtitle { font-size: 9px; margin-bottom: 2mm; }
        .line { border-top: 1px dashed #000; margin: 2mm 0; }
        .item { display: flex; justify-content: space-between; align-items: center; margin: 1mm 0; }
        .item > div:first-child { flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-right: 5px; }
        .item > div:last-child { white-space: nowrap; flex-shrink: 0; text-align: right; }
        .total { display: flex; justify-content: space-between; font-weight: bold; margin-top: 2mm; width: 100%; }
        .total div:last-child { min-width: 80px; text-align: right; }
        .footer { text-align: center; font-size: 9px; margin-top: 4mm; }
        .qr { text-align: center; margin-top: 3mm; }
        img { margin-top: 1mm; }
    </style>
</head>
<body>
<div class="receipt">
    <div class="center logo">KBM</div>
    <div class="center logo"><img src="{{ public_path('img/logo_kbm.jpg') }}" alt="Logo KBM" style="max-width: 80px; max-height: 40px;"/></div>
    <div class="center title">REÇU OCCASIONNEL</div>
    <div class="center subtitle">Merci pour votre confiance</div>
    <div class="line"></div>

    <p><strong>Référence :</strong> {{ $recu->reference }}</p>
    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($recu->date_edition)->format('d/m/Y H:i') }}</p>
    <p><strong>Motif :</strong> {{ $recu->motif }}</p>
    <p><strong>Mode Paiement :</strong> {{ $recu->mode_paiement->nom ?? 'N/A' }}</p>

    <div class="line"></div>

    {{-- Ressources --}}
    @foreach ($recu->ressources as $index => $ressource)
        @php
            $tarif = \App\Models\TarifsRessource::find($ressource->pivot->id_tarif);
            $prixUnitaire = $tarif ? $tarif->prix_unitaire : 0;
            $quantite = $ressource->pivot->quantite ?? 1;
            $montant = $prixUnitaire * $quantite;
        @endphp
        <div class="item">
            <div>{{ $index + 1 }}. {{ \Illuminate\Support\Str::limit($ressource->nom, 20) }}</div>
            <div>{{ number_format($montant, 0, ',', ' ') }} Ar</div>
        </div>
    @endforeach

    {{-- Accessoires --}}
    @foreach ($recu->accessoires as $accessoire)
        @php
            $tarif = \App\Models\TarifsAccessoire::find($accessoire->pivot->id_tarif);
            $prixUnitaire = $tarif ? $tarif->prix_unitaire : 0;
            $quantite = $accessoire->pivot->quantite ?? 1;
            $montant = $prixUnitaire * $quantite;
        @endphp
        <div class="item">
            <div>{{ \Illuminate\Support\Str::limit($accessoire->nom, 20) }}</div>
            <div>{{ number_format($montant, 0, ',', ' ') }} Ar</div>
        </div>
    @endforeach

    <div class="line"></div>

    {{-- Totaux --}}
    <div class="total">
        <div>Total</div>
        <div>{{ number_format($recu->cout_total, 0, ',', ' ') }} Ar</div>
    </div>

    <div class="line"></div>
    <div class="reference_paiement">
        <p><strong>Référence de paiement :</strong> {{ $recu->reference_paiement ?? '-' }}</p>
    </div>

    <div class="line"></div>
    <div class="footer">MERCI POUR VOTRE CONFIANCE !</div>

    <div class="qr">
        <img src="data:image/png;base64,{{ $qrBase64 }}" width="60">
    </div>
</div>
</body>
</html>
