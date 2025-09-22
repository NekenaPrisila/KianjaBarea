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
                            @if(isset($types_paiement))
                                @foreach($types_paiement as $tp)
                                    <option value="{{ $tp->id }}" {{ request('type_paiement') == $tp->id ? 'selected' : '' }}>{{ $tp->nom }}</option>
                                @endforeach
                            @else
                                <option value="acompte" {{ request('type_paiement') == 'acompte' ? 'selected' : '' }}>Acompte</option>
                                <option value="totalite" {{ request('type_paiement') == 'totalite' ? 'selected' : '' }}>Totalité</option>
                            @endif
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="client_search_factures" class="col-sm-2 col-form-label">Client</label>
                    <div class="col-sm-10 position-relative">
                        <input type="text" class="form-control" id="client_search_factures" name="client_name" autocomplete="off" placeholder="Rechercher un client par nom..." value="{{ request('client_name') }}">
                        <input type="hidden" id="client_id_factures" name="client_id" value="{{ request('client_id') }}">
                        <div id="client_suggestions_factures" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="etat" class="col-sm-2 col-form-label">État</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="etat" name="etat">
                            <option value="">-- Tous --</option>
                            <option value="reglee" {{ request('etat') == 'reglee' ? 'selected' : '' }}>Réglée</option>
                            <option value="non_reglee" {{ request('etat') == 'non_reglee' ? 'selected' : '' }}>Non réglée</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="reference_reservation" class="col-sm-2 col-form-label">Référence Réservation</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="reference_reservation" name="reference_reservation"
                               value="{{ request('reference_reservation') }}" placeholder="Référence réservation">
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
                    <th>Date édition</th>
                    <th>Client</th>
                    <th>Réservation</th>
                    <th>Type Paiement</th>
                    <th>Montant Payé (Ar)</th>
                    <th>Reste à Payer (Ar)</th>
                    @if(auth()->user()->role_utilisateur->role == 'commercial')
                        <th>État</th>
                    @endif
                    {{-- @if(auth()->user()->role_utilisateur->role == 'caisse')
                        <th>Créé par</th>
                    @endif --}}
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
                    <td>{{ $facture->type_paiement->nom ?? '—' }}</td>
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
                    {{-- @if(auth()->user()->role_utilisateur->role == 'caisse')
                        <td>{{ $facture->utilisateur->nom_utilisateur ?? 'N/A' }}</td>
                    @endif --}}
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
                    <td colspan="10" class="text-center">Aucune facture trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('partials.toggle-search')
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Autocomplete client pour factures
    let timerFactures;
    const input = document.getElementById('client_search_factures');
    const suggestions = document.getElementById('client_suggestions_factures');

    if (input) {
        input.addEventListener('input', function() {
            clearTimeout(timerFactures);
            let query = this.value.trim();
            suggestions.innerHTML = '';
            document.getElementById('client_id_factures').value = '';
            if (query.length < 1) return;
            timerFactures = setTimeout(() => {
                fetch(`/api/clients/search?query=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => {
                        suggestions.innerHTML = '';
                        data.forEach(client => {
                            let item = document.createElement('button');
                            item.type = 'button';
                            item.className = 'list-group-item list-group-item-action';
                            item.textContent = `${client.nom} (${client.reference})`;
                            item.onclick = function() {
                                input.value = client.nom + ' (' + client.reference + ')';
                                document.getElementById('client_id_factures').value = client.id;
                                suggestions.innerHTML = '';
                            };
                            suggestions.appendChild(item);
                        });
                    });
            }, 200);
        });

        document.addEventListener('click', function(e) {
            if(!input.contains(e.target)) {
                suggestions.innerHTML = '';
            }
        });
    }
});
</script>
@endsection