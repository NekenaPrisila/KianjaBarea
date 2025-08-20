@extends('layouts.app')

@section('title', 'Liste des Accessoires')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">Recherche Accessoires</h5>
        <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm" type="button">
          <i id="toggleIcon" class="bi bi-dash"></i>
        </button>
      </div>

      <!-- Formulaire recherche -->
      <form id="searchForm" action="{{ route('accessoires.index') }}" method="GET">
        <div class="row mb-3">
          <label for="nom" class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" id="nom" name="nom" class="form-control" value="{{ request('nom') }}" placeholder="Nom accessoire">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Actions</label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            <a href="{{ route('accessoires.create') }}" class="btn btn-success">Nouvel Accessoire</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Liste des Accessoires</h5>
    <table class="table datatable">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Nombre disponible</th>
          <th>Tarifs</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($accessoires as $accessoire)
          <tr>
            <td>{{ $accessoire->nom }}</td>
            <td>{{ $accessoire->nombre_disponible ?? 'N/A' }}</td>
            <td>
              @foreach($accessoire->tarifs_accessoires as $tarif)
                <span class="badge bg-primary">
                  {{ number_format($tarif->prix_unitaire, 2, ',', ' ') }} /
                  {{ $tarif->unite_tarif->nom }}
                </span>
              @endforeach
            </td>
            <td>
              <a href="{{ route('accessoires.edit', $accessoire->id) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('accessoires.destroy', $accessoire->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center">Aucun accessoire trouvé</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@include('partials.toggle-search')
@endsection
