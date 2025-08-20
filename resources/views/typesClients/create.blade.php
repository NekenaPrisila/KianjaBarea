@extends('layouts.app')

@section('title', isset($typeClient) ? 'Modifier un Type de Client' : 'Créer un Type de Client')

@section('content')
<div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ isset($typeClient) ? 'Modifier le Type de Client' : 'Nouveau Type de Client' }}
      </h5>

      <form method="POST" action="{{ isset($typeClient) ? route('type-client.update', $typeClient->id) : route('type-client.store') }}">
        @csrf
        @if(isset($typeClient))
          @method('PUT')
        @endif

        {{-- Nom --}}
        <div class="mb-3">
          <label for="nom" class="form-label">Nom *</label>
          <input type="text"
                 class="form-control"
                 id="nom"
                 name="nom"
                 value="{{ old('nom', $typeClient->nom ?? '') }}"
                 required>
        </div>

        <hr>

        {{-- Boutons --}}
        <div class="text-end">
          <button type="submit" class="btn btn-primary">
            {{ isset($typeClient) ? 'Mettre à jour' : 'Enregistrer' }}
          </button>
          <a href="{{ route('type-client.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
