<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ProductType;

class PRODUCT_TYPE_HELPER extends BASE_HELPER
{
    static function allProductType()
    {
        $product_type =  ProductType::orderBy("id", "desc")->get();
        return self::sendResponse($product_type, 'Tout les Type de produit récupérés avec succès!!');
    }

    static function _retrieveProductType($id)
    {
        $product_type = ProductType::where('id', $id)->get();
        if ($product_type->count() == 0) {
            return self::sendError("Ce type de produit n'existe pas!", 404);
        }
        return self::sendResponse($product_type, "Type de produit récupéré avec succès:!!");
    }
}
