<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Pos;
use App\Models\Sold;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class POS_HELPER extends BASE_HELPER
{
    ##======== ADD POS VALIDATION =======##
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

    ##======== UPDATE POS VALIDATION =======##
    static function update_pos_rules(): array
    {
        return [
            "username" => [Rule::unique("pos")],
            "phone" => [Rule::unique("pos")],
        ];
    }

    static function Update_Pos_Validator($formDatas)
    {
        $rules = self::update_pos_rules();

        $validator = Validator::make($formDatas, $rules);
        return $validator;
    }

    static function _createPos($request)
    {
        $formData = $request->all();
        #SON ENREGISTREMENT EN TANT QU'UN USER

        $user = request()->user();

        $posData = [
            "username" => $formData['username'],
            "country" => $formData['country'],
            "phone" => $formData['phone'],
        ];

        #============= SON ENREGISTREMENT EN TANT QU'UN Pos ==========#
        $Pos = Pos::create($posData); #ENREGISTREMENT DU Pos DANS LA DB
        $Pos->owner = $user->id;
        $Pos->save();

        ### CREATION DU SOLDE DU POS
        $solde = new Sold();
        $solde->pos = $Pos->id;
        $solde->save();
        return self::sendResponse($Pos, 'Pos crée avec succès!!');
    }

    static function allPoss()
    {
        $user = request()->user();
        if ($user->is_admin) {
            $Pos =  Pos::with(["owner", "agents", "agencies", "stores", "sold"])->latest()->get();
        } else {
            $Pos =  Pos::with(["owner", "agents", "agencies", "stores", "sold"])->where(['owner' => request()->user()->id, 'visible' => 1])->latest()->get();
        }
        return self::sendResponse($Pos, 'Tout les Pos récupérés avec succès!!');
    }

    static function _retrievePos($id)
    {
        $user = request()->user();
        if ($user->is_admin) {
            $pos = Pos::with(["owner", "agents", "agencies", "stores", "sold"])->find($id);
        } else {
            $pos = Pos::with(["owner", "agents", "agencies", "stores", "sold"])->where(['id' => $id, 'owner' => request()->user()->id, 'visible' => 1])->get();
        }
        if (!$pos) {
            return self::sendError("Ce Pos n'existe pas", 404);
        }

        return self::sendResponse($pos, "Pos récupéré avec succès:!!");
    }

    static function _updatePos($request, $id)
    {
        $formData = $request->all();
        $Pos = Pos::where(['owner' => request()->user()->id, 'visible' => 1])->find($id);
        if (!$Pos) {
            return self::sendError("Ce Pos n'existe pas!", 404);
        };

        $Pos->update($formData);
        return self::sendResponse($Pos, 'Ce Pos a été modifié avec succès!');
    }

    static function posDelete($id)
    {
        $Pos = Pos::where(['owner' => request()->user()->id, 'visible' => 1])->find($id);
        if (!$Pos) {
            return self::sendError("Ce Pos n'existe pas!", 404);
        };

        $Pos->delete_at = now();
        $Pos->visible = 0;
        $Pos->save();
        return self::sendResponse($Pos, 'Ce Pos a été supprimé avec succès!');
    }

    static function _AffectToAgency($formData)
    {

        $pos = Pos::where(['owner' => request()->user()->id, "visible" => 1])->find($formData['pos_id']);
        $agency = Agency::where(['owner' => request()->user()->id, "visible" => 1])->find($formData['agency_id']);

        if ($pos->affected) {
            return  self::sendError("Ce Pos est déjà affecté à une agence!!", 404);
        }

        if (!$pos) {
            return  self::sendError("Ce Pos n'existe pas!!", 404);
        }

        if (!$agency) {
            return  self::sendError("Cette Agence n'existe pas!!", 404);
        }

        $pos->agency_id = $formData["agency_id"];
        $pos->affected = true;
        $pos->save();

        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }
}
