@extends('layouts.app')

@section('title', 'Liste des Ressources')

@section('content')
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Ajouter une Nouvelle Ressource</h5>
            </div>

            <!-- Recherche ressources (style similaire à clients) -->
            <form action="{{ route('ressources.index') }}" method="GET" class="mb-3">
                <div class="row mb-3">
                    <label for="ressource_search" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10 position-relative">
                        <input type="text" id="ressource_search" name="nom" class="form-control" placeholder="Rechercher une ressource par nom..." value="{{ request('nom') }}" autocomplete="off">
                        <input type="hidden" id="ressource_id" name="ressource_id" value="{{ request('ressource_id') }}">
                        <div id="ressource_suggestions" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="id_type_ressource" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <select name="id_type_ressource" id="id_type_ressource" class="form-select">
                            <option value="">-- Tous les types --</option>
                            @foreach($typesRessource as $t)
                                <option value="{{ $t->id }}" {{ request('id_type_ressource') == $t->id ? 'selected' : '' }}>{{ $t->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Actions</label>
                    <div class="col-sm-10">
                        <button class="btn btn-primary" type="submit">Rechercher</button>
                        <a href="{{ route('ressources.create') }}" class="btn btn-success ms-2">Nouvelle Ressource</a>
                    </div>
                </div>
            </form>
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
                        <th>Tarifs (dernier par unité)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ressources as $ressource)
                    <tr>
                        <td>{{ $ressource->nom }}</td>
                        <td>{{ $ressource->type_ressource->nom }}</td>
                        <td>
                            @php
                                // Grouper les tarifs par unité et prendre le plus récent (date_saisie ou id)
                                $latestByUnit = collect($ressource->tarifs_ressources)->groupBy('id_unite_tarif')->map(function($group) {
                                    return $group->sortByDesc('date_saisie')->first();
                                });
                            @endphp
                            @foreach($latestByUnit as $tarif)
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('ressource_search');
    const suggestions = document.getElementById('ressource_suggestions');
    let timerRes;

    if (!input) return;

    input.addEventListener('input', function() {
        clearTimeout(timerRes);
        let q = this.value.trim();
        suggestions.innerHTML = '';
        document.getElementById('ressource_id').value = '';
        if (q.length < 1) return;
        timerRes = setTimeout(() => {
            // On tente un endpoint REST /api/ressources/search; si absent, le champ nom sera soumis au serveur
            fetch(`/api/ressources/search?query=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => {
                    suggestions.innerHTML = '';
                    data.forEach(item => {
                        let btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'list-group-item list-group-item-action';
                        btn.textContent = `${item.nom}`;
                        btn.onclick = function() {
                            input.value = item.nom;
                            document.getElementById('ressource_id').value = item.id;
                            suggestions.innerHTML = '';
                        };
                        suggestions.appendChild(btn);
                    });
                }).catch(err => {
                    // si endpoint non disponible, on laisse la recherche côté serveur
                    console.warn('Autocomplete ressources non disponible', err);
                });
        }, 200);
    });

    document.addEventListener('click', function(e) {
        if (!input.contains(e.target)) suggestions.innerHTML = '';
    });
});
</script>
@endsection
