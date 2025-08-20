<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>PROFORMA KBM_{{ date('Y') }}{{ date('m') }}_{{ $reservation->id }}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
      margin: 10px;
    }
    header {
      text-align: center;
    }
    header img {
      max-height: 80px;
    }
    h1 {
      color: #A52A2A;
      text-decoration: underline;
      font-size: 16px;
    }
    .proforma-info {
      text-align: right;
      margin-top: -35px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #000;
      padding: 5px 8px;
    }
    th {
      background: #b7b7b7;
    }
    .total {
      text-align: right;
      font-weight: bold;
    }
    .amount {
      font-weight: bold;
    }
    .objet {
      margin: 20px 0 5px 0;
      font-weight: bold;
      text-decoration: underline;
    }
    .footer {
      margin-top: 20px;
      font-size: 9px;
    }
    .bank {
      background: #4b4b4b;
      color: #ffffff;
      padding-top: 0.01px;
      padding-bottom: 0.01px;
      padding-left: 10px;
      padding-right: 10px;
      margin-top: 15px;
      font-size: 10px;
    }
    .signature {
      float: right;
      margin-top: 10px;
      text-align: center;
    }
    .contact {
        text-align: center;
        font-size: 9px;
    }
    .encadre-total {
      width: 300px;
      margin-left: auto;
      display: block;
    }
    .total {
      width: 100%;
    }
    .text-right {
      text-align: right;
    }
    .text-left {
      text-align: left;
    }
  </style>
</head>
<body>

<header>
  <img src="{{ public_path('img/logo_kbm.jpg') }}" alt="Logo Kianja Barea">
  <h1>Proforma</h1>
</header>

<div class="proforma-info">
  <p style="color: #A52A2A"><strong>Référence :</strong> KBM_{{ date('Y') }}{{ date('m') }}_{{ $reservation->id }}</p>
  <p><strong>Date :</strong> {{ date('d/m/Y') }}</p>
  <p><strong>Client :</strong> {{ $client->nom }}</p>
  <p><strong>Référence client :</strong> {{ $reservation->reference_client }}</p>
</div>

<p><span class="objet">Objet</span> : {{ $reservation->description }}</p>

<table>
  <thead>
    <tr>
      <th>Ressources</th>
      <th>PU</th>
      <th>Qté</th>
      <th>Unité</th>
      <th>Montant</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($ressources as $ressource)
    @php
      $tarif = \App\Models\TarifsRessource::find($ressource->pivot->id_tarif_ressource);
    @endphp
    <tr>
      <td>
          {{ $ressource->nom }} 
          ({{ \Carbon\Carbon::parse($ressource->pivot->debut_utilisation)->format('H:i') }} 
          à 
          {{ \Carbon\Carbon::parse($ressource->pivot->fin_utilisation)->format('H:i') }})
      </td>
      <td>{{ number_format($tarif->prix_unitaire, 0, ',', ' ') }}</td>
      <td>{{ $ressource->pivot->quantite }}</td>
      <td>{{ $tarif->unite_tarif->nom }}</td>
      <td>{{ number_format($tarif->prix_unitaire * $ressource->pivot->quantite, 0, ',', ' ') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

@if($accessoires->isNotEmpty())
<table>
  <thead>
    <tr>
      <th>Accessoires</th>
      <th>PU</th>
      <th>Qté</th>
      <th>Unité</th>
      <th>Montant</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($accessoires as $accessoire)
      @php
        $tarif = \App\Models\TarifsAccessoire::find($accessoire->pivot->id_tarif_accessoire);
      @endphp
      <tr>
        <td class="text-left">{{ $accessoire->nom }}</td>
        <td>{{ number_format($tarif->prix_unitaire, 0, ',', ' ') }}</td>
        <td>{{ $accessoire->pivot->quantite }}</td>
        <td>{{ $tarif->unite_tarif->nom }}</td>
        <td>{{ number_format($tarif->prix_unitaire * $accessoire->pivot->quantite, 0, ',', ' ') }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endif

<div class="encadre-total">
  <table class="total">
      <tr>
          <td class="text-right" colspan="3"><strong>Montant total (HT) :</strong></td>
          <td class="text-right">{{ number_format($montant_net, 2, ',', ' ') }} AR</td>
      </tr>
      <tr>
          <td class="text-right" colspan="3"><strong>Réduction ({{ $reduction }}%) :</strong></td>
          <td class="text-right">-{{ number_format($montant_reduction, 2, ',', ' ') }} AR</td>
      </tr>
      <tr>
          <td class="text-right" colspan="3"><strong>Montant après réduction :</strong></td>
          <td class="text-right">{{ number_format($montant_apres_reduction, 2, ',', ' ') }} AR</td>
      </tr>
  </table>
</div>

@php
  $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
  $montant_lettres = ucfirst($fmt->format(round($montant_apres_reduction)));
@endphp

<p><strong>Arrêté le présent proforma à la somme de :</strong> {{ $montant_lettres }} ariary.</p>

<div class="signature" style="text-align: right; width: 100%;">
  <p style="margin-bottom: 50px; width: 100%;">Le Responsable Commercial</p>
  <p>Société de Patrimoine KIANJA BAREA SA</p>
</div>

<div class="footer">
  <p><strong>Conditions :</strong></p>
  <ul>
    <li>40% à la réservation (non remboursable)</li>
    <li>60% au plus tard une semaine avant l'événement</li>
    <li>Caution exigée avant l'événement (montant défini en réunion technique)</li>
  </ul>
</div>

<div class="bank">
  <p><strong>Informations bancaires :</strong></p>
  <p>Nom du bénéficiaire : Société de Patrimoine KIANJA BAREA SA<br>
  N° compte : 00004 00001 05516820101 08<br>
  SWIFT : BMOIMGMGXXX | IBAN : MG46 0000 4000 0105 5168 2010 108<br>
  Banque : BMOI MADAGASCAR</p>
</div>

<div class="contact">
    <p>KIANJA BAREA MAHAMSINA - RUE RAJOELINA MAHAMSINA<br>
    Tél. (00261) 38 50 881 10/11 | Email : contact@kbarea.com<br>
    RCS Antananarivo 2024B00957 | NIF/STAT : 4.018.643.827 / 42102 11 2024 0 10980</p>
</div>

</body>
</html>