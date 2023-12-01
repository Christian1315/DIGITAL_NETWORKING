<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class FactureNormalisationController extends FACTURE_NORMALISATION_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        $this->middleware("CheckIf_DGI_Api_Work");

        set_time_limit(0);
    }

    #CREATION D'UN Facture
    public function Create(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR Facture_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        // $validator = $this->Facture_Validator($request->all());

        // if ($validator->fails()) {
        //     #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS BASE_HELPER HERITEE PAR Facture_HELPER
        //     return $this->sendError($validator->errors(), 404);
        // }

        // $clientId = $request->get("client");
        return $this->demandeFactureNormalisation($id);
    }

    #RECUPERATION DE TOUT LES FACTURES
    public function _Factures(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR Facture_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        return $this->factures(); #RETOURNE TOUTES LES FACTURES
    }

    #RECUPERATION D'UNE FACTURE
    public function _Retrieve(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR Facture_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        return $this->retrieveFacture($id);
    }


    #MODIFICATION D'UN Facture
    public function Update(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR Facture_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        return $this->updateFacture($request, $id);
    }

    #SUPPRESION D'UN Facture
    public function Delete(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR Facture_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        return $this->deleteFacture($id);
    }
}
