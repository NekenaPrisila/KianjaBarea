@extends('layouts.app')

@section('title', 'Liste des Ressources')

@section('content')
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Ajouter une Nouvelle Ressource</h5>
            <a href="{{ route('ressources.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nouvelle Ressource
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Liste des Ressources</h5>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Tarifs</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ressources as $ressource)
                    <tr>
                        <td>{{ $ressource->nom }}</td>
                        <td>{{ $ressource->type_ressource->nom }}</td>
                        <td>
                            @foreach($ressource->tarifs_ressources as $tarif)
                                <span class="badge bg-primary">
                                    {{ number_format($tarif->prix_unitaire, 2, ',', ' ') }} /
                                    {{ $tarif->unite_tarif->nom }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('ressources.edit', $ressource->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('ressources.destroy', $ressource) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
