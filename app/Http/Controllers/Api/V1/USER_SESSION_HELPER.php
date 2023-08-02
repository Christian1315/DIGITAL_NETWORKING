<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\StoreProduit;
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
        $session = new UserSession();
        $session->user = request()->user()->id;
        $session->ip = Str::uuid();
        $session->begin_date = now();
        $session->active = true;
        $session->save();
        return self::sendResponse($session, 'Session crée avec succès!!');
    }

    static function _retrieveSession($id)
    {
        $product = StoreProduit::with(['owner', "store"])->where(["id" => $id, "owner" => request()->user()->id])->get();
        if ($product->count() == 0) {
            return self::sendError("Ce Product n'existe pas!", 404);
        }
        return self::sendResponse($product, "Produit récupéré avec succès:!!");
    }

    static function sessionDelete($id)
    {
        $product = StoreProduit::where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if (count($product) == 0) {
            return self::sendError("Ce Produit n'existe pas!", 404);
        };
        $product = StoreProduit::find($id);
        $product->visible = 0;
        $product->delete_at = now();
        $product->save();
        return self::sendResponse($product, 'Ce Produit a été supprimé avec succès!');
    }

    static function sessionDeconnexion($request)
    {
        $userId =  $request->user()->id;
        $user_session = UserSession::where(["user" => $userId])->get();
        if (count($user_session) == 0) {
            return self::sendError("Cette Session n'existe pas!", 404);
        };
        $user_session = UserSession::find($userId);
        $user_session->active = 0;
        $user_session->save();
        return self::sendResponse($user_session, 'Déconnexion éffectuée avec succès!');
    }

    static function sessionLogin($request)
    {
        $userId =  $request->user()->id;
        $user_session = UserSession::where(["user" => $userId])->get();
        if (count($user_session) == 0) {
            return self::sendError("Cette Session n'existe pas!", 404);
        };
        $user_session = UserSession::find($userId);
        $user_session->active = 1;
        $user_session->save();
        return self::sendResponse($user_session, 'Connexion éffectuée avec succès!');
    }
}
