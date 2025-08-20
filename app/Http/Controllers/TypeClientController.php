<?php

namespace App\Http\Controllers;

use App\Models\TypeClient;
use Illuminate\Http\Request;

class TypeClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typesClients = TypeClient::all();
        return view('typesClients.index', compact('typesClients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vue en mode création
        return view('typesClients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_client,nom',
        ]);

        // Création
        TypeClient::create([
            'nom' => $request->nom,
        ]);

        return redirect()->route('type-client.index')->with('success', 'Type de client créé avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeClient $typeClient)
    {
        // On renvoie la même vue que create, mais avec $typeClient
        return view('typesClients.create', compact('typeClient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeClient $typeClient)
    {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_client,nom,' . $typeClient->id,
        ]);

        // Mise à jour
        $typeClient->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('type-client.index')->with('success', 'Type de client mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeClient $typeClient)
    {
        $typeClient->delete();
        return redirect()->route('type-client.index')->with('success', 'Type de client supprimé avec succès !');
    }
}
