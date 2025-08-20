@extends('layouts.app')

@section('title', 'Liste des Clients')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Recherche Clients</h5>
                <a href="{{ route('clients.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-circle"></i> Ajouter Client
                </a>
            </div>

            <!-- Formulaire de recherche -->
            <form action="{{ route('clients.index') }}" method="GET">
                <div class="row mb-3">
                    <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="nom" name="nom" value="{{ request('nom') }}" placeholder="Nom du client">
                    </div>

                    <label for="telephone" class="col-sm-2 col-form-label">Téléphone</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="telephone" name="telephone" value="{{ request('telephone') }}" placeholder="Numéro de téléphone">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Réinitialiser</a>
                    </div>
                </div>
            </form>
            <!-- Fin formulaire recherche -->
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Liste des Clients</h5>
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Représentant</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th>Date Ajout</th>
                    <th>Type de Client</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td>{{ $client->nom }}</td>
                        <td>{{ $client->representant }}</td>
                        <td>{{ $client->telephone }}</td>
                        <td>{{ $client->email ?? '—' }}</td>
                        <td>{{ $client->adresse ?? '—' }}</td>
                        <td>{{ $client->date_ajout->format('d/m/Y') }}</td>
                        <td>{{ $client->type_client->nom ?? '—' }}</td>
                        <td>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Aucun client trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
