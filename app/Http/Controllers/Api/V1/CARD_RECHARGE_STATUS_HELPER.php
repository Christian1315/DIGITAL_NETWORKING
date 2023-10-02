<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CardRechargeStatus;

class CARD_RECHARGE_STATUS_HELPER extends BASE_HELPER
{
    static function allCardRechargeStatus()
    {
        $card_recharge_status =  CardRechargeStatus::orderBy("id", "desc")->get();
        return self::sendResponse($card_recharge_status, 'Tout les status de rechargement de carte récupérés avec succès!!');
    }

    static function _retrieveCardRechargeStatus($id)
    {
        $card_recharge_status = CardRechargeStatus::where('id', $id)->get();
        if ($card_recharge_status->count() == 0) {
            return self::sendError("Ce status de rechargement de carte n'existe pas!", 404);
        }
        return self::sendResponse($card_recharge_status, "Status de rechargement de Carte récupéré avec succès:!!");
    }
}
