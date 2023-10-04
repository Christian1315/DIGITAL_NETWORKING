<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\CanalFormula;

class CANAL_FORMULA_HELPER extends BASE_HELPER
{
    static function allFormule()
    {
        $formules =  CanalFormula::orderBy("id", "desc")->get();
        return self::sendResponse($formules, 'Toutes les formules récupérées avec succès!!');
    }

    static function _retrieveFormule($id)
    {
        $formule = CanalFormula::where('id', $id)->get();
        if ($formule->count() == 0) {
            return self::sendError("Cette fomule n'existe pas!", 404);
        }
        return self::sendResponse($formule, "Formule récupérée avec succès:!!");
    }
}
