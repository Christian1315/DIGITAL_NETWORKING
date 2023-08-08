<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Agent;
use App\Models\Pos;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class STORE_HELPER extends BASE_HELPER
{
    ##======== STORE VALIDATION =======##

    static function store_rules(): array
    {
        return [
            'name' => ['required', Rule::unique("stores")],
            'active' => ['required', 'integer'],
        ];
    }

    static function store_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'acti.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Store_Validator($formDatas)
    {
        $rules = self::store_rules();
        $messages = self::store_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createStore($formData)
    {
        $store = Store::create($formData); #ENREGISTREMENT DU STORE DANS LA DB
        $store->owner = request()->user()->id;
        $store->save();
        return self::sendResponse($store, 'Store crée avec succès!!');
    }

    static function allStores()
    {
        $stores =  Store::with(['owner', "agent", "agency", "pos", "supplies", "stocks"])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($stores, 'Tout les stores récupérés avec succès!!');
    }

    static function _retrieveStore($id)
    {
        $store = Store::with(['owner', "agent", "agency", "pos", "supplies", "stocks"])->where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if ($store->count() == 0) {
            return self::sendError("Ce store n'existe pas!", 404);
        }
        return self::sendResponse($store, "Store récupérée avec succès:!!");
    }

    static function _updateStore($formData, $id)
    {
        $store = Store::where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if (count($store) == 0) {
            return self::sendError("Ce Store n'existe pas!", 404);
        };
        $store = Store::find($id);
        $store->update($formData);
        return self::sendResponse($store, 'Ce Store a été modifié avec succès!');
    }

    static function storeDelete($id)
    {
        $store = Store::where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if (count($store) == 0) {
            return self::sendError("Ce Store n'existe pas!", 404);
        };
        $store = Store::find($id);
        $store->visible = 0;
        $store->delete_at = now();

        $store->save();
        return self::sendResponse($store, 'Ce store a été supprimée avec succès!');
    }

    static function _AffectToPos($formData)
    {

        // return $formData;
        $store = Store::where(['owner' => request()->user()->id, 'id' => $formData['store_id'], "visible" => 1])->get();
        $pos = Pos::where(['owner' => request()->user()->id, 'id' => $formData['pos_id'], "visible" => 1])->get();

        if ($store->count() == 0) {
            return  self::sendError("Ce Store n'existe pas!!", 404);
        }

        if ($pos->count() == 0) {
            return  self::sendError("Ce Pos n'existe pas!!", 404);
        }

        $store = Store::find($formData["store_id"]);
        $store->pos_id = $formData["pos_id"];
        $store->affected = true;
        $store->save();
        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }

    static function _AffectToAgent($formData)
    {

        // return $formData;
        $store = Store::where(['owner' => request()->user()->id, 'id' => $formData['store_id'], "visible" => 1])->get();
        $agent = Agent::where(['owner' => request()->user()->id, 'id' => $formData['agent_id'], "visible" => 1])->get();

        if ($store->count() == 0) {
            return  self::sendError("Ce Store n'existe pas!!", 404);
        }

        if ($agent->count() == 0) {
            return  self::sendError("Ce Agent n'existe pas!!", 404);
        }

        $store = Store::find($formData["store_id"]);
        $store->agent_id = $formData["agent_id"];
        $store->affected = true;
        $store->save();
        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }

    static function _AffectToAgency($formData)
    {

        $store = Store::where(['owner' => request()->user()->id, 'id' => $formData['store_id'], "visible" => 1])->get();
        $agency = Agency::where(['owner' => request()->user()->id, 'id' => $formData['agency_id'], "visible" => 1])->get();

        if ($store->count() == 0) {
            return  self::sendError("Ce Store n'existe pas!!", 404);
        }

        if ($agency->count() == 0) {
            return  self::sendError("Cette Agence n'existe pas!!", 404);
        }

        $store = Store::find($formData["store_id"]);
        $store->agency_id = $formData["agency_id"];
        $store->affected = true;
        $store->save();
        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }
}