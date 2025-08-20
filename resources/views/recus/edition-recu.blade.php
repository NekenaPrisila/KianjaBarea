@extends('layouts.app')

@section('title', 'Édition du Reçu')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Édition du recu de la facture {{ $facture->reference }}</h5>

        <!-- Formulaire d'édition du mode de paiement -->
        <form action="{{ route('recus.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_facture" value="{{ $facture->id }}">
            <input type="hidden" name="reference_facture" value="{{ $facture->reference }}">

            <div class="row mb-3">
                <label for="id_mode_paiement" class="col-sm-2 col-form-label">Mode de Paiement</label>
                <div class="col-sm-10">
                    <select class="form-select" id="id_mode_paiement" name="id_mode_paiement" required>
                        <option value="">-- Choisir un mode de paiement --</option>
                        @foreach ($modesPaiement as $mode)
                            <option value="{{ $mode->id }}" {{ old('id_mode_paiement') == $mode->id ? 'selected' : '' }}>
                                {{ $mode->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nouveau champ : Référence de paiement -->
            <div class="row mb-3">
                <label for="reference_paiement" class="col-sm-2 col-form-label">Référence de Paiement</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="reference_paiement" name="reference_paiement" 
                           value="{{ old('reference_paiement') }}" placeholder="Entrez la référence de paiement" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('factures.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </div>

        </form>

    </div>
</div>
@endsection
