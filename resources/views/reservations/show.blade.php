@extends('layouts.app')

@section('title', 'Détails de la réservation')

@section('styles')
    <link href="{{ asset('css/reservation-details.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="reservation-details">
    <header class="page-header">
        <a href="{{ route('reservations.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            <span>Retour à la liste</span>
        </a>
        <div class="header-actions">
            @if(auth()->user()->role_utilisateur->role == 'commercial')
                <div class="documents-section">
                    <a href="{{ route('facture.edit' , $reservation->id) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-pdf"></i> Générer Facture
                    </a>
                    <a href="{{ route('proforma.generate' , $reservation->id) }}" target="_blank" class="btn btn-outline-primary">
                        Générer Proforma
                    </a>
                </div>
            @endif
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reductionModal">
                <i class="bi bi-plus"></i>
                Ajouter une réduction
            </button>
        </div>
    </header>

    <div class="row">
        <div class="col-lg-8">
            <div class="details-card reservation-main-card animated-fade-in">
                <div class="card-header">
                    <div class="icon-box">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div>
                        <h1 class="card-title">Réservation #{{ $reservation->reference }}</h1>
                        <span class="badge bg-{{ $reservation->statutPaiement->statut_paiement === 'confirmée' ? 'success' : 'warning' }}">
                            {{ ucfirst($reservation->statutPaiement->statut_paiement) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Date du premier jour</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($reservation->date_premier_jour)->format('d/m/Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date du dernier jour</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($reservation->date_dernier_jour)->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Montant --}}
            <div class="details-card animated-fade-in" style="animation-delay: 0.1s;">
                <div class="card-header">
                    <div class="icon-box">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h2 class="card-title">Montant de la réservation</h2>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Montant total</div>
                            <div class="info-value">{{ number_format($reservation->cout_total, 2, ',', ' ') }} Ar</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Montant en lettres</div>
                            <div class="montant-lettres">
                                {{ ucfirst((new \NumberFormatter('fr', \NumberFormatter::SPELLOUT))->format($reservation->cout_total)) }} Ariary
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ressources réservées --}}
            <div class="details-card animated-fade-in" style="animation-delay: 0.3s;">
                <div class="card-header">
                    <div class="icon-box">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h2 class="card-title">Ressources réservées</h2>
                </div>
                <div class="card-body">
                    @if($reservation->ressources->count())
                        <div class="ressource-grid">
                            @foreach ($reservation->ressources as $ressource)
                                <div class="ressource-card">
                                    <strong class="d-block mb-2">{{ $ressource->nom ?? $ressource->title ?? 'Ressource' }}</strong>
                                    <div class="text-muted small mb-2">
                                        <div>Du {{ $ressource->pivot->debut_utilisation }}</div>
                                        <div>Au {{ $ressource->pivot->fin_utilisation }}</div>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-secondary">Quantité : {{ $ressource->pivot->quantite ?? '1' }}</span>
                                        @if($ressource->pivot->id_tarif_ressource)  
                                            <span class="badge bg-success">
                                                {{ number_format(\App\Models\TarifsRessource::find($ressource->pivot->id_tarif_ressource)->prix_unitaire, 2, ',', ' ') }} Ar
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Aucune ressource réservée.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Clients --}}
            <div class="details-card animated-fade-in" style="animation-delay: 0.2s;">
                <div class="card-header">
                    <div class="icon-box">
                        <i class="bi bi-person"></i>
                    </div>
                    <h2 class="card-title">Client</h2>
                </div>
                <div class="card-body">
                    <ul class="data-list">
                        <li>
                            <i class="bi bi-person-circle"></i>
                            <strong>Nom:</strong>
                            <span>{{ $reservation->client->nom ?? 'N/A' }}</span>
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            <strong>Email:</strong>
                            <span>{{ $reservation->client->email ?? 'N/A' }}</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <strong>Téléphone:</strong>
                            <span>{{ $reservation->client->telephone ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Accessoires --}}
            <div class="details-card animated-fade-in" style="animation-delay: 0.4s;">
                <div class="card-header">
                    <div class="icon-box">
                        <i class="bi bi-plug"></i>
                    </div>
                    <h3 class="card-title">Accessoires</h3>
                </div>
                <div class="card-body">
                    @if($reservation->accessoires->count())
                        <div class="list-group">
                            @foreach ($reservation->accessoires as $accessoire)
                                <div class="list-group-item">
                                    <span>{{ $accessoire->nom ?? $accessoire->title ?? 'Accessoire' }}</span>
                                    <span class="badge bg-secondary">Quantité : {{ $accessoire->pivot->quantite ?? '1' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Aucun accessoire réservé.</p>
                    @endif
                </div>
            </div>

            {{-- Reductions --}}
            <div class="details-card animated-fade-in" style="animation-delay: 0.5s;">
                <div class="card-header">
                    <div class="icon-box">
                        <i class="bi bi-tag"></i>
                    </div>
                    <h3 class="card-title">Réductions</h3>
                </div>
                <div class="card-body">
                    @if($reservation->reductions->count())
                        <div class="list-group">
                            @foreach ($reservation->reductions as $reduction)
                                <div class="list-group-item">
                                    <span>{{ $reduction->motif ?? 'Réduction' }}</span>
                                    <span class="badge bg-secondary">Valeur : {{ $reduction->valeur ?? '0' }} %</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Aucune réduction appliquée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour créer une réduction -->
    <div class="modal fade" id="reductionModal" tabindex="-1" aria-labelledby="reductionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('reductions.store') }}">
                    @csrf
                    <input type="hidden" name="id_reservation" value="{{ $reservation->id }}">
                    <input type="hidden" name="reference_reservation" value="{{ $reservation->reference }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reductionModalLabel">Nouvelle Réduction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-subtitle">Ajoutez une réduction pour la réservation #{{$reservation->reference}}.</p>
                        <div class="mb-3">
                            <label for="motif" class="form-label">Motif</label>
                            <input type="text" class="form-control" name="motif" id="motif" placeholder="Ex: Geste commercial" required>
                        </div>
                        <div class="mb-3">
                            <label for="valeur" class="form-label">Valeur</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="valeur" id="valeur" min="0" max="100" step="0.01" placeholder="5" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animation for elements
    document.addEventListener('DOMContentLoaded', function() {
        const animatedElements = document.querySelectorAll('.animated-fade-in');
        animatedElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endsection
