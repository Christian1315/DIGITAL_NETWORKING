<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Module;

class MODULE_HELPER extends BASE_HELPER
{
    static function allModules()
    {
        $modules =  Module::all();
        return self::sendResponse($modules, 'Tout les Type d\'Agents récupérés avec succès!!');
    }

    static function _retrieveModule($id)
    {
        $module = Module::where('id', $id)->get();
        if ($module->count() == 0) {
            return self::sendError("Ce type de module n'existe pas!", 404);
        }
        return self::sendResponse($module, "Type de module récupéré avec succès:!!");
    }
}
