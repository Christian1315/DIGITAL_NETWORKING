<?php

namespace App\Http\Controllers\Api\V1;

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
        $label = "AGT";
        $number =  Master_Add_Number($user, $label); ##Get_Number est un helper qui genère le **number**

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

        $master =  request()->user()->master;
        $agentData = [
            "firstname" => $formData['firstname'],
            "lastname" => $formData['lastname'],
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "sexe" => $formData['sexe'], 
            "type_id" => $formData['type_id'], 
            "user_id" => $formData['user_id'], 
            "number" => $formData['number'], 
            "master_id" => $master->id, 
        ];
        #SON ENREGISTREMENT EN TANT QU'UN AGENT
        $Agent = Agent::create($agentData); #ENREGISTREMENT DU Agent DANS LA DB
        $Agent['owner'] = request()->user()->id;
        $Agent->save();
        return self::sendResponse($Agent, 'Agent crée avec succès!!');
    }

    static function allAgents()
    {
        $Agents =  Agent::with(["master","owner"])->where(['owner'=>request()->user()->id])->get();
        return self::sendResponse($Agents, 'Tout les Agents récupérés avec succès!!');
    }

    static function _retrieveAgent($id)
    {
        $Agent_collec = Agent::with(['master',"owner"])->where(['id' => $id, 'owner' => request()->user()->id])->get();
        if ($Agent_collec->count() == 0) {
            return self::sendResponse($Agent_collec, "Master recupere avec succès!!");
        }
        $agent = $Agent_collec[0];
        $user = $agent->user;#RECUPERATION DU MASTER EN TANT QU'UN USER
        $rang = $user->rang;
        $profil = $user->profil;

        #renvoie des droits du user 
        $agent['rights'] = User_Rights($rang->id, $profil->id);

        return self::sendResponse($agent, "Agent récupéré avec succès:!!");
    }

    static function _updateAgent($formData, $id)
    {
        $Agent = Agent::with(['master', "owner"])->where('id', $id)->get();
        if (count($Agent) == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };
        $Agent = Agent::with(['master', "owner"])->find($id);
        $Agent->update($formData);
        return self::sendResponse($Agent, 'Ce Agent a été modifié avec succès!');
    }

    static function AgentDelete($id)
    {
        $Agent = Agent::where('id', $id)->get();
        if (count($Agent) == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };
        $Agent = Agent::with(['master', "owner"])->find($id);
        $Agent->delete();
        return self::sendResponse($Agent, 'Ce Agent a été supprimé avec succès!');
    }
}
