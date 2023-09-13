<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CardType;

class CARD_TYPE_HELPER extends BASE_HELPER
{
    static function allCardType()
    {
        $card_Type =  CardType::orderBy("id", "desc")->get();
        return self::sendResponse($card_Type, 'Tout les Type de carte récupérés avec succès!!');
    }

    static function _retrieveCardType($id)
    {
        $card_Type = CardType::where('id', $id)->get();
        if ($card_Type->count() == 0) {
            return self::sendError("Ce Type de carte n'existe pas!", 404);
        }
        return self::sendResponse($card_Type, "Type de Card récupéré avec succès:!!");
    }
}
