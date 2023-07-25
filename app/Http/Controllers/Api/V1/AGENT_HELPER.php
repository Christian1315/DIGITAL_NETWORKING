<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Agent;
use App\Models\AgentType;
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
            "password" => $number,
            "profil_id" => 7, #UN AGENT
            "rang_id" => 2, #UN MODERATEUR
        ];


        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();
        // return !count($user)===0;
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

        $formData['user_id'] = $create_user['id'];
        $formData['number'] = $number;

        $_user =  request()->user();
        // return $_user;
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
            $Agent['master_id'] = request()->user()->master;
        } else {
            $Agent['admin'] = request()->user()->id;
        }
        $Agent->save();

        return self::sendResponse($Agent, 'Agent crée avec succès!!');
    }

    static function allAgents()
    {
        $Agents =  Agent::with(["master", "owner","agency"])->where(['owner' => request()->user()->id,'visible'=>1])->get();
        return self::sendResponse($Agents, 'Tout les Agents récupérés avec succès!!');
    }

    static function _retrieveAgent($id)
    {
        $Agent_collec = Agent::with(['master', "owner"])->where(['id' => $id, 'owner' => request()->user()->id,'visible'=>1])->get();
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

    static function _updateAgent($formData, $id)
    {
        $Agent = Agent::with(['master', "owner"])->where(['id'=> $id,"owner"=>request()->id,"visible"=>1])->get();
        if (count($Agent) == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };
        $Agent = Agent::with(['master', "owner"])->find($id);
        $Agent->update($formData);
        return self::sendResponse($Agent, 'Ce Agent a été modifié avec succès!');
    }

    static function AgentDelete($id)
    {
        $Agent = Agent::where(['id'=> $id,'owner' => request()->user()->id,'visible'=> true])->get();
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

        $agent = Agent::where(['id'=>$formData['agent_id'],"visible"=>1])->get();
        $agency = Agency::where(['id'=>$formData['agency_id'],"visible"=>1])->get();

        if ($agent->count()==0) {
            return  self::sendError("Ce Agent n'existe pas!!",404);
        }

        if ($agency->count()==0) {
            return  self::sendError("Cette Agence n'existe pas!!",404);
        }

        $agent = Agent::find($formData["agent_id"]);
        // return $agent;
        $agent->agency_id = $formData["agency_id"]; 
        $agent->save();

        return self::sendResponse([],"Affectation effectuée avec succès!!");
    }
}
