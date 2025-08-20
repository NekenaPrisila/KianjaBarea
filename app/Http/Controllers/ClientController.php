<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\TypeClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::with('type_client')
            ->when($request->nom, function ($query, $nom) {
                return $query->where('nom', 'like', "%$nom%");
            })
            ->when($request->telephone, function ($query, $tel) {
                return $query->where('telephone', 'like', "%$tel%");
            })
            ->orderBy('date_ajout', 'desc')
            ->get();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $typesClient = TypeClient::all();
        return view('clients.create', compact('typesClient'));
    }

    public function search(Request $request)
    {
        $q = $request->query('query');
        $clients = \App\Models\Client::where('nom', 'like', "%$q%")
            ->orWhere('reference', 'like', "%$q%")
            ->limit(10)
            ->get(['id', 'nom', 'reference']);
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'representant' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'adresse' => 'nullable|string',
            'id_type_client' => 'required|integer|exists:type_client,id',
        ]);

        $nextId = (Client::max('id') ?? 0) + 1;

        $validated['reference'] = 'CLI' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $validated['date_ajout'] = now();

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

}