<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ActivityDomain;
use App\Models\Agency;
use App\Models\AgencyType;
use App\Models\Agent;
use App\Models\Piece;
use App\Models\Sold;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AGENCY_HELPER extends BASE_HELPER
{
    ##======== AGENCY VALIDATION =======##

    static function Agency_rules(): array
    {
        return [
            'name' => ['required'],
            'ifu' => ['required'],
            'ifu_file' => ['required'],
            'rccm' => ['required'],
            'rccm_file' => ['required'],
            'phone' => ['required', Rule::unique("users")],
            'phone' => ['required', Rule::unique("agencies")],

            'email' => ['required', 'email', Rule::unique("users")],
            'email' => ['required', 'email', Rule::unique("agencies")],
            'numero_piece' => ['required'],
            'type_piece' => ['required', 'integer'],
            'piece_file' => ['required'],
            'domaine_activite' => ['required', 'integer'],
            'photo' => ['required'],
            'comment' => ['required'],
            'type_id' => ['required', 'integer'],
            'agent_dad' => ['required', 'integer'],
        ];
    }

    static function Agency_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Agency_Validator($formDatas)
    {
        $rules = self::Agency_rules();
        $messages = self::Agency_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createAgency($request)
    {
        $user = request()->user();
        $formData = $request->all();
        $agency_type = AgencyType::where('id', $formData['type_id'])->get();
        if (count($agency_type) == 0) {
            return self::sendError("Ce type d'agence n'existe pas!", 404);
        }
        #SON ENREGISTREMENT EN TANT QU'UN USER
        $piece_type = Piece::where('id', $formData['type_piece'])->get();
        $domaine_activite = ActivityDomain::where('id', $formData['domaine_activite'])->get();
        $agent_dad = Agent::where(['id' => $formData['agent_dad'], "owner" => $user->id])->get();


        if (count($domaine_activite) == 0) {
            return self::sendError("Ce domaine d'activité n'existe pas!!", 404);
        }

        if (count($piece_type) == 0) {
            return self::sendError("Ce type de piece n'existe pas!!", 404);
        }

        if (count($agent_dad) == 0) {
            return self::sendError("Ce Agent n'existe pas!!", 404);
        }

        $user = request()->user();
        $type = "AGY";

        $number =  Add_Number($user, $type); ##Add_Number est un helper qui genère le **number** 
        $default_password = $number . Custom_Timestamp();

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();
        if (count($user) != 0) {
            return self::sendError("Cet utilisateur existe déjà!", 404);
        }

        $user = User::where("phone", $formData['phone'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce phone!", 404);
        }
        $user = User::where("email", $formData['email'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce mail!!", 404);
        }


        $userData = [
            "username" => $number,
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "password" => $default_password,
            "profil_id" => 5, #UNE AGENCE
            "rang_id" => 2, #UN MODERATEUR
        ];
        $user = User::create($userData);
        $user->pass_default = $default_password;
        $user->owner = request()->user()->id;
        $user->save();
        $formData['user_id'] = $user['id'];
        $formData['number'] = $number;


        $agencyData = [
            "number" => $formData['number'],
            "name" => $formData['name'],
            "ifu" => $formData['ifu'],
            "ifu_file" => $formData['ifu_file'],
            "rccm" => $formData['rccm'],
            "rccm_file" => $formData['rccm_file'],
            "country" => $formData['country'],
            "commune" => $formData['commune'],
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "numero_piece" => $formData['numero_piece'],
            "piece_file" => $formData['piece_file'],
            "photo" => $formData['photo'],
            "comment" => $formData['comment'],
            "comment" => $formData['comment'],
            "domaine_activite" => $formData['domaine_activite'],
            "type_piece" => $formData['type_piece'],
            "user_id" => $formData['user_id'],
            "agent_dad" => $formData['agent_dad'],
            "type_id" => $formData['type_id'],
        ];

        #SON ENREGISTREMENT EN TANT QU'UNE AGENCE
        ##GESTION DES FICHIERS
        $ifu_file = $request->file('ifu_file');
        $rccm_file = $request->file('rccm_file');
        $piece_file = $request->file('piece_file');
        $photo = $request->file('photo');


        $ifu_name = $ifu_file->getClientOriginalName();
        $rccm_name = $rccm_file->getClientOriginalName();
        $piece_name = $piece_file->getClientOriginalName();
        $photo_name = $photo->getClientOriginalName();


        $request->file('ifu_file')->move("pieces", $ifu_name);
        $request->file('rccm_file')->move("pieces", $rccm_name);
        $request->file('piece_file')->move("pieces", $piece_name);
        $request->file('photo')->move("pieces", $photo_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
        $agencyData["ifu_file"] = asset("pieces/" . $ifu_name);
        $agencyData["rccm_file"] = asset("pieces/" . $rccm_name);
        $agencyData["piece_file"] = asset("pieces/" . $piece_name);
        $agencyData["photo"] = asset("pieces/" . $photo_name);


        $agency = Agency::create($agencyData); #ENREGISTREMENT DE L'AGENCE DANS LA DB
        $agency['owner'] = request()->user()->id;

        if (Is_User_A_Master($user->id)) { #Si c'est pas un master
            $agency['master_id'] = request()->user()->master;
        } else {
            $agency['admin'] = request()->user()->id;
        }
        $agency->save();
        $agency['domaine_activite'] = $domaine_activite;


        ### CREATION DU SOLDE DU USER
        $solde = new Sold();
        $solde->agency = $agency->id;
        $solde->owner = $user->id;
        $solde->save();

        #=====ENVOIE D'SMS =======~####
        Send_Email(
            $formData['email'],
            "Création de compte Agence",
            "Votre compte Agence a été crée avec succès sur DIGITAL NETWORKING. Voici ci-dessous vos identifiants de connexion: Username::" . $number . "; Password par defaut::" . $default_password,
        );

        // $sms_login =  Login_To_Frik_SMS();

        // if ($sms_login['status']) {
        //     $token =  $sms_login['data']['token'];

        //     Send_SMS(
        //         $formData['phone'],
        //         "Votre compte a été crée avec succès sur JNP Store. Voici ci-dessous vos identifiants de connexion: Username::" . $number . "; Password par defaut::" . $default_password,
        //         $token
        //     );
        // }
        #=====FIN D'ENVOIE D'SMS =======~####

        return self::sendResponse($agency, 'Agence crée avec succès!!');
    }

    static function allAgencys()
    {
        $Agencys =  Agency::with(["master", "owner", "agents", "poss", "stores"])->where(['owner' => request()->user()->id, "visible" => 1])->get();

        foreach ($Agencys as $agency) {
            $agent_dad_id =  $agency->agent_dad;
            $agent_dad = Agent_Dad($agent_dad_id);
            $agency["agent_dad"] = $agent_dad;
        }
        return self::sendResponse($Agencys, 'Tout les Agences récupérés avec succès!!');
    }

    static function _retrieveAgency($id)
    {
        $agency = Agency::with(["master", "owner", "agents", "poss", "stores"])->where(['id' => $id, 'owner' => request()->user()->id])->get();
        if ($agency->count() == 0) {
            return self::sendResponse($agency, "Agences recupere avec succès!!");
        }

        $agency = $agency[0];
        $user = $agency->user; #RECUPERATION DU MASTER EN TANT QU'UN USER
        $rang = $user->rang;
        $profil = $user->profil;

        $agent_dad_id =  $agency->agent_dad;
        $agent_dad = Agent_Dad($agent_dad_id);

        $agency["agent_dad"] = $agent_dad;


        #renvoie des droits du user 
        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés

        if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
            $agency['rights'] = User_Rights($rang->id, $profil->id);
        } else {
            $agency['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
        }

        $piece = Piece::find($agency->type_piece);
        $agency['piece'] = $piece;
        return self::sendResponse($agency, "Agence récupéré avec succès:!!");
    }

    static function _updateAgency($request, $id)
    {
        $AGENCY = Agency::with(['master', "owner", "agents"])->where(['id' => $id, "owner" => request()->id, "visible" => 1])->get();
        if (count($AGENCY) == 0) {
            return self::sendError("Ce AGENCY n'existe pas!", 404);
        };

        $formData = $request->all();

        $AGENCY = Agency::with(['master', "owner"])->find($id);

        #####TRAITEMENT DES DATAS AVANT UPDATE ######
        if ($request->get("type_id")) {
            $agency_type = AgencyType::where('id', $formData['type_id'])->get();
            if (count($agency_type) == 0) {
                return self::sendError("Ce type d'agence n'existe pas!", 404);
            }
        }

        if ($request->get("type_piece")) {
            $piece_type = Piece::where('id', $formData['type_piece'])->get();
            if (count($piece_type) == 0) {
                return self::sendError("Ce type de piece n'existe pas!!", 404);
            }
        }

        if ($request->get("domaine_activite")) {
            $domaine_activite = ActivityDomain::where('id', $formData['domaine_activite'])->get();
            if (count($domaine_activite) == 0) {
                return self::sendError("Ce domaine d'activité n'existe pas!!", 404);
            }
        }

        if ($request->get("agent_dad")) {
            $agent_dad = Agent::where('id', $formData['agent_dad'])->get();

            if (count($agent_dad) == 0) {
                return self::sendError("Ce Agent n'existe pas!!", 404);
            }
        }

        if ($request->get("phone")) {
            $phone = User::where('phone', $formData['phone'])->get();

            if (!count($phone) == 0) {
                return self::sendError("Ce phone existe déjà!!", 404);
            }
        }

        if ($request->get("email")) {
            $email = User::where('email', $formData['email'])->get();

            if (!count($email) == 0) {
                return self::sendError("Ce email existe déjà!!", 404);
            }
        }

        ##GESTION DES FICHIERS
        if ($request->file("ifu_file")) {
            $ifu_file = $request->file('ifu_file');
            $ifu_name = $ifu_file->getClientOriginalName();
            $request->file('ifu_file')->move("pieces", $ifu_name);
            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["ifu_file"] = asset("pieces/" . $ifu_name);
        }
        if ($request->file("rccm_file")) {
            $rccm_file = $request->file('rccm_file');

            $rccm_name = $rccm_file->getClientOriginalName();
            $request->file('rccm_file')->move("pieces", $rccm_name);
            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["rccm_file"] = asset("pieces/" . $rccm_name);
        }

        if ($request->file("piece_file")) {
            $piece_file = $request->file('piece_file');
            $piece_name = $piece_file->getClientOriginalName();
            $request->file('piece_file')->move("pieces", $piece_name);

            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["piece_file"] = asset("pieces/" . $piece_name);
        }

        if ($request->file("photo")) {
            $photo = $request->file('photo');

            $photo_name = $photo->getClientOriginalName();
            $request->file('photo')->move("pieces", $photo_name);

            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["photo"] = asset("pieces/" . $photo_name);
        }

        $AGENCY->update($formData);
        return self::sendResponse($AGENCY, 'Ce AGENCY a été modifié avec succès!');
    }

    static function AgencyDelete($id)
    {
        $Agence = Agency::where(['id' => $id, 'owner' => request()->user()->id, 'visible' => true])->get();
        if (count($Agence) == 0) {
            return self::sendError("Cette Agence n'existe pas!", 404);
        };

        $Agence = Agency::find($id);
        $Agence->delete_at = now();
        $Agence->visible = false;
        $Agence->save();
        return self::sendResponse($Agence, 'Cette Agence a été supprimé avec succès!');
    }
}
