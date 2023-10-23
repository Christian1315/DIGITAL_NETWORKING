<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CommandStatus;

class COMMAND_STATUS_HELPER extends BASE_HELPER
{
    static function allCommandStatus()
    {
        $Command_status =  CommandStatus::orderBy("id", "desc")->get();
        return self::sendResponse($Command_status, 'Tout les status de Commande récupérés avec succès!!');
    }

    static function _retrieveCommandStatus($id)
    {
        $Command_status = CommandStatus::where('id', $id)->get();
        if ($Command_status->count() == 0) {
            return self::sendError("Ce status de Commande n'existe pas!", 404);
        }
        return self::sendResponse($Command_status, "Status de Command récupéré avec succès:!!");
    }
}
