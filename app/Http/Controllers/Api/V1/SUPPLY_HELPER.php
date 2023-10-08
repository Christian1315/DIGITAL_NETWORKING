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
        $user = request()->user();
        $store = Store::where(["id" => $formData["store"], "visible" => 1])->get();
        $pos = Pos::where(["id" => $formData["pos"], "visible" => 1])->get();

        if ($store->count() == 0) {
            return self::sendError("Ce store n'existe pas", 404);
        }
        if ($pos->count() == 0) {
            return self::sendError("Ce Pos n'existe pas", 404);
        }
        $supply = StoreSupply::create($formData); #ENREGISTREMENT DE LA TABLE DANS LA DB
        $supply->owner = $user->id;
        $session = GetSession($user->id);
        $supply->session = $session->id;
        $supply->save();
        return self::sendResponse($supply, 'Approvisionnement crée avec succès!!');
    }

    static function allSupply()
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $supplies =  StoreSupply::with(['owner', "pos", "store", "supply_products", "session"])->where(["visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($supplies, 'Tout les approvisionnement récupérés avec succès!!');
    }

    static function _retrieveSupply($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $supply = StoreSupply::with(['owner', "pos", "store", "supply_products", "session"])->where(["id" => $id, "visible" => 1])->get();
        if ($supply->count() == 0) {
            return self::sendError("Ce supply n'existe pas!", 404);
        }
        return self::sendResponse($supply, "Approvisionnement récupérée avec succès:!!");
    }

    static function _updateSupply($formData, $id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE

        $supply = StoreSupply::where(["owner" => $user->id, "visible" => 1])->find($id);
        if (!$supply) {
            return self::sendError("Ce Approvisionnement n'existe pas!", 404);
        };

        $supply->update($formData);
        return self::sendResponse($supply, 'Ce Approvisionnement a été modifié avec succès!');
    }

    static function deleteSupply($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE

        $supply = StoreSupply::where(["owner" => $user->id, "visible" => 1])->find($id);
        if (!$supply) {
            return self::sendError("Ce Approvisionnement n'existe pas!", 404);
        };

        $supply->visible = 0;
        $supply->delete_at = now();
        $supply->save();
        return self::sendResponse($supply, 'Ce Approvisionnement a été supprimée avec succès!');
    }
}
