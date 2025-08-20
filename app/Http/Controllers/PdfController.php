<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Facture;
use App\Models\Recu;
use App\Models\TarifsRessource;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfController extends Controller
{
    public function printProforma($id)
    {
        $reservation = Reservation::with([
            'client',
            'ressources',
            'accessoires',
        ])->findOrFail($id);

        $montant_net = $reservation->cout_total;
 
        $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
        $montant_lettres = ucfirst($formatter->format($montant_net));

        $currentYear = now()->format('y');
        $currentMonth = now()->format('m');

        $pdf = Pdf::loadView('pdfs.proforma', [
            'reservation' => $reservation,
            'reduction' => $reservation->getSommeReductions(),
            'montant_reduction' => ($reservation->getSommeReductions() * $montant_net) / 100,
            'montant_apres_reduction' => $montant_net - ($reservation->getSommeReductions()*$montant_net)/100,
            'client' => $reservation->client,
            'ressources' => $reservation->ressources,
            'accessoires' => $reservation->accessoires,
            'montant_net' => $montant_net,
            'montant_lettres' => $montant_lettres,
            'current_year' => $currentYear,
            'current_month' => $currentMonth,
        ]);

        return $pdf->stream("Proforma_{$currentYear}{$currentMonth}_{$id}.pdf");
    }

    public function printFacture($id)
    {
        $facture = Facture::with(['reservation.client', 'reservation.ressources', 'reservation.accessoires', 'type_paiement'])
            ->findOrFail($id);

        foreach ($facture->reservation->ressources as $ressource) {
            $tarif = TarifsRessource::find($ressource->pivot->id_tarif_ressource);
            
        }

        $pdf = Pdf::loadView('pdfs.facture', [
            'facture' => $facture
        ]);

        return $pdf->stream("Facture_{$facture->reference}.pdf");
    }

    public function printRecu($id)
    {
        // Récupération du reçu avec la facture et la réservation associée
        $recu = Recu::with(['facture.reservation.client', 'facture.reservation.ressources', 'facture.reservation.accessoires'])
            ->findOrFail($id);

        $facture = $recu->facture;
        $reservation = $facture->reservation;

        $montant_net = $reservation->cout_total - ($reservation->getSommeReductions() * $reservation->cout_total / 100);

        $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
        $montant_lettres = ucfirst($formatter->format(round($montant_net)));

        // QR code
        $qrText = "ID={$recu->id};Facture={$facture->reference};Client={$reservation->reference_client};Net={$montant_net};";
        $qrCode = QrCode::format('svg')->size(100)->generate($qrText);
        $qrBase64 = base64_encode($qrCode);

        // Calcul dynamique de la hauteur : base + nombre de lignes (ressources + accessoires)
        $baseHauteur = 130;
        $ligneHauteur = 18;
        $nbLignes = count($reservation->ressources) + count($reservation->accessoires);
        $hauteurTotal = $baseHauteur + ($nbLignes * $ligneHauteur);
        $hauteurTotal += 100; // pour QR

        $pdf = Pdf::loadView('pdfs.recu', [
            'recu' => $recu,                  // <-- passer la variable $recu
            'facture' => $facture,
            'reservation' => $reservation,
            'montant_net' => $montant_net,
            'montant_lettres' => $montant_lettres,
            'qrBase64' => $qrBase64,
        ])->setPaper([0, 0, 165, $hauteurTotal], 'portrait');

        return $pdf->stream("Recu_{$recu->id}.pdf");
    }

}
