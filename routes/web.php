<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici sont définies toutes les routes de l'application.
| Les routes publiques (login/register) sont en début de fichier.
| Toutes les autres routes sont protégées par le middleware 'auth'.
|
*/

// --------------------------------------------------------------------------
// 1) Routes publiques (login / register)
// --------------------------------------------------------------------------

// Redirection de la page d’accueil vers la page de connexion
Route::get('/', fn() => redirect()->route('login'));

// Formulaire d’enregistrement
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Formulaire de connexion
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Déconnexion (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --------------------------------------------------------------------------
// 2) Routes nécessitant d’être connecté (auth)
//    Les contrôles de rôle se feront DANS les méthodes du contrôleur.
// --------------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // 2.1) Édition de profil (nom et mot de passe)
    Route::get('/profile/edit',      [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update',   [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // 2.2) Tableau de bord (visible par tous les rôles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ----------------------------------------------------------------------
    // 2.3) Présentateur
    // ----------------------------------------------------------------------
    Route::prefix('presenter/seminars')
         ->name('seminars.presenter.')
         ->group(function () {
             Route::get('/',                    [SeminarController::class, 'presenterIndex'])->name('index');
             Route::get('/create',              [SeminarController::class, 'presenterCreate'])->name('create');
             Route::post('/store',              [SeminarController::class, 'presenterStore'])->name('store');

             Route::get('/{seminar}/upload-summary',  [SeminarController::class, 'showUploadSummary'])->name('upload_summary');
             Route::post('/{seminar}/upload-summary', [SeminarController::class, 'uploadSummary'])->name('upload_summary.store');

             Route::get('/{seminar}/upload-presentation',  [SeminarController::class, 'showUploadPresentation'])->name('upload_presentation');
             Route::post('/{seminar}/upload-presentation', [SeminarController::class, 'uploadPresentation'])->name('upload_presentation.store');
         });

    // ----------------------------------------------------------------------
    // 2.4) Secrétaire
    // ----------------------------------------------------------------------
    Route::prefix('secretary/seminars')
         ->name('seminars.secretary.')
         ->group(function () {
             // Afficher les demandes en attente
             Route::get('/',                     [SeminarController::class, 'secretaryIndex'])->name('index');

             // Accepter une demande
             Route::post('/{seminar}/accept',    [SeminarController::class, 'accept'])->name('accept');

             // Refuser une demande
             Route::post('/{seminar}/reject',    [SeminarController::class, 'reject'])->name('reject');

             // Afficher les séminaires à publier (7 jours avant)
             Route::get('/publish-list',         [SeminarController::class, 'showToPublish'])->name('publish_list');
             Route::post('/{seminar}/publish',   [SeminarController::class, 'publish'])->name('publish');

             // Upload fichier de présentation final si nécessaire (back-office)
             Route::get('/{seminar}/upload-presentation',  [SeminarController::class, 'showUploadPresentation'])->name('upload_presentation');
             Route::post('/{seminar}/upload-presentation', [SeminarController::class, 'uploadPresentation'])->name('upload_presentation.store');
         });

    // ----------------------------------------------------------------------
    // 2.5) Étudiant
    // ----------------------------------------------------------------------
    Route::prefix('student/seminars')
         ->name('seminars.student.')
         ->group(function () {
             // Voir les séminaires publiés
             Route::get('/',                    [SeminarController::class, 'studentIndex'])->name('index');

             // Télécharger une présentation existante (uploadée par le présentateur)
             Route::get('/{seminar}/download',  [SeminarController::class, 'downloadPresentation'])->name('download');
         });

    // ----------------------------------------------------------------------
    // 2.6) Pages générales pour tous (auth)
    // ----------------------------------------------------------------------
    // Séminaires à venir
    Route::get('/seminars/upcoming', [SeminarController::class, 'upcoming'])->name('seminars.upcoming');
    // Présentations récentes
    Route::get('/seminars/recent',   [SeminarController::class, 'recent'])->name('seminars.recent');

    // ----------------------------------------------------------------------
    // 2.7) PDF récapitulatif
    // ----------------------------------------------------------------------
    // Génére et télécharge le récapitulatif PDF d’un séminaire
    Route::get(
        '/seminars/{seminar}/recap',
        [SeminarController::class, 'downloadRecap']
    )->name('seminars.recap');
});


// resources/views/web.php

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Séminaires à venir
    Route::get('/seminars/upcoming', [SeminarController::class, 'upcoming'])->name('seminars.upcoming');
    
    // Présentations récentes
    Route::get('/seminars/recent', [SeminarController::class, 'recent'])->name('seminars.recent');
});

Route::get('seminars/secretary/{id}', [SeminarSecretaryController::class, 'show'])
     ->middleware('auth')
     ->name('seminars.secretary.show');


// …

Route::middleware('auth')
     ->group(function () {
         // Formulaire d’envoi de résumé
         Route::get('/seminars/{seminar}/upload-resume', [SeminarController::class, 'showUploadResumeForm'])
              ->name('seminars.presenter.uploadResume');

         Route::post('/seminars/{seminar}/upload-resume', [SeminarController::class, 'submitResume'])
              ->name('seminars.presenter.submitResume');
     });


Route::middleware('auth')->group(function () {

    // Présentateur : soumettre le résumé (J-10)
    Route::get('/seminars/{seminar}/upload-resume', [SeminarController::class, 'showUploadResumeForm'])
         ->name('seminars.presenter.uploadResume');
    Route::post('/seminars/{seminar}/upload-resume', [SeminarController::class, 'submitResume'])
         ->name('seminars.presenter.submitResume');

    // Secrétaire : publier le séminaire (J-7)
    Route::get('/seminars/{seminar}/publish', [SeminarController::class, 'publish'])
         ->name('seminars.secretary.publish');
    Route::put('/seminars/{seminar}/publish', [SeminarController::class, 'doPublish'])
         ->name('seminars.secretary.doPublish');

    // Autres routes (dashboard, liste, etc.)…
});
Route::get('/secretary/seminars/publish-list', [SeminarController::class, 'publishList'])
     ->middleware('auth')
     ->name('seminars.secretary.publish_list');

// routes/web.php
Route::get('/seminars/{seminar}/summary', [SeminarController::class, 'showSummary'])
    ->name('seminars.secretary.showSummary')
    ->middleware(['auth']);

Route::get('/secretary/seminars/expired', [SeminarController::class, 'expired'])
    ->name('seminars.secretary.expired')
    ->middleware('auth');

Route::post('/seminars/{seminar}/publish', [SeminarController::class, 'doPublish'])
     ->name('seminars.secretary.publish');

// routes/web.php


Route::middleware(['auth'])->group(function () {
    // Affiche la liste des séminaires pour soumettre un résumé
    Route::get('/presenter/seminars/submit-summary', [SeminarController::class, 'showSubmitSummaryList'])
         ->name('seminars.presenter.submitSummaryList');

    // Traite la soumission du résumé (formulaire)
    Route::post('/presenter/seminars/{seminar}/submit-summary', [SeminarController::class, 'submitSummary'])
         ->name('seminars.presenter.submitSummary');
});

use App\Http\Controllers\AdminController;

Route::middleware(['auth'])->group(function () {
    // Affiche la liste des utilisateurs (seul l’admin peut y accéder)
    Route::get('/admin/users', [AdminController::class, 'index'])
         ->name('admin.users.index');

    // Met à jour le rôle d’un utilisateur (seul l’admin peut y accéder)
    Route::put('/admin/users/{user}/role', [AdminController::class, 'updateRole'])
         ->name('admin.users.updateRole');
});
