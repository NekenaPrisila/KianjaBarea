<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Ressource;

class CalendarController extends Controller
{
    public function index()
    {
        // Récupérer toutes les réservations avec leurs relations
        $reservations = Reservation::with([
            'client',
            'ressources', // Charge les ressources associées via la relation many-to-many
        ])->get();

        // Transformer les réservations en format compatible avec FullCalendar
        $events = [];
        
        foreach ($reservations as $reservation) {
            if (isset($reservation->statutPaiement) && $reservation->statutPaiement->statut_paiement === 'confirmée') {
                // Générez la couleur une seule fois par réservation
                $color = $this->stringToColor($reservation->id);

                foreach ($reservation->ressources as $ressource) {
                    $events[] = [
                        'id' => $reservation->id,
                        'title' => $reservation->client->nom . ' - ' .$reservation->client->representant,
                        'start' => $ressource->pivot->debut_utilisation,
                        'end' => $ressource->pivot->fin_utilisation,
                        'resourceId' => $ressource->id,
                        'backgroundColor' => $color,
                        'borderColor' => $color,
                        'extendedProps' => [
                            'client' => $reservation->client->nom,
                            'representant' => $reservation->client->representant,
                            'telephone' => $reservation->client->telephone,
                            'status' => $reservation->status,
                            'status_paiement' => $reservation->status_paiement,
                            'montant_total' => $reservation->montant_total,
                            'ressource_id' => $ressource->id,
                            'ressource_nom' => $ressource->nom
                        ]
                    ];
                }
            }
        }

        // Récupérer toutes les ressources pour le calendrier
        $resources = Ressource::with('type_ressource')->get()->map(function($ressource) {
            return [
                'id' => $ressource->id,
                'title' => $ressource->nom,
                'capacite' => $ressource->capacite,
                'group' => $ressource->type_ressource ? $ressource->type_ressource->nom : 'Autres' // 👈 ici
            ];
        })->toArray();


        return view('calendar', [
            'events' => $events,
            'resources' => $resources
        ]);
    }

    /**
     * Génère une couleur hexadécimale unique à partir d'une chaîne
     */
    private function stringToColor($str)
    {
        // Utilise md5 pour une meilleure répartition
        $hash = md5($str);

        // Prend les 6 premiers caractères pour R, G, B
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));

        // Optionnel : Ajuste la luminosité pour éviter des couleurs trop sombres
        $r = ($r + 128) % 256;
        $g = ($g + 128) % 256;
        $b = ($b + 128) % 256;

        return sprintf("#%02X%02X%02X", $r, $g, $b);
    }

}