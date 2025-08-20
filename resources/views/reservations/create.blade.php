@extends('layouts.app')

@section('title', 'Création Réservation')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Création d'une nouvelle réservation</h5>

      <form method="POST" action="{{ route('reservations.store') }}">
        @csrf

        {{-- Client --}}
        <div class="row mb-3">
          <label for="client_search" class="col-sm-2 col-form-label">Client *</label>
          <div class="col-sm-8 position-relative">
            <input type="text" class="form-control" id="client_search" autocomplete="off" placeholder="Rechercher un client par nom...">
            <input type="hidden" id="client_id" name="client_id">
            <div id="client_suggestions" class="list-group position-absolute w-100" style="z-index:1000;"></div>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nouveauClientModal">
              Nouveau client
            </button>
          </div>
        </div>

        {{-- Description --}}
        <div class="row mb-3">
          <label for="description" class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Ajouter une description...">{{ old('description') }}</textarea>
          </div>
        </div>

        {{-- Modal Nouveau Client --}}
        <div class="modal fade" id="nouveauClientModal" tabindex="-1" aria-labelledby="nouveauClientModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="nouveauClientModalLabel">Ajouter un nouveau client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="nouveau_client_nom" class="form-label">Nom du client</label>
                  <input type="text" class="form-control" id="nouveau_client_nom" name="nouveau_client_nom">
                </div>
                <div class="mb-3">
                  <label for="nouveau_client_reference" class="form-label">Référence client</label>
                  <input type="text" class="form-control" id="nouveau_client_reference" name="nouveau_client_reference">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="validerNouveauClient">Valider</button>
              </div>
            </div>
          </div>
        </div>

        {{-- Accessoires --}}
        <hr>
        <h5>Accessoires</h5>
        <table class="table table-bordered" id="accessoires-table">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Quantité</th>
              <th>Tarif</th>
              <th>Début utilisation</th>
              <th>Fin utilisation</th>
              <th>Action</th> {{-- Ajout colonne Action --}}
            </tr>
          </thead>
          <tbody id="accessoires-list"></tbody>
        </table>
        <button type="button" class="btn btn-outline-success mb-3" data-bs-toggle="modal" data-bs-target="#accessoireModal">
          Ajouter un accessoire
        </button>

        {{-- Modal Accessoire --}}
        <div class="modal fade" id="accessoireModal" tabindex="-1" aria-labelledby="accessoireModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="accessoireModalLabel">Ajouter un accessoire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="accessoire_id" class="form-label">Accessoire</label>
                  <select class="form-control" id="accessoire_id">
                    @foreach($accessoires as $accessoire)
                      <option value="{{ $accessoire->id }}" data-tarifs='@json($accessoire->tarifs_accessoires)'>{{ $accessoire->nom }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label for="accessoire_quantite" class="form-label">Quantité</label>
                  <input type="number" min="1" class="form-control" id="accessoire_quantite">
                </div>
                <div class="mb-3">
                  <label for="accessoire_tarif" class="form-label">Tarif</label>
                  <select class="form-control" id="accessoire_tarif"></select>
                </div>
                <div class="mb-3">
                  <label for="accessoire_debut" class="form-label">Début utilisation</label>
                  <input type="datetime-local" class="form-control" id="accessoire_debut">
                </div>
                <div class="mb-3">
                  <label for="accessoire_fin" class="form-label">Fin utilisation</label>
                  <input type="datetime-local" class="form-control" id="accessoire_fin">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="ajouterAccessoire">Ajouter</button>
              </div>
            </div>
          </div>
        </div>

        {{-- Ressources --}}
        <hr>
        <h5>Ressources</h5>
        <table class="table table-bordered" id="ressources-table">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Quantité</th>
              <th>Tarif</th>
              <th>Début utilisation</th>
              <th>Fin utilisation</th>
              <th>Action</th> {{-- Ajout colonne Action --}}
            </tr>
          </thead>
          <tbody id="ressources-list"></tbody>
        </table>
        <button type="button" class="btn btn-outline-success mb-3" data-bs-toggle="modal" data-bs-target="#ressourceModal">
          Ajouter une ressource
        </button>

        {{-- Modal Ressource --}}
        <div class="modal fade" id="ressourceModal" tabindex="-1" aria-labelledby="ressourceModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="ressourceModalLabel">Ajouter une ressource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="ressource_id" class="form-label">Ressource</label>
                  <select class="form-control" id="ressource_id">
                    @foreach($ressources as $ressource)
                      <option value="{{ $ressource->id }}" data-tarifs='@json($ressource->tarifs_ressources)'>{{ $ressource->nom }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label for="ressource_quantite" class="form-label">Quantité</label>
                  <input type="number" min="1" class="form-control" id="ressource_quantite">
                </div>
                <div class="mb-3">
                  <label for="ressource_tarif" class="form-label">Tarif</label>
                  <select class="form-control" id="ressource_tarif"></select>
                </div>
                <div class="mb-3">
                  <label for="ressource_debut" class="form-label">Début utilisation</label>
                  <input type="datetime-local" class="form-control" id="ressource_debut">
                </div>
                <div class="mb-3">
                  <label for="ressource_fin" class="form-label">Fin utilisation</label>
                  <input type="datetime-local" class="form-control" id="ressource_fin">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="ajouterRessource">Ajouter</button>
              </div>
            </div>
          </div>
        </div>

        {{-- Champs cachés pour accessoires et ressources --}}
        <div id="hidden-accessoires"></div>
        <div id="hidden-ressources"></div>

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- JS pour gérer les popups et champs dynamiques --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Autocomplete client
  let timer;
  document.getElementById('client_search').addEventListener('input', function() {
    clearTimeout(timer);
    let query = this.value.trim();
    let suggestions = document.getElementById('client_suggestions');
    suggestions.innerHTML = '';
    if(query.length < 1) return; // Affiche dès le 1er caractère
    timer = setTimeout(() => {
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
              document.getElementById('client_search').value = client.nom + ' (' + client.reference + ')';
              document.getElementById('client_id').value = client.id;
              suggestions.innerHTML = '';
            };
            suggestions.appendChild(item);
          });
        });
    }, 200);
  });

  // Cacher suggestions si clic ailleurs
  document.addEventListener('click', function(e) {
    if(!document.getElementById('client_search').contains(e.target)) {
      document.getElementById('client_suggestions').innerHTML = '';
    }
  });

  // Nouveau client: vider champ caché
  document.getElementById('validerNouveauClient').onclick = function() {
    document.getElementById('client_id').value = '';
    document.getElementById('client_search').value = '';
    document.getElementById('nouveauClientModal').querySelector('.btn-close').click();
  };

  // Accessoire: charger tarifs selon accessoire choisi
  document.getElementById('accessoire_id').onchange = function() {
    let tarifs = JSON.parse(this.selectedOptions[0].dataset.tarifs || '[]');
    let select = document.getElementById('accessoire_tarif');
    select.innerHTML = '';
    tarifs.forEach(t => {
      let unite = t.unite_tarif && t.unite_tarif.nom ? ' / ' + t.unite_tarif.nom : '';
      select.innerHTML += `<option value="${t.id}" data-prix="${t.prix_unitaire}">${t.prix_unitaire} Ariary${unite}</option>`;
    });
  };
  document.getElementById('accessoire_id').dispatchEvent(new Event('change'));

  // Ajouter accessoire
  document.getElementById('ajouterAccessoire').onclick = function() {
    let id = document.getElementById('accessoire_id').value;
    let nom = document.getElementById('accessoire_id').selectedOptions[0].text;
    let quantite = document.getElementById('accessoire_quantite').value;
    let tarif_id = document.getElementById('accessoire_tarif').value;
    let tarif_prix = document.getElementById('accessoire_tarif').selectedOptions[0].dataset.prix;
    let debut = document.getElementById('accessoire_debut').value;
    let fin = document.getElementById('accessoire_fin').value;

    // Générer un identifiant unique pour ce set d'accessoire
    let uniqueId = 'acc_' + Date.now() + '_' + Math.floor(Math.random()*1000);

    // Affichage dans le tableau
    let list = document.getElementById('accessoires-list');
    let row = document.createElement('tr');
    row.setAttribute('data-unique', uniqueId);
    row.innerHTML = `<td>${nom}</td><td>${quantite}</td><td>${tarif_prix} Ariary</td><td>${debut.replace('T',' ')}</td><td>${fin.replace('T',' ')}</td>
      <td><button type="button" class="btn btn-danger btn-sm supprimer-accessoire">Supprimer</button></td>`;
    list.appendChild(row);

    // Champs cachés
    let hiddenFields = [
      {name: `accessoires[${id}][quantite]`, value: quantite},
      {name: `accessoires[${id}][tarif_id]`, value: tarif_id},
      {name: `accessoires[${id}][debut_utilisation]`, value: debut},
      {name: `accessoires[${id}][fin_utilisation]`, value: fin},
    ];
    hiddenFields.forEach(f => {
      let hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = f.name;
      hidden.value = f.value;
      hidden.setAttribute('data-unique', uniqueId);
      document.getElementById('hidden-accessoires').appendChild(hidden);
    });

    document.getElementById('accessoireModal').querySelector('.btn-close').click();
  };

  // Suppression accessoire
  document.getElementById('accessoires-list').addEventListener('click', function(e) {
    if(e.target.classList.contains('supprimer-accessoire')) {
      let row = e.target.closest('tr');
      let uniqueId = row.getAttribute('data-unique');
      row.remove();
      // Supprimer les champs cachés associés
      document.querySelectorAll(`#hidden-accessoires input[data-unique="${uniqueId}"]`).forEach(el => el.remove());
    }
  });

  // Ressource: charger tarifs selon ressource choisie
  document.getElementById('ressource_id').onchange = function() {
    let tarifs = JSON.parse(this.selectedOptions[0].dataset.tarifs || '[]');
    let select = document.getElementById('ressource_tarif');
    select.innerHTML = '';
    tarifs.forEach(t => {
      let unite = t.unite_tarif && t.unite_tarif.nom ? ' / ' + t.unite_tarif.nom : '';
      select.innerHTML += `<option value="${t.id}">${t.prix_unitaire} Ariary${unite}</option>`;
    });
  };
  document.getElementById('ressource_id').dispatchEvent(new Event('change'));

  // Ajouter ressource
  document.getElementById('ajouterRessource').onclick = function() {
    let id = document.getElementById('ressource_id').value;
    let nom = document.getElementById('ressource_id').selectedOptions[0].text;
    let quantite = document.getElementById('ressource_quantite').value;
    let tarif_id = document.getElementById('ressource_tarif').value;
    let tarif_nom = document.getElementById('ressource_tarif').selectedOptions[0].text;
    let debut = document.getElementById('ressource_debut').value;
    let fin = document.getElementById('ressource_fin').value;

    // Générer un identifiant unique pour ce set de ressource
    let uniqueId = 'res_' + Date.now() + '_' + Math.floor(Math.random()*1000);

    // Affichage dans le tableau
    let list = document.getElementById('ressources-list');
    let row = document.createElement('tr');
    row.setAttribute('data-unique', uniqueId);
    row.innerHTML = `<td>${nom}</td><td>${quantite}</td><td>${tarif_nom}</td><td>${debut.replace('T',' ')}</td><td>${fin.replace('T',' ')}</td>
      <td><button type="button" class="btn btn-danger btn-sm supprimer-ressource">Supprimer</button></td>`;
    list.appendChild(row);

    // Champs cachés
    let hiddenFields = [
      {name: `ressources[${id}][quantite]`, value: quantite},
      {name: `ressources[${id}][tarif_id]`, value: tarif_id},
      {name: `ressources[${id}][debut_utilisation]`, value: debut},
      {name: `ressources[${id}][fin_utilisation]`, value: fin},
    ];
    hiddenFields.forEach(f => {
      let hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = f.name;
      hidden.value = f.value;
      hidden.setAttribute('data-unique', uniqueId);
      document.getElementById('hidden-ressources').appendChild(hidden);
    });

    document.getElementById('ressourceModal').querySelector('.btn-close').click();
  };

  // Suppression ressource
  document.getElementById('ressources-list').addEventListener('click', function(e) {
    if(e.target.classList.contains('supprimer-ressource')) {
      let row = e.target.closest('tr');
      let uniqueId = row.getAttribute('data-unique');
      row.remove();
      // Supprimer les champs cachés associés
      document.querySelectorAll(`#hidden-ressources input[data-unique="${uniqueId}"]`).forEach(el => el.remove());
    }
  });
});
</script>
@endsection
