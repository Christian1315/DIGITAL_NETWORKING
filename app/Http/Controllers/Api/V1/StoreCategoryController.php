<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class StoreCategoryController extends CATEGORY_PRODUCT_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access']);
        $this->middleware('CheckSession');
    }

    #GET ALL CATEGORIES
    function ProductCategories(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CATEGORY_PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUTES LES CATEGORIES DE PRODUIT
        return $this->allProductCategory();
    }

    #MODIFIER UNE CATEGORIE DE PRODUIT
    function UpdateProductCategory(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CATEGORY_PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UNE CATEGORIE DE PRODUIT VIA SON **id**
        return $this->_updateProductCategory($request->all(), $id);
    }

    #RECUPERER UNE CATEGORIE DE PRODUIT
    function RetrieveProductCategory(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CATEGORY_PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UNE CATEGORY DE PRODUIT VIA SON **id**
        return $this->_retrieveProductCategory($id);
    }

    function CreateProductCategory(Request $request)
    {

        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CATEGORY_PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR CATEGORY_PRODUCT_HELPER
        $validator = $this->Product_category_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR CATEGORY_PRODUCT_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **_createProductCategory** DE LA CLASS BASE_HELPER HERITEE PAR CATEGORY_PRODUCT_HELPER
        return $this->_createProductCategory($request->all());
    }


    function _DeleteProductCategory(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS AGENT_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->productCategoryDelete($id);
    }
}
