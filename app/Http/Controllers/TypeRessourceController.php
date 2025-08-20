<?php

namespace App\Http\Controllers;

use App\Models\TypeRessource;
use Illuminate\Http\Request;

class TypeRessourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typesRessources = TypeRessource::all();
        return view('typesRessources.index', compact('typesRessources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typesRessources.create'); // vue en mode création
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_ressource,nom',
            'description' => 'nullable|string',
        ]);

        TypeRessource::create($request->only(['nom', 'description']));

        return redirect()->route('type-ressource.index')
                         ->with('success', 'Type de ressource créé avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeRessource $typeRessource)
    {
        return view('typesRessources.create', compact('typeRessource')); // même vue que create
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeRessource $typeRessource)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:type_ressource,nom,' . $typeRessource->id,
            'description' => 'nullable|string',
        ]);

        $typeRessource->update($request->only(['nom', 'description']));

        return redirect()->route('type-ressource.index')
                         ->with('success', 'Type de ressource mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeRessource $typeRessource)
    {
        $typeRessource->delete();

        return redirect()->route('type-ressource.index')
                         ->with('success', 'Type de ressource supprimé avec succès !');
    }
}
