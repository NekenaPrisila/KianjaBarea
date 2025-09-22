@extends('layouts.app')

@section('title', isset($ressource) ? 'Modifier Ressource' : 'Nouvelle Ressource')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title">
      {{ isset($ressource) ? 'Modifier la Ressource' : 'Créer une Ressource' }}
    </h5>

    <form method="POST" action="{{ isset($ressource) ? route('ressources.update', $ressource) : route('ressources.store') }}">
      @csrf
      @if(isset($ressource))
        @method('PUT')
      @endif

      {{-- Nom --}}
      <div class="mb-3">
        <label class="form-label">Nom *</label>
        <input type="text" class="form-control" name="nom" 
               value="{{ old('nom', $ressource->nom ?? '') }}" required>
      </div>

      {{-- Type Ressource --}}
      <div class="mb-3">
        <label class="form-label">Type *</label>
        <select class="form-control" name="id_type_ressource" required>
          <option value="">-- Sélectionner un type --</option>
          @foreach($typesRessource as $type)
            <option value="{{ $type->id }}" 
              {{ old('id_type_ressource', $ressource->id_type_ressource ?? '') == $type->id ? 'selected' : '' }}>
              {{ $type->nom }}
            </option>
          @endforeach
        </select>
      </div>

      <hr>
      <h5>Tarifs</h5>
      <div id="tarifs-container">
        @foreach(old('tarifs', $ressource->tarifs_ressources ?? []) as $i => $tarif)
          <div class="row mb-2 tarif-item">
            <input type="hidden" name="tarifs[{{ $i }}][id]" value="{{ $tarif['id'] ?? $tarif->id ?? '' }}">
            
            {{-- Prix --}}
            <div class="col-md-5">
              <input type="number" step="0.01" class="form-control"
                     name="tarifs[{{ $i }}][prix_unitaire]" 
                     value="{{ $tarif['prix_unitaire'] ?? $tarif->prix_unitaire ?? '' }}" placeholder="Prix unitaire">
            </div>

            {{-- Unité --}}
            <div class="col-md-5">
              <select class="form-control" name="tarifs[{{ $i }}][id_unite_tarif]">
                <option value="">-- Unité --</option>
                @foreach($unitesTarif as $unite)
                  <option value="{{ $unite->id }}" 
                    {{ ($tarif['id_unite_tarif'] ?? $tarif->id_unite_tarif ?? '') == $unite->id ? 'selected' : '' }}>
                    {{ $unite->nom }}
                  </option>
                @endforeach
              </select>
            </div>

            {{-- Bouton supprimer --}}
            <div class="col-md-2">
              <button type="button" class="btn btn-danger supprimer-tarif">X</button>
            </div>
          </div>
        @endforeach
      </div>

      <button type="button" class="btn btn-outline-primary" id="ajouterTarif">+ Ajouter Tarif</button>

      <hr>
      <div class="text-end">
        <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('ressources.index') }}" class="btn btn-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let index = document.querySelectorAll('.tarif-item').length;

  document.getElementById('ajouterTarif').onclick = function () {
    let container = document.getElementById('tarifs-container');
    let html = `
      <div class="row mb-2 tarif-item">
        <div class="col-md-5">
          <input type="number" step="0.01" class="form-control" 
                 name="tarifs[${index}][prix_unitaire]" placeholder="Prix unitaire">
        </div>
        <div class="col-md-5">
          <select class="form-control" name="tarifs[${index}][id_unite_tarif]">
            <option value="">-- Unité --</option>
            @foreach($unitesTarif as $unite)
              <option value="{{ $unite->id }}">{{ $unite->nom }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger supprimer-tarif">X</button>
        </div>
      </div>`;
    container.insertAdjacentHTML('beforeend', html);
    index++;
  };

  document.getElementById('tarifs-container').addEventListener('click', function (e) {
    if (e.target.classList.contains('supprimer-tarif')) {
      e.target.closest('.tarif-item').remove();
    }
  });
});
</script>
@endsection
