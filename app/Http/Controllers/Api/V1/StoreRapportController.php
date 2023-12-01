<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class StoreRapportController extends RAPPORT_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        // $this->middleware('CheckMaster');
    }

    #RECUPERER UN RAPPORT
    function RetrieveRapport(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN RAPPORT VIA SON **id**
        return $this->_retrieveRaport($id);
    }

    // #GET ALL RAPPORT
    function _AllRapport(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUT LES RAPPORT
        return $this->allRapports($request);
    }
}
