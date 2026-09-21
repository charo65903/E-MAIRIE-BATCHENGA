<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\Citoyen\DashboardController as CitoyenDashboardController;
use App\Http\Controllers\Citoyen\ServiceController as CitoyenServiceController;
use App\Http\Controllers\Citoyen\DemandeController;
use App\Http\Controllers\Citoyen\RendezVousController;
use App\Http\Controllers\Citoyen\NotificationController;
use App\Http\Controllers\Citoyen\ProfileController;

use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\DemandeController as AgentDemandeController;
use App\Http\Controllers\Agent\RendezVousController as AgentRendezVousController;
use App\Http\Controllers\Agent\ActeController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;

use App\Http\Controllers\ChatbotController;

use App\Http\Controllers\PublicController;

use App\Http\Controllers\DocumentVerificationController;

Route::get('/', [PublicController::class, 'accueil'])->name('accueil');

Route::get('/services', [PublicController::class, 'services'])->name('public.services');

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'administrateur' => redirect()->route('admin.dashboard'),
        'agent' => redirect()->route('agent.dashboard'),
        default => redirect()->route('citoyen.dashboard'),
    };
})->middleware('auth')->name('dashboard');

Route::get('/verification/{reference}', [DocumentVerificationController::class, 'show'])->name('verification.document');

// --- Authentification ---
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/connexion', [AuthenticatedSessionController::class, 'store']);
    Route::get('/inscription', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/inscription', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/deconnexion', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// --- Espace citoyen ---
Route::middleware(['auth', 'role:citoyen'])->prefix('citoyen')->name('citoyen.')->group(function () {
    Route::get('/tableau-de-bord', [CitoyenDashboardController::class, 'index'])->name('dashboard');

    Route::get('/services', [CitoyenServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}', [CitoyenServiceController::class, 'show'])->name('services.show');

    Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/creer', [DemandeController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    Route::get('/demandes/{demande}', [DemandeController::class, 'show'])->name('demandes.show');
    Route::get('/demandes/{demande}/telecharger', [DemandeController::class, 'telechargerDocument'])->name('demandes.telecharger-document');

    Route::get('/rendez-vous', [RendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::get('/rendez-vous/creer', [RendezVousController::class, 'create'])->name('rendez-vous.create');
    Route::post('/rendez-vous', [RendezVousController::class, 'store'])->name('rendez-vous.store');
    Route::get('/rendez-vous/{rendezVous}/modifier', [RendezVousController::class, 'edit'])->name('rendez-vous.edit');
    Route::put('/rendez-vous/{rendezVous}', [RendezVousController::class, 'update'])->name('rendez-vous.update');
    Route::delete('/rendez-vous/{rendezVous}', [RendezVousController::class, 'destroy'])->name('rendez-vous.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/lue', [NotificationController::class, 'marquerLue'])->name('notifications.marquer-lue');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');
});

// --- Espace agent ---
Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/tableau-de-bord', [AgentDashboardController::class, 'index'])->name('dashboard');

    Route::get('/demandes', [AgentDemandeController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/{demande}', [AgentDemandeController::class, 'show'])->name('demandes.show');
    Route::post('/demandes/{demande}/prendre-en-charge', [AgentDemandeController::class, 'prendreEnCharge'])->name('demandes.prendre-en-charge');
    Route::post('/demandes/{demande}/valider', [AgentDemandeController::class, 'valider'])->name('demandes.valider');
    Route::post('/demandes/{demande}/rejeter', [AgentDemandeController::class, 'rejeter'])->name('demandes.rejeter');

    Route::get('/rendez-vous', [AgentRendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::post('/rendez-vous/{rendezVous}/annuler', [AgentRendezVousController::class, 'annuler'])->name('rendez-vous.annuler');

    Route::get('/actes', [ActeController::class, 'index'])->name('actes.index');
    Route::get('/actes/{acte}', [ActeController::class, 'show'])->name('actes.show');
    Route::get('/actes/naissance/creer', [ActeController::class, 'createNaissance'])->name('actes.create-naissance');
    Route::post('/actes/naissance', [ActeController::class, 'storeNaissance'])->name('actes.store-naissance');
    Route::get('/actes/mariage/creer', [ActeController::class, 'createMariage'])->name('actes.create-mariage');
    Route::post('/actes/mariage', [ActeController::class, 'storeMariage'])->name('actes.store-mariage');
    Route::get('/actes/deces/creer', [ActeController::class, 'createDeces'])->name('actes.create-deces');
    Route::post('/actes/deces', [ActeController::class, 'storeDeces'])->name('actes.store-deces');
});

// --- Espace administrateur ---
Route::middleware(['auth', 'role:administrateur'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/utilisateurs', [AdminUserController::class, 'index'])->name('utilisateurs.index');
    Route::patch('/utilisateurs/{utilisateur}/basculer-actif', [AdminUserController::class, 'basculerActif'])->name('utilisateurs.basculer-actif');
    Route::get('/utilisateurs/creer-agent', [AdminUserController::class, 'createAgent'])->name('utilisateurs.create-agent');
    Route::post('/utilisateurs/creer-agent', [AdminUserController::class, 'storeAgent'])->name('utilisateurs.store-agent');

    Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::get('/services/creer', [AdminServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/modifier', [AdminServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::patch('/services/{service}/basculer-actif', [AdminServiceController::class, 'basculerActif'])->name('services.basculer-actif');
});
Route::post('/chatbot/message', [ChatbotController::class, 'repondre'])
    ->middleware('throttle:30,1')
    ->name('chatbot.repondre');
