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
            "domaine_activite" => ['required', 'integer'],
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
        $type = "MAST";

        $number =  Add_Number($user, $type); ##Add_Number est un helper qui genère le **number** 
        $default_password = $number.Custom_Timestamp();

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce identifiant!", 404);
        }
        $user = User::where("phone", $formData['phone'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce identifiant!", 404);
        }
        $user = User::where("email", $formData['email'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce identifiant!!", 404);
        }

        $userData = [
            "username" => $number,
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "password" => $default_password,
            "profil_id" => 6, #UN MASTER
            "rang_id" => 2, #UN MODERATEUR
        ];

        $user = User::create($userData);
        $user->pass_default = $default_password;
        $user->save();
        $formData['user_id'] = $user['id'];
        $formData['number'] = $number;


        #=====ENVOIE D'SMS =======~####
        $sms_login =  Login_To_Frik_SMS();

        if ($sms_login['status']) {
            $token =  $sms_login['data']['token'];
            
            $response = Send_SMS(
                $formData['phone'],
                "Votre compte a été crée avec succès sur JNP Store. Voici ci-dessous vos identifiants de connexion: Username::".$number."; Password par defaut::".$default_password,
                $token
            );
        }

        #=====FIN D'ENVOIE D'SMS =======~####


        #============= SON ENREGISTREMENT EN TANT QU'UN MASTER ==========#

        ##GESTION DES FICHIERS
        $ifu_file = $request->file('ifu_file');
        $rccm_file = $request->file('rccm_file');

        $ifu_name = $ifu_file->getClientOriginalName();
        $rccm_name = $rccm_file->getClientOriginalName();

        $request->file('ifu_file')->move("pieces", $ifu_name);
        $request->file('rccm_file')->move("pieces", $rccm_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE **MASTERS**
        $formData["ifu_file"] = asset("pieces/" . $ifu_name);
        $formData["rccm_file"] = asset("pieces/" . $rccm_name);

        $userId = request()->user()->id;

        if (Is_User_An_Admin($userId)) {
            $parentId = null; #S'il est un admin alors le master qu'on veut creer n'a pas de parent
            $admin = $userId; #L'admin
        } else {
            $parent = request()->user(); #S'il n'est pas un admin alors il est un master. Il est donc le parent du master qu'on cree
            $parentId = $parent->master->id;
            $admin = null;
        }

        $formData['parent'] = $parentId;

        $Master = Master::create($formData); #ENREGISTREMENT DU MASTER DANS LA DB
        $Master['owner'] = $userId;
        $Master['admin'] = $admin;
        $Master->save();
        $Master['domaine_activite'] = $domaine_activite;
        return self::sendResponse($Master, 'Master crée avec succès!!');
    }

    static function allMasters()
    {
        $masters =  Master::with(["agents", "parent", "poss"])->where(['owner' => request()->user()->id, 'visible' => 1])->orderBy("id","desc")->get();
        
        return self::sendResponse($masters, 'Tout les masters récupérés avec succès!!');
    }

    static function _retrieveMaster($id)
    {
        $Master = Master::with(["agents", "parent", "poss"])->where(['id' => $id, 'owner' => request()->user()->id, 'visible' => 1])->get();
        if ($Master->count() == 0) {
            return self::sendResponse($Master, "Master recupere avec succès!!");
        }

        $master = $Master[0];
        $user = $master->user; #RECUPERATION DU MASTER EN TANT QU'UN USER
        $rang = $user->rang;
        $profil = $user->profil;

        #renvoie des droits du user 
        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés

        if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
            $master['rights'] = User_Rights($rang->id, $profil->id);
        } else {
            $master['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
        }

        $parent = request()->user();
        $piece = Piece::find($Master[0]->type_piece);
        $Master['parent'] = $parent;
        $Master['piece'] = $piece;

        return self::sendResponse($master, "Master récupéré avec succès:!!");
    }

    static function _updateMaster($formData, $id)
    {
        $Master = Master::where(['id' => $id, 'owner' => request()->user()->id, 'visible' => true])->get();
        if (count($Master) == 0) {
            return self::sendError("Ce Master n'existe pas!", 404);
        };
        $Master = Master::find($id);
        $Master->update($formData);
        return self::sendResponse($Master, 'Ce Master a été modifié avec succès!');
    }

    static function masterDelete($id)
    {
        $Master = Master::where(['id' => $id, 'owner' => request()->user()->id, 'visible' => true])->get();
        if (count($Master) == 0) {
            return self::sendError("Ce Master n'existe pas!", 404);
        };

        $Master = Master::find($id);
        $Master->delete_at = now();
        $Master->visible = false;
        $Master->save();
        return self::sendResponse($Master, 'Ce Master a été supprimé avec succès!');
    }
}
