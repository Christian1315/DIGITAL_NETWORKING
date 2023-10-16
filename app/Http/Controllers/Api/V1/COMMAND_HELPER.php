<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\StoreCommand;
use App\Models\StoreProduit;
use App\Models\StoreStock;
use Illuminate\Support\Facades\Validator;

class COMMAND_HELPER extends BASE_HELPER
{
    ##======== COMMAND VALIDATION =======##

    static function command_rules(): array
    {
        return [
            // 'store' => ['required', 'integer'],
            // 'table' => ['required', 'integer'],
            'product' => ['required', 'integer'],
            'qty' => ['required', 'integer'],
            'client' => ['required'],

            // "amount" => ['required', 'integer']
            // "rate"=> ['required']
        ];
    }

    static function command_messages(): array
    {
        return [
            // 'store.required' => 'Le champ store est réquis!',
            'product.required' => 'Le champ product est réquis!',
            'qty.required' => 'Le champ qty est réquis!',
            'client.integer' => 'Le client est réquis!',
        ];
    }

    static function Command_Validator($formDatas)
    {
        $rules = self::command_rules();
        $messages = self::command_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createCommand($request)
    {
        $user = request()->user();
        $formData = $request->all();
        $session = GetSession($user->id);


        // $store = Store::where(["id" => $formData["store"], "visible" => 1])->get();
        // // $table = StoreTable::where(["id" => $formData["table"], "owner" => request()->user()->id, "visible" => 1])->get();
        // if ($store->count() == 0) {
        //     return self::sendError("Ce Store n'existe pas", 404);
        // }

        $client = $formData["client"];
        
        // $products = [
        //     [
        //         "type" => 1,
        //         "weight" => 3000,
        //         "length" => 100,
        //     ],
        //     [
        //         "type" => 2,
        //         "weight" => 5000,
        //         "length" => 200,
        //     ]
        // ];

        #ON VERIFIE L'EXISTENCE DU PRODUIT
        $product = StoreProduit::find($formData["product"]);
        if (!$product) {
            return self::sendError("Ce product n'existe pas!", 404);
        }
        #ON VERIFIE L'EXISTENCE DU PRODUIT DANS LE STOCK DU STORE
        // $product_stock = StoreStock::with(["product", "store"])->where(["product" => $formData["product"], "store" => $formData["store"], "visible" => 1])->get();
        $product_stock = StoreStock::with(["product", "store"])->where(["product" => $formData["product"], "visible" => 1])->get();

        // if ($table->count() == 0) {
        //     return self::sendError("Cette Table n'existe pas", 404);
        // }
        if ($product_stock->count() == 0) {
            return self::sendError("Ce Produit n'existe pas dans le stock du store", 404);
        }

        $product_stock = $product_stock[0];

        #Verifions la quantité du produit
        if ($product_stock->quantity < 0 || $product_stock->quantity == 0) {
            return self::sendError("Ce produit est fini dans le stock! Veuillez approvisionner le stock avant de passer aux commandes", 505);
        }

        #Verifions si la quantité de la commande est inferieur à celle du produit existant dans le stock
        if ($product_stock->quantity < $formData["qty"]) {
            return self::sendError("Stock insuffisant dans le store! Dimuniez la quantité de votre commande", 505);
        }


        $current_agent = Agent::where(["user_id" => $user->id])->get();
        if ($current_agent->count() == 0) {
            return self::sendError("Le compte agent auquel vous êtes associé.e n'existe plus", 404);
        }


        ###L'agent actuel
        $current_agent = $current_agent[0];
        $this_agent_pos = $current_agent->pos;
        // $this_agent_pos_sold = $this_agent_pos->sold;

        if (!$this_agent_pos) {
            return self::sendError("Vous n'etes pas affecté à un POS! Vous ne pouvez pas passer une commande", 505);
        }
        ####VOYONS SI LE POS DISPOSE D'UN SOLDE SUFFISANT

        $formData["amount"] = $formData["qty"] * $product->price;

        if (!Is_Pos_Account_Enough($this_agent_pos->id, $formData["amount"])) {
            return self::sendError("Désolé! Votre Pos ne dispose pas de solde suffisant pour éffectuer cette opération!", 505);
        }

        $formData["session"] = $session->id;
        $formData["owner"] = $user->id;

        // return $product_stock;
        #Passons à la validation de la commande
        $command = StoreCommand::create($formData); #ENREGISTREMENT DE LA COMMANDE DANS LA DB

        #changeons sa **visibilité** et son **update_at**
        $product_stock->visible = false;
        $product_stock->update_at = now();
        $product_stock->save();

        #Decreditons l'ancienne ligne & Recréeons une nouvelle ligne de ce produit dans la table des stocks
        $new_stock = new StoreStock();
        $new_stock->session = $session->id;
        $new_stock->owner = $product_stock->owner;
        $new_stock->product = $formData["product"];
        // $new_stock->store = $formData["store"];
        $new_stock->quantity = $product_stock->quantity - $formData["qty"];

        $new_stock->comments = $product_stock->comments;
        $new_stock->save();

        ##___DECREDITATION DU SOLDE DE L'AGENCE
        $countData = [
            "module_type" => 1,
            "comments" => "Décreditation de solde du Pos par " . $user->username . ", pour initier une souscription!",
            "amount" => $formData["amount"],
            "pos" => $this_agent_pos->id
        ];
        Decredite_Pos_Account($countData);

        return self::sendResponse($command, 'Commande éffectuée avec succès!!');
    }

    static function allCommands()
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $commands =  StoreCommand::with(['owner', "store", "product", "session"])->where(["owner" => $user->id, "visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($commands, 'Toutes les commandes récupérés avec succès!!');
    }

    static function _retrieveCommand($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::with(['owner', "store", "product", "session"])->where(["owner" => $user->id, "visible" => 1])->find($id);
        if (!$command) {
            return self::sendError("Cette commande n'existe pas!", 404);
        }
        return self::sendResponse($command, "Commande récupérée avec succès:!!");
    }

    static function _updateCommand($formData, $id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::where(["owner" => $user->id, "visible" => 1])->find($id);
        if (!$command) {
            return self::sendError("Cette Commande n'existe pas!", 404);
        };
        $command = StoreCommand::find($id);
        $command->update($formData);
        return self::sendResponse($command, 'Cette Commande a été modifiée avec succès!');
    }

    static function commandDelete($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::where(["owner" => $user->id, "visible" => 1])->find($id);
        if (!$command) {
            return self::sendError("Cette Commande n'existe pas!", 404);
        };

        $command->visible = 0;
        $command->delete_at = now();

        $command->save();
        return self::sendResponse($command, 'Cette commande a été supprimée avec succès!');
    }
}
