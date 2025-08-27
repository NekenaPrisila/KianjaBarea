@extends('layouts.app')

@section('title', 'Création Reçu Occasionnel')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Création d'un nouveau reçu occasionnel</h5>

      <form method="POST" action="{{ route('recu-occasionnel.store') }}">
        @csrf

        {{-- Client / Référence --}}
        <div class="row mb-3">
          <label for="client_search" class="col-sm-2 col-form-label">Client *</label>
          <div class="col-sm-8 position-relative">
            <input type="text" class="form-control" id="client_search" autocomplete="off" placeholder="Rechercher un client...">
            <input type="hidden" id="client_id" name="client_id">
            <div id="client_suggestions" class="list-group position-absolute w-100" style="z-index:1000;"></div>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#nouveauClientModal">
              Nouveau client
            </button>
          </div>
        </div>

        {{-- Motif --}}
        <div class="row mb-3">
          <label for="motif" class="col-sm-2 col-form-label">Motif *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="motif" name="motif" value="{{ old('motif') }}" required>
          </div>
        </div>

        {{-- Date édition --}}
        <div class="row mb-3">
          <label for="date_edition" class="col-sm-2 col-form-label">Date d'édition</label>
          <div class="col-sm-10">
            <input type="datetime-local" class="form-control" id="date_edition" name="date_edition" value="{{ old('date_edition', now()->format('Y-m-d\TH:i')) }}">
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
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="accessoires-list"></tbody>
        </table>
        <button type="button" class="btn btn-outline-success mb-3" data-bs-toggle="modal" data-bs-target="#accessoireModal">Ajouter un accessoire</button>

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
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="ressources-list"></tbody>
        </table>
        <button type="button" class="btn btn-outline-success mb-3" data-bs-toggle="modal" data-bs-target="#ressourceModal">Ajouter une ressource</button>

        {{-- Champs cachés --}}
        <div id="hidden-accessoires"></div>
        <div id="hidden-ressources"></div>

        <div class="text-end">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <a href="{{ route('recu-occasionnel.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
