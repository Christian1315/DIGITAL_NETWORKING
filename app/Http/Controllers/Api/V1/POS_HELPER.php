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
            "username" => ['required', Rule::unique("pos")],
            "username" => ['required', Rule::unique("users")],
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

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $formData['username'])->get();
        if (count($user) != 0) {
            return self::sendError("Cet utilisateur existe déjà!", 404);
        }

        $userData = [
            "username" => $formData['username'],
            "phone" => $formData['phone'],
            "password" => $formData['username'],
        ];
        $user = User::create($userData);

        #============= SON ENREGISTREMENT EN TANT QU'UN Pos ==========#
        $Pos = Pos::create($formData); #ENREGISTREMENT DU Pos DANS LA DB

        // $this_pos = Pos::find($Pos['id']);
        
        // #REFORMULATION DU formData après enregistrement du user
        // $this_pos['user_id'] = $user['id'];
        // $this_pos['owner'] = request()->user()->id;
        
        // #SI LE USER EST UN MASTER
        // if (Is_User_A_Master(request()->user()->id)) {
        //     $this_pos['master_id'] = request()->user()->id;
        // }
        
        // $pos = $this_pos->save();
        // return $pos;
        return self::sendResponse($Pos, 'Pos crée avec succès!!');
    }

    static function allPoss()
    {
        $Pos =  Pos::orderBy('id', 'desc')->get();
        return self::sendResponse($Pos, 'Tout les Pos récupérés avec succès!!');
    }

    static function _retrievePos($id)
    {
        $pos = Pos::where('id', $id)->get();
        // return $Master;
        if ($pos->count() == 0) {
            return self::sendError("Ce Pos n'existe pas!", 404);
        }

        // $parent = request()->user();
        // $piece = Piece::find($Master[0]->type_piece);
        // $Master['parent'] = $parent;
        // $Master['piece'] = $piece;

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
