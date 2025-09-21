<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\TypeClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Affiche la liste des clients.
     */
    public function index(Request $request)
    {
        $query = Client::with('type_client');

        // Si un client_id est fourni (sélection via autocomplete), filtrer par id
        if ($request->filled('client_id')) {
            $query->where('id', $request->client_id);
        } else {
            $query->when($request->nom, function ($q, $nom) {
                return $q->where('nom', 'like', "%$nom%");
            });
        }

        // Filtre par type de client si fourni
        if ($request->filled('id_type_client')) {
            $query->where('id_type_client', $request->id_type_client);
        }

        $clients = $query->orderBy('date_ajout', 'desc')->get();

        $typesClient = TypeClient::all();

        return view('clients.index', compact('clients', 'typesClient'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        $typesClient = TypeClient::all();
        return view('clients.create', compact('typesClient'));
    }

    /**
     * Enregistre un nouveau client.
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'representant' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string',
            'id_type_client' => 'required|integer|exists:type_client,id',
        ]);

        // Génération référence unique
        $nextId = (Client::max('id') ?? 0) + 1;
        $validated['reference'] = 'CLI' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $validated['date_ajout'] = now();

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d’édition.
     */
    public function edit(Client $client)
    {
        $typesClient = TypeClient::all();
        return view('clients.create', compact('client', 'typesClient'));
    }

    /**
     * Met à jour un client existant.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'representant' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string',
            'id_type_client' => 'required|integer|exists:type_client,id',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Supprime un client.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }

    /**
     * Recherche (pour autocomplete).
     */
    public function search(Request $request)
    {
        $q = $request->query('query');
        $clients = Client::where('nom', 'like', "%$q%")
            ->orWhere('reference', 'like', "%$q%")
            ->limit(10)
            ->get(['id', 'nom', 'reference']);
        return response()->json($clients);
    }
}
