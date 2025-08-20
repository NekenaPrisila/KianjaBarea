<?php

namespace App\Http\Controllers;

use App\Models\UniteTarif;
use Illuminate\Http\Request;

class UniteTarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uniteTarifs = UniteTarif::all();
        return view('uniteTarifs.index', compact('uniteTarifs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // On envoie juste la vue sans variable (mode création)
        return view('uniteTarifs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255|unique:unite_tarif,nom',
        ]);

        // Création
        UniteTarif::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('unite-tarif.index')->with('success', 'Unité de tarif créée avec succès !');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UniteTarif $uniteTarif)
    {
        // On utilise la même vue "create.blade.php" mais avec $uniteTarif
        return view('uniteTarifs.create', compact('uniteTarif'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UniteTarif $uniteTarif)
    {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255|unique:unite_tarif,nom,' . $uniteTarif->id,
        ]);

        // Mise à jour
        $uniteTarif->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('unite-tarif.index')->with('success', 'Unité de tarif mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UniteTarif $uniteTarif)
    {
        $uniteTarif->delete();
        return redirect()->route('unite-tarif.index')->with('success', 'Unité de tarif supprimée avec succès !');
    }
}
