<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\Pos;
use App\Models\UserSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class USER_SESSION_HELPER extends BASE_HELPER
{
    ##======== SESSION VALIDATION =======##

    static function session_rules(): array
    {
        return [
            'pos' => ['required', 'integer'],
            // 'price' => ['required'],
            // 'img' => ['required'],
            // 'description' => ['required'],
            // 'category' => ['required', "integer"],
            // 'store' => ['required', "integer"],
            // 'active' => ['required', "integer"],
        ];
    }

    static function session_messages(): array
    {
        return [
            'pos.required' => 'Le champ Pos est réquis!',
            'pos.integer' => 'Le pos est numeric!',
            // 'active.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Session_Validator($formDatas)
    {
        $rules = self::session_rules();
        $messages = self::session_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createSession($request)
    {
        $formData = $request->all();
        $user = request()->user();

        ##__
        $agent = Agent::where(["user_id" => $user->id])->first();
        if (!$agent) {
            return self::sendError("L'agent auquel vous êtes associé n'existe plus!", 404);
        }

        ###___
        $agent_pos_id = null; ###___LE POS DE L'AGENT
        $poss = Pos::all();
        foreach ($poss as $pos) {
            if ($agent->pos_id == $pos->id) {
                $agent_pos_id = $pos->id; ###___QUAND L'AGENT APPARTIENT A UN POS
                ###___ON RECUPERE LE POS DE L'AGENT
            }
        }
        if (!$agent_pos_id) {
            return self::sendError("Vous n'avez pas été affecté.e à un Pos!", 404);
        }

        ##___
        if (CheckIfUserHasAnActiveSession($user->id)) {
            return self::sendError("Vous avez déjà une section active! Veuillez vous en déconnecter avant d'initier une autre!", 505);
        }

        ##____VERIFIONS S'IL Y A UNE SESSION ACTIVE DANS SON POS
        if (CheckIfAgentPosHasASessionActivated($agent_pos_id)) {
            return self::sendError("Une session est déjà active dans votre POS! Veuillez attendre que celle-ci soit d'abord désactivée!", 505);
        }

        ####_____
        $session = new UserSession();
        $session->user = $user->id;
        $session->ip = Str::uuid();
        $session->begin_date = now();
        $session->pos = $agent_pos_id;
        $session->active = true;
        $session->save();

        #=====ENVOIE DE L'IP DE LA SESSION AU USER PAR SMS =======~####
        try {
            Send_Notification(
                $user,
                "INITIATION DE SESSION SUR DIGITAL NETWORK",
                "Votre session a été inité avec succès. Voici son IP::" . $session->ip,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }

        return self::sendResponse($session, 'Session crée avec succès!!');
    }

    static function _retrieveSession($id)
    {
        $session = UserSession::with(['user'])->where(["id" => $id, "user" => request()->user()->id])->get();
        if ($session->count() == 0) {
            return self::sendError("Cette Session n'existe pas!", 404);
        }
        return self::sendResponse($session, "Session récupéré avec succès:!!");
    }

    static function sessionDelete($id)
    {
        $session = UserSession::where(["id" => $id, "user" => request()->user()->id])->get();
        if (count($session) == 0) {
            return self::sendError("Cette Session n'existe pas!", 404);
        };
        $session = UserSession::find($id);
        $session->delete();
        return self::sendResponse($session, 'Cette Session a été supprimée avec succès!');
    }

    static function sessionDeconnexion($request)
    {
        $user =  request()->user();
        $session = GetSession($user->id);
        if (!$session) {
            return self::sendError("Session non active, ou inexistante", 404);
        }


        // if (!$request->session_ip) {
        //     return self::sendError("Le champ session_ip est réquis!", 404);
        // }
        // $user_session = UserSession::where(["user" => $user->id, "ip" => $request->session_ip])->get();
        // if (count($user_session) == 0) {
        //     return self::sendError("Cette Session n'existe pas!", 404);
        // };

        // if (!$session->active) {
        //     return self::sendError("Cette session est déjà deconnectée!", 505);
        // }
        $session->active = 0;
        $session->save();
        return self::sendResponse($session, 'Déconnexion éffectuée avec succès!');
    }

    static function sessionLogin($request)
    {
        if (!$request->session_ip) {
            return self::sendError("Le champ session_ip est réquis!", 404);
        }
        #QUAND L'UTILISATEUR DISPOSE DEJA D'UNE SESSION OUVERTE
        #IL DOIT D'ABORD S'EN DECONNECTER 
        #AVANT DE SE CONNECTER A CELLE-CI
        $userId =  $request->user()->id;

        $user_session_ip = $request->session_ip;
        $user_session = UserSession::where(["user" => $userId, "ip" => $user_session_ip])->get();
        if (count($user_session) == 0) {
            return self::sendError("La Session auquelle vous voulez vous deconnecter n'existe pas!", 404);
        };

        ##__
        $agent = Agent::where(["user_id" => $userId])->first();
        if (!$agent) {
            return self::sendError("L'agent auquel vous êtes associé n'existe plus!", 404);
        }

        ###___
        if (CheckIfUserHasAnActiveSession($userId)) {
            return self::sendError("Vous avez déjà une section active! Veuillez vous en déconnecter avant de vous connecter à celle-ci!", 201);
        }
 
        ###___BLOCAGE DE CONNEXION A LA SESSION TANT QU'UNE AUTRE SESSION EST ACTIVE DANS LE POS DE L'AGENT
        $agent_pos_id = null; ###___LE POS DE L'AGENT
        $poss = Pos::all();
        foreach ($poss as $pos) {
            if ($agent->pos_id == $pos->id) {
                $agent_pos_id = $pos->id; ###___QUAND L'AGENT APPARTIENT A UN POS
                ###___ON RECUPERE LE POS DE L'AGENT
            }
        }

        ##____VERIFIONS S'IL Y A UNE SESSION ACTIVE DANS SON POS
        if (CheckIfAgentPosHasASessionActivated($agent_pos_id)) {
            return self::sendError("Une session est déjà active dans votre POS! Veuillez attendre que celle-ci soit d'abord désactivée!", 505);
        }

        ###___
        $user_session = $user_session[0];
        $user_session->active = 1;
        $user_session->save();
        return self::sendResponse($user_session, 'Connexion éffectuée avec succès!');
    }
}
