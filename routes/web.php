<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\DelegueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\PayementCollectiveController;
use App\Http\Controllers\PayementIndividuelleController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TontineCollectiveController;
use App\Http\Controllers\TontineIndividuelleController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\VersementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('acceuil');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profil', [ProfilController::class, 'update'])->name('updateProfil');
    Route::put('/profil', [ProfilController::class, 'updatePassword'])->name('updatePassword');
});

// Les routes pour l'authentification;
Route::get('/', [AuthentificationController::class, 'login'])->name('auth.login');
// Route::post('/login', [AuthentificationController::class, 'dologin'])->name('seconnecter');
// Route::delete('/logout', [AuthentificationController::class, 'logout'])->name('auth.logout');

// La route pour les utilisateurs
Route::get('/utilisateurs',[UtilisateurController::class, 'index'])->name('index.utilisateur');

// Les Routes pour les agences
Route::get('/agences/afficherAgence',[AgenceController::class, 'create'])->name('afficherAgence');

Route::post('/agences/afficherAgence',[AgenceController::class, 'search'])->name('searchAgence');

Route::post('/agences/afficherAgence/Arret',[AgenceController::class, 'arretAgence'])->name('arretAgence');

Route::post('/agences/afficherAgence/Activation',[AgenceController::class, 'actifAgence'])->name('actifAgence');

Route::get('/agences/ajoutAgence', [AgenceController::class, 'createAjout'])->name('ajoutAgence');

Route::post('/agences/ajoutAgence', [AgenceController::class, 'store'])->name('storeAgence');

Route::post('/agences/updateAgence', [AgenceController::class, 'update'])->name('updateAgence');

// Routes pour les delegues des agences
Route::get('agences/ajoutDelegues', [DelegueController::class, 'index'])->name('delegue.ajout');
Route::get('agences/listDelegues', [DelegueController::class, 'list'])->name('listeDelegue');
Route::post('agences/store', [DelegueController::class, 'store'])->name('storeDelegue');
Route::post('agences/update', [DelegueController::class, 'update'])->name('updatedelegue');
Route::post('agences/search', [DelegueController::class, 'search'])->name('searchDelegue');

// Les Routes pour les agents
Route::get('/agents/ajoutAgent',[AgentController::class, 'createAjout'])->name('ajoutAgent');

Route::get('/agents/listeAgent',[AgentController::class, 'create'])->name('listeAgent');

Route::post('/agents/listeAgent/Suspendu',[AgentController::class, 'suspendAgent'])->name('suspendAgent');

Route::post('/agents/listeAgent/Reintegre',[AgentController::class, 'reintgrerAgent'])->name('reintgrerAgent');

Route::post('/agents/storeAgent',[AgentController::class, 'store'])->name('storeAgent');

Route::post('/agents/listeAgent/Modification',[AgentController::class, 'update'])->name('updateAgent');

Route::post('/agents/listeAgent',[AgentController::class, 'search'])->name('searchAgent');

// Pour Tontine Collectifs
Route::get('/tontineCollectifs/ajoutTontine',[TontineCollectiveController::class, 'createTontine'])->name('ajoutTontine');

Route::post('/tontineCollectifs/ajoutTontine',[TontineCollectiveController::class, 'store'])->name('ajoutTontine.store');

Route::post('/tontineCollectifs/modification',[TontineCollectiveController::class, 'update'])->name('updateTontineC');

Route::post('/tontineCollectifs/listeTontine',[TontineCollectiveController::class, 'search'])->name('searchTontineC');

Route::get('/tontineCollectifs/historiqueTontine',[TontineCollectiveController::class, 'createHistoriqueTontine'])->name('historiqueTontine');

Route::post('/tontineCollectifs/historiqueTontine',[TontineCollectiveController::class, 'searchHistoriqueTontineC'])->name('searchHistoriqueTontineC');

Route::get('/tontineCollectifs/listeTontine',[TontineCollectiveController::class, 'createListeTontine'])->name('listeTontine');

Route::get('/tontineCollectifs/gestionTontine',[TontineCollectiveController::class, 'createGestionTontine'])->name('gestionTontine');

Route::post('/tontineCollectifs/gestionTontine/association',[TontineCollectiveController::class, 'associate'])->name('associationTontine');

Route::post('/tontineCollectifs/gestionTontine/payement',[PayementCollectiveController::class, 'store'])->name('payementCollectif');

Route::get('/tontineCollectifs/gestionTontine/list',[TontineCollectiveController::class, 'displayMembre'])->name('displayMembreTontineCollective');

// Route Ajax pour la suivi de la tontine
Route::get('/tontineCollectifs/info/{id}',[TontineCollectiveController::class, 'getInfoTontineCollective'])->name('TontineCollective.info');


// Les routes pour le versement
Route::get('/payements/ajoutPayement',[VersementController::class, 'createVersement'])->name('ajoutPayement.create');

Route::post('/payements/ajoutPayement/store',[VersementController::class, 'store'])->name('ajoutPayement');

Route::post('/payements/ajoutPayement',[VersementController::class, 'getMembreTontine'])->name('membreTontine');

Route::get('/payements/listePayement',[VersementController::class, 'createListeVersement'])->name('listePayement');

Route::post('/payements/listePayement',[VersementController::class, 'search'])->name('searchVersement');

// Les routes pour cotisations
Route::get('/cotisations/affichCotisation',[CotisationController::class, 'createListe'])->name('afficheCotisation');

Route::get('/cotisations/cotisation',[CotisationController::class, 'createAjout'])->name('cotisation');

Route::post('/cotisations/cotisation/store',[CotisationController::class, 'store'])->name('StoreCotisation');

Route::post('/cotisations/cotisation',[CotisationController::class, 'getTontineIndividuelle'])->name('getTontineIndividuelle');

Route::post('/cotisations/affichCotisation/tontine',[CotisationController::class, 'CotisationByTontine'])->name('cotisationByTontine');

Route::post('/cotisations/affichCotisation/search',[CotisationController::class, 'searchDate'])->name('searchDate');

Route::get('/cotisations/historiqueCotisation',[CotisationController::class, 'createHistorique'])->name('historiqueCotisation');

Route::post('/cotisations/historiqueCotisation',[CotisationController::class, 'searchHistorique'])->name('searchHistorique');

Route::post('/cotisations/info/{id}',[CotisationController::class, 'getCotisationsInfo'])->name('cotisation.info');



// Route pour retourner les tontines dans membres

// Les routes pour les membres
Route::get('/membres/membres',[MembreController::class, 'create'])->name('membre');

Route::get('/membres/modifMembre',[MembreController::class, 'createModif'])->name('modifMembre');

// Pour tontine Individuelle
Route::get('/tontineIndividuelles/ajoutTontineInd',[TontineIndividuelleController::class, 'createTontine'])->name('ajoutTontineInd');

Route::post('/tontineIndividuelles/ajoutTontineInd',[TontineIndividuelleController::class, 'store'])->name('ajoutTontineInd');

Route::post('/tontineIndividuelles/listeTontineInd',[TontineIndividuelleController::class, 'search'])->name('searchTontine');

Route::get('/tontineIndividuelles/historiqueTontineInd',[TontineIndividuelleController::class, 'createHistoriqueTontine'])->name('historiqueTontineInd');

Route::post('/tontineIndividuelles/historiqueTontineInd',[TontineIndividuelleController::class, 'searchHistorique'])->name('searchHistoriqueTontineInd');

Route::get('/tontineIndividuelles/listeTontineInd',[TontineIndividuelleController::class, 'createListeTontine'])->name('listeTontineInd');

Route::get('/TontineIndividuelles/info/{id}',[TontineIndividuelleController::class, 'getInfoTontineIndividuelle'])->name('TontineIndividuelle.info');

Route::post('/TontineIndividuelles/Payement',[PayementIndividuelleController::class, 'payementTontineIndividuelle'])->name('TontineIndividuelle.payement');

// Route pour le profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/compte', [CompteController::class, 'create'])->name('compte.create');



require __DIR__.'/auth.php';
