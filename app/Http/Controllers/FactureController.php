<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Reservation;
use App\Models\TypePaiement;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index(Request $request)
    {
        $query = Facture::with(['reservation.client', 'utilisateur'])
            ->orderBy('date_edition', 'desc');

        // Filtres GET
        $clientId = $request->query('client_id');
        $etat = $request->query('etat'); // 'reglee' or 'non_reglee'
    $referenceReservation = $request->query('reference_reservation');
        $typePaiement = $request->query('type_paiement');

        if ($clientId) {
            // factures liées à des réservations d'un client
            $query->whereHas('reservation', function($q) use ($clientId) {
                $q->where('id_client', $clientId);
            });
        }

        if ($etat !== null && $etat !== '') {
            if ($etat === 'reglee') {
                // factures qui ont au moins un reçu
                $query->whereHas('recus');
            } elseif ($etat === 'non_reglee') {
                $query->whereDoesntHave('recus');
            }
        }

        if ($referenceReservation) {
            // Filtrer par référence de la réservation liée
            $query->whereHas('reservation', function($q) use ($referenceReservation) {
                $q->where('reference', 'like', "%$referenceReservation%");
            });
        }

        if ($typePaiement) {
            $query->where('id_type_paiement', $typePaiement);
        }

        $factures = $query->paginate(20)->appends($request->query());

        $types_paiement = TypePaiement::all();

        return view('factures.index', compact('factures', 'types_paiement'));
    }

    public function editFacture($id)
    {
        $reservation = Reservation::with(['client', 'ressources', 'accessoires', ])->findOrFail($id);
        $types_paiement = TypePaiement::all();

        return view('factures.edition-facture', compact('reservation', 'types_paiement'));
    }

    public function store (Request $request)
    {
        $facture = new Facture();

        // dd($request->all());
        $id = $request->input('reservation_id');
        $reservation = Reservation::findOrFail($id);

        $facture->reservation()->associate($reservation);
        $facture->reference_reservation = $reservation->reference;
        $facture->id_type_paiement = $request->type_paiement;
        $facture->id_creer_par = auth()->id();

        // Calcul des montants
        $montant_net = $reservation->cout_total;
        $montant_verse = 0;
        $montant_apres_reduction = $montant_net;
        $reste_a_payer = 0;
        $reductions = $reservation->getSommeReductions(); // Liste des réductions associées

        $montant_reduction = ($reductions * $montant_net)/100;
        $montant_reduction = ($facture->reservation->getSommeReductions() * $facture->reservation->cout_total)/100;


        $montant_apres_reduction = $montant_net - $montant_reduction;

        $typePaiement = TypePaiement::find($request->type_paiement);

        if ($typePaiement && strtolower($typePaiement->nom) === 'acompte') {
            if (!$request->montant_acompte) {
                return back()->withErrors(['montant_acompte' => 'Le montant de l\'acompte est requis.'])->withInput();
            }
            $montant_verse = $request->montant_acompte;
            $MontantDejaPaye = Facture::getTotalMontantPaye($id);
            $reste_a_payer = $montant_apres_reduction - $MontantDejaPaye - $montant_verse;

        } elseif ($typePaiement && strtolower($typePaiement->nom) === 'reste') {
            $reste = Facture::getResteAPayerParReservation($id);
            $montant_verse = $reste;
            $reste_a_payer = 0;

        } else {
            $montant_verse = $montant_apres_reduction;
            $reste_a_payer = 0;
        }

        // Création de la facture
        $facture->reference = 'Temporaire';
        $facture->date_edition = now();
        $facture->montant_paye = $montant_verse;
        $facture->reste_a_payer = $reste_a_payer;

        $facture->save();

        // Générer la référence avec la date + ID
        $facture->reference = 'FACT-' . now()->format('Ymd') . '-' . str_pad($facture->id, 4, '0', STR_PAD_LEFT);

        // Sauvegarder la référence mise à jour
        $facture->save();

        // ✅ Rediriger ou retour
        return redirect()->route('factures.index')->with('success', 'Facture créée avec succès !');
    }
    
}