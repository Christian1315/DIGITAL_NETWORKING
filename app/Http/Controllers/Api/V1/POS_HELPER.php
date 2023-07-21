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
        $label = "POS";
        $number =  Master_Add_Number($user, $label); ##Get_Number est un helper qui genère le **number**

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
        $master =  $current_user->master;
        // return $master;
        $posData = [
            "username" => $number,
            "country" => $formData['country'],
            "phone" => $formData['phone'],
            "user_id" => $formData['user_id'], 
            "master_id" => $master->id, 
            "owner" => $current_user->id, 
        ];
        // return $posData;
        #============= SON ENREGISTREMENT EN TANT QU'UN Pos ==========#
        $Pos = Pos::create($posData); #ENREGISTREMENT DU Pos DANS LA DB
        $Pos->user_id = $formData['user_id'];
        $Pos->master_id = $master->id;
        $Pos->owner = $current_user->id;
        $Pos->save();

        
        return self::sendResponse($Pos, 'Pos crée avec succès!!');
    }

    static function allPoss()
    {
        $Pos =  Pos::with(["master","owner"])->where('owner',request()->user()->id)->get();
        return self::sendResponse($Pos, 'Tout les Pos récupérés avec succès!!');
    }

    static function _retrievePos($id)
    {
        $pos = Pos::with(['master',"owner"])->where(['id' => $id, 'owner' => request()->user()->id])->get();
        if ($pos->count() == 0) {
            return self::sendResponse($pos, "Pos recupere avec succès!!");
        }
        return self::sendResponse($pos, "Pos récupéré avec succès:!!");
    }

    static function _updateMaster($formData, $id)
    {
        $Master = Master::where('id', $id)->get();
        if (count($Master) == 0) {
            return self::sendError("Ce Master n'existe pas!", 404);
        };
        $Master = Master::find($id);
        $Master->update($formData);
        return self::sendResponse($Master, 'Ce Master a été modifié avec succès!');
    }

    static function masterDelete($id)
    {
        $Master = Master::where('id', $id)->get();
        if (count($Master) == 0) {
            return self::sendError("Ce Master n'existe pas!", 404);
        };
        $Master = Master::find($id);
        $Master->delete();
        return self::sendResponse($Master, 'Ce Master a été supprimé avec succès!');
    }
}
