<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Agent;
use App\Models\Pos;
use App\Models\Store;
use App\Models\User;
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

    static function storeAffected()
    {
        $storeAffected = [];
        $curent_user = request()->user();

        $all_store = Store::with(["owner", "agent", "agency", "pos", "supplies", "stocks"])->get();
        foreach ($all_store as $store) {
            $agency = Agency::find($store->agency_id);
            $user_agency = null;
            if ($agency) {
                $user_agency = User::find($agency->user_id);
            }

            if ($user_agency) {
                if ($user_agency->id == $curent_user->id) {
                    array_push($storeAffected, $store);
                }
            }
        }
        return self::sendResponse($storeAffected, "Liste de mes stores affectes");
    }

    static function allStores()
    {
        $user = request()->user();

        $stores = [];
        if (Is_User_A_Master($user->id)) {
            $stores =  Store::with(['owner', "agent", "agency", "pos", "supplies", "stocks"])->where(["owner" => $user->id, "visible" => 1])->orderBy('id', 'desc')->get();
        }

        if (Is_User_An_Agency($user->id)) {
            return self::storeAffected();
        }

        if ($user->is_admin) {
            $stores = Store::all();
        }

        if (Is_User_An_Agent($user->id)) {
            $agent = Agent::where(["user_id" => $user->id])->get();
            if (count($agent) == 0) {
                return self::sendError("L'agent auquel vous etes associé n'existe plus!", 505);
            }
            $agent = $agent[0];
            $stores = Store::where(["agent_id" => $agent->id])->get();
        }
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
        $user = request()->user();

        $store = Store::where(["visible" => 1])->find($id);
        if (!$store) {
            return self::sendError("Ce Store n'existe pas!", 404);
        };

        if ($store->owner != $user->id) {
            return self::sendError("Ce store ne vous appartient pas!", 404);
        };

        $store->update($formData);
        return self::sendResponse($store, 'Ce Store a été modifié avec succès!');
    }

    static function storeDelete($id)
    {
        $user = request()->user();

        $store = Store::where(["visible" => 1])->find($id);
        if (!$store) {
            return self::sendError("Ce Store n'existe pas!", 404);
        };

        if ($store->owner != $user->id) {
            return self::sendError("Ce store ne vous appartient pas!", 404);
        };

        $store->visible = 0;
        $store->delete_at = now();

        $store->save();
        return self::sendResponse($store, 'Ce store a été supprimée avec succès!');
    }

    static function _AffectToPos($formData)
    {
        $user = request()->user();

        $store = Store::where(["visible" => 1])->find($formData['store_id']);
        $pos = Pos::where(["visible" => 1])->find($formData['pos_id']);

        if (!$store) {
            return  self::sendError("Ce Store n'existe pas!!", 404);
        }
        if (!$pos) {
            return  self::sendError("Ce Pos n'existe pas!!", 404);
        }

        if ($store->owner != $user->id) {
            return self::sendError("Ce store ne vous appartient pas!", 404);
        };
        if ($pos->owner != $user->id) {
            return self::sendError("Ce pos ne vous appartient pas!", 404);
        };

        $store->pos_id = $formData["pos_id"];
        $store->affected = true;
        $store->save();
        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }

    static function _AffectToAgent($formData)
    {

        $user = request()->user();

        $store = Store::where(["visible" => 1])->find($formData['store_id']);
        $agent = Agent::where(["visible" => 1])->find($formData['agent_id']);

        if (!$store) {
            return  self::sendError("Ce Store n'existe pas!!", 404);
        }
        if (!$agent) {
            return  self::sendError("Ce Agent n'existe pas!!", 404);
        }

        if ($store->owner != $user->id) {
            return self::sendError("Ce store ne vous appartient pas!", 404);
        };
        if ($agent->owner != $user->id) {
            return self::sendError("Ce agent ne vous appartient pas!", 404);
        };

        $store->agent_id = $formData["agent_id"];
        $store->affected = true;
        $store->save();
        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }

    static function _AffectToAgency($formData)
    {

        $user = request()->user();

        $store = Store::where(["visible" => 1])->find($formData['store_id']);
        $agency = Agency::where(["visible" => 1])->find($formData['agency_id']);

        if (!$store) {
            return  self::sendError("Ce Store n'existe pas!!", 404);
        }

        if (!$agency) {
            return  self::sendError("Cette Agence ne vous appartient pas!!", 404);
        }

        $store->agency_id = $formData["agency_id"];
        $store->affected = true;
        $store->save();
        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }
}
