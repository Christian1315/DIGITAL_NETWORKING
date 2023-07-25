<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ActivityDomain;
use App\Models\Master;
use App\Models\Piece;
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
            "country" => ['required'],
            "phone" => ['required', Rule::unique("users")],
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

        $user = request()->user();
        $type = "POS";

        $number =  Add_Number($user, $type); ##Add_Number est un helper qui genère le **number** 

        $userData = [
            "username" => $number,
            "phone" => $formData['phone'],
            "password" => $number,
            "profil_id" => 5, #UNE AGENCE
            "rang_id" => 2, #UN MODERATEUR
        ];
        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();
        if (count($user) != 0) {
            return self::sendError("Cet utilisateur existe déjà!", 404);
        }
        $user = User::where("phone", $formData['phone'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce identifiant!", 404);
        }


        $user = User::create($userData);
        $formData['user_id'] = $user['id'];
        $current_user = request()->user();
        // $master =  $current_user->master;
        // return $master;
        $posData = [
            "username" => $number,
            "country" => $formData['country'],
            "phone" => $formData['phone'],
            "user_id" => $formData['user_id'],
            // "master_id" => $master->id, 
            "owner" => $current_user->id,
        ];
        // return $posData;
        #============= SON ENREGISTREMENT EN TANT QU'UN Pos ==========#
        $Pos = Pos::create($posData); #ENREGISTREMENT DU Pos DANS LA DB
        $Pos->user_id = $formData['user_id'];
        // $Pos->master_id = $master->id;
        $Pos->owner = $current_user->id;

        // if (Is_User_An_Agency_Or_Admin($user->id)) { #Si c'est pas un master
        //     $agency['master_id'] = request()->user()->master;
        // } else {
        //     $agency['admin'] = request()->user()->id;
        // }
        $Pos->save();
        return self::sendResponse($Pos, 'Pos crée avec succès!!');
    }

    static function allPoss()
    {
        $Pos =  Pos::with(["admin", "owner"])->where(['owner' => request()->user()->id, 'visible' => 1])->get();
        return self::sendResponse($Pos, 'Tout les Pos récupérés avec succès!!');
    }

    static function _retrievePos($id)
    {
        $pos = Pos::with(['admin', "owner"])->where(['id' => $id, 'owner' => request()->user()->id, 'visible' => 1])->get();
        if ($pos->count() == 0) {
            return self::sendError("Ce Pos n'existe pas", 404);
        }

        $pos = Pos::find($id);
        #renvoie des droits du user 
        $user =  $pos->user;
        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
        // return $attached_rights;

        if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
            if (Is_User_An_Admin($user->id)) { #s'il est un admin
                $pos['rights'] = All_Rights();
            } else {
                $pos['rights'] = User_Rights($user->rang['id'], $user->profil['id']);
            }
        } else {
            $pos['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
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
}
