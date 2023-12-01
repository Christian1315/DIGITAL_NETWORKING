<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\Master;
use App\Models\StoreFacturation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use QrCode;
use PDF;

class FACTURE_NORMALISATION_HELPER extends BASE_HELPER
{
    ##======== REGISTER VALIDATION =======##
    static function facture_normalisation_rules(): array
    {
        return [
            'client' => 'required|integer',
        ];
    }

    static function facture_normalisation_messages(): array
    {
        return [
            'client.required' => 'Veuillez precisez l\'id du client à facturer!',
            'client.integer' => 'Le champ client doit être un entier!',
        ];
    }

    static function Facture_normalisation_Validator($formDatas)
    {
        $rules = self::facture_normalisation_rules();
        $messages = self::facture_normalisation_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function demandeFactureNormalisation($facture)
    {
        $user = request()->user();
        $facture = StoreFacturation::with(["_client", "facturier", "_command"])->where(["visible" => 1])->find($facture);
        if (!$facture) {
            return self::sendError("Cette facture n'existe pas!", 404);
        }

        ##__VOYONS SI CETTE FACTURE EST DEJA NORMALISEE
        if ($facture->normalized) {
            return self::sendError("Cette facture est déjà normalisée!", 404);
        }

        if (!Is_User_An_Admin($user->id)) {
            if ($facture->facturier != $user->id) {
                return self::sendError("Cette facture ne vous appartient pas! Vous ne pouvez donc pas la normaliser!", 505);
            }
        }

        ##__RECUPERATION  DES INFOS DU CLIENT DE LA COMMANDE
        $operator = [
            "id" => "",
            "name" => "Joel",
        ];

        ##__RECUPERATION  DES INFOS DU CLIENT DE LA COMMANDE
        $client = [
            "name" => $facture->_client->firstname . " " . $facture->_client->lastname,
            "contact" => $facture->_client->phone,
            "adress" => $facture->_client->email,
        ];

        ##__RECUPERATION DES PRODUITS DE LA COMMANDE ET
        ##__TRANSFORMATION EN DES ITEMS

        $items = [];
        $commands_products =  $facture->_command->products;
        foreach ($commands_products as $product) {
            $item = [];
            $item["name"] = $product->name;
            $item["price"] = $product->price;
            $item["quantity"] = $product->qty ? explode(" ", $product->qty)[0] : 1;
            $item["taxGroup"] = env("OUR_FACTURE_TAX_GROUP");
            array_push($items, $item);
        }

        $normalisationData = [
            "ifu" => env("OUR_DGI_IFU"),
            "type" => env("OUR_FACTURE_TYPE"),
            "items" => $items,
            "client" => $client,
            "operator" => $operator,
        ];

        ##______DEMANDE DE NORMALISATION DE LA FACTURE
        $demande_response = DEMAND_FACTURE_NORMALISATION($normalisationData);

        if (http_response_code() != 200) {
            return self::sendError("Désolé! Une erreure est survenue lors de votre demande de normalisation de facture!", 505);
        }

        if (http_response_code() == 200) {
            $uid = $demande_response["uid"];

            ###___ON PASSE MAINTENANT A LA CONFIRMATION
            $confirm_response = CONFIRM_NORMALISATION_DEMAND($uid);

            if (http_response_code() != 200) {
                return self::sendError("Désolé! Une erreure est survenue lors de la confirmation de votre demande de normalisation de facture!", 505);
            }

            ###___FORMATION DU CODE QR
            $qrcode = "facture_qrCode_" . $facture->id . ".png";
            QrCode::format("png")->size(200)->generate($confirm_response["qrCode"], "factureQrcodes/" . $qrcode);
            $facture->qr_code = asset("factureQrcodes/" . $qrcode);
            $facture->normalized = true;
            $facture->save();

            ###___ON RECUPERE L'AGENCE DE CET AGENT
            $current_user = request()->user();

            $agent_attach_to_this_user = Agent::where(["user_id" => $current_user->id])->first();
            if (!$agent_attach_to_this_user) {
                return self::sendError("Le compte agent qui vous est associé n'existe plus!", 505);
            }
            $agency_of_this_agent =  $agent_attach_to_this_user->agency;

            if (!$agency_of_this_agent) {
                return self::sendError("L'agence auquelle vous êtes associée n'existe plus! Vous ne pouvez pas générer une facture.", 505);
            }

            $photoName = explode("pieces/", $agency_of_this_agent->photo)[1];
            $agency_of_this_agent_img = "data:image/png;base64," . base64_encode(file_get_contents("pieces/" . $photoName));

            ###__REGENERATION DE LA FACTURE
            $client = $facture->_client;
            $reference = $facture->reference;
            $command = $facture->_command;
            $products = $facture->_command->products;
            $total = $facture->_command->amount;
            $dgi_details = $confirm_response;
            $code_qr_img = "data:image/png;base64," . base64_encode(file_get_contents("factureQrcodes/" . $qrcode));

            $pdf = PDF::loadView('normalized-facture', compact([
                "facture",
                "command",
                "client",
                "reference",
                "products",
                "total",
                "dgi_details",
                "code_qr_img",
                "agency_of_this_agent",
                "agency_of_this_agent_img"
            ]));

            $pdf->save(public_path("factures_nomalizes/" . $reference . ".pdf"));
            $facturepdf_path = asset("factures_nomalizes/" . $reference . ".pdf");

            ###____TICKETS NORMALISE
            $ticket = PDF::loadView('normalized-ticket', compact([
                "facture",
                "command",
                "client",
                "reference",
                "products",
                "total",
                "dgi_details",
                "code_qr_img",
                "agency_of_this_agent",
                "agency_of_this_agent_img"
            ]));

            ##__
            $ticket->save(public_path("tickets_nomalizes/" . $reference . ".pdf"));
            $ticket_path = asset("tickets_nomalizes/" . $reference . ".pdf");
            ###___


            ###___
            $facture->facture = $facturepdf_path;
            $facture->ticket = $ticket_path;
            $facture->save();

            return self::sendResponse($facture, "Facture normalisée avec succès!");
        }

        return self::sendResponse($facture, 'Normalisation de facture effectuée avec succès!!');
    }

    static function retrieveFactureNormalisation($id)
    {
        $facture = StoreFacturation::with(["_client", "facturier"])->find($id);
        if (!$facture) {
            return self::sendError("Cette facture n'est pas disponible", 404);
        }
        return self::sendResponse($facture, "Facture récupérée avec succès");
    }

    static function facturesNormalisations()
    {
        $factures = StoreFacturation::with(["_client", "facturier"])->orderBy("id", "desc")->get();
        if ($factures->count() == 0) {
            return self::sendError("Aucune facture n'est disponible", 404);
        }
        return self::sendResponse($factures, 'Liste des factures récupérés avec succès!!');
    }

    static function updateFactureNormalisation($request, $id)
    {
        $facture = StoreFacturation::find($id);
        if (!$facture) {
            return self::sendError('Cette facture n\'existe pas!', 404);
        };

        if ($request->get("paid")) {
            $facture->paid = $request->get("paid");
            $facture->save();
        }
        $facture->update($request->all());
        return self::sendResponse($facture, "Facture modifiée avec succès!!");
    }

    static function deleteFactureNormalisation($id)
    {
        $facture = StoreFacturation::find($id);
        if (!$facture) {
            return self::sendError('Cette facture n\'existe pas!', 404);
        };
        $facture->delete();
        return  self::sendResponse($facture, "Facture supprimée avec succès!");
    }
}
