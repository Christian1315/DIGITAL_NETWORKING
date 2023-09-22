<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SoldStatus;

class SOLD_STATUS_HELPER extends BASE_HELPER
{
    static function allSoldStatus()
    {
        $Sold_status =  SoldStatus::orderBy("id", "desc")->get();
        return self::sendResponse($Sold_status, 'Tout les status de solde récupérés avec succès!!');
    }

    static function _retrieveSoldStatus($id)
    {
        $Sold_status = SoldStatus::where('id', $id)->get();
        if ($Sold_status->count() == 0) {
            return self::sendError("Ce status de solde n'existe pas!", 404);
        }
        return self::sendResponse($Sold_status, "Status de Sold récupéré avec succès:!!");
    }
}
