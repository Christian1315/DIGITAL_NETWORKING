<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Master;
use App\Models\StoreCommand;
use App\Models\StoreFacturation;
use Illuminate\Support\Facades\Validator;
use PDF;

class FACTURE_HELPER extends BASE_HELPER
{
    ##======== REGISTER VALIDATION =======##
    static function facture_rules(): array
    {
        return [
            'client' => 'required|integer',
        ];
    }

    static function facture_messages(): array
    {
        return [
            'client.required' => 'Veuillez precisez l\'id du client à facturer!',
            'client.integer' => 'Le champ client doit être un entier!',
        ];
    }

    static function Facture_Validator($formDatas)
    {
        $rules = self::facture_rules();
        $messages = self::facture_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function createFacture($commandId)
    {
        $command = StoreCommand::find($commandId);
        if (!$command) {
            return self::sendError("Cette commande n'existe pas!", 404);
        }
        $client = Client::find($command->client);

        if (!$client) {
            return self::sendError("Le client associé à cette commande n'existe pas!", 404);
        }

        if ($command->factured) {
            return self::sendError("Cette commande a déjà été facturée!", 505);
        }

        ###___GESTION DES FACTURES

        $reference = Custom_Timestamp();

        $formData = [];
        $formData["reference"] = $reference;

        $current_user = request()->user(); ##(agent)

        if (request()->user()) {
            $formData["facturier"] = $current_user->id;
        }

        ###___ON RECUPERE LE MASTER DE CET AGENT
        $agent_attach_to_this_user = Agent::where(["user_id" => $current_user->id])->first();
        if (!$agent_attach_to_this_user) {
            return self::sendError("Le compte agent qui vous est associé n'existe plus!", 505);
        }

        $master_of_this_agent = Master::find($agent_attach_to_this_user->master_id);
        if (!$master_of_this_agent) {
            return self::sendError("Vous ne disposez pas de master! Vous ne pouvez pas générer une facture.", 505);
        }

        $products = $command->products;
        $total = $command->amount;

        ###___GESTION DES TICKETS
        $pdf = PDF::loadView('facture', compact(["command", "client", "reference", "products", "total", "master_of_this_agent"]));
        $pdf->save(public_path("factures/" . $reference . ".pdf"));
        $facturepdf_path = asset("factures/" . $reference . ".pdf");
        ###____
        $ticket = PDF::loadView('ticket', compact(["command", "client", "reference", "products", "total", "master_of_this_agent"]));
        $ticket->save(public_path("tickets/" . $reference . ".pdf"));
        $ticket_path = asset("tickets/" . $reference . ".pdf");
        ###___

        $formData["facture"] = $facturepdf_path;
        $formData["client"] = $client->id;
        $formData["command"] = $commandId;
        $formData["ticket"] = $ticket_path;

        // return $formData["ticket"];
        $facture = StoreFacturation::create($formData);

        ####_____NOTIFIER QUE LA COMMANDE A ETE FACTURES
        $command->factured = 1;
        $command->save();

        ####___ENVOIE DE MAIL AU CLIENT POUR LUI NOTIFIER LA FACTURE
        try {
            Send_Notification(
                $client,
                "FACTURATION DES COMMANDES SUR DIGITAL NETWORK",
                "Cher Client, Vous venez juste d'etre facturé.e sur DIGITAL NETWORK! \n Veuillez cliquer sur le lien ci-dessous pour la télécharger: " . $facturepdf_path
            );
        } catch (\Throwable $th) {
        }
        return self::sendResponse($facture, 'Facture générée avec succès!!');
    }

    static function retrieveFacture($id)
    {
        $facture = StoreFacturation::with(["client", "facturier", "command"])->find($id);
        if (!$facture) {
            return self::sendError("Cette facture n'est pas disponible", 404);
        }
        return self::sendResponse($facture, "Facture récupérée avec succès");
    }

    static function factures()
    {
        $factures = StoreFacturation::with(["client", "facturier", "command"])->orderBy("id", "desc")->get();
        if ($factures->count() == 0) {
            return self::sendError("Aucune facture n'est disponible", 404);
        }
        return self::sendResponse($factures, 'Liste des factures récupérés avec succès!!');
    }

    static function updateFacture($request, $id)
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

    static function deleteFacture($id)
    {
        $facture = StoreFacturation::find($id);
        if (!$facture) {
            return self::sendError('Cette facture n\'existe pas!', 404);
        };
        $facture->delete();
        return  self::sendResponse($facture, "Facture supprimée avec succès!");
    }
}
