<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class StoreProduitController extends PRODUCT_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(['Login']);
        $this->middleware('CheckAgent')->except(["Products", "RetrieveProduct"]);
        $this->middleware('CheckSession')->only(["UpdateProduct", "CreateProduct", "_SupplyProduct"]);
    }

    #GET ALL PRODUCTS
    function Products(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION DE TOUT LES PRODUIT
        return $this->allProduct();
    }

    #MODIFIER UN PRODUIT
    function UpdateProduct(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN PRODUIT VIA SON **id**
        return $this->_updateProduct($request, $id);
    }

    #RECUPERER UN PRODUIT
    function RetrieveProduct(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #RECUPERATION D'UN PRODUIT VIA SON **id**
        return $this->_retrieveProduct($id);
    }

    function CreateProduct(Request $request)
    {

        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
        $validator = $this->Product_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        #ENREGISTREMENT DANS LA DB VIA **_createProduct** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
        return $this->_createProduct($request);
    }

    function _SupplyProduct(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS AGENT_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };
        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
        $validator = $this->Supply_Product_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError($validator->errors(), 404);
        }

        return $this->supplyProduct($request);
    }

    function _DeleteProduct(Request $request, $id)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "DELETE") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS AGENT_HELPER
            return $this->sendError("La méthode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return $this->productDelete($id);
    }
}
