<?php

namespace App\Http\Controllers\Api\V1;

use App\Imports\CardImport;
use App\Models\Card;
use Maatwebsite\Excel\Facades\Excel;



use Illuminate\Http\Request;

class CardController extends CARD_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        $this->middleware('CheckMasterOrAdmin')->only(["AddCard", "UpdateCard"]);
        $this->middleware('CheckAgencyOrAdmin')->only(["CardPartialValidation"]);
    }

    function CardPartialValidation(Request $request, $card)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #ENREGISTREMENT DANS LA DB VIA **_PartialValidation** DE LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
        return $this->_PartialValidation($request, $card);
    }

    function AddCard(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
        $validator = $this->Card_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **createUser** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
        return $this->_createCard($request->all());
    }

    #GET ALL CardS
    function Cards(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUT LES UTILISATEURS AVEC LEURS ROLES & TRANSPORTS
        return $this->allCards();
    }

    #GET A Card
    function RetrieveCard(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DU Card
        return $this->_retrieveCard($id);
    }

    #RECUPERER UN Card
    function UpdateCard(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN Card VIA SON **id**
        return $this->_updateCard($request, $id);
    }

    function DeleteCard(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS CARD_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->CardDelete($id);
    }

    function VerifyCard(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS CARD_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
        $validator = $this->Verify_Card_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        return $this->_VerifyCard($request);
    }

    function AffectCartToAgency(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS CARD_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
        $validator = $this->Affect_Card_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        return $this->_AffectCartToAgency($request);
    }

    function ImportCards(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS CARD_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        ### VEUILLEZ CHOISIR COMME UN EXEMPLAIE, LE FICHIER EXCEL **Cards.xlsx** QUI SE TROUVE DANS LA RACINE DU PROJET
        if (!$request->file('cards')) {
            return $this->sendError("Veuillez charger les cartes via le fichier excel !", 404);
        }
        Excel::import(new CardImport, $request->file('cards'));

        ##____EVITER LES DOUBLONS
        $Cards = Card::all();
        foreach ($Cards as $Card) {
            $Card_duplicates = Card::where([
                "card_id" => $Card->card_id,
                "card_num" => $Card->card_num,
                "expire_date" => $Card->expire_date,
                "type" => $Card->type,
            ])->get();

            if ($Card_duplicates->count() > 1) {
                foreach ($Card_duplicates as $key => $Card_duplicate) {
                    if ($key > 0) { ##On conserve le premier et on supprime les doublons
                        $Card_duplicate->delete();
                    }
                }
            }
        }
        ##____
        return self::sendResponse([], "Importantion de cartes éffectuée avec succès!");
    }
}
