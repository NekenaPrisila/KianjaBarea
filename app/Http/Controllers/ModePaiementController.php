<?php

namespace App\Http\Controllers;

use App\Models\ModePaiement;
use Illuminate\Http\Request;

class ModePaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modePaiements = ModePaiement::all();
        return view('modePaiements.index', compact('modePaiements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modePaiements.create'); // Vue en mode création
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:mode_paiement,nom',
        ]);

        ModePaiement::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('mode-paiement.index')->with('success', 'Mode de paiement créé avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModePaiement $modePaiement)
    {
        return view('modePaiements.create', compact('modePaiement')); // même vue que create
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModePaiement $modePaiement)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:mode_paiement,nom,' . $modePaiement->id,
        ]);

        $modePaiement->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('mode-paiement.index')->with('success', 'Mode de paiement mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModePaiement $modePaiement)
    {
        $modePaiement->delete();
        return redirect()->route('mode-paiement.index')->with('success', 'Mode de paiement supprimé avec succès !');
    }
}
