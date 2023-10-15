<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Action;
use App\Models\Profil;
use App\Models\Rang;
use App\Models\Right;
use Illuminate\Support\Facades\Validator;

class RIGHTS_HELPER extends BASE_HELPER
{
    ##======== RIGHT VALIDATION =======##

    static function right_rules(): array
    {
        return [
            'module' => ['required', 'integer'],
            'action' => ['required', 'integer'],
            'rang' => ['required', 'integer'],
            'profil' => ['required', 'integer'],
            'description' => ['required'],
        ];
    }

    static function right_messages(): array
    {
        return [
            // 'label.required' => 'Le champ name est réquis!',
            // 'label.unique' => 'Ce droit existe déjà',
            // 'profil_id.required' => 'Le champ profil_id est réquis!',
            // 'action_id.required' => 'Le champ action_id est réquis!',
            // 'rang_id.required' => 'Le champ rand_id est réquis!',
        ];
    }

    static function Right_Validator($formDatas)
    {
        $rules = self::right_rules();
        $messages = self::right_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createRight($formData)
    {
        $action = Action::find($formData['action']);
        $profil = Profil::find($formData['profil']);
        $rang = Rang::find($formData['rang']);

        if (!$action) {
            return self::sendError("Cette action n'existe pas!!", 404);
        }
        if (!$profil) {
            return self::sendError("Ce profil n'existe pas!!", 404);
        }
        if (!$rang) {
            return self::sendError("Ce rang n'existe pas!!", 404);
        }

        #CREATION DU DROIT
        $right = Right::create($formData); #ENREGISTREMENT DU DROIT DANS LA DB

        $right['action'] = $right->action;
        $right['profil'] = $right->profil;
        $right['rang'] = $right->rang;

        $right = Right::with(["action", "profil", "rang"])->find($right->id);
        return self::sendResponse($right, 'Right crée avec succès!!');
    }

    static function allRights()
    {
        $rights =  Right::with(['action', 'profil', 'rang'])->get();
        return self::sendResponse($rights, 'Tout les droits récupérés avec succès!!');
    }

    static function _retrieveRight($id)
    {
        $right = Right::with(['action', "profil", "rang"])->find($id);
        if (!$right) {
            return self::sendError("Ce droit n'existe pas!", 404);
        }
        return self::sendResponse($right, "Droit récupéré avec succès:!!");
    }

    static function rightDelete($id)
    {
        $right = Right::find($id);
        if (!$right) {
            return self::sendError("Ce droit n'existe pas!", 404);
        };

        $right->delete();
        return self::sendResponse($right, 'Ce droit a été supprimée avec succès!');
    }
}
