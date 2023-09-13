<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Agent;
use App\Models\AgentType;
use App\Models\Pos;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AGENT_HELPER extends BASE_HELPER
{
    ##======== Agent VALIDATION =======##
    static function Agent_rules(): array
    {
        return [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'phone' => ['required', Rule::unique("users")],
            'phone' => ['required', Rule::unique("agents")],
            'email' => ['required', 'email', Rule::unique("users")],
            'email' => ['required', 'email', Rule::unique("agents")],

            'sexe' => ['required'],
            'type_id' => ['required', 'integer'],
        ];
    }

    static function Agent_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Agent_Validator($formDatas)
    {
        $rules = self::Agent_rules();
        $messages = self::Agent_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createAgent($formData)
    {

        #SON ENREGISTREMENT EN TANT QU'UN USER
        $user = request()->user();
        $type = "AGT";

        $number =  Add_Number($user, $type); ##Add_Number est un helper qui genère le **number** 
        $default_password = $number . Custom_Timestamp();


        $agent_type = AgentType::where('id', $formData['type_id'])->get();
        if (count($agent_type) == 0) {
            return self::sendError("Ce type d'agent n'existe pas!", 404);
        }


        $userData = [
            "username" => $number,
            "firstname" => $formData['firstname'],
            "lastname" => $formData['lastname'],
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "password" => $default_password,
            "profil_id" => 7, #UN AGENT
            "rang_id" => 2, #UN MODERATEUR
        ];


        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();

        if (!count($user) === 0) {
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

        $create_user = User::create($userData); #ENREGISTREMENT
        $create_user->pass_default = $default_password;
        $create_user->owner = request()->user()->id;
        $create_user->save();


        $formData['user_id'] = $create_user['id'];
        $formData['number'] = $number;

        $_user =  request()->user();

        $agentData = [
            "firstname" => $formData['firstname'],
            "lastname" => $formData['lastname'],
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "sexe" => $formData['sexe'],
            "type_id" => $formData['type_id'],
            "user_id" => $formData['user_id'],
            "number" => $formData['number'],
        ];

        #SON ENREGISTREMENT EN TANT QU'UN AGENT
        $Agent = Agent::create($agentData); #ENREGISTREMENT DU Agent DANS LA DB
        $Agent['owner'] = request()->user()->id;
        if (Is_User_A_Master($_user->id)) { #Si c'est pas un master
            $Agent['master_id'] = request()->user()->master->id; #L'id du master
        } else {
            $Agent['admin'] = request()->user()->id;
        }
        $Agent->save();

        #~~===== ENVOIE D'SMS =======~####
        $sms_login =  Login_To_Frik_SMS();
        // return $sms_login;

        if ($sms_login['status']) {
            $token =  $sms_login['data']['token'];

            Send_SMS(
                $formData['phone'],
                "Votre compte a été crée avec succès sur DIGITAL-NETWORK. Voici ci-dessous vos identifiants de connexion: Username::" . $number . "; Password par defaut::" . $default_password,
                $token
            );
        }
        #=====FIN D'ENVOIE D'SMS =======~####

        return self::sendResponse($Agent, 'Agent crée avec succès!!');
    }

    static function allAgents()
    {
        $Agents =  Agent::with(["master", "owner", "agency", "pos", "stores"])->where(['owner' => request()->user()->id, 'visible' => 1])->orderBy("id", "desc")->get();
        return self::sendResponse($Agents, 'Tout les Agents récupérés avec succès!!');
    }

    static function _retrieveAgent($id)
    {
        $Agent_collec = Agent::with(['master', "owner", "pos", "stores"])->where(['id' => $id, 'owner' => request()->user()->id, 'visible' => 1])->get();
        if ($Agent_collec->count() == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        }
        $agent = $Agent_collec[0];
        $user = $agent->user; #RECUPERATION DU MASTER EN TANT QU'UN USER
        $rang = $user->rang;
        $profil = $user->profil;


        #renvoie des droits du user 
        $attached_rights = $user->drts; #drts represente les droits associés au user par relation #Les droits attachés
        // return $attached_rights;

        if ($attached_rights->count() == 0) { #si aucun droit ne lui est attaché
            $agent['rights'] = User_Rights($rang->id, $profil->id);
        } else {
            $agent['rights'] = $attached_rights; #Il prend uniquement les droits qui lui sont attachés
        }

        return self::sendResponse($agent, "Agent récupéré avec succès:!!");
    }

    static function _updateAgent($request, $id)
    {
        $formData = $request->all();
        $Agent = Agent::with(['master', "owner"])->where(['id' => $id, "owner" => request()->id, "visible" => 1])->get();
        if (count($Agent) == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };
        $Agent = Agent::with(['master', "owner"])->find($id);

        #####TRAITEMENT DES DATAS AVANT UPDATE ######
        if ($request->get("type_id")) {
            $agent_type = AgentType::where('id', $formData['type_id'])->get();
            if (count($agent_type) == 0) {
                return self::sendError("Ce type d'agent n'existe pas!", 404);
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

        $Agent->update($formData);
        return self::sendResponse($Agent, 'Ce Agent a été modifié avec succès!');
    }

    static function AgentDelete($id)
    {
        $Agent = Agent::where(['id' => $id, 'owner' => request()->user()->id, 'visible' => true])->get();
        if (count($Agent) == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };

        $Agent = Agent::find($id);
        $Agent->delete_at = now();
        $Agent->visible = false;
        $Agent->save();
        return self::sendResponse($Agent, 'Ce Agent a été supprimé avec succès!');
    }

    static function _AffectToAgency($formData)
    {

        $agent = Agent::where(['owner' => request()->user()->id, 'id' => $formData['agent_id'], "visible" => 1])->get();
        $agency = Agency::where(['owner' => request()->user()->id, 'id' => $formData['agency_id'], "visible" => 1])->get();

        if ($agent->count() == 0) {
            return  self::sendError("Ce Agent n'existe pas!!", 404);
        }

        if ($agency->count() == 0) {
            return  self::sendError("Cette Agence n'existe pas!!", 404);
        }

        $agent = Agent::find($formData["agent_id"]);
        // return $agent;
        $agent->agency_id = $formData["agency_id"];
        $agent->affected = true;

        $agent->save();

        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }

    static function _AffectToPos($formData)
    {

        // return $formData;
        $agent = Agent::where(['owner' => request()->user()->id, 'id' => $formData['agent_id'], "visible" => 1])->get();
        $pos = Pos::where(['owner' => request()->user()->id, 'id' => $formData['pos_id'], "visible" => 1])->get();

        if ($agent->count() == 0) {
            return  self::sendError("Ce Agent n'existe pas!!", 404);
        }

        if ($pos->count() == 0) {
            return  self::sendError("Ce Pos n'existe pas!!", 404);
        }

        $agent = Agent::find($formData["agent_id"]);
        $agent->pos_id = $formData["pos_id"];
        $agent->affected = true;

        $agent->save();

        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }
}
