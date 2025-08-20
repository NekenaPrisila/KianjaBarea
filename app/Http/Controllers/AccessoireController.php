<?php

namespace App\Http\Controllers;

use App\Models\Accessoire;
use App\Models\UniteTarif;
use App\Models\TarifsAccessoire;
use Illuminate\Http\Request;

class AccessoireController extends Controller
{
    public function index()
    {
        $accessoires = Accessoire::with('tarifs_accessoires.unite_tarif')->get();
        return view('accessoires.index', compact('accessoires'));
    }

    public function create()
    {
        $unitesTarif = UniteTarif::all();
        return view('accessoires.create', compact('unitesTarif'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_disponible' => 'nullable|integer|min:0',
            'tarifs' => 'array',
            'tarifs.*.prix_unitaire' => 'required|numeric|min:0',
            'tarifs.*.id_unite_tarif' => 'required|exists:unite_tarif,id',
        ]);

        $accessoire = Accessoire::create([
            'nom' => $validated['nom'],
            'nombre_disponible' => $validated['nombre_disponible'] ?? 0,
        ]);

        if (!empty($validated['tarifs'])) {
            foreach ($validated['tarifs'] as $tarif) {
                $accessoire->tarifs_accessoires()->create([
                    'prix_unitaire' => $tarif['prix_unitaire'],
                    'id_unite_tarif' => $tarif['id_unite_tarif'],
                    'date_saisie' => now(),
                ]);
            }
        }

        return redirect()->route('accessoires.index')->with('success', 'Accessoire créé avec ses tarifs !');
    }

    public function edit(Accessoire $accessoire)
    {
        $accessoire->load('tarifs_accessoires.unite_tarif');
        $unitesTarif = UniteTarif::all();
        return view('accessoires.create', compact('accessoire', 'unitesTarif'));
    }

    public function update(Request $request, Accessoire $accessoire)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_disponible' => 'nullable|integer|min:0',
            'tarifs' => 'array',
            'tarifs.*.id' => 'nullable|exists:tarifs_accessoires,id',
            'tarifs.*.prix_unitaire' => 'required|numeric|min:0',
            'tarifs.*.id_unite_tarif' => 'required|exists:unite_tarif,id',
        ]);

        $accessoire->update([
            'nom' => $validated['nom'],
            'nombre_disponible' => $validated['nombre_disponible'] ?? 0,
        ]);

        // Mettre à jour ou créer les tarifs
        $idsConserves = [];
        foreach ($validated['tarifs'] ?? [] as $tarifData) {
            if (!empty($tarifData['id'])) {
                $tarif = TarifsAccessoire::find($tarifData['id']);
                $tarif->update($tarifData);
                $idsConserves[] = $tarif->id;
            } else {
                $tarif = $accessoire->tarifs_accessoires()->create([
                    'prix_unitaire' => $tarifData['prix_unitaire'],
                    'id_unite_tarif' => $tarifData['id_unite_tarif'],
                    'date_saisie' => now(),
                ]);
                $idsConserves[] = $tarif->id;
            }
        }

        // Supprimer les anciens tarifs non présents dans la requête
        $accessoire->tarifs_accessoires()->whereNotIn('id', $idsConserves)->delete();

        return redirect()->route('accessoires.index')->with('success', 'Accessoire mis à jour avec ses tarifs !');
    }

    public function destroy(Accessoire $accessoire)
    {
        $accessoire->tarifs_accessoires()->delete();
        $accessoire->delete();

        return redirect()->route('accessoires.index')->with('success', 'Accessoire supprimé avec ses tarifs !');
    }
}
