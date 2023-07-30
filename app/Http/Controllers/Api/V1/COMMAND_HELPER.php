<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Store;
use App\Models\StoreCommand;
use App\Models\StoreProduit;
use App\Models\StoreTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class COMMAND_HELPER extends BASE_HELPER
{
    ##======== COMMAND VALIDATION =======##

    static function command_rules(): array
    {
        return [
            'store' => ['required', 'integer'],
            'table' => ['required', 'integer'],
            'product' => ['required', 'integer'],
            'qty' => ['required', 'integer'],
            "amount"=> ['required', 'integer']
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
        $store = Store::where(["id" => $formData["store"], "owner" => request()->user()->id,"visible" => 1])->get();
        $table = StoreTable::where(["id" => $formData["table"], "owner" => request()->user()->id,"visible" => 1])->get();
        $product = StoreProduit::where(["id" => $formData["product"], "owner" => request()->user()->id,"visible" => 1])->get();

        if ($store->count()==0) {
            return self::sendError("Ce Store n'existe pas",404);
        }
        if ($table->count()==0) {
            return self::sendError("Cette Table n'existe pas",404);
        }
        if ($product->count()==0) {
            return self::sendError("Ce Produit n'existe pas",404);
        }
        // return $formData;
        $command = StoreCommand::create($formData); #ENREGISTREMENT DE LA COMMANDE DANS LA DB
        $command->owner = request()->user()->id;
        $command->save();
        return self::sendResponse($command, 'Commande crée avec succès!!');
    }

    static function allCommands()
    {
        $commands =  StoreCommand::with(['owner',"store","product","table"])->where(["owner" => request()->user()->id,"visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($commands, 'Toutes les commandes récupérés avec succès!!');
    }

    static function _retrieveCommand($id)
    {
        $command = StoreCommand::with(['owner',"store","product","table"])->where(["id" => $id, "owner" => request()->user()->id,"visible" => 1])->get();
        if ($command->count() == 0) {
            return self::sendError("Cette commande n'existe pas!", 404);
        }
        return self::sendResponse($command, "Commande récupérée avec succès:!!");
    }

    static function _updateCommand($formData, $id)
    {
        $command = StoreCommand::where(["id" => $id, "owner" => request()->user()->id,"visible" => 1])->get();
        if (count($command) == 0) {
            return self::sendError("Cette Commande n'existe pas!", 404);
        };
        $command = StoreCommand::find($id);
        $command->update($formData);
        return self::sendResponse($command, 'Cette Commande a été modifiée avec succès!');
    }

    static function commandDelete($id)
    {
        $command = StoreCommand::where(["id" => $id, "owner" => request()->user()->id,"visible" => 1])->get();
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
