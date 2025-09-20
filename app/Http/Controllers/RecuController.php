<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;
use App\Models\Recu;
use App\Models\ModePaiement;

class RecuController extends Controller
{
    public function index(Request $request)
    {
        $recus = Recu::all();

        $modesPaiement = ModePaiement::all();

        return view('recus.index', compact('recus', 'modesPaiement'));
    }

    public function editRecu($id)
    {
        $facture = Facture::findOrFail($id);
        $modesPaiement = ModePaiement::all();

        return view('recus.edition-recu', compact('facture', 'modesPaiement'));
    }

    public function store(Request $request)
    {
        $recu = new Recu();

        $recu->date_edition = now();
        $recu->reference = 'Temporaire';
        $recu->id_mode_paiement = $request->id_mode_paiement;
        $recu->id_facture = $request->id_facture;
        $recu->reference_facture = $request->reference_facture;
        $recu->reference_paiement = $request->reference_paiement;
        $recu->creer_par = auth()->id();

        $recu->save();

        // Générer la référence avec la date + ID
        $recu->reference = 'RECU-' . now()->format('Ymd') . '-' . str_pad($recu->id, 4, '0', STR_PAD_LEFT);

        // Sauvegarder la référence mise à jour
        $recu->save();

        return redirect()->route('recus.index')->with('success', 'Reçu créé avec succès.');
    }

}
