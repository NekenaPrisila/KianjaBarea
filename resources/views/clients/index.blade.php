@extends('layouts.app')

@section('title', 'Liste des Clients')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title mb-0">Recherche Clients</h5>
        <button id="toggleSearchBtn" class="btn btn-outline-primary btn-sm" type="button">
          <i id="toggleIcon" class="bi bi-dash"></i>
        </button>
      </div>

      <!-- Formulaire recherche -->
      <form id="searchForm" action="{{ route('clients.index') }}" method="GET">
        <div class="row mb-3">
          <label for="client_search_clients" class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10 position-relative">
            <input type="text" id="client_search_clients" name="nom" class="form-control"
                   value="{{ request('nom') }}" placeholder="Rechercher un client par nom..." autocomplete="off">
            <input type="hidden" id="client_id_clients" name="client_id" value="{{ request('client_id') }}">
            <div id="client_suggestions_clients" class="list-group position-absolute w-100" style="z-index:1000;"></div>
          </div>
        </div>

        <div class="row mb-3">
          <label for="id_type_client" class="col-sm-2 col-form-label">Type de client</label>
          <div class="col-sm-10">
            <select id="id_type_client" name="id_type_client" class="form-select">
              <option value="">-- Tous --</option>
              @foreach($typesClient as $type)
                <option value="{{ $type->id }}" {{ request('id_type_client') == $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Actions</label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Réinitialiser</a>
            <a href="{{ route('clients.create') }}" class="btn btn-success">Nouveau Client</a>
          </div>
        </div>
      </form>
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
              <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i>
              </a>
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

@include('partials.toggle-search')
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  let timerClients;
  const input = document.getElementById('client_search_clients');
  const suggestions = document.getElementById('client_suggestions_clients');

  if (input) {
    input.addEventListener('input', function() {
      clearTimeout(timerClients);
      let query = this.value.trim();
      suggestions.innerHTML = '';
      document.getElementById('client_id_clients').value = '';
      if (query.length < 1) return;
      timerClients = setTimeout(() => {
        fetch(`/api/clients/search?query=${encodeURIComponent(query)}`)
          .then(r => r.json())
          .then(data => {
            suggestions.innerHTML = '';
            data.forEach(client => {
              let item = document.createElement('button');
              item.type = 'button';
              item.className = 'list-group-item list-group-item-action';
              item.textContent = `${client.nom} (${client.reference})`;
              item.onclick = function() {
                input.value = client.nom + ' (' + client.reference + ')';
                document.getElementById('client_id_clients').value = client.id;
                suggestions.innerHTML = '';
              };
              suggestions.appendChild(item);
            });
          });
      }, 200);
    });

    document.addEventListener('click', function(e) {
      if(!input.contains(e.target)) {
        suggestions.innerHTML = '';
      }
    });
  }
});
</script>
@endsection
