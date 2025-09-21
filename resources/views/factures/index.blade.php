@extends('layouts.app')

@section('title', 'Liste des Factures')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recherche Factures</h5>
                <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm" type="button" aria-expanded="true" aria-controls="searchForm">
                    <i id="toggleIcon" class="bi bi-dash"></i>
                </button>
            </div>

            <!-- Formulaire de Recherche -->
            <form id="searchForm" action="{{ route('factures.index') }}" method="GET">
                <div class="row mb-3">
                    <label for="type_paiement" class="col-sm-2 col-form-label">Type Paiement</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="type_paiement" name="type_paiement">
                            <option value="">-- Tous --</option>
                            <option value="acompte" {{ request('type_paiement') == 'acompte' ? 'selected' : '' }}>Acompte</option>
                            <option value="totalite" {{ request('type_paiement') == 'totalite' ? 'selected' : '' }}>Totalité</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="reference" class="col-sm-2 col-form-label">Référence</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="reference" name="reference"
                               value="{{ request('reference') }}" placeholder="Référence facture">
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
        <h5 class="card-title">Liste des Factures</h5>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Réservation</th>
                    <th>Montant Payé (Ar)</th>
                    <th>Reste à Payer (Ar)</th>
                    @if(auth()->user()->role_utilisateur->role == 'commercial')
                        <th>État</th>
                    @endif
                    @if(auth()->user()->role_utilisateur->role == 'caisse')
                        <th>Créé par</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($factures as $facture)
                <tr>
                    <td>{{ $facture->reference }}</td>
                    <td>{{ $facture->date_edition->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $facture->reservation->client->nom ?? 'N/A' }}
                        @if($facture->reservation->client->reference_client ?? false)
                            <br><small class="text-muted">{{ $facture->reservation->client->reference_client }}</small>
                        @endif
                    </td>
                    <td>{{ $facture->reference_reservation }}</td>
                    <td>{{ number_format($facture->montant_paye, 0, ',', ' ') }}</td>
                    <td>{{ number_format($facture->reste_a_payer, 0, ',', ' ') }}</td>
                    @if(auth()->user()->role_utilisateur->role == 'commercial')
                        <td>
                            @if ($facture->estReglee())
                                ✅ Réglée
                            @else
                                ❌ Non réglée
                            @endif
                        </td>
                    @endif
                    @if(auth()->user()->role_utilisateur->role == 'caisse')
                        <td>{{ $facture->utilisateur->nom_utilisateur ?? 'N/A' }}</td>
                    @endif
                    <td>
                        @if(auth()->user()->role_utilisateur->role == 'caisse')
                            @if(!$facture->estReglee())
                                <a href="{{ route('recu.edit', $facture->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-printer"></i> Éditer le reçu
                                </a>
                            @else
                                <span class="badge bg-success">Facture réglée</span>
                            @endif
                        @else
                            <a href="{{ route('facture.generate', $facture->id) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="bi bi-printer"></i> Imprimer
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Aucune facture trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('partials.toggle-search')
@endsection