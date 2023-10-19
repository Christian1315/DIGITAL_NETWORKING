<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class UserSessionController extends USER_SESSION_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(['Login', 'UpdatePassword']);
        $this->middleware('CheckAgent')->except(["_SessionRetrieve", "DeleteSession"]);
    }

    function CreateSession(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS USER_SESSION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };


        // #VALIDATION DES DATAs DEPUIS LA CLASS USER_SESSION_HELPER
        // $validator = $this->Session_Validator($request->all());

        // if ($validator->fails()) {
        //     #RENVOIE D'ERREURE VIA **sendResponse** DE LA CLASS USER_HELPER
        //     return $this->sendError($validator->errors(), 404);
        // }

        return $this->_createSession($request);
    }

    #SESSION DECONNEXION
    function SessionLogout(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS USER_SESSION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->sessionDeconnexion($request);
    }

    #SESSION LOGIN
    function _SessionLogin(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS USER_SESSION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->sessionLogin($request);
    }

    #SESSION RETRIEVE
    function _SessionRetrieve(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS USER_SESSION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->_retrieveSession($id);
    }

    #SESSION DELETE
    function DeleteSession(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS USER_SESSION_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        return $this->sessionDelete($id);
    }
}
