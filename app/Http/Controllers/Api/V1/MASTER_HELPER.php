<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ActivityDomain;
use App\Models\Master;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MASTER_HELPER extends BASE_HELPER
{
    ##======== MASTER VALIDATION =======##
    static function master_rules(): array
    {
        return [
            "raison_sociale" => ['required'],
            "ifu" => ['required'],
            "ifu_file" => ['required'],
            "rccm" => ['required'],
            "rccm_file" => ['required'],
            "country" => ['required'],
            "commune" => ['required'],
            "domaine_activite" => ['required','integer'],
            "type_piece" => ['required', 'integer'],
            "numero_piece" => ['required'],
            "phone" => ['required', Rule::unique("users")],
            "phone" => ['required', Rule::unique("masters")],
            "email" => ['required', 'email', Rule::unique("users")],
            "email" => ['required', 'email', Rule::unique("masters")],
        ];
    }

    static function Add_Master_Validator($formDatas)
    {
        $rules = self::master_rules();

        $validator = Validator::make($formDatas, $rules);
        return $validator;
    }

    static function _addMaster($request)
    {
        $formData = $request->all();
        #SON ENREGISTREMENT EN TANT QU'UN USER
        $piece_type = Piece::where('id', $formData['type_piece'])->get();

        $domaine_activite = ActivityDomain::where('id', $formData['domaine_activite'])->get();

        if (count($domaine_activite) == 0) {
            return self::sendError("Ce domaine d'activité n'existe pas!!", 404);
        }

        if (count($piece_type) == 0) {
            return self::sendError("Ce type de piece n'existe pas!!", 404);
        }

        $user = request()->user();
        $label = "MAS";

        $number =  Admin_Add_Number($user, $label); ##Get_Number est un helper qui genère le **number** 

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();
        if (count($user) != 0) {
            return self::sendError("Cet utilisateur existe déjà!", 404);
        }

        $userData = [
            "username" => $number,
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "password" => $number,
        ];
        $user = User::create($userData);
        $formData['user_id'] = $user['id'];
        $formData['number'] = $number;

        #============= SON ENREGISTREMENT EN TANT QU'UN MASTER ==========#

        ##GESTION DES FICHIERS
        $ifu_file = $request->file('ifu_file');
        $rccm_file = $request->file('rccm_file');

        $ifu_name = $ifu_file->getClientOriginalName();
        $rccm_name = $rccm_file->getClientOriginalName();

        $request->file('ifu_file')->move("pieces", $ifu_name);
        $request->file('rccm_file')->move("pieces", $rccm_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE **MASTERS**
        $formData["ifu_file"] = asset("pieces/".$ifu_name);
        $formData["rccm_file"] = asset("pieces/".$rccm_name);
        
        $Master = Master::create($formData); #ENREGISTREMENT DU MASTER DANS LA DB
        $Master['domaine_activite'] = $domaine_activite;
        return self::sendResponse($Master, 'Master crée avec succès!!');
    }

    static function allMasters()
    {
        $masters =  Master::with(["agents"])->orderBy('id', 'desc')->get();
        return self::sendResponse($masters, 'Tout les masters récupérés avec succès!!');
    }

    static function _retrieveMaster($id)
    {
        $Master = Master::with(["agents"])->where('id', $id)->get();
        // return $Master;
        if ($Master->count() == 0) {
            return self::sendError("Ce Master n'existe pas!", 404);
        }

        $parent = request()->user();
        $piece = Piece::find($Master[0]->type_piece);
        $Master['parent'] = $parent;
        $Master['piece'] = $piece;

        return self::sendResponse($Master, "Master récupéré avec succès:!!");
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
