<?php

use App\Http\Controllers\Api\V1\ActionController;
use App\Http\Controllers\Api\V1\ActivityDomainController;
use App\Http\Controllers\Api\V1\AgencyController;
use App\Http\Controllers\Api\V1\AgencyTypeController;
use App\Http\Controllers\Api\V1\AgentController;
use App\Http\Controllers\Api\V1\AgentTypeController;
use App\Http\Controllers\Api\V1\Authorization;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProfilController;
use App\Http\Controllers\Api\V1\RangController;
use App\Http\Controllers\Api\V1\RightController;
use App\Http\Controllers\Api\V1\MasterController;
use App\Http\Controllers\Api\V1\PieceController;
use App\Http\Controllers\Api\V1\PosController;
use App\Http\Controllers\Api\V1\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {
    ###========== USERs ROUTINGS ========###
    Route::controller(UserController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::any('login', 'Login');
            Route::middleware(['auth:api'])->get('logout', 'Logout');
            Route::any('all', 'Users');
            Route::any('{id}/retrieve', 'RetrieveUser');
            Route::any('{id}/update', 'UpdateUser');
            Route::any('{id}/password/update', 'UpdatePassword');
            Route::any('{id}/delete', 'DeleteUser');
            Route::any('attach-user', 'AttachRightToUser'); #Attacher un droit au user 
            Route::any('desattach-user', 'DesAttachRightToUser'); #Attacher un droit au user 
        });
    });
    Route::any('authorization', [Authorization::class, 'Authorization'])->name('authorization');

    ###========== PROFILS ROUTINGS ========###
    Route::controller(ProfilController::class)->group(function () {
        Route::prefix('profil')->group(function () {
            Route::any('add', 'CreateProfil'); #AJOUT DE PROFIL
            Route::any('all', 'Profils'); #RECUPERATION DE TOUT LES PROFILS
            Route::any('{id}/retrieve', 'RetrieveProfil'); #RECUPERATION D'UN PROFIL
            Route::any('{id}/update', 'UpdateProfil'); #MODIFICATION D'UN PROFIL
            Route::any('{id}/delete', 'DeleteProfil'); #SUPPRESSION D'UN PROFIL
        });
    });

    ###========== RANG ROUTINGS ========###
    Route::controller(RangController::class)->group(function () {
        Route::prefix('rang')->group(function () {
            Route::any('add', 'CreateRang'); #AJOUT DE RANG
            Route::any('all', 'Rangs'); #RECUPERATION DE TOUT LES RANGS
            Route::any('{id}/retrieve', 'RetrieveRang'); #RECUPERATION D'UN RANG
            Route::any('{id}/delete', 'DeleteRang'); #SUPPRESSION D'UN RANG
            Route::any('{id}/update', 'UpdateRang'); #MODIFICATION D'UN RANG'
        });
    });

    ###========== ACTION ROUTINGS ========###
    Route::controller(ActionController::class)->group(function () {
        Route::prefix('action')->group(function () {
            Route::any('add', 'CreateAction'); #AJOUT D'UNE ACTION'
            Route::any('all', 'Actions'); #GET ALL ACTIONS
            Route::any('{id}/retrieve', 'RetrieveAction'); #RECUPERATION D'UNE ACTION
            Route::any('{id}/delete', 'DeleteAction'); #SUPPRESSION D'UNE ACTION
            Route::any('{id}/update', 'UpdateAction'); #MODIFICATION D'UNE ACTION
        });
    });

    ###========== RIGHTS ROUTINGS ========###
    Route::controller(RightController::class)->group(function () {
        Route::prefix('right')->group(function () {
            Route::any('add', 'CreateRight'); #AJOUT D'UN DROIT'
            Route::any('all', 'Rights'); #GET ALL RIGHTS
            Route::any('{id}/retrieve', 'RetrieveRight'); #RECUPERATION D'UN DROIT
            Route::any('{id}/delete', 'DeleteRight'); #SUPPRESSION D'UN DROIT
        });
    });

    ###========== DOMAIN ACTIVITY ROUTINGS ========###
    Route::controller(ActivityDomainController::class)->group(function () {
        Route::prefix('activity')->group(function () {
            Route::any('all', 'DomainActivities'); #RECUPERATION DE TOUT LES DOMAINES D'ACTIVITE
            Route::any('{id}/retrieve', 'RetrieveDomainActivity'); #RECUPERATION D'UN DOMAIN D'ACTIVITE
        });
    });

    ###========== PIECE ROUTINGS ========###
    Route::controller(PieceController::class)->group(function () {
        Route::prefix('pieces')->group(function () {
            Route::any('all', 'Pieces'); #RECUPERATION DE TOUTES LES PIECES
            Route::any('{id}/retrieve', 'RetrievePiece'); #RECUPERATION D'UNE PIECE
        });
    });

    ###========== AGENT TYPE ROUTINGS ========###
    Route::controller(AgentTypeController::class)->group(function () {
        Route::prefix('agentType')->group(function () {
            Route::any('all', 'AgentTypes'); #RECUPERATION DE TOUT LES TYPES D'AGENT
            Route::any('{id}/retrieve', 'RetrieveAgentType'); #RECUPERATION D'UN TYPE D'AGENT
        });
    });

    ###========== AGENCY TYPE ROUTINGS ========###
    Route::controller(AgencyTypeController::class)->group(function () {
        Route::prefix('agencyType')->group(function () {
            Route::any('all', 'AgencyTypes'); #RECUPERATION DE TOUT LES TYPES D'AGENCE
            Route::any('{id}/retrieve', 'RetrieveAgencyType'); #RECUPERATION D'UN TYPE D'AGENCE
        });
    });

    ###========== AGENTS ROUTINGS ========###
    Route::controller(AgentController::class)->group(function () {
        Route::prefix('agent')->group(function () {
            Route::any('add', 'AddAgent'); #AJOUT D'UN AGENT
            Route::any('all', 'Agents'); #GET ALL AGENTS
            Route::any('{id}/retrieve', 'RetrieveAgent'); #RECUPERATION D'UN AGENT
            Route::any('affect-to-agency', 'AffectToAgency'); #AFFECTER A UNE AGENCE
            Route::any('{id}/delete', 'DeleteAgent'); #SUPPRESSION D'UN AGENT
            Route::any('{id}/update', 'UpdateAgent'); #MODIFICATION D'UN AGENT
        });
    });

    ###========== AGENCY ROUTINGS ========###
    Route::controller(AgencyController::class)->group(function () {
        Route::prefix('agency')->group(function () {
            Route::any('add', 'AddAgency'); #AJOUT D'UN AGENCY
            Route::any('all', 'Agencys'); #GET ALL AGENCYS
            Route::any('{id}/retrieve', 'RetrieveAgency'); #RECUPERATION D'UN AGENCY
            Route::any('{id}/delete', 'DeleteAgency'); #SUPPRESSION D'UN AGENCY
            Route::any('{id}/update', 'UpdateAgency'); #MODIFICATION D'UN AGENCY
        });
    });

    ###========== MASTERS ROUTINGS ========###
    Route::controller(MasterController::class)->group(function () {
        Route::prefix('master')->group(function () {
            Route::any('add', 'AddMaster'); #AJOUT D'UN MASTER
            Route::any('all', 'Masters'); #GET ALL MASTERS
            Route::any('{id}/retrieve', 'RetrieveMaster'); #RECUPERATION D'UN MASTER
            Route::any('{id}/delete', 'DeleteMaster'); #SUPPRESSION D'UN MASTER
            Route::any('{id}/update', 'UpdateMaster'); #MODIFICATION D'UN MASTER
        });
    });

    ###========== POS ROUTINGS ========###
    Route::controller(PosController::class)->group(function () {
        Route::prefix('pos')->group(function () {
            Route::any('add', 'AddPos'); #AJOUT D'UN POS
            Route::any('all', 'Poss'); #GET ALL POS
            Route::any('{id}/retrieve', 'RetrievePos'); #RECUPERATION D'UN POS
            Route::any('{id}/delete', 'DeletePos'); #SUPPRESSION D'UN POS
            Route::any('{id}/update', 'UpdatePos'); #MODIFICATION D'UN POS
        });
    });

    ###========== STORE ROUTINGS ========###
    Route::controller(StoreController::class)->group(function () {
        Route::prefix('store')->group(function () {
            Route::any('add', 'CreateStore'); #AJOUT D'UN STORE
            Route::any('all', 'Stores'); #GET ALL STORES
            Route::any('{id}/retrieve', 'RetrieveStore'); #RECUPERATION D'UN STORE
            Route::any('{id}/delete', 'DeleteStore'); #SUPPRESSION D'UN STORE
            Route::any('{id}/update', 'UpdateStore'); #MODIFICATION D'UN STORE
        });
    });
});
