<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\AgentType;

class AGENT_TYPE_HELPER extends BASE_HELPER
{
    static function allAgentType()
    {
        $agent_type =  AgentType::all();
        return self::sendResponse($agent_type, 'Tout les Type d\'Agents récupérés avec succès!!');
    }

    static function _retrieveAgentType($id)
    {
        $agent_type = AgentType::where('id', $id)->get();
        if ($agent_type->count() == 0) {
            return self::sendError("Ce type d'agent n'existe pas!",404);
        }
        return self::sendResponse($agent_type, "Type d'agent récupéré avec succès:!!");
    }
}
