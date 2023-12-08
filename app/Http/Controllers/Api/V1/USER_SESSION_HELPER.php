<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Agent;
use App\Models\Pos;
use App\Models\StoreCommand;
use App\Models\StoreRapport;
use App\Models\UserSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

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

        ###___ON RECUPERE L'AGENCE DE CET AGENT
        $current_user = request()->user();

        $agent_attach_to_this_user = Agent::where(["user_id" => $current_user->id])->first();
        if (!$agent_attach_to_this_user) {
            return self::sendError("Le compte agent qui vous est associé n'existe plus!", 505);
        }
        $pos_of_this_agent = Pos::find($agent_attach_to_this_user->pos_id);
        $agency_of_this_pos = Agency::find($pos_of_this_agent->agency_id);

        $agency_of_this_agent = $agency_of_this_pos;
        if (!$agency_of_this_agent) {
            return self::sendError("L'agence auquelle vous êtes associée n'existe plus! Vous ne pouvez pas générer une facture.", 505);
        }


        $photoName = explode("pieces/", $agency_of_this_agent->photo)[1];
        $agency_of_this_agent_img = "data:image/png;base64," . base64_encode(file_get_contents("pieces/" . $photoName));


        ###____RECUPERATION DES COMMANDES DE LA SESSION
        $commands = StoreCommand::with(["products"])->where([
            "session" => $session->id,
            "owner" => $user->id,
        ])->get();


        ###___GESTION DES  RAPPORTS A LA FERMETURE
        ###___D'UNE SESSION

        $pdf = PDF::loadView('rapport', compact([
            "session",
            "agency_of_this_agent",
            "agency_of_this_agent_img",
            "commands",
        ]));

        $pdf->save(public_path("rapports/" . $session->id . ".pdf"));
        $facturepdf_path = asset("rapports/" . $session->id . ".pdf");

        ##__
        $rapport = new StoreRapport();
        $rapport->rapport = $facturepdf_path;
        $rapport->session = $session->id;
        $rapport->owner = $user->id;
        $rapport->save();

        ##__

        ##__DECONNEXION DE LA SESSION
        $session->active = 0;
        $session->save();
        ##____
        $session["rapport"] = $rapport->rapport;

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
