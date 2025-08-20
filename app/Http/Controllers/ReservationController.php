<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\Accessoire;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['client', 'utilisateur', 'accessoires', 'ressources'])
            ->orderBy('date_creation', 'desc')
            ->get();
        
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $clients = Client::all();
        $utilisateurs = Utilisateur::all();
        $accessoires = Accessoire::with('tarifs_accessoires.unite_tarif')->get();
        $ressources = Ressource::with('tarifs_ressources.unite_tarif')->get();
        return view('reservations.create', compact('clients', 'utilisateurs', 'accessoires', 'ressources'));
    }

    public function store(Request $request)
    {
        $reservation = new Reservation();

        $date_premier_jour = null;
        $date_dernier_jour = null;

        $clientId = $request->input('client_id');
        $client = Client::findOrFail($clientId);

        $reservation->client()->associate($client);
        $reservation->reference_client = $client->reference;
        $reservation->id_creer_par = auth()->id();
        $reservation->reference = 'Temporaire';
        $reservation->date_creation = now();

        $accessoires = $request->input('accessoires', []);
        $ressources = $request->input('ressources', []);

        // Parcours des ressources pour trouver les bornes de date
        foreach ($ressources as $ressourceId => $details) {
            $debut = Carbon::parse($details['debut_utilisation']);
            $fin = Carbon::parse($details['fin_utilisation']);

            if (is_null($date_premier_jour) || $debut->lt($date_premier_jour)) {
                $date_premier_jour = $debut;
            }
            if (is_null($date_dernier_jour) || $fin->gt($date_dernier_jour)) {
                $date_dernier_jour = $fin;
            }
        }

        $reservation->date_premier_jour = $date_premier_jour;
        $reservation->date_dernier_jour = $date_dernier_jour;
        $reservation->description = $request->input('description', '');
        $reservation->save(); // On sauve ici pour avoir l'ID de la réservation

        // Générer la référence avec la date + ID
        $reservation->reference = 'RES-' . now()->format('Ymd') . '-' . str_pad($reservation->id, 4, '0', STR_PAD_LEFT);

        // Sauvegarder la référence mise à jour
        $reservation->save();

        // ✅ Attacher les accessoires
        foreach ($accessoires as $accessoireId => $details) {
            $reservation->accessoires()->attach($accessoireId, [
                'reference_reservation' => $reservation->reference,
                'id_tarif_accessoire' => $details['tarif_id'],
                'quantite' => $details['quantite'],
                'debut_utilisation' => $details['debut_utilisation'],
                'fin_utilisation' => $details['fin_utilisation'],
            ]);
        }

        // ✅ Attacher les ressources
        foreach ($ressources as $ressourceId => $details) {
            $reservation->ressources()->attach($ressourceId, [
                'reference_reservation' => $reservation->reference,
                'id_tarif_ressource' => $details['tarif_id'],
                'debut_utilisation' => $details['debut_utilisation'],
                'quantite' => $details['quantite'],
                'fin_utilisation' => $details['fin_utilisation'],
            ]);
        }

        // ✅ Rediriger ou retour
        return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès !');
    }

    public function show($id)
    {
        $reservation = Reservation::with([
            'client',
            'ressources',
            'accessoires',
        ])->findOrFail($id);

        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $clients = Client::all();
        $utilisateurs = Utilisateur::all();
        $accessoires = Accessoire::all();
        $ressources = Ressource::all();
        
        return view('reservations.create', compact('reservation', 'clients', 'utilisateurs', 'accessoires', 'ressources'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'montant_total' => 'required|numeric',
            'reduction' => 'nullable|numeric',
            'status_paiement' => 'required|string',
            'accessoires' => 'nullable|array',
            'ressources' => 'nullable|array'
        ]);

        $reservation->update([
            'status' => $validated['status'],
            'montant_total' => $validated['montant_total'],
            'reduction' => $validated['reduction'] ?? 0,
            'status_paiement' => $validated['status_paiement']
        ]);

        // Sync accessoires et ressources
        if (isset($validated['accessoires'])) {
            $accessoiresData = [];
            foreach ($validated['accessoires'] as $accessoireId => $quantite) {
                if ($quantite > 0) {
                    $accessoiresData[$accessoireId] = ['quantite' => $quantite];
                }
            }
            $reservation->accessoires()->sync($accessoiresData);
        }

        if (isset($validated['ressources'])) {
            $ressourcesData = [];
            foreach ($validated['ressources'] as $ressourceId => $details) {
                if ($details['quantite'] > 0) {
                    $ressourcesData[$ressourceId] = [
                        'quantite' => $details['quantite'],
                        'id_tarif_ressource' => $details['tarif_id']
                    ];
                }
            }
            $reservation->ressources()->sync($ressourcesData);
        }

        return redirect()->route('reservations.show', $reservation->id)
            ->with('success', 'Réservation mise à jour avec succès!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')
            ->with('success', 'Réservation supprimée avec succès!');
    }
}
