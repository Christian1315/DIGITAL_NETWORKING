<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Pos;
use App\Models\Store;
use App\Models\StoreSupply;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SUPPLY_HELPER extends BASE_HELPER
{
    ##======== SUPPLY VALIDATION =======##

    static function supply_rules(): array
    {
        return [
            'comments' => ['required', Rule::unique("store_supplies")],
            'store' => ['required', 'integer'],
            'pos' => ['required', 'integer'],
            'status' => ['required', 'integer'],
        ];
    }

    static function supply_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'acti.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Supply_Validator($formDatas)
    {
        $rules = self::supply_rules();
        $messages = self::supply_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createSupply($formData)
    {
        $store = Store::where(["id" => $formData["store"], "owner" => request()->user()->id, "visible" => 1])->get();
        $pos = Pos::where(["id" => $formData["pos"], "owner" => request()->user()->id, "visible" => 1])->get();

        if ($store->count() == 0) {
            return self::sendError("Ce store n'existe pas", 404);
        }
        if ($pos->count() == 0) {
            return self::sendError("Ce Pos n'existe pas", 404);
        }
        $supply = StoreSupply::create($formData); #ENREGISTREMENT DE LA TABLE DANS LA DB
        $supply->owner = request()->user()->id;
        $session = GetSession(request()->user()->id);
        $supply->session = $session->id;
        $supply->save();
        return self::sendResponse($supply, 'Supply crée avec succès!!');
    }

    static function allSupply()
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $supplies =  StoreSupply::with(['owner', "pos", "store", "supply_products"])->where(["owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($supplies, 'Tout les supplies récupérés avec succès!!');
    }

    static function _retrieveSupply($id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $table = StoreSupply::with(['owner', "pos", "store", "supply_products"])->where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if ($table->count() == 0) {
            return self::sendError("Ce supply n'existe pas!", 404);
        }
        return self::sendResponse($table, "Supply récupérée avec succès:!!");
    }

    static function _updateSupply($formData, $id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $table = StoreSupply::where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if (count($table) == 0) {
            return self::sendError("Ce Supply n'existe pas!", 404);
        };
        $supply = StoreSupply::find($id);
        $supply->update($formData);
        return self::sendResponse($supply, 'Ce Supply a été modifié avec succès!');
    }

    static function deleteSupply($id)
    {
        // return $id;
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $supply = StoreSupply::where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if (count($supply) == 0) {
            return self::sendError("Ce Supply n'existe pas!", 404);
        };

        $supply = $supply[0];
        $supply->visible = 0;
        $supply->delete_at = now();
        $supply->save();
        return self::sendResponse($supply, 'Ce Supply a été supprimée avec succès!');
    }
}
