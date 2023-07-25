<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class MasterController extends MASTER_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        $this->middleware('checkMasterOrAdmin');
    }

    #AJOUT DU MASTER
    function AddMaster(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR MASTER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR MASTER_HELPER
        $validator = $this->Add_Master_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR MASTER_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        
        #ENREGISTREMENT DANS LA DB VIA **createUser** DE LA CLASS BASE_HELPER HERITEE PAR MASTER_HELPER
        return $this->_addMaster($request);
    }

    #GET ALL MASTERS
    function Masters(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR MASTER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUT LES UTILISATEURS AVEC LEURS ROLES & TRANSPORTS
        return $this->allMasters();
    }

    #GET A MASTER
    function RetrieveMaster(Request $request,$id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR MASTER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DU MASTER
        return $this->_retrieveMaster($id);
    }

    #RECUPERER UN MASTER
    function UpdateMaster(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR MASTER_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN MASTER VIA SON **id**
        return $this->_updateMaster($request->all(),$id);
    }

    function DeleteMaster(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS MASTER_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->masterDelete($id);
    }
}
