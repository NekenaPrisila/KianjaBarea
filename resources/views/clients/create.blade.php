@extends('layouts.app')

@section('title', 'Ajout d\'un Client')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Ajout d'un nouveau client</h5>

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="representant" class="col-sm-2 col-form-label">Représentant</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="representant" name="representant" value="{{ old('representant') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="telephone" class="col-sm-2 col-form-label">Téléphone</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="adresse" class="col-sm-2 col-form-label">Adresse</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="adresse" name="adresse">{{ old('adresse') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="id_type_client" class="col-sm-2 col-form-label">Type de Client</label>
                <div class="col-sm-10">
                    <select class="form-select" id="id_type_client" name="id_type_client" required>
                        <option value="">-- Choisir un type de client --</option>
                        @foreach ($typesClient as $type)
                            <option value="{{ $type->id }}" {{ old('id_type_client') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
