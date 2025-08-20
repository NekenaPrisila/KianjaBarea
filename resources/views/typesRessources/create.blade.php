@extends('layouts.app')

@section('title', isset($typeRessource) ? 'Modifier un Type de Ressource' : 'Créer un Type de Ressource')

@section('content')
<div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ isset($typeRessource) ? 'Modifier le Type de Ressource' : 'Nouveau Type de Ressource' }}
      </h5>

      <form method="POST" action="{{ isset($typeRessource) ? route('type-ressource.update', $typeRessource->id) : route('type-ressource.store') }}">
        @csrf
        @if(isset($typeRessource))
          @method('PUT')
        @endif

        {{-- Nom --}}
        <div class="mb-3">
          <label for="nom" class="form-label">Nom *</label>
          <input type="text"
                 class="form-control"
                 id="nom"
                 name="nom"
                 value="{{ old('nom', $typeRessource->nom ?? '') }}"
                 required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control"
                    id="description"
                    name="description"
                    rows="3">{{ old('description', $typeRessource->description ?? '') }}</textarea>
        </div>

        <hr>

        {{-- Boutons --}}
        <div class="text-end">
          <button type="submit" class="btn btn-primary">
            {{ isset($typeRessource) ? 'Mettre à jour' : 'Enregistrer' }}
          </button>
          <a href="{{ route('type-ressource.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
