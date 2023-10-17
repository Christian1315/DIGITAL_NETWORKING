<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Client;
use App\Models\ProductCommand;
use App\Models\StoreCommand;
use App\Models\StoreFacturation;
use App\Models\StoreProduit;
use App\Models\User;
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
        // $client = User::find($clientId);
        // if (!$client) {
        //     return self::sendError("Ce client n'existe pas!", 404);
        // }

        $command = StoreCommand::find($commandId);
        $client = Client::find($command->client);
        if (!$command) {
            return self::sendError("Cette commande n'existe pas!", 404);
        }

        if (!$client) {
            return self::sendError("Le client associé à cette commande n'existe pas!", 404);
        }

        if ($command->factured) {
            return self::sendError("Cette commande a déjà été facturée!", 505);
        }

        ###___GESTION DES FACTURES
        // $commands = StoreCommand::where(["owner" => $clientId, "factured" => 0])->orderBy("id", "desc")->get();

        // if (count($commands) == 0) {
        //     return self::sendError("Vous ne disposez pas de commande à facturer", 404);
        // }

        $reference = Custom_Timestamp();

        $formData = [];
        $formData["reference"] = $reference;
        if (request()->user()) {
            $formData["facturier"] = request()->user()->id;
        }

        $command = StoreCommand::find($commandId);
        // foreach ($commands as $command) {
        //     array_push($command_amounts, $command->amount);
        // }
        $products = $command->products;
        $total = $command->amount;

        $pdf = PDF::loadView('facture', compact(["client", "reference", "products", "total"]));
        $pdf->save(public_path("factures/" . $reference . ".pdf"));

        ###____

        $facturepdf_path = asset("factures/" . $reference . ".pdf");

        $formData["client"] = $command->client;
        $formData["facture"] = $facturepdf_path;
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
            //throw $th;
        }

        return self::sendResponse($facture, 'Facture générée avec succès!!');
    }

    static function retrieveFacture($id)
    {
        $facture = StoreFacturation::with(["client", "facturier"])->find($id);
        if (!$facture) {
            return self::sendError("Cette facture n'est pas disponible", 404);
        }
        return self::sendResponse($facture, "Facture récupérée avec succès");
    }

    static function factures()
    {
        $factures = StoreFacturation::with(["client", "facturier"])->orderBy("id", "desc")->get();
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
