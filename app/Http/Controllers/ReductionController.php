<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reduction;
use App\Models\Reservation;

class ReductionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'motif' => 'required|string|max:255',
            'valeur' => 'required|numeric|min:0',
            'id_reservation' => 'required|exists:reservations,id',
            'reference_reservation' => 'required|string'
        ]);

        Reduction::create([
            'motif' => $request->motif,
            'valeur' => $request->valeur,
            'id_reservation' => $request->id_reservation,
            'reference_reservation' => $request->reference_reservation,
        ]);

        return redirect()->back()->with('success', 'Réduction enregistrée avec succès.');
    }
}
