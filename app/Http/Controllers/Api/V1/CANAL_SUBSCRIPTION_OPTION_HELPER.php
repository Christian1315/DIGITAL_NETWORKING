<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CanalSubscriptionOption;

class CANAL_SUBSCRIPTION_OPTION_HELPER extends BASE_HELPER
{
    static function subscriptionOptions()
    {
        $options =  CanalSubscriptionOption::orderBy("id", "desc")->get();
        return self::sendResponse($options, 'Toutes les options récupérées avec succès!!');
    }

    static function _subscriptionOption($id)
    {
        $option = CanalSubscriptionOption::where('id', $id)->get();
        if ($option->count() == 0) {
            return self::sendError("Cette option n'existe pas!", 404);
        }
        return self::sendResponse($option, "Option récupérée avec succès:!!");
    }
}
