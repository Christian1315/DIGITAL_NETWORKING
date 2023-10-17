<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class SoldController extends SOLD_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        // $this->middleware("CheckSession")->only("InitiateSold");
        $this->middleware("CheckAgency")->only([
            "InitiateSold",
            "CreditateSoldForPos"
        ]);
        $this->middleware("CheckMasterOrAdmin")->only([
            "ValidateSold",
        ]);
    }

    function InitiateSold(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        $validator = $this->Sold_Validator($request->all());
        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **initiateSolde** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
        return $this->initiateSolde($request);
    }

    function ValidateSold(Request $request, $agency_id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "PATCH") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #ENREGISTREMENT DANS LA DB VIA **validateSolde** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
        return $this->validateSolde($agency_id);
    }

    function  CreditateSoldForPos(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        $validator = $this->Sold_Validator($request->all());
        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **creditateSoldeForPos** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
        return $this->creditateSoldeForPos($request);
    }


    #GET ALL SOLDES
    function Soldes(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->allSoldes();
    }

    #RECUPERER UN SOLD
    function RetrieveSold(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SOLD_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN USER VIA SON **id**
        return $this->retrieveSolde($id);
    }
}
