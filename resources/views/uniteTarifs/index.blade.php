@extends('layouts.app')

@section('title', 'Liste des Unités de Tarif')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">Recherche Unités de Tarif</h5>
        <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm"><i id="toggleIcon" class="bi bi-dash"></i></button>
      </div>

      <form id="searchForm" action="{{ route('unite-tarif.index') }}" method="GET">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" name="nom" class="form-control" value="{{ request('nom') }}" placeholder="Nom de l'unité">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            <a href="{{ route('unite-tarif.create') }}" class="btn btn-success">Nouvelle Unité</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Liste des Unités de Tarif</h5>
    <table class="table datatable">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($uniteTarifs as $unite)
        <tr>
          <td>{{ $unite->nom }}</td>
          <td>
            <a href="{{ route('unite-tarif.edit', $unite->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('unite-tarif.destroy', $unite->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="2" class="text-center">Aucune unité trouvée</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@include('partials.toggle-search')
@endsection
