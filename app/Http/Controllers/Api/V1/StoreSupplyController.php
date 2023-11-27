<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class StoreSupplyController extends SUPPLY_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(['Login']);
        $this->middleware('CheckMaster');
        // $this->middleware('CheckSession')->except(["_AllSupply", "RetrieveSupply"]);
    }

    // #GET ALL SUPPLY
    function _AllSupply(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUT LES SUPPLY
        return $this->allSupply($request);
    }

    #MODIFIER UN SUPPLY
    function UpdateSupply(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN SUPPLY VIA SON **id**
        return $this->_updateSupply($request->all(), $id);
    }

    #RECUPERER UN SUPPLY
    function RetrieveSupply(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN SUPPLY VIA SON **id**
        return $this->_retrieveSupply($id);
    }

    function CreateSupply(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
        $validator = $this->Supply_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
            return $this->sendError($validator->errors(), 404);
        }
        #ENREGISTREMENT DANS LA DB VIA **_createSupply** DE LA CLASS BASE_HELPER HERITEE PAR COMMAND_HELPER
        return $this->_createSupply($request->all());
    }


    function _DeleteSupply(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS AGENT_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->deleteSupply($id);
    }
}
