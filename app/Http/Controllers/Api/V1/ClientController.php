<?php

namespace App\Http\Controllers\Api\V1;

use App\Exports\ClientExport;
use App\Imports\ClientImport;
use App\Models\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends CLIENT_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(["ExportClients"]);
    }

    function AddClient(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
        $validator = $this->Client_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        return $this->_addClient($request);
    }

    #GET ALL Clients
    function Clients(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->allClients();
    }

    #GET A Client
    function RetrieveClient(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DU Client
        return $this->_retrieveClient($id);
    }

    #RECUPERER UN Client
    function UpdateClient(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CARD_CLIENT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        return $this->_updateClient($request, $id);
    }

    function DeleteClient(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS CARD_CLIENT_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->clientDelete($id);
    }

    ##__IMPORTATION DE CLIENTS
    public function ImportClients(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR REPERTORY_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        ### VEUILLEZ CHOISIR COMME UN EXEMPLAIE, LE FICHIER EXCEL **clients.xlsx** QUI SE TROUVE DANS LA RACINE DU PROJET
        if (!$request->file('clients')) {
            return $this->sendError("Veuillez charger le fichier excel des clients!", 404);
        }
        $formdata = $request->file('clients');

        // return $formdata;
        $data = Excel::import(new ClientImport, $formdata);
        $clients = Client::all();

        foreach ($clients as $client) {
            $client_duplicates = Client::where([
                "firstname" => $client->firstname,
                "lastname" => $client->lastname,
                "owner" => request()->user()->id,
            ])->get();

            if ($client_duplicates->count() > 1) {
                foreach ($client_duplicates as $key => $client_duplicate) {
                    if ($key > 0) { ##On conserve le premier et on supprime les doublons
                        $client_duplicate->delete();
                    }
                }
            }
        }
        return $this->sendResponse($data, "Client importés avec succès!!");
    }

    ##__EXPORTATION DE CLIENTS
    function ExportClients(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return Excel::download(new ClientExport, "clients.xlsx");
    }
}
