<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\StoreRapport;

class RAPPORT_HELPER extends BASE_HELPER
{

    static function allRapports()
    {
        $user = request()->user();
        $session = GetSession($user->id);
        if ($user->is_admin) {
            $rapports = StoreRapport::with(["owner", "this_session"])->orderBy("id", "desc")->get();
        } else {
            $rapports = StoreRapport::with(["owner", "this_session"])->where(["owner" => $user->id])->orderBy("id", "desc")->get();
        }

        return self::sendResponse($rapports, 'Tout les rapports récupérés avec succès!!');
    }

    static function _retrieveRaport($id)
    {
        $user = request()->user();
        $session = GetSession($user->id);
        if ($user->is_admin) {
            $rapport = StoreRapport::with(["owner", "this_session"])->find($id);
        } else {
            $rapport = StoreRapport::with(["owner", "this_session"])->where(["owner" => $user->id])->find($id);
        }
        return self::sendResponse($rapport, "Rapport récupéré avec succès:!!");
    }
}
