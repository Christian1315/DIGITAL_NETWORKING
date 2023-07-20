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

        
        $userData = [
            "username" => $number,
            "firstname" => $formData['firstname'],
            "lastname" => $formData['lastname'],
            "phone" => $formData['phone'],
            "email" => $formData['email'],
            "password" => $number,
        ];
        
        $agent_type = AgentType::where('id', $formData['type_id'])->get();
        if (count($agent_type) == 0) {
            return self::sendError("Ce type d'agent n'existe pas!", 404);
        }

        ##VERIFIONS SI LE USER EXISTAIT DEJA
        $user = User::where("username", $number)->get();
        // return !count($user)===0;
        if (!count($user) ===0) {
            return self::sendError("Cet utilisateur existe déjà!", 404);
        } 
        
        $create_user = User::create($userData);#ENREGISTREMENT
        
        $formData['user_id'] = $create_user['id'];
        $formData['number'] = $number;
        
        #SON ENREGISTREMENT EN TANT QU'UN AGENT
        $Agent = Agent::create($formData); #ENREGISTREMENT DU Agent DANS LA DB
        
        $master = request()->user();
        $Agent['master'] = $master;
        return self::sendResponse($Agent, 'Agent crée avec succès!!');
    }

    static function allAgents()
    {
        $Agents =  Agent::with(["master"])->orderBy('id', 'desc')->get();
        return self::sendResponse($Agents, 'Tout les Agents récupérés avec succès!!');
    }

    static function _retrieveAgent($id)
    {
        $Agent_collec = Agent::with(['master'])->where('id', $id)->get();
        if ($Agent_collec->count() == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        }
        $Agent = $Agent_collec[0];
        return self::sendResponse($Agent, "Agent récupéré avec succès:!!");
    }

    static function _updateAgent($formData, $id)
    {
        $Agent = Agent::with(['users', "rights"])->where('id', $id)->get();
        if (count($Agent) == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };
        $Agent = Agent::with(['users', "rights"])->find($id);
        $Agent->update($formData);
        return self::sendResponse($Agent, 'Ce Agent a été modifié avec succès!');
    }

    static function AgentDelete($id)
    {
        $Agent = Agent::where('id', $id)->get();
        if (count($Agent) == 0) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };
        $Agent = Agent::with(['users', "rights"])->find($id);
        $Agent->delete();
        return self::sendResponse($Agent, 'Ce Agent a été supprimé avec succès!');
    }
}
