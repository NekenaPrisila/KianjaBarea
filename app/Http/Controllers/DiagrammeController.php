<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VueRepartitionMensuelleReservation;

class DiagrammeController extends Controller
{
    public function reservationsParMois(Request $request)
    {
        // Liste des années distinctes dans la base, pour le filtre
        $anneesDisponibles = DB::table('vue_repartition_mensuelle_reservations')
            ->select('annee')
            ->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee')
            ->toArray();

        // Année sélectionnée dans la requête (GET) ou année actuelle par défaut
        $anneeSelectionnee = $request->input('annee', date('Y'));

        // Mois fixes
        $allMonths = ['01','02','03','04','05','06','07','08','09','10','11','12'];

        // Données pour l'année sélectionnée
        $donnees = DB::table('vue_repartition_mensuelle_reservations')
            ->where('annee', $anneeSelectionnee)
            ->get();

        // Initialisation des données mois par mois
        $mois = [];
        $nombre = [];
        foreach ($allMonths as $moisNum) {
            $mois[] = $moisNum;
            $valeur = $donnees->firstWhere('mois', $moisNum);
            $nombre[] = $valeur ? $valeur->nombre_reservations : 0;
        }

        return view('diagramme', compact('mois', 'nombre', 'anneesDisponibles', 'anneeSelectionnee'));
    }

    public function chiffreAffaireParMois(Request $request)
    {
        // Liste des années distinctes dans la base, pour le filtre
        $anneesDisponibles = DB::table('vue_chiffre_affaire_mensuel')
            ->select('annee')
            ->distinct()
            ->orderBy('annee', 'desc')
            ->pluck('annee')
            ->toArray();

        // Année sélectionnée dans la requête (GET) ou année actuelle par défaut
        $anneeSelectionnee = $request->input('annee', date('Y'));

        // Mois fixes
        $allMonths = ['1','2','3','4','5','6','7','8','9','10','11','12'];

        // Données pour l'année sélectionnée
        $donnees = DB::table('vue_chiffre_affaire_mensuel')
            ->where('annee', $anneeSelectionnee)
            ->get();

        // Initialisation des données mois par mois
        $mois = [];
        $chiffre = [];
        foreach ($allMonths as $moisNum) {
            $mois[] = $moisNum;
            $valeur = $donnees->firstWhere('mois', $moisNum);
            $chiffre[] = $valeur ? $valeur->chiffre_affaire : 0;
        }

        return view('chiffreAffaire', compact('mois', 'chiffre', 'anneesDisponibles', 'anneeSelectionnee'));
    }
}
