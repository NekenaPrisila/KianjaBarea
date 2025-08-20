@extends('layouts.app')

@section('title', isset($uniteTarif) ? 'Modifier une Unité de Tarif' : 'Créer une Unité de Tarif')

@section('content')
<div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ isset($uniteTarif) ? 'Modifier l\'Unité de Tarif' : 'Nouvelle Unité de Tarif' }}
      </h5>

      <form method="POST" action="{{ isset($uniteTarif) ? route('unite-tarif.update', $uniteTarif->id) : route('unite-tarif.store') }}">
        @csrf
        @if(isset($uniteTarif))
          @method('PUT')
        @endif

        {{-- Nom --}}
        <div class="mb-3">
          <label for="nom" class="form-label">Nom *</label>
          <input type="text"
                 class="form-control"
                 id="nom"
                 name="nom"
                 value="{{ old('nom', $uniteTarif->nom ?? '') }}"
                 required>
        </div>

        <hr>

        {{-- Boutons --}}
        <div class="text-end">
          <button type="submit" class="btn btn-primary">
            {{ isset($uniteTarif) ? 'Mettre à jour' : 'Enregistrer' }}
          </button>
          <a href="{{ route('unite-tarif.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
