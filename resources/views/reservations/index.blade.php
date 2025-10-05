@extends('layouts.app')

@section('title', 'Liste des Réservations')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recherche Réservations</h5>
                <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm" type="button" aria-expanded="true" aria-controls="searchForm">
                    <i id="toggleIcon" class="bi bi-dash"></i>
                </button>
            </div>

            <!-- Formulaire de Recherche -->
            <form id="searchForm" action="{{ route('reservations.index') }}" method="GET">
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">Statut</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="status" name="status">
                            <option value="">-- Tous --</option>
                            <option value="1">Confirmée</option>
                            <option value="2">En attente</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="status_paiement" class="col-sm-2 col-form-label">Statut Paiement</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="status_paiement" name="status_paiement">
                            <option value="">-- Tous --</option>
                            <option value="1">payé</option>
                            <option value="2">acompte</option>
                            <option value="3">non payé</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="client_search_index" class="col-sm-2 col-form-label">Client</label>
                    <div class="col-sm-10 position-relative">
                        <input type="text" class="form-control" id="client_search_index" name="client_name" autocomplete="off" placeholder="Rechercher un client par nom..." value="{{ request('client_name') }}">
                        <input type="hidden" id="client_id_index" name="client_id" value="{{ request('client_id') }}">
                        <div id="client_suggestions_index" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="date_premier_jour" class="col-sm-2 col-form-label">Date du premier jour</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_premier_jour" name="date_premier_jour" value="{{ request('date_premier_jour') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Filtrer</label>
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
        <h5 class="card-title">Liste des Réservations</h5>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Date création</th>
                    <th>Statut</th>
                    <th>Montant Total (Ar)</th>
                    <th>Réduction (%)</th>
                    <th>Etat de Paiement</th>
                    @if(auth()->user()->role_utilisateur->role == 'dg')
                        <th>Créé par</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->reference }}</td>
                    <td>
                        {{ $reservation->client->nom ?? 'N/A' }}
                        @if($reservation->reference_client)
                            <br><small class="text-muted">{{ $reservation->reference_client }}</small>
                        @endif
                    </td>
                    <td>{{ $reservation->date_creation->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge bg-{{ $reservation->statutPaiement->statut_paiement === 'confirmée' ? 'success' : 'warning' }}">
                            {{ ucfirst($reservation->statutPaiement->statut_paiement) }}
                        </span>
                    </td>
                    <td>{{ number_format($reservation->cout_total, 2, ',', ' ') }}</td>
                    <td>{{ number_format($reservation->getSommeReductions(), 2, ',', ' ') }}</td>
                    <td>
                        @if ($reservation->etatPaiement?->etat_paiement === 'Payé')
                            ✅ Payé
                        @elseif ($reservation->etatPaiement?->etat_paiement === 'Acompte')
                            ⚠️ Acompte
                        @else
                            ❌ Non payé
                        @endif
                    </td>
                    @if(auth()->user()->role_utilisateur->role == 'dg')
                        <td>{{ $reservation->utilisateur->nom_utilisateur ?? 'N/A' }}</td>
                    @endif
                    <td>
                        <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"> Voir détails</i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('partials.toggle-search')
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Autocomplete client pour la page index
    let timerIndex;
    const input = document.getElementById('client_search_index');
    const suggestions = document.getElementById('client_suggestions_index');

    if (input) {
        input.addEventListener('input', function() {
            clearTimeout(timerIndex);
            let query = this.value.trim();
            suggestions.innerHTML = '';
            document.getElementById('client_id_index').value = '';
            if (query.length < 1) return;
            timerIndex = setTimeout(() => {
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
                                document.getElementById('client_id_index').value = client.id;
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
