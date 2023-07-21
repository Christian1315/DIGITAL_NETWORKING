<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ActivityDomain;
use App\Models\Agency;
use App\Models\AgencyType;
use App\Models\Piece;
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
        $formData = $request->all();
        $agency_type = AgencyType::where('id', $formData['type_id'])->get();
        if (count($agency_type) == 0) {
            return self::sendError("Ce type d'agence n'existe pas!", 404);
        }
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
        $label = "AGC";

        $number =  Master_Add_Number($user, $label); ##Get_Number est un helper qui genère le **number** 

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();
        if (count($user) != 0) {
            return self::sendError("Cet utilisateur existe déjà!", 404);
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
            "password" => $number,
            "profil_id" => 5, #UNE AGENCE
            "rang_id" => 2, #UN MODERATEUR
        ];
        $user = User::create($userData);
        $formData['user_id'] = $user['id'];
        $formData['number'] = $number;


        $master =  request()->user()->master;
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
            "master_id" => $master->id,
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

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE **MASTERS**
        $agencyData["ifu_file"] = asset("pieces/" . $ifu_name);
        $agencyData["rccm_file"] = asset("pieces/" . $rccm_name);
        $agencyData["piece_file"] = asset("pieces/" . $piece_name);
        $agencyData["photo"] = asset("pieces/" . $photo_name);


        $agency = Agency::create($agencyData); #ENREGISTREMENT DE L'AGENCE DANS LA DB
        $agency['owner'] = request()->user()->id;
        $agency->save();
        $agency['domaine_activite'] = $domaine_activite;
        return self::sendResponse($agency, 'Agence crée avec succès!!');
    }

    static function allAgencys()
    {
        $Agencys =  Agency::with(["master", "owner"])->where(['owner' => request()->user()->id])->get();
        return self::sendResponse($Agencys, 'Tout les Agences récupérés avec succès!!');
    }

    static function _retrieveAgency($id)
    {
        $agency = Agency::with(["master", "owner"])->where(['id' => $id, 'owner' => request()->user()->id])->get();
        if ($agency->count() == 0) {
            return self::sendResponse($agency, "Master recupere avec succès!!");
        }

        $agency = $agency[0];
        $user = $agency->user; #RECUPERATION DU MASTER EN TANT QU'UN USER
        $rang = $user->rang;
        $profil = $user->profil;
        // return $rang;
        #renvoie des droits du user 
        $agency['rights'] = User_Rights($rang->id, $profil->id);
        // return $agency;
        $parent = request()->user();
        $piece = Piece::find($agency->type_piece);
        $agency['parent'] = $parent;
        $agency['piece'] = $piece;


        return self::sendResponse($agency, "Agence récupéré avec succès:!!");
    }

    static function _updateAgent($formData, $id)
    {
        $AGENCY = Agency::with(['master', "owner"])->where('id', $id)->get();
        if (count($AGENCY) == 0) {
            return self::sendError("Ce AGENCY n'existe pas!", 404);
        };
        $AGENCY = Agency::with(['master', "owner"])->find($id);
        $AGENCY->update($formData);
        return self::sendResponse($AGENCY, 'Ce AGENCY a été modifié avec succès!');
    }

    static function AgencyDelete($id)
    {
        $AGENCY = Agency::where('id', $id)->get();
        if (count($AGENCY) == 0) {
            return self::sendError("Ce AGENCY n'existe pas!", 404);
        };
        $AGENCY = Agency::with(['master', "owner"])->find($id);
        $AGENCY->delete();
        return self::sendResponse($AGENCY, 'Ce AGENCY a été supprimé avec succès!');
    }
}
