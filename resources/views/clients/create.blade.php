@extends('layouts.app')

@section('title', isset($client) ? 'Modifier un Client' : 'Créer un Client')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            {{ isset($client) ? 'Modifier le Client' : 'Nouveau Client' }}
        </h5>

        <form method="POST" action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}">
            @csrf
            @if(isset($client))
                @method('PUT')
            @endif

            {{-- Nom --}}
            <div class="row mb-3">
                <label for="nom" class="col-sm-2 col-form-label">Nom *</label>
                <div class="col-sm-10">
                    <input type="text" 
                           class="form-control" 
                           id="nom" 
                           name="nom" 
                           value="{{ old('nom', $client->nom ?? '') }}" 
                           required>
                </div>
            </div>

            {{-- Représentant --}}
            <div class="row mb-3">
                <label for="representant" class="col-sm-2 col-form-label">Représentant *</label>
                <div class="col-sm-10">
                    <input type="text" 
                           class="form-control" 
                           id="representant" 
                           name="representant" 
                           value="{{ old('representant', $client->representant ?? '') }}" 
                           required>
                </div>
            </div>

            {{-- Téléphone --}}
            <div class="row mb-3">
                <label for="telephone" class="col-sm-2 col-form-label">Téléphone *</label>
                <div class="col-sm-10">
                    <input type="text" 
                           class="form-control" 
                           id="telephone" 
                           name="telephone" 
                           value="{{ old('telephone', $client->telephone ?? '') }}" 
                           required>
                </div>
            </div>

            {{-- Email --}}
            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $client->email ?? '') }}">
                </div>
            </div>

            {{-- Adresse --}}
            <div class="row mb-3">
                <label for="adresse" class="col-sm-2 col-form-label">Adresse</label>
                <div class="col-sm-10">
                    <textarea class="form-control" 
                              id="adresse" 
                              name="adresse">{{ old('adresse', $client->adresse ?? '') }}</textarea>
                </div>
            </div>

            {{-- Type de client --}}
            <div class="row mb-3">
                <label for="id_type_client" class="col-sm-2 col-form-label">Type de Client *</label>
                <div class="col-sm-10">
                    <select class="form-select" id="id_type_client" name="id_type_client" required>
                        <option value="">-- Choisir un type de client --</option>
                        @foreach ($typesClient as $type)
                            <option value="{{ $type->id }}" 
                                {{ old('id_type_client', $client->id_type_client ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr>

            {{-- Boutons --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    {{ isset($client) ? 'Mettre à jour' : 'Enregistrer' }}
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
