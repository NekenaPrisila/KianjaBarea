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

        $factures = $query->paginate(20);

        return view('factures.index', compact('factures'));
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

        $montant_apres_reduction = $montant_net - $montant_reduction;

        $typePaiement = TypePaiement::find($request->type_paiement);

        if ($typePaiement && strtolower($typePaiement->nom) === 'acompte') {
            if (!$request->montant_acompte) {
                return back()->withErrors(['montant_acompte' => 'Le montant de l\'acompte est requis.'])->withInput();
            }
            $montant_verse = $request->montant_acompte;
            $reste_a_payer = $montant_apres_reduction - $montant_verse;

        } elseif ($request->montant_verse && $request->montant_verse < $montant_apres_reduction) {
            $montant_verse = $request->montant_verse;
            $reste_a_payer = $montant_apres_reduction - $montant_verse;

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