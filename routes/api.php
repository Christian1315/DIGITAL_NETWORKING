<?php

use App\Http\Controllers\Api\V1\ActionController;
use App\Http\Controllers\Api\V1\Authorization;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProfilController;
use App\Http\Controllers\Api\V1\RangController;
use App\Http\Controllers\Api\V1\RightController;
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
            Route::any('register', 'Register');
            Route::any('login', 'Login');
            Route::middleware(['auth:api'])->get('logout', 'Logout');
            Route::any('all', 'Users');
            Route::any('{id}/retrieve', 'RetrieveUser');
            Route::any('{id}/update', 'UpdateUser');
            Route::any('{id}/delete', 'DeleteUser');
            Route::any('/attach-profil', 'AttachUserToProfil'); #ATTACHER UN USER A UN PROFIL
            Route::any('/attach-rang', 'AttachUserToRang');#ATTACHER UN USER A UN RANG
            Route::any('/attach-right', 'AttachUserToRight');#ATTACHER UN USER A UN DROIT
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
            Route::any('{id}/update', 'UpdateRight'); #MODIFICATION D'UN DROIT
        });
    });
});
