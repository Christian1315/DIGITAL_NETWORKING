<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ProductClasse;

class PRODUCT_CLASSE_HELPER extends BASE_HELPER
{
    static function allProductClasse()
    {
        $product_classe =  ProductClasse::orderBy("id", "desc")->get();
        return self::sendResponse($product_classe, 'Toutes les classes de produit récupérés avec succès!!');
    }

    static function _retrieveProductClasse($id)
    {
        $product_classe = ProductClasse::where('id', $id)->get();
        if ($product_classe->count() == 0) {
            return self::sendError("Cette classe de produit n'existe pas!", 404);
        }
        return self::sendResponse($product_classe, "Classe de produit récupérée avec succès:!!");
    }
}
