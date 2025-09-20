@extends('layouts.app')

@section('title', 'Détails de la réservation')

@section('content')
<div class="col-lg-12">

    {{-- Bouton retour en haut --}}
    <div class="mb-3">
        <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <h4 class="card-title mb-4 text-center">Détails de la réservation {{ $reservation->reference }}</h4>
 
            {{-- Informations principales --}}
            <div class="mb-4">
                <h5 class="text-primary">Informations Réservation</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Date du premier jour :</strong><br>
                        {{ \Carbon\Carbon::parse($reservation->date_premier_jour)->format('d/m/Y') }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Date du dernier jour :</strong><br>
                        {{ \Carbon\Carbon::parse($reservation->date_dernier_jour)->format('d/m/Y') }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Montant total :</strong><br>
                        {{ number_format($reservation->cout_total, 2, ',', ' ') }} Ar
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Montant en lettres :</strong><br>
                        {{ ucfirst((new \NumberFormatter('fr', \NumberFormatter::SPELLOUT))->format($reservation->cout_total)) }} Ariary
                    </div>
                </div>
            </div>

            {{-- Informations client --}}
            <div class="mb-4">
                <h5 class="text-primary">Client</h5>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <strong>Nom :</strong><br>
                        {{ $reservation->client->nom ?? 'N/A' }}
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Email :</strong><br>
                        {{ $reservation->client->email ?? 'N/A' }}
                    </div>
                    <div class="col-md-4 mb-2">
                        <strong>Téléphone :</strong><br>
                        {{ $reservation->client->telephone ?? 'N/A' }}
                    </div>
                </div>
            </div>

            {{-- Ressources réservées --}}
            <div class="mb-4">
                <h5 class="text-primary">Ressources réservées</h5>
                <hr>
                @if($reservation->ressources->count())
                    <div class="row">
                        @foreach ($reservation->ressources as $ressource)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card border rounded shadow-sm">
                                <div class="d-flex flex-column justify-content-center align-items-center py-2" style="min-height: 50px; line-height: 1.4;">
                                    <strong class="text-center mb-1">{{ $ressource->nom ?? $ressource->title ?? 'Ressource' }}</strong>
                                    <div class="text-center text-muted small">
                                        <span>{{ $ressource->pivot->debut_utilisation }}</span>
                                        <span class="mx-1">au</span>
                                        <span>{{ $ressource->pivot->fin_utilisation }}</span>
                                    </div>
                                    <span class="badge bg-secondary mt-1">Quantité : {{ $ressource->pivot->quantite ?? '1' }}</span>
                                    @if($ressource->pivot->id_tarif_ressource)  
                                        <span class="badge bg-success mt-1">
                                            {{ number_format(\App\Models\TarifsRessource::find($ressource->pivot->id_tarif_ressource)->prix_unitaire, 2, ',', ' ') }} Ar
                                        </span>
                                    @endif
                                </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Aucune ressource réservée.</p>
                @endif
            </div>

            {{-- Accessoires --}}
            <div class="mb-4">
                <h5 class="text-primary">Accessoires</h5>
                <hr>
                @if($reservation->accessoires->count())
                    <ul class="list-group">
                        @foreach ($reservation->accessoires as $accessoire)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $accessoire->nom ?? $accessoire->title ?? 'Accessoire' }}
                                <span class="badge bg-secondary">Quantité : {{ $accessoire->pivot->quantite ?? '1' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucun accessoire réservé.</p>
                @endif
            </div>

            {{-- Reductions --}}
            <div class="mb-4">
                <h5 class="text-primary">Réductions</h5>
                <hr>
                @if($reservation->reductions->count())
                    <ul class="list-group">
                        @foreach ($reservation->reductions as $reduction)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $reduction->motif ?? 'Réduction' }}
                                <span class="badge bg-secondary">Valeur : {{ $reduction->valeur ?? '0' }} %</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucune réduction appliquée.</p>
                @endif
            </div>


            @if(auth()->user()->role_utilisateur->role == 'commercial')
            {{-- Autres boutons --}}
            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('facture.edit' , $reservation->id) }}" class="btn btn-success">
                    <i class="fas fa-file-pdf"></i> Générer Facture
                </a>
                <a href="{{ route('proforma.generate' , $reservation->id) }}" target="_blank" class="btn btn-secondary">
                    Générer Proforma
                </a>
            </div>
            @endif
                {{-- Bouton pour les autres rôles --}}
                <div class="mt-4">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reductionModal">
                        <i class="fas fa-percent"></i> Créer une réduction
                    </button>

                    <!-- Modal pour créer une réduction -->
                    <div class="modal fade" id="reductionModal" tabindex="-1" aria-labelledby="reductionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('reductions.store') }}">
                            @csrf
                            <input type="hidden" name="id_reservation" value="{{ $reservation->id }}">
                            <input type="hidden" name="reference_reservation" value="{{ $reservation->reference }}">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reductionModalLabel">Ajouter une réduction</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="motif" class="form-label">Motif</label>
                                        <input type="text" class="form-control" name="motif" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="valeur" class="form-label">Valeur (en %)</label>
                                        <input type="number" class="form-control" name="valeur" min="0" max="100" step="0.01" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
