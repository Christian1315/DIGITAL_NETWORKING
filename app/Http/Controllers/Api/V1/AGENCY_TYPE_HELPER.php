<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AgencyType;

class AGENCY_TYPE_HELPER extends BASE_HELPER
{
    static function allAgencyType()
    {
        $agency_type =  AgencyType::all();
        return self::sendResponse($agency_type, 'Tout les Type d\'Agence récupérés avec succès!!');
    }

    static function _retrieveAgencyType($id)
    {
        $agency_type = AgencyType::where('id', $id)->get();
        if ($agency_type->count() == 0) {
            return self::sendError("Ce type d'agence n'existe pas!",404);
        }
        return self::sendResponse($agency_type, "Type d'agence récupéré avec succès:!!");
    }
}
