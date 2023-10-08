<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\Store;
use App\Models\StoreCommand;
use App\Models\StoreProduit;
use App\Models\StoreStock;
use App\Models\StoreTable;
use App\Models\SupplyProduct;
use Illuminate\Support\Facades\Validator;

class COMMAND_HELPER extends BASE_HELPER
{
    ##======== COMMAND VALIDATION =======##

    static function command_rules(): array
    {
        return [
            'store' => ['required', 'integer'],
            // 'table' => ['required', 'integer'],
            'product' => ['required', 'integer'],
            'qty' => ['required', 'integer'],
            "amount" => ['required', 'integer']
            // "rate"=> ['required']
        ];
    }

    static function command_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'acti.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Command_Validator($formDatas)
    {
        $rules = self::command_rules();
        $messages = self::command_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createCommand($formData)
    {
        $user = request()->user();
        $store = Store::where(["id" => $formData["store"], "visible" => 1])->get();
        // $table = StoreTable::where(["id" => $formData["table"], "owner" => request()->user()->id, "visible" => 1])->get();
        #ON VERIFIE L'EXISTENCE DU PRODUIT DANS LE STOCK DU STORE
        $product_stock = StoreStock::where(["product" => $formData["product"], "store" => $formData["store"], "visible" => 1])->get();

        if ($store->count() == 0) {
            return self::sendError("Ce Store n'existe pas", 404);
        }
        // if ($table->count() == 0) {
        //     return self::sendError("Cette Table n'existe pas", 404);
        // }
        if ($product_stock->count() == 0) {
            return self::sendError("Ce Produit n'existe pas dans le stock du store", 404);
        }

        $product_stock = $product_stock[0];

        #Verifions la quantité du produit
        if ($product_stock->quantity < 0 || $product_stock->quantity == 0) {
            return self::sendError("Ce produit est fini dans le stock!Veuillez approvisionner le stock avant de passer aux commandes", 505);
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
        
        ####VOYONS SI LE POS DISPOSE D'UN SOLDE SUFFISANT

        if (!Is_Pos_Account_Enough($this_agent_pos->id, $formData["amount"])) {
            return self::sendError("Désolé! Votre Pos ne dispose pas de solde suffisant pour éffectuer cette opération!", 505);
        }
        
        #Passons à la validation de la commande
        $command = StoreCommand::create($formData); #ENREGISTREMENT DE LA COMMANDE DANS LA DB
        $command->owner = $user->id;
        $session = GetSession($user->id);
        $command->session = $session->id;
        $command->save();

        #Décrementons la quantité de ce stock et changeons sa **visibilité** et son **update_at**
        $product_stock->visible = false;
        $product_stock->update_at = now();
        $product_stock->save();

        #Recréeons une nouvelle ligne de ce produit dans la table des stocks
        $new_stock = new StoreStock();
        $new_stock->session = $session->id;
        $new_stock->owner = $user->id;
        $new_stock->product = $formData["product"];
        $new_stock->store = $formData["store"];
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
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $commands =  StoreCommand::with(['owner', "store", "product", "table"])->where(["owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($commands, 'Toutes les commandes récupérés avec succès!!');
    }

    static function _retrieveCommand($id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::with(['owner', "store", "product", "table"])->where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if ($command->count() == 0) {
            return self::sendError("Cette commande n'existe pas!", 404);
        }
        return self::sendResponse($command, "Commande récupérée avec succès:!!");
    }

    static function _updateCommand($formData, $id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if (count($command) == 0) {
            return self::sendError("Cette Commande n'existe pas!", 404);
        };
        $command = StoreCommand::find($id);
        $command->update($formData);
        return self::sendResponse($command, 'Cette Commande a été modifiée avec succès!');
    }

    static function commandDelete($id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if (count($command) == 0) {
            return self::sendError("Cette Commande n'existe pas!", 404);
        };

        $command = $command[0];

        $command->visible = 0;
        $command->delete_at = now();

        $command->save();
        return self::sendResponse($command, 'Cette commande a été supprimée avec succès!');
    }
}
