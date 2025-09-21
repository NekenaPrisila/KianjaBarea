<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\RecuController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReductionController;
use App\Http\Controllers\DiagrammeController;
use App\Http\Controllers\TypeRessourceController;
use App\Http\Controllers\AccessoireController;
use App\Http\Controllers\ModePaiementController;
use App\Http\Controllers\UniteTarifController;
use App\Http\Controllers\TypeClientController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\RecuOccasionnelController;

// Authentification
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// routes/web.php
Route::get('/api/clients/search', [ClientController::class, 'search']);
Route::get('/api/ressources/search', [RessourceController::class, 'search']);

// Ressources
Route::resource('ressources', RessourceController::class)->middleware('role:commercial,dg,admin');

// Accessoires
Route::resource('accessoires', AccessoireController::class)->middleware('role:commercial,dg,admin');

// Reservations
Route::resource('reservations', ReservationController::class)->middleware('role:dg,commercial');

// Reductions
Route::post('/reductions', [ReductionController::class, 'store'])->name('reductions.store')->middleware('role:dg,commercial');

// Clients
Route::resource('clients', ClientController::class);

// Calendar
Route::resource('calendar', CalendarController::class)->middleware('role:dg,commercial');

Route::get('/diagramme/stats', [DiagrammeController::class, 'reservationsParMois'])->name('diagramme.stats');

Route::get('/diagramme/statsChiffreAffaire', [DiagrammeController::class, 'chiffreAffaireParMois'])->name('diagramme.statsChiffreAffaire');

// Factures
Route::resource('factures', FactureController::class)->middleware('role:commercial,caisse');

Route::resource('recus', RecuController::class)->middleware('role:caisse');

Route::resource('recus-occasionnel', RecuOccasionnelController::class)->middleware('role:caisse');

Route::middleware('role:admin')->group(function () {
    Route::resource('type-ressource', TypeRessourceController::class);
    Route::resource('accessoires', AccessoireController::class);
    Route::resource('mode-paiement', ModePaiementController::class);
    Route::resource('unite-tarif', UniteTarifController::class);
    Route::resource('type-client', TypeClientController::class);
    Route::resource('utilisateurs', UtilisateurController::class);
});

// PDF & Documents
Route::middleware('role:commercial')->group(function () {
    Route::get('/proforma/{id}', [PdfController::class, 'printProforma'])->name('proforma.generate');
    Route::get('/facture/{id}/edit', [FactureController::class, 'editFacture'])->name('facture.edit');
    Route::get('/facture/{id}', [PdfController::class, 'printFacture'])->name('facture.generate');
});

Route::middleware('role:caisse')->group(function () {
    Route::get('/recu/{id}/edit', [RecuController::class, 'editRecu'])->name('recu.edit');
    Route::get('/recu/{id}', [PdfController::class, 'printRecu'])->name('recu.generate');
    Route::get('/recu-occasionnel/{id}', [PdfController::class, 'printRecuOccasionnel'])->name('recu-occasionnel.generate');
});
