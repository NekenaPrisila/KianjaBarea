@extends('layouts.app')

@section('title', 'Édition de la Facture')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center">Édition de la facture pour la réservation {{ $reservation->reference }}</h5>

        <form action="{{ route('factures.store') }}" method="POST">
            @csrf

            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
            <input type="hidden" name="reference_reservation" value="{{ $reservation->reference }}">

            {{-- Type de paiement --}}
            <div class="row mb-3">
                <label for="type_paiement" class="col-sm-3 col-form-label">Type de paiement</label>
                <div class="col-sm-9">
                    <select name="type_paiement" id="type_paiement" class="form-select" required>
                        @foreach($types_paiement as $type)
                            <option value="{{ $type->id }}" 
                                {{ old('type_paiement') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Montant de l'acompte (si applicable) --}}
            <div class="row mb-3" id="montant_acompte_div" style="display: none;">
                <label for="montant_acompte" class="col-sm-3 col-form-label">Montant Acompte (AR)</label>
                <div class="col-sm-9">
                    <input type="number" name="montant_acompte" id="montant_acompte" class="form-control"
                        step="0.01" min="0" value="{{ old('montant_acompte') }}">
                    <small class="form-text text-muted">Indiquez le montant de l'acompte à verser si applicable.</small>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="row mb-3">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Générer la facture PDF</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Script JS pour afficher le champ acompte --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('type_paiement');
        const acompteDiv = document.getElementById('montant_acompte_div');
        const acompteInput = document.getElementById('montant_acompte');

        function toggleAcompte() {
            const selectedOption = select.options[select.selectedIndex];
            const selectedText = selectedOption ? selectedOption.text.toLowerCase() : "";

            if (selectedText.includes('acompte')) {
                acompteDiv.style.display = 'flex';
                acompteInput.required = true;
            } else {
                acompteDiv.style.display = 'none';
                acompteInput.required = false;
            }
        }

        select.addEventListener('change', toggleAcompte);
        toggleAcompte(); // Initialisation
    });
</script>
@endsection
