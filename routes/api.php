<?php

use App\Http\Controllers\Api\V1\ActionController;
use App\Http\Controllers\Api\V1\ActivityDomainController;
use App\Http\Controllers\Api\V1\AgencyController;
use App\Http\Controllers\Api\V1\AgencyTypeController;
use App\Http\Controllers\Api\V1\AgentController;
use App\Http\Controllers\Api\V1\AgentTypeController;
use App\Http\Controllers\Api\V1\Authorization;
use App\Http\Controllers\Api\V1\CanalFormulaController;
use App\Http\Controllers\Api\V1\CanalSubscriptionController;
use App\Http\Controllers\Api\V1\CanalSubscriptionOptionController;
use App\Http\Controllers\Api\V1\CanalSubscriptionStatusController;
use App\Http\Controllers\Api\V1\CardStatusController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProfilController;
use App\Http\Controllers\Api\V1\RangController;
use App\Http\Controllers\Api\V1\RightController;
use App\Http\Controllers\Api\V1\MasterController;
use App\Http\Controllers\Api\V1\PieceController;
use App\Http\Controllers\Api\V1\PosController;
use App\Http\Controllers\Api\V1\ProductTypeController;
use App\Http\Controllers\Api\V1\StoreCategoryController;
use App\Http\Controllers\Api\V1\StoreCommandController;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\StoreProduitController;
use App\Http\Controllers\Api\V1\StoreSupplyController;
use App\Http\Controllers\Api\V1\StoreTableController;
use App\Http\Controllers\Api\V1\SupplyProductController;
use App\Http\Controllers\Api\V1\UserSessionController;
use App\Http\Controllers\Api\V1\CardController;
use App\Http\Controllers\Api\V1\CardRechargeController;
use App\Http\Controllers\Api\V1\CardRechargeStatusController;
use App\Http\Controllers\Api\V1\CardTypeController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\CommandStatusController;
use App\Http\Controllers\Api\V1\FactureNormalisationController;
use App\Http\Controllers\Api\V1\ModuleController;
use App\Http\Controllers\Api\V1\ProductClasseController;
use App\Http\Controllers\Api\V1\SoldController;
use App\Http\Controllers\Api\V1\SoldStatusController;
use App\Http\Controllers\Api\V1\StoreFacturationController;
use App\Http\Controllers\Api\V1\StoreRapportController;
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
            Route::any('password/demand_reinitialize', 'DemandReinitializePassword');
            Route::any('password/reinitialize', 'ReinitializePassword');
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
            Route::any('{id}/delete', 'DeleteAgent'); #SUPPRESSION D'UN AGENT
            Route::any('{id}/update', 'UpdateAgent'); #MODIFICATION D'UN AGENT
            // Route::any('affect-to-agency', 'AffectToAgency'); #AFFECTER A UNE AGENCE
            Route::any('affect-to-pos', 'AffectToPos'); #AFFECTER A UN POS
            Route::any('confirm-pos-amount', 'ConfirmPosAmount'); #CONFIRMATION DU SOLD DE MON POS
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

    ### ========== POS ROUTINGS ========###
    Route::controller(PosController::class)->group(function () {
        Route::prefix('pos')->group(function () {
            Route::any('add', 'AddPos'); #AJOUT D'UN POS
            Route::any('all', 'Poss'); #GET ALL POS
            Route::any('{id}/retrieve', 'RetrievePos'); #RECUPERATION D'UN POS
            Route::any('my-affected-pos', 'GetAllPosAffectedToMe'); #RECUPERATION DE TOUT LES POS QUI ME SONT AFFECTES
            Route::any('{id}/delete', 'DeletePos'); #SUPPRESSION D'UN POS
            Route::any('{id}/update', 'UpdatePos'); #MODIFICATION D'UN POS
            Route::any('affect-to-agency', 'AffectToAgency'); #AFFECTER A UNE AGENCE
        });
    });

    ### ========= USERs SESSION ROUTINGS ========###
    Route::controller(UserSessionController::class)->group(function () {
        Route::prefix('session')->group(function () {
            Route::any('create', 'CreateSession');
            Route::any('logout', 'SessionLogout');
            Route::any('login', '_SessionLogin');
            Route::any('{id}/retrieve', '_SessionRetrieve');
            Route::any('{id}/delete', 'DeleteSession');
        });
    });

    ### ========= SESSION RAPPORT ROUTINGS ========###
    Route::prefix('rapport')->group(function () {
        Route::controller(StoreRapportController::class)->group(function () {
            Route::any('all', '_AllRapport');
            Route::any('{id}/retrieve', 'RetrieveRapport');
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
            Route::any('affect-to-pos', 'AffectToPos'); #AFFECTER A UN POS
            Route::any('affect-to-agent', 'AffectToAgent'); #AFFECTER A UN AGENT
            Route::any('affect-to-agency', 'AffectToAgency'); #AFFECTER A UNE AGENCE
        });
    });

    Route::prefix('products')->group(function () {
        ###========== PRODUCT TYPE ROUTINGS ========###
        Route::controller(ProductTypeController::class)->group(function () {
            Route::prefix('type')->group(function () {
                Route::any('all', 'ProductTypes'); #RECUPERATION DE TOUT LES TYPES DE PRODUIT
                Route::any('{id}/retrieve', 'RetrieveProductType'); #RECUPERATION D'UN TYPE DE PRODUIT
            });
        });

        // LES CLASSES
        Route::prefix("classe")->group(function () {
            Route::controller(ProductClasseController::class)->group(function () {
                Route::any('all', 'ProductClasses');
                Route::any('{id}/retrieve', 'RetrieveProductClasse');
            });
        });

        ###========== PRODUCT CATEGORY ROUTINGS ========###
        Route::controller(StoreCategoryController::class)->group(function () {
            Route::prefix('category')->group(function () {
                Route::any('add', 'CreateProductCategory'); #AJOUT D'UNE CATEGORIE DE PRODUIT
                Route::any('all', 'ProductCategories'); #GET ALL CATEGORY DE PRDUIT
                Route::any('{id}/retrieve', 'RetrieveProductCategory'); #RECUPERATION D'UNE CATEGORY DE PRDUIT
                Route::any('{id}/delete', '_DeleteProductCategory'); #SUPPRESSION D'UNE CATEGORY DE PRDUIT
                Route::any('{id}/update', 'UpdateProductCategory'); #MODIFICATION D'UN CATEGORY DE PRODUIT
            });
        });

        ###========== PRODUCTS ROUTINGS ========###
        Route::controller(StoreProduitController::class)->group(function () {
            Route::any('add', 'CreateProduct'); #AJOUT D'UN PRODUIT
            Route::any('all', 'Products'); #GET ALL PRDUIT
            Route::any('{id}/retrieve', 'RetrieveProduct'); #RECUPERATION D'UN PRDUIT
            Route::any('supply', '_SupplyProduct'); #APPROVISIONNER UN PRODUIT DANS UN SUPPLY
            Route::any('{id}/delete', '_DeleteProduct'); #SUPPRESSION D'UN PRDUIT
            Route::any('{id}/update', 'UpdateProduct'); #MODIFICATION D'UN PRODUIT
        });
    });

    ###========== TABLES ROUTINGS ========###
    Route::prefix("tables")->group(function () {
        Route::controller(StoreTableController::class)->group(function () {
            Route::any('add', 'CreateTable'); #AJOUT D'UNE TABLE
            Route::any('all', 'Tables'); #GET ALL TABLES
            Route::any('{id}/retrieve', 'RetrieveTable'); #RECUPERATION D'UNE TABLE
            Route::any('{id}/delete', '_DeleteTable'); #SUPPRESSION D'UN TABLE
            Route::any('{id}/update', 'UpdateTable'); #MODIFICATION D'UN TABLE
        });
    });

    ###========== COMMANDS ROUTINGS ========###
    Route::prefix("commands")->group(function () {
        Route::controller(StoreCommandController::class)->group(function () {
            Route::any('add', 'CreateCommand'); #AJOUT D'UNE COMMANDE
            Route::any('all', 'Commands'); #GET ALL COMMANDS
            Route::any('{id}/retrieve', 'RetrieveCommand'); #RECUPERATION D'UNE COMMANDE
            Route::any('{id}/delete', '_DeleteCommand'); #SUPPRESSION D'UN COMMANDE
            Route::any('{id}/update', 'UpdateCommand'); #MODIFICATION D'UN COMMANDE
        });

        ###========== COMMANDS STATUS ROUTINGS ========###
        Route::prefix("status")->group(function () {
            Route::controller(CommandStatusController::class)->group(function () {
                Route::any('all', 'CommandStatus'); #GET ALL COMMANDS STATUS
                Route::any('{id}/retrieve', 'RetrieveCommandStatus'); #RECUPERATION D'UN STATUS
            });
        });
    });


    ###========== SUPPLY ROUTINGS ========###
    Route::prefix("supply")->group(function () {
        Route::controller(StoreSupplyController::class)->group(function () {
            Route::any('add', 'CreateSupply'); #AJOUT D'UN APPROVISIONNEMENT
            Route::any('all', '_AllSupply'); #GET ALL APPROVISIONNEMENT
            Route::any('{id}/retrieve', 'RetrieveSupply'); #RECUPERATION D'UN APPROVISIONNEMENT
            Route::any('{id}/delete', '_DeleteSupply'); #SUPPRESSION D'UN APPROVISIONNEMENT
            Route::any('{id}/update', 'UpdateSupply'); #MODIFICATION D'UN APPROVISIONNEMENT
        });
    });

    ###========== SUPPLY A PRODUCT ROUTINGS ========###
    Route::prefix("supply-product")->group(function () {
        Route::controller(SupplyProductController::class)->group(function () {
            Route::any('supply', 'Supply_A_Product'); #AJOUT D'UN PRODUIT A UN APPROVISIONNEMENT
            // Route::any('all', '_AllSupply'); #GET ALL APPROVISIONNEMENT
            // Route::any('{id}/retrieve', 'RetrieveSupply'); #RECUPERATION D'UN APPROVISIONNEMENT
            // Route::any('{id}/delete', '_DeleteSupply'); #SUPPRESSION D'UN APPROVISIONNEMENT
        });
    });

    Route::prefix('facture')->group(function () {
        Route::controller(StoreFacturationController::class)->group(function () {
            Route::any('all', '_Factures'); #RECUPERER TOUTES LES FACTURES
            Route::any('{id}/create', 'Create'); #CREER UNE FACTURES
            Route::any('/{id}/retrieve', '_Retrieve'); #RECUPERER TOUTES LES FACTURE
            Route::any('/{id}/update', 'Update'); #MODIFIER UNE FACTURE
            Route::any('/{id}/delete', 'Delete'); #SUPPRESSION D'UNE FACTURE
        });
    });

    Route::prefix('normalize-facture')->group(function () {
        Route::controller(FactureNormalisationController::class)->group(function () {
            Route::any('all', '_Factures'); #RECUPERER TOUTES LES FACTURES NORMALISEE
            Route::any('{facture}/demande', 'Create'); #CREER UNE FACTURES NORMALISEE
            Route::any('/{id}/retrieve', '_Retrieve'); #RECUPERER TOUTES LES FACTURE NORMALISEE
        });
    });


    ###========== SOLDES  ROUTINGS ========###
    Route::controller(SoldController::class)->group(function () {
        Route::prefix('sold')->group(function () {
            // LES STATUS
            Route::prefix("status")->group(function () {
                Route::controller(SoldStatusController::class)->group(function () {
                    Route::any('all', 'SoldStatus');
                    Route::any('{id}/retrieve', 'RetrieveSoldStatus');
                });
            });

            ###____
            Route::any('initiate', 'InitiateSold');
            Route::any('creditate-for-pos', 'CreditateSoldForPos');
            Route::any('agency/{id}/validate', 'ValidateSold');
            Route::any('all', 'Soldes');
            Route::any('{id}/retrieve', 'RetrieveSold');
        });
    });


    ###========== CLIENT ROUTINGS ========###
    Route::prefix("client")->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::any('create', 'AddClient');
            Route::any('all', 'Clients');
            Route::any('{id}/retrieve', 'RetrieveClient');
            Route::any('{id}/update', 'UpdateClient');
            Route::any('{id}/delete', 'DeleteClient');
        });
    });

    ##~~~~~~~~~~~~~~~~~~~~~~~~~~~~##
    ##~~~~~~~~ MODULE UBA ~~~~~~~~##
    ##~~~~~~~~~~~~~~~~~~~~~~~~~~~~##

    ###========== CARD ROUTINGS ========###
    Route::prefix("card")->group(function () {
        // LES STATUS
        Route::prefix("status")->group(function () {
            Route::controller(CardStatusController::class)->group(function () {
                Route::any('all', 'CardStatus');
                Route::any('{id}/retrieve', 'RetrieveCardStatus');
            });
        });

        // LES TYPES
        Route::prefix("type")->group(function () {
            Route::controller(CardTypeController::class)->group(function () {
                Route::any('all', 'CardType');
                Route::any('{id}/retrieve', 'RetrieveCardType');
            });
        });

        // LES CARDS
        Route::controller(CardController::class)->group(function () {
            Route::any('{card}/partial-validate', 'CardPartialValidation');
            Route::any('add', 'AddCard');
            Route::any('import', 'ImportCards');
            Route::any('all', 'Cards');
            Route::any('{id}/retrieve', 'RetrieveCard');
            Route::any('{id}/update', 'UpdateCard');
            Route::any('{id}/delete', 'DeleteCard');
            Route::any('/verify-card', 'VerifyCard');
            Route::any('/affect-to-agency', 'AffectCartToAgency');
        });
    });

    ###========== CARD RECHARGEMENT ROUTINGS ========###
    Route::prefix("rechargement")->group(function () {
        Route::controller(CardRechargeController::class)->group(function () {
            Route::prefix("card")->group(function () {
                Route::any('{card}/initiate', 'InitiateRechargement');
            });

            // LES STATUS
            Route::prefix("status")->group(function () {
                Route::controller(CardRechargeStatusController::class)->group(function () {
                    Route::any('all', 'CardRechargeStatus');
                    Route::any('{id}/retrieve', 'RetrieveRechargeCardStatus');
                });
            });

            Route::any('all', 'Rechargements');
            Route::any('{id}/retrieve', 'RetrieveRechargement');
            Route::any('{id}/update', 'UpdateRechargement');
            Route::any('{id}/delete', 'DeleteRechargement');
        });
    });

    Route::prefix("module")->group(function () {
        Route::controller(ModuleController::class)->group(function () {
            Route::any('all', 'Modules');
            Route::any('{id}/retrieve', 'RetrieveModule');
        });
    });


    ##~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~##
    ##~~~~~~~~ MODULE CANAL ~~~~~~~~##
    ##~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~##

    ###========== CARD ROUTINGS ========###
    Route::prefix("canal")->group(function () {
        // LES FORMULE
        Route::prefix("subscription/formule")->group(function () {
            Route::controller(CanalFormulaController::class)->group(function () {
                Route::any('all', 'Formules');
                Route::any('{id}/retrieve', 'RetrieveFormule');
            });
        });

        // LES OPTIONS
        Route::prefix("subscription/option")->group(function () {
            Route::controller(CanalSubscriptionOptionController::class)->group(function () {
                Route::any('all', 'Options');
                Route::any('{id}/retrieve', 'RetrieveOption');
            });
        });

        // LES STATUS
        Route::prefix("subscription/status")->group(function () {
            Route::controller(CanalSubscriptionStatusController::class)->group(function () {
                Route::any('all', 'Status');
                Route::any('{id}/retrieve', 'RetrieveStatus');
            });
        });

        // GESTION DES SOUSCRIPTIONS
        Route::prefix("subscription")->group(function () {
            Route::controller(CanalSubscriptionController::class)->group(function () {
                Route::any('search', '__SearchSubscription');
                Route::any('initiate', 'InitiateSubscription');
                Route::any('{id}/validate', 'ValidateSubscription');

                Route::any('all', '_Subscriptions');
                Route::any('{id}/retrieve', 'RetrieveSubscription');
                Route::any('{id}/update', 'UpdateSubscription');
                Route::any('{id}/delete', 'DeleteSubscription');
            });
        });
    });
});
