@extends('layouts.app')

@section('title', 'Liste des Utilisateurs')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">Recherche Utilisateurs</h5>
        <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm"><i id="toggleIcon" class="bi bi-dash"></i></button>
      </div>

      <form id="searchForm" action="{{ route('utilisateurs.index') }}" method="GET">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Nom utilisateur</label>
          <div class="col-sm-10">
            <input type="text" name="nom_utilisateur" class="form-control" value="{{ request('nom_utilisateur') }}">
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Rôle</label>
          <div class="col-sm-10">
            <select name="role" class="form-select">
              <option value="">-- Tous --</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->role }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            <a href="{{ route('utilisateurs.create') }}" class="btn btn-success">Nouvel Utilisateur</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Liste des Utilisateurs</h5>
    <table class="table datatable">
      <thead>
        <tr>
          <th>Nom Utilisateur</th>
          <th>Rôle</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($utilisateurs as $user)
        <tr>
          <td>{{ $user->nom_utilisateur }}</td>
          <td>{{ $user->role_utilisateur->role ?? 'N/A' }}</td>
          <td>
            <a href="{{ route('utilisateurs.edit', $user->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center">Aucun utilisateur trouvé</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@include('partials.toggle-search')
@endsection
