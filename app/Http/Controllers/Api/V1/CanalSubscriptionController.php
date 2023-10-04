<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class CanalSubscriptionController extends CANAL_SUBSCRIPTION_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        $this->middleware('CheckAgent')->only(["InitiateSubscription", "UpdateSubscription"]);
        $this->middleware('CheckSession')->only("InitiateSubscription");
        $this->middleware('CheckMasterOrAdmin')->only(["ValidateSubscription"]);
    }

    function __SearchSubscription(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS CANAL_SUBSCRIPTION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        $validator = $this->Search_subscription_Validator($request->all());
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 404);
        }
        return $this->_searchSubscription($request);
    }

    function InitiateSubscription(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
        $validator = $this->Subscription_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **_initiateSubscription** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
        return $this->_initiateSubscription($request);
    }

    function ValidateSubscription(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
        $validator = $this->Validate_Subscription_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **_validateSubscription** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
        return $this->_validateSubscription($request, $id);
    }

    #GET ALL SUBSCRIPTION
    function _Subscriptions(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUT LES UTILISATEURS AVEC LEURS ROLES & TRANSPORTS
        return $this->subscriptions($request);
    }

    #GET A SUBSCRIPTION
    function RetrieveSubscription(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DU Card
        return $this->_retrieveSubscription($id);
    }

    #RECUPERER UN Subscription
    function UpdateSubscription(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CANAL_SUBSCRIPTION_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UNE SOUSCRIPTION VIA SON **id**
        return $this->_updateSubscription($request, $id);
    }

    function DeleteSubscription(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS CANAL_SUBSCRIPTION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->SubscriptionDelete($id);
    }
}
