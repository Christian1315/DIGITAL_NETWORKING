<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Pos;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class POS_HELPER extends BASE_HELPER
{
    ##======== POS VALIDATION =======##
    static function pos_rules(): array
    {
        return [
            "username" => ['required', Rule::unique("pos")],
            "country" => ['required'],
            "phone" => ['required', Rule::unique("pos")],
            "phone" => ['required', Rule::unique("pos")],
        ];
    }

    static function Add_Pos_Validator($formDatas)
    {
        $rules = self::pos_rules();

        $validator = Validator::make($formDatas, $rules);
        return $validator;
    }

    static function _createPos($request)
    {
        $formData = $request->all();
        #SON ENREGISTREMENT EN TANT QU'UN USER

        $current_user = request()->user();

        $posData = [
            "username" => $formData['username'],
            "country" => $formData['country'],
            "phone" => $formData['phone'],
        ];

        #============= SON ENREGISTREMENT EN TANT QU'UN Pos ==========#
        $Pos = Pos::create($posData); #ENREGISTREMENT DU Pos DANS LA DB
        $Pos->owner = $current_user->id;

        $Pos->save();
        return self::sendResponse($Pos, 'Pos crée avec succès!!');
    }

    static function allPoss()
    {
        $Pos =  Pos::with(["owner", "agents","agencies","stores"])->where(['owner' => request()->user()->id, 'visible' => 1])->latest()->get();
        return self::sendResponse($Pos, 'Tout les Pos récupérés avec succès!!');
    }

    static function _retrievePos($id)
    {
        $pos = Pos::with(["owner", "agents","agencies","stores"])->where(['id' => $id, 'owner' => request()->user()->id, 'visible' => 1])->get();
        if ($pos->count() == 0) {
            return self::sendError("Ce Pos n'existe pas", 404);
        }

        return self::sendResponse($pos, "Pos récupéré avec succès:!!");
    }

    static function _updatePos($formData, $id)
    {
        $Pos = Pos::where(['id' => $id, 'owner' => request()->user()->id, 'visible' => 1])->get();
        if (count($Pos) == 0) {
            return self::sendError("Ce Pos n'existe pas!", 404);
        };
        $Pos = Pos::find($id);
        $Pos->update($formData);
        return self::sendResponse($Pos, 'Ce Pos a été modifié avec succès!');
    }

    static function posDelete($id)
    {
        $Pos = Pos::where(['id' => $id, 'owner' => request()->user()->id, 'visible' => true])->get();
        if (count($Pos) == 0) {
            return self::sendError("Ce Pos n'existe pas!", 404);
        };

        $Pos = Pos::find($id);
        $Pos->delete_at = now();
        $Pos->visible = false;
        $Pos->save();
        return self::sendResponse($Pos, 'Ce Pos a été supprimé avec succès!');
    }


    static function _AffectToAgency($formData)
    {

        // return $formData;

        $pos = Pos::where(['owner' => request()->user()->id, 'id' => $formData['pos_id'], "visible" => 1])->get();
        $agency = Agency::where(['owner' => request()->user()->id, 'id' => $formData['agency_id'], "visible" => 1])->get();

        if ($pos->count() == 0) {
            return  self::sendError("Ce Pos n'existe pas!!", 404);
        }

        if ($agency->count() == 0) {
            return  self::sendError("Cette Agence n'existe pas!!", 404);
        }

        $pos = Pos::find($formData["pos_id"]);
        $pos->agency_id = $formData["agency_id"];
        $pos->affected = true;

        $pos->save();

        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }
}
