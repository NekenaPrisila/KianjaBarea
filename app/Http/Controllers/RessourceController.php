<?php

namespace App\Http\Controllers;

use App\Models\Ressource;
use App\Models\TypeRessource;
use App\Models\UniteTarif;
use App\Models\TarifsRessource;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    public function index()
    {
        $ressources = Ressource::with('tarifs_ressources.unite_tarif')->get();
        return view('ressources.index', compact('ressources'));
    }

    public function create()
    {
        $typesRessource = TypeRessource::all();
        $unitesTarif = UniteTarif::all();
        return view('ressources.create', compact('typesRessource', 'unitesTarif'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'caution' => 'nullable|numeric',
            'capacite' => 'nullable|integer',
            'id_type_ressource' => 'required|integer|exists:type_ressource,id',
            'tarifs' => 'array',
            'tarifs.*.prix_unitaire' => 'required|numeric|min:0',
            'tarifs.*.id_unite_tarif' => 'required|exists:unite_tarif,id',
        ]);

        $ressource = Ressource::create($validated);

        if (!empty($validated['tarifs'])) {
            foreach ($validated['tarifs'] as $tarif) {
                $ressource->tarifs_ressources()->create([
                    'prix_unitaire' => $tarif['prix_unitaire'],
                    'id_unite_tarif' => $tarif['id_unite_tarif'],
                    'date_saisie' => now(),
                ]);
            }
        }

        return redirect()->route('ressources.index')->with('success', 'Ressource créée avec ses tarifs !');
    }

    public function edit(Ressource $ressource)
    {
        $typesRessource = TypeRessource::all();
        $unitesTarif = UniteTarif::all();
        $ressource->load('tarifs_ressources.unite_tarif');
        return view('ressources.create', compact('ressource', 'typesRessource', 'unitesTarif'));
    }

    public function update(Request $request, Ressource $ressource)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'caution' => 'nullable|numeric',
            'capacite' => 'nullable|integer',
            'id_type_ressource' => 'required|integer|exists:type_ressource,id',
            'tarifs' => 'array',
            'tarifs.*.id' => 'nullable|exists:tarifs_ressources,id',
            'tarifs.*.prix_unitaire' => 'required|numeric|min:0',
            'tarifs.*.id_unite_tarif' => 'required|exists:unite_tarif,id',
        ]);

        $ressource->update($validated);

        // Mettre à jour / Créer les tarifs
        $idsConserves = [];
        foreach ($validated['tarifs'] ?? [] as $tarifData) {
            if (!empty($tarifData['id'])) {
                $tarif = TarifsRessource::find($tarifData['id']);
                $tarif->update($tarifData);
                $idsConserves[] = $tarif->id;
            } else {
                $tarif = $ressource->tarifs_ressources()->create([
                    'prix_unitaire' => $tarifData['prix_unitaire'],
                    'id_unite_tarif' => $tarifData['id_unite_tarif'],
                    'date_saisie' => now(),
                ]);
                $idsConserves[] = $tarif->id;
            }
        }

        // Supprimer les anciens tarifs non présents dans la requête
        $ressource->tarifs_ressources()->whereNotIn('id', $idsConserves)->delete();

        return redirect()->route('ressources.index')->with('success', 'Ressource mise à jour avec ses tarifs !');
    }

    public function destroy(Ressource $ressource)
    {
        $ressource->tarifs_ressources()->delete();
        $ressource->delete();
        return redirect()->route('ressources.index')->with('success', 'Ressource supprimée avec ses tarifs !');
    }
}
