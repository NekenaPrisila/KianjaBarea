<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Facture KBM_{{ date('Ymd') }}.{{ $facture->reference }}</title>
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
    .facture-info {
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
  </style>
</head>
<body>

<header>
  <img src="{{ public_path('img/logo_kbm.jpg') }}" alt="Logo Kianja Barea">
  <h1>Facture</h1>
</header>

<div class="facture-info">
  <p style="color: #A52A2A"><strong>N°</strong> KBM_{{ $facture->reference }}</p>
  <p><strong>Date :</strong> {{ date('d/m/Y') }}</p>
  <p><strong>Doit :</strong> {{ $facture->reservation->client->nom }}</p>
  <p><strong>Référence :</strong> {{ $facture->reservation->reference_client }}</p>
</div>

<p><span class="objet">Objet</span> : {{ $facture->reservation->description }}</p>

<table>
  <thead>
    <tr>
      <th>Ressources</th>
      <th>PU en Ar</th>
      <th>Qté</th>
      <th>unite</th>
      <th>Montant en Ar</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($facture->reservation->ressources as $ressource)
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

@if ($facture->reservation->accessoires->isNotEmpty())
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
    @foreach ($facture->reservation->accessoires as $accessoire)
      @php
        $tarif = \App\Models\TarifsAccessoire::find($accessoire->pivot->id_tarif_accessoire);
      @endphp
      <tr>
        <td>{{ $accessoire->nom }}</td>
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
          <td class="text-right" colspan="3"><strong>Montant total :</strong></td>
          <td class="text-right">{{ number_format($facture->reservation->cout_total, 2, ',', ' ') }}</td>
      </tr>
      <tr>
          <td class="text-right" colspan="3"><strong>Réduction ({{ $facture->reservation->getSommeReductions() }}%) :</strong></td>
          <td class="text-right">-{{ number_format(($facture->reservation->getSommeReductions()*$facture->reservation->cout_total)/100, 2, ',', ' ') }}</td>
      </tr>
      <tr>
          <td class="text-right" colspan="3"><strong>Montant après réduction :</strong></td>
          <td class="text-right">
              {{ number_format($facture->reservation->cout_total - ($facture->reservation->getSommeReductions()*$facture->reservation->cout_total)/100, 2, ',', ' ') }}
          </td>
      </tr>
      <tr>
          <td class="text-right" colspan="3"><strong>Montant payé :</strong></td>
          <td class="text-right">{{ number_format($facture->montant_paye, 2, ',', ' ') }}</td>
      </tr>
      <tr>
          <td class="text-right" colspan="3"><strong>Reste à payer :</strong></td>
          <td class="text-right">{{ number_format($facture->reste_a_payer, 2, ',', ' ') }}</td>
      </tr>
  </table>
</div>

@php
  $fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
  $montant_lettres = ucfirst($fmt->format(round($facture->reservation->cout_total - ($facture->reservation->getSommeReductions()*$facture->reservation->cout_total)/100)));
@endphp

<p><strong>Arrêtée la présente facture à la somme de :</strong> {{ $montant_lettres }} ariary.</p>

<div class="signature" style="text-align: right; width: 100%;">
  <p style="margin-bottom: 50px; width: 100%;">Le Responsable</p>
  <p>Société de Patrimoine KIANJA BAREA SA</p>
</div>

<div class="footer">
  <p><strong>Observations :</strong></p>
  <ul>
    <li>Parking à 2.000 Ar/véhicule le jour et 5.000 Ar/véhicule à partir de 16h</li>
    <li>Jour d’installation supérieur à 2 jours : 3% de la location totale par jour</li>
    <li>Jour de désinstallation supérieur à 1 jour : 3% de la location totale par jour</li>
    <li>Présence d’éléments de la Force de l’Ordre obligatoire (à la charge du client)</li>
  </ul>

  <p>Une CAUTION sera exigée avant chaque évènement, restituée après état des lieux.<br>
  Mode de paiement : Espèces, mobile money, chèque ou virement bancaire.<br>
  - 40% à la réservation (non remboursable)<br>
  - 60% au plus tard une semaine avant l’évènement.</p>
</div>

<div class="bank">
  <p><strong>Informations bancaires :</strong></p>
  <p>Nom du bénéficiaire  : Société de Patrimoine KIANJA BAREA<br>
  Compte : 00004 00001 05516820101<br>
  Swift : BMOIMGMGXXX | IBAN : MG46 0000 4000 0105 5168 2010 106<br>
  Banque : BMOI MADAGASCAR<br>
  RCS Antananarivo 2024B00957 | NIF/STAT : 4.018.643.827 / 42102 11 2024 0 10980<br>
  Tél. (00261) 38 50 881 101 | info@kbarea.com</p>
</div>

<div class="contact">
    <p>KIANJA BAREA MAHAMSINA - RUE, RAJOELINA MAHAMSINA<br>
    Tél. (00261) 38 50 881 1011 | Mail: info@kbarea.com<br>
    RCS Antananarivo 2024B00957 | NIF/STATISTIQUE : 4.018.643.827 / 42102 11 2024 0 10980
    </p>
</div>

</body>
</html>
