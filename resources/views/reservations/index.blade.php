@extends('layouts.app')

@section('title', 'Liste des Réservations')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recherche Réservations</h5>
                <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm" type="button" aria-expanded="true" aria-controls="searchForm">
                    <i id="toggleIcon" class="fas fa-minus"></i>
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
                        <span class="badge bg-{{ 
                            $reservation->etatPaiement?->etat_paiement === 'payé' ? 'success' : (
                                $reservation->etatPaiement?->etat_paiement === 'accepté' ? 'warning' : 'danger') 
                        }}">
                            {{ ucfirst($reservation->etatPaiement?->etat_paiement ?? 'Inconnu') }}
                        </span>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleSearchBtn');
        const searchForm = document.getElementById('searchForm');
        const toggleIcon = document.getElementById('toggleIcon');

        toggleBtn.addEventListener('click', function () {
            if (searchForm.style.display === 'none') {
                searchForm.style.display = 'block';
                toggleIcon.classList.remove('fa-plus');
                toggleIcon.classList.add('fa-minus');
                toggleBtn.setAttribute('aria-expanded', 'true');
            } else {
                searchForm.style.display = 'none';
                toggleIcon.classList.remove('fa-minus');
                toggleIcon.classList.add('fa-plus');
                toggleBtn.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
@endsection
