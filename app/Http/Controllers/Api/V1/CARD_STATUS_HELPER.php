<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CardStatus;

class CARD_STATUS_HELPER extends BASE_HELPER
{
    static function allCardStatus()
    {
        $card_status =  CardStatus::orderBy("id", "desc")->get();
        return self::sendResponse($card_status, 'Tout les status de carte récupérés avec succès!!');
    }

    static function _retrieveCardStatus($id)
    {
        $card_status = CardStatus::where('id', $id)->get();
        if ($card_status->count() == 0) {
            return self::sendError("Ce status de carte n'existe pas!", 404);
        }
        return self::sendResponse($card_status, "Status de Card récupéré avec succès:!!");
    }
}
