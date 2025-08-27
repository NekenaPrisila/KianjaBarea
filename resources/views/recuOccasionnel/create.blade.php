@extends('layouts.app')

@section('title', 'Création Reçu Occasionnel')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Création d'un nouveau reçu occasionnel</h5>

      <form method="POST" action="{{ route('recus-occasionnel.store') }}">
        @csrf

        {{-- Motif --}}
        <div class="row mb-3">
          <label for="motif" class="col-sm-2 col-form-label">Motif *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="motif" name="motif" value="{{ old('motif') }}" required>
          </div>
        </div>

        {{-- Mode de paiement --}}
        <div class="row mb-3">
          <label for="id_mode_paiement" class="col-sm-2 col-form-label">Mode de paiement</label>
          <div class="col-sm-10">
            <select class="form-control" id="id_mode_paiement" name="id_mode_paiement">
              @foreach($modesPaiement as $mode)
                <option value="{{ $mode->id }}">{{ $mode->nom }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Nouveau champ : Référence de paiement -->
        <div class="row mb-3">
            <label for="reference_paiement" class="col-sm-2 col-form-label">Référence de Paiement</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="reference_paiement" name="reference_paiement" 
                       value="{{ old('reference_paiement') }}" placeholder="Entrez la référence de paiement" required>
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

        {{-- Champs cachés pivot --}}
        <div id="hidden-accessoires"></div>
        <div id="hidden-ressources"></div>

        {{-- Créé par --}}
        <input type="hidden" name="creer_par" value="{{ auth()->id() }}">

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <a href="{{ route('recus-occasionnel.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
let editingId = null; // variable globale pour le mode édition
document.addEventListener('DOMContentLoaded', function() {
    // --------------------
  // ACCESSOIRES
  // --------------------
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

  document.getElementById('ajouterAccessoire').onclick = function() {
    let id = document.getElementById('accessoire_id').value;
    let nom = document.getElementById('accessoire_id').selectedOptions[0].text;
    let quantite = document.getElementById('accessoire_quantite').value;
    let tarif_id = document.getElementById('accessoire_tarif').value;
    let tarif_prix = document.getElementById('accessoire_tarif').selectedOptions[0].dataset.prix;
    let debut = document.getElementById('accessoire_debut').value;
    let fin = document.getElementById('accessoire_fin').value;

    if(editingId) {
      // --- Mode modification ---
      let row = document.querySelector(`#accessoires-list tr[data-unique="${editingId}"]`);
      row.innerHTML = `<td>${nom}</td><td>${quantite}</td><td>${tarif_prix} Ariary</td>
        <td>${debut.replace('T',' ')}</td><td>${fin.replace('T',' ')}</td>
        <td><button type="button" class="btn btn-warning btn-sm modifier-accessoire">Modifier</button>
            <button type="button" class="btn btn-danger btn-sm supprimer-accessoire">Supprimer</button></td>`;

      document.querySelectorAll(`#hidden-accessoires input[data-unique="${editingId}"]`).forEach(el => el.remove());
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
        hidden.setAttribute('data-unique', editingId);
        document.getElementById('hidden-accessoires').appendChild(hidden);
      });
      editingId = null;
    } else {
      // --- Mode ajout ---
      let uniqueId = 'acc_' + Date.now() + '_' + Math.floor(Math.random()*1000);
      let list = document.getElementById('accessoires-list');
      let row = document.createElement('tr');
      row.setAttribute('data-unique', uniqueId);
      row.innerHTML = `<td>${nom}</td><td>${quantite}</td><td>${tarif_prix} Ariary</td>
        <td>${debut.replace('T',' ')}</td><td>${fin.replace('T',' ')}</td>
        <td><button type="button" class="btn btn-warning btn-sm modifier-accessoire">Modifier</button>
            <button type="button" class="btn btn-danger btn-sm supprimer-accessoire">Supprimer</button></td>`;
      list.appendChild(row);

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
    }
    document.getElementById('accessoireModal').querySelector('.btn-close').click();
  };

  document.getElementById('accessoires-list').addEventListener('click', function(e) {
    if(e.target.classList.contains('supprimer-accessoire')) {
      let row = e.target.closest('tr');
      let uniqueId = row.getAttribute('data-unique');
      row.remove();
      document.querySelectorAll(`#hidden-accessoires input[data-unique="${uniqueId}"]`).forEach(el => el.remove());
    }
    if(e.target.classList.contains('modifier-accessoire')) {
      let row = e.target.closest('tr');
      editingId = row.getAttribute('data-unique');
      let cells = row.querySelectorAll('td');
      document.getElementById('accessoire_quantite').value = cells[1].textContent;
      document.getElementById('accessoire_debut').value = cells[3].textContent.replace(' ','T');
      document.getElementById('accessoire_fin').value = cells[4].textContent.replace(' ','T');
      let modal = new bootstrap.Modal(document.getElementById('accessoireModal'));
      modal.show();
    }
  });

  // --------------------
  // RESSOURCES
  // --------------------
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

  document.getElementById('ajouterRessource').onclick = function() {
    let id = document.getElementById('ressource_id').value;
    let nom = document.getElementById('ressource_id').selectedOptions[0].text;
    let quantite = document.getElementById('ressource_quantite').value;
    let tarif_id = document.getElementById('ressource_tarif').value;
    let tarif_nom = document.getElementById('ressource_tarif').selectedOptions[0].text;
    let debut = document.getElementById('ressource_debut').value;
    let fin = document.getElementById('ressource_fin').value;

    if(editingId) {
      // --- Mode modification ---
      let row = document.querySelector(`#ressources-list tr[data-unique="${editingId}"]`);
      row.innerHTML = `<td>${nom}</td><td>${quantite}</td><td>${tarif_nom}</td>
        <td>${debut.replace('T',' ')}</td><td>${fin.replace('T',' ')}</td>
        <td><button type="button" class="btn btn-warning btn-sm modifier-ressource">Modifier</button>
            <button type="button" class="btn btn-danger btn-sm supprimer-ressource">Supprimer</button></td>`;

      document.querySelectorAll(`#hidden-ressources input[data-unique="${editingId}"]`).forEach(el => el.remove());
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
        hidden.setAttribute('data-unique', editingId);
        document.getElementById('hidden-ressources').appendChild(hidden);
      });
      editingId = null;
    } else {
      // --- Mode ajout ---
      let uniqueId = 'res_' + Date.now() + '_' + Math.floor(Math.random()*1000);
      let list = document.getElementById('ressources-list');
      let row = document.createElement('tr');
      row.setAttribute('data-unique', uniqueId);
      row.innerHTML = `<td>${nom}</td><td>${quantite}</td><td>${tarif_nom}</td>
        <td>${debut.replace('T',' ')}</td><td>${fin.replace('T',' ')}</td>
        <td><button type="button" class="btn btn-warning btn-sm modifier-ressource">Modifier</button>
            <button type="button" class="btn btn-danger btn-sm supprimer-ressource">Supprimer</button></td>`;
      list.appendChild(row);

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
    }
    document.getElementById('ressourceModal').querySelector('.btn-close').click();
  };

  document.getElementById('ressources-list').addEventListener('click', function(e) {
    if(e.target.classList.contains('supprimer-ressource')) {
      let row = e.target.closest('tr');
      let uniqueId = row.getAttribute('data-unique');
      row.remove();
      document.querySelectorAll(`#hidden-ressources input[data-unique="${uniqueId}"]`).forEach(el => el.remove());
    }
    if(e.target.classList.contains('modifier-ressource')) {
      let row = e.target.closest('tr');
      editingId = row.getAttribute('data-unique');
      let cells = row.querySelectorAll('td');
      document.getElementById('ressource_quantite').value = cells[1].textContent;
      document.getElementById('ressource_debut').value = cells[3].textContent.replace(' ','T');
      document.getElementById('ressource_fin').value = cells[4].textContent.replace(' ','T');
      let modal = new bootstrap.Modal(document.getElementById('ressourceModal'));
      modal.show();
    }
  });

});
</script>
@endsection
