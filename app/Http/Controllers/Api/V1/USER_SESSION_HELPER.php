<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class USER_SESSION_HELPER extends BASE_HELPER
{
    ##======== SESSION VALIDATION =======##

    static function session_rules(): array
    {
        return [
            // 'name' => ['required'],
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
            // 'name.required' => 'Le champ name est réquis!',
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

    static function _createSession()
    {
        $user = request()->user();
        if (CheckIfUserHasAnActiveSession($user->id)) {
            return self::sendError("Vous avez déjà une section active! Veuillez vous en déconnecter avant d'initier une autre!", 505);
        }
        // $user_session_all = UserSession::where(["user" => $user->id, "active" => 1])->get();
        // #DESACTIVATION DE TOUTES LES PRECEDENTES SECTION DU USER
        // foreach ($user_session_all as $user_session) {
        //     $user_session->active = 0;
        //     $user_session->save();
        // }

        ###___BLOCAGE DE L'INITIATION DE LA SESSION TANT QU'UNE AUTRE SESSION EST ACTIVE
        $all_active_session = UserSession::where(["active" => 1])->get();
        if ($all_active_session->count() != 0) {
            return self::sendError("Une session est active! Veuillez patienter que cette dernière soit d'abord desactivée!", 201);
        }

        ####_____
        $session = new UserSession();
        $session->user = $user->id;
        $session->ip = Str::uuid();
        $session->begin_date = now();
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
        // Send_Email(
        //     $user->email,
        //     "Votre session a été initiée!",
        //     "Votre session a été inité avec succès. Voici son IP::" . $session->ip,
        // );

        // $sms_login =  Login_To_Frik_SMS();

        // if ($sms_login['status']) {
        //     $token =  $sms_login['data']['token'];

        //     Send_SMS(
        //         $user_phone,
        //         "Votre session a été crée avec succès. Voici son IP::" . $session->ip,
        //         $token
        //     );
        // }
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
        if (!$request->session_ip) {
            return self::sendError("Le champ session_ip est réquis!", 404);
        }
        $userId =  $request->user()->id;
        $user_session = UserSession::where(["user" => $userId, "ip" => $request->session_ip])->get();
        if (count($user_session) == 0) {
            return self::sendError("Cette Session n'existe pas!", 404);
        };
        $user_session = $user_session[0];

        if (!$user_session->active) {
            return self::sendError("Cette session est déjà deconnectée!", 505);
        }
        $user_session->active = 0;
        $user_session->save();
        return self::sendResponse($user_session, 'Déconnexion éffectuée avec succès!');
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
        if (CheckIfUserHasAnActiveSession($userId)) {
            return self::sendError("Vous avez déjà une section active! Veuillez vous en déconnecter avant de vous connecter à celle-ci!", 201);
        }
        ##

        ###___BLOCAGE DE CONNEXION A LA SESSION TANT QU'UNE AUTRE SESSION EST ACTIVE
        $all_active_session = UserSession::where(["active" => 1])->get();
        if ($all_active_session->count() != 0) {
            return self::sendError("Une session est active! Veuillez patienter que cette dernière soit d'abord desactivée!", 201);
        }


        $user_session_ip = $request->session_ip;
        $user_session = UserSession::where(["user" => $userId, "ip" => $user_session_ip])->get();
        if (count($user_session) == 0) {
            return self::sendError("Cette Session n'existe pas!", 404);
        };
        $user_session = $user_session[0];
        $user_session->active = 1;
        $user_session->save();
        return self::sendResponse($user_session, 'Connexion éffectuée avec succès!');
    }
}
