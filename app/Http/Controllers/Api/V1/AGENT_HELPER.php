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
            return self::sendError("Un compte existe déjà au nom de ce phone!", 404);
        }
        $user = User::where("email", $formData['email'])->get();
        if (count($user) != 0) {
            return self::sendError("Un compte existe déjà au nom de ce email!!", 404);
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
        $Agent['owner'] = $_user->id;
        if (Is_User_A_Master($_user->id)) { #Si c'est pas un master
            $Agent['master_id'] = $_user->master->id; #L'id du master
        } else {
            $Agent['admin'] = $_user->id;
        }
        $Agent->save();

        ####AFFECTATION DE L'AGENT A CE USER AU CAS OU LE USER EST UNE AGENCE
        $user = request()->user();
        if (Is_User_An_Agency($user->id)) {
            $agence = Agency::where(["user_id" => $user->id])->first();
            $Agent->agency_id = $agence->id;
            $Agent->affected = true;
            $Agent->save();
        };


        #=====ENVOIE DE MAIL =======~####
        // return $create_user;
        try {
            Send_Notification(
                $create_user,
                "Création de compte Agent",
                "Votre compte Agent a été crée avec succès sur DIGITAL NETWORKING. \n Voici ci-dessous vos identifiants de connexion: \n Username::" . $number . "; \n Password par defaut::" . $default_password,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
        // Send_Email(
        //     $formData['email'],
        //     "Création de compte Agent",
        //     "Votre compte Agent a été crée avec succès sur DIGITAL NETWORKING. Voici ci-dessous vos identifiants de connexion: Username::" . $number . "; Password par defaut::" . $default_password,
        // );
        // $sms_login =  Login_To_Frik_SMS();

        // if ($sms_login['status']) {
        //     $token =  $sms_login['data']['token'];

        //     Send_SMS(
        //         $formData['phone'],
        //         "Votre compte a été crée avec succès sur DIGITAL-NETWORK. Voici ci-dessous vos identifiants de connexion: Username::" . $number . "; Password par defaut::" . $default_password,
        //         $token
        //     );
        // }
        #=====FIN D'ENVOIE D'SMS =======~####

        return self::sendResponse($Agent, 'Agent crée avec succès!!');
    }

    static function allAgents()
    {
        $user = request()->user();

        if (Is_User_An_Agency($user->id)) {
            $my_agency = Agency::where(["user_id" => $user->id, "visible" => 1])->get();

            if (count($my_agency) != 0) {
                $my_agents = [];

                $my_agency = $my_agency[0];
                $my_agents = [];

                ##___GET DU AGENT_DAD
                $agent_dad = Agent::with(["master", "owner", "agency", "pos", "stores"])->find($my_agency->agent_dad);
                array_push($my_agents, $agent_dad);

                ##___GET DES AUTRES AGENTS EXISTANT DANS MES POS
                $all_my_poss = Pos::with(["owner", "agents", "agencie", "stores", "sold"])->where(["agency_id" => $my_agency->id])->get();
                ###___je parcoure les pos et je les recupere
                foreach ($all_my_poss as $all_my_pos) {
                    ###___je parcoure les agents des pos et je les recupere
                    foreach ($all_my_pos->agents as $posAgent) {
                        $pos_agent = Agent::with(["master", "owner", "agency", "pos", "stores"])->find($posAgent);
                        if ($pos_agent) {
                            array_push($my_agents, $pos_agent);
                        }
                    }
                }
                return self::sendResponse($my_agents, 'Tout les Agents récupérés avec succès!!');
            } else {
                return self::sendError("L'agence associée à ce compte n'existe pas!", 404);
            }
        } elseif ($user->admin) {
            $Agents =  Agent::with(["master", "owner", "agency", "pos", "stores"])->where(['visible' => 1])->orderBy("id", "desc")->get();
        } else {
            $Agents =  Agent::with(["master", "owner", "agency", "pos", "stores"])->where(["owner" => $user->id, 'visible' => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($Agents, 'Tout les Agents récupérés avec succès!!');
    }

    static function _retrieveAgent($id)
    {
        $user = request()->user();
        $agent = Agent::with(['master', "owner", "pos", "stores"])->where(['owner' => $user->id, 'visible' => 1])->find($id);
        if (!$agent) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        }
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
        $user = request()->user();

        $Agent = Agent::with(['master', "owner"])->where(["owner" => $user->id, "visible" => 1])->find($id);
        if (!$Agent) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };

        #####TRAITEMENT DES DATAS AVANT UPDATE ######
        if ($request->get("type_id")) {
            $agent_type = AgentType::where('id', $formData['type_id'])->get();
            if (count($agent_type) == 0) {
                return self::sendError("Ce type d'agent n'existe pas!", 404);
            }
        }

        $Agent->update($formData);
        return self::sendResponse($Agent, 'Ce Agent a été modifié avec succès!');
    }

    static function AgentDelete($id)
    {
        $user = request()->user();
        $Agent = Agent::where(['owner' => $user->id, 'visible' => true])->find($id);
        if (!$Agent) {
            return self::sendError("Ce Agent n'existe pas!", 404);
        };

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
        $user = request()->user();
        $agent = Agent::where(['owner' => $user->id, "visible" => 1])->find($formData['agent_id']);

        if (!$agent) {
            return  self::sendError("Ce Agent n'existe pas!!", 404);
        }

        if ($agent->pos_id) {
            return self::sendError("Ce agent est déjà affecté à un pos", 505);
        }

        ####AFFECTATION DE L'AGENT AU POS CE USER AU CAS OU LE USER EST UNE AGENCE
        if (Is_User_An_Agency($user->id)) {
            $agence = Agency::where(["user_id" => $user->id])->first();
            ##__tout les pos affectes à cette agence
            $agence_pos_all = Pos::where(['agency_id' => $agence->id, "visible" => 1])->get();
            // return $agence_pos_all;

            ###___verifions si le POS a ete affecte vraiment à cette agence            $is_this_pos_belong_to_this_agency = false;
            $is_this_pos_belong_to_this_agency = false;
            foreach ($agence_pos_all as $agence_pos) {
                if ($agence_pos->id == $formData['pos_id']) {
                    $is_this_pos_belong_to_this_agency = true;
                }
            };

            if ($is_this_pos_belong_to_this_agency) {
                $pos = Pos::where(['agency_id' => $agence->id, "visible" => 1])->find($formData['pos_id']);
            }
        } else { ###Quand il n'est pas une agence
            $pos = Pos::where(['owner' => $user->id, "visible" => 1])->find($formData['pos_id']);
        };

        if (!$pos) {
            return  self::sendError("Ce Pos n'existe pas!!", 404);
        }

        $agent->pos_id = $formData["pos_id"];
        $agent->affected = true;
        $agent->save();

        return self::sendResponse([], "Affectation effectuée avec succès!!");
    }

    function confirm_Pos_Amount($request)
    {
        $formData = $request->all();
        $user = request()->user();

        if ($request->amount == null) {
            return self::sendError("Veuillez préciser le montant existant sur votre POS!", 505);
        }
        if (!$request->pos_id) {
            return self::sendError("Veuillez préciser le POS en question!", 505);
        }

        $pos = Pos::find($formData["pos_id"]);
        if (!$pos) {
            return self::sendError("Ce Pos n'existe pas!", 404);
        }

        $current_agent = Agent::where(["user_id" => $user->id])->get();
        $current_agent = $current_agent[0];


        ###__LES AGENTS ASSOCIES A CE POS
        $posAgents = $pos->agents;

        if ($posAgents) {
            # code...
            ###__VERIFIONS SI CE AGENT FAIT PARTI DES AGENTS ASSOCIES AU POS
            foreach ($posAgents as $posAgent) {
                if ($posAgent->id == $current_agent->id) {
                    if ($pos->sold->amount != $formData["amount"]) {
                        return self::sendError("Ce montant ne corresponds pas à celui de votre POS", 404);
                    }
                    return self::sendResponse([], "Ce montant corresponds à celui de votre POS");
                }
            }
        }

        return self::sendError("Aucun agent n'est associé à ce POS!", 505);
    }
}
