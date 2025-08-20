@extends('layouts.app')

@section('title', 'Liste des Reçus')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recherche Reçus</h5>
                <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm" type="button" aria-expanded="true" aria-controls="searchForm">
                    <i id="toggleIcon" class="bi bi-dash"></i>
                </button>
            </div>

            <!-- Formulaire de Recherche -->
            <form id="searchForm" action="{{ route('recus.index') }}" method="GET">
                <div class="row mb-3">
                    <label for="mode_paiement" class="col-sm-2 col-form-label">Mode de Paiement</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="mode_paiement" name="mode_paiement">
                            <option value="">-- Tous --</option>
                            @foreach($modesPaiement as $mode)
                                <option value="{{ $mode->id }}" {{ request('mode_paiement') == $mode->id ? 'selected' : '' }}>
                                    {{ $mode->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="reference" class="col-sm-2 col-form-label">Référence</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="reference" name="reference"
                               value="{{ request('reference') }}" placeholder="Référence reçu">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Actions</label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </div>
            </form>
            <!-- Fin du formulaire -->
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Liste des Reçus</h5>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Date</th>
                    <th>Facture Associée</th>
                    <th>Client</th>
                    <th>Mode Paiement</th>
                    <th>Créé par</th>
                    <th>Référence de Paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recus as $recu)
                <tr>
                    <td>{{ $recu->reference }}</td>
                    <td>{{ $recu->date_edition->format('d/m/Y H:i') }}</td>
                    <td>{{ $recu->facture->reference ?? 'N/A' }}</td>
                    <td>{{ $recu->facture->reservation->client->nom ?? 'N/A' }}</td>
                    <td>{{ $recu->mode_paiement->nom ?? 'N/A' }}</td>
                    <td>{{ $recu->utilisateur->nom_utilisateur ?? 'N/A' }}</td>
                    <td>{{ $recu->reference_paiement ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('recu.generate', $recu->id) }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="bi bi-printer"></i> Imprimer
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Aucun reçu trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('partials.toggle-search')
@endsection
