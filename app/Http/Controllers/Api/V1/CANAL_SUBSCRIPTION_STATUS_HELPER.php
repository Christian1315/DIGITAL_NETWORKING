<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CanalSubscriptionStatus;

class CANAL_SUBSCRIPTION_STATUS_HELPER extends BASE_HELPER
{
    static function allSubscriptionStatus()
    {
        $status =  CanalSubscriptionStatus::orderBy("id", "desc")->get();
        return self::sendResponse($status, 'Tout les status récupérés avec succès!!');
    }

    static function _retrieveSubscriptionStatus($id)
    {
        $status = CanalSubscriptionStatus::where('id', $id)->get();
        if ($status->count() == 0) {
            return self::sendError("Ce status n'existe pas!", 404);
        }
        return self::sendResponse($status, "Ce Status récupéré avec succès:!!");
    }
}
