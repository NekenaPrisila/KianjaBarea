<?php

namespace App\Http\Controllers;

use App\Models\RecuOccasionnel;
use App\Models\Accessoire;
use App\Models\Ressource;
use App\Models\ModePaiement;
use Illuminate\Http\Request;

class RecuOccasionnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recus = RecuOccasionnel::with(['accessoires', 'ressources'])->get();
        $modesPaiement = ModePaiement::all();

        return view('recuOccasionnel.index', compact('recus', 'modesPaiement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accessoires = Accessoire::with('tarifs_accessoires')->get();
        $ressources  = Ressource::with('tarifs_ressources')->get();
        $modesPaiement = ModePaiement::all();

        return view('recuOccasionnel.create', compact('accessoires', 'ressources', 'modesPaiement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des champs principaux
        $request->validate([
            'motif' => 'required|string|max:255',
            'id_mode_paiement' => 'required|exists:mode_paiement,id',
            'reference_paiement' => 'nullable|string|max:255',
            'creer_par' => 'required|exists:utilisateur,id',
        ]);

        // --- Créer le reçu occasionnel avec une référence temporaire ---
        $recu = RecuOccasionnel::create([
            'motif' => $request->motif,
            'id_mode_paiement' => $request->id_mode_paiement,
            'reference_paiement' => $request->reference_paiement,
            'date_edition' => now(),
            'creer_par' => $request->creer_par,
            'reference' => 'TEMP', // Référence temporaire
        ]);

        // --- Générer une vraie référence basée sur la date + ID ---
        $recu->reference = 'REC-OCCAS-' . now()->format('Ymd') . '-' . str_pad($recu->id, 4, '0', STR_PAD_LEFT);
        $recu->save();

        // --- Attacher les accessoires ---
        $accessoires = $request->input('accessoires', []);
        foreach ($accessoires as $accessoireId => $data) {
            $recu->accessoires()->attach($accessoireId, [
                'reference_recu_occasionnel' => $recu->reference,
                'id_tarif' => $data['tarif_id'] ?? null,
                'quantite' => $data['quantite'] ?? 1,
                'debut_utilisation' => $data['debut_utilisation'] ?? null,
                'fin_utilisation' => $data['fin_utilisation'] ?? null,
            ]);
        }

        // --- Attacher les ressources ---
        $ressources = $request->input('ressources', []);
        foreach ($ressources as $ressourceId => $data) {
            $recu->ressources()->attach($ressourceId, [
                'reference_recu_occasionnel' => $recu->reference,
                'id_tarif' => $data['tarif_id'] ?? null,
                'quantite' => $data['quantite'] ?? 1,
                'debut_utilisation' => $data['debut_utilisation'] ?? null,
                'fin_utilisation' => $data['fin_utilisation'] ?? null,
            ]);
        }

        return redirect()->route('recus-occasionnel.index')
                        ->with('success', 'Reçu occasionnel créé avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RecuOccasionnel $recuOccasionnel)
    {
        $recuOccasionnel->load(['accessoires', 'ressources']);
        $accessoires = Accessoire::with('tarifs_accessoires')->get();
        $ressources  = Ressource::with('tarifs_ressources')->get();

        return view('recuOccasionnel.create', compact('recuOccasionnel', 'accessoires', 'ressources'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecuOccasionnel $recuOccasionnel)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'motif' => 'required|string|max:255',
            'date_edition' => 'nullable|date',
        ]);

        $recuOccasionnel->update([
            'motif' => $request->motif,
            'date_edition' => $request->date_edition ?? now(),
        ]);

        // --- Synchroniser Accessoires ---
        $accessoiresData = [];
        if ($request->has('accessoires')) {
            foreach ($request->accessoires as $accessoireId => $data) {
                $accessoiresData[$accessoireId] = [
                    'id_tarif' => $data['tarif_id'] ?? null,
                    'quantite' => $data['quantite'] ?? 1,
                    'debut_utilisation' => $data['debut_utilisation'] ?? null,
                    'fin_utilisation' => $data['fin_utilisation'] ?? null,
                ];
            }
        }
        $recuOccasionnel->accessoires()->sync($accessoiresData);

        // --- Synchroniser Ressources ---
        $ressourcesData = [];
        if ($request->has('ressources')) {
            foreach ($request->ressources as $ressourceId => $data) {
                $ressourcesData[$ressourceId] = [
                    'id_tarif' => $data['tarif_id'] ?? null,
                    'quantite' => $data['quantite'] ?? 1,
                    'debut_utilisation' => $data['debut_utilisation'] ?? null,
                    'fin_utilisation' => $data['fin_utilisation'] ?? null,
                ];
            }
        }
        $recuOccasionnel->ressources()->sync($ressourcesData);

        return redirect()->route('recus-occasionnel.index')->with('success', 'Reçu occasionnel mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecuOccasionnel $recuOccasionnel)
    {
        $recuOccasionnel->accessoires()->detach();
        $recuOccasionnel->ressources()->detach();
        $recuOccasionnel->delete();

        return redirect()->route('recus-occasionnel.index')->with('success', 'Reçu occasionnel supprimé avec succès.');
    }
}
