<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ActivityDomain;

class ACTIVITY_HELPER extends BASE_HELPER
{
    static function allActivities()
    {
        $activities =  ActivityDomain::all();
        return self::sendResponse($activities, 'Tout les domaines d\'activité récupérés avec succès!!');
    }

    static function _retrieveActivity($id)
    {
        $activitie = ActivityDomain::where('id', $id)->get();
        if ($activitie->count() == 0) {
            return self::sendError("Ce domaine d'activité n'existe pas!", 404);
        }
        return self::sendResponse($activitie, "Domaine d'activité récupéré avec succès:!!");
    }

}
