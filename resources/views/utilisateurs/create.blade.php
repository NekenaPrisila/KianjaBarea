@extends('layouts.app')

@section('title', isset($utilisateur) ? 'Modifier un Utilisateur' : 'Créer un Utilisateur')

@section('content')
<div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        {{ isset($utilisateur) ? 'Modifier l\'Utilisateur' : 'Nouvel Utilisateur' }}
      </h5>

      {{-- Afficher toutes les erreurs --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ isset($utilisateur) ? route('utilisateurs.update', $utilisateur->id) : route('utilisateurs.store') }}">
        @csrf
        @if(isset($utilisateur))
          @method('PUT')
        @endif

        {{-- Nom utilisateur --}}
        <div class="mb-3">
          <label for="nom_utilisateur" class="form-label">Nom d’utilisateur *</label>
          <input type="text"
                 class="form-control"
                 id="nom_utilisateur"
                 name="nom_utilisateur"
                 value="{{ old('nom_utilisateur', $utilisateur->nom_utilisateur ?? '') }}"
                 required>
        </div>

        {{-- Mot de passe (uniquement si création ou si utilisateur souhaite le changer) --}}
        <div class="mb-3">
          <label for="password" class="form-label">
            {{ isset($utilisateur) ? 'Nouveau mot de passe (laisser vide si inchangé)' : 'Mot de passe *' }}
          </label>
          <input type="password"
                 class="form-control"
                 id="password"
                 name="password"
                 {{ isset($utilisateur) ? '' : 'required' }}>
        </div>

        {{-- Rôle --}}
        <div class="mb-3">
          <label for="id_role" class="form-label">Rôle *</label>
          <select class="form-control" id="id_role" name="id_role" required>
            <option value="">-- Sélectionner un rôle --</option>
            @foreach($roles as $role)
              <option value="{{ $role->id }}"
                {{ old('id_role', $utilisateur->id_role ?? '') == $role->id ? 'selected' : '' }}>
                {{ $role->role }}
              </option>
            @endforeach
          </select>
        </div>

        <hr>

        {{-- Boutons --}}
        <div class="text-end">
          <button type="submit" class="btn btn-primary">
            {{ isset($utilisateur) ? 'Mettre à jour' : 'Enregistrer' }}
          </button>
          <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
