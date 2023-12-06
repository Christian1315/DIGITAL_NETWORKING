<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\StoreCommand;
use App\Models\StoreFacturation;
use App\Models\StoreProduit;
use Illuminate\Http\Request;

class StoreProduitController extends PRODUCT_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(['Login']);
        // $this->middleware('CheckAgent')->except(["CreateProduct", "Products", "RetrieveProduct"]);
        // $this->middleware('CheckMaster')->only(["CreateProduct"]);
        // $this->middleware('CheckSession')->only(["UpdateProduct", "CreateProduct", "_SupplyProduct"]);
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

    static function ChangeProductAffectation()
    {

        $products = StoreProduit::all();

        foreach ($products as $product) {
            $new_product = new StoreProduit();
            $new_product->session = $product->session;
            $new_product->name = $product->name;
            $new_product->price = $product->price;
            $new_product->img = $product->img;
            $new_product->description = $product->description;
            $new_product->store = $product->store;
            $new_product->product_type = $product->product_type;
            $new_product->category = $product->category;
            $new_product->owner = 4;
            $new_product->supplied = $product->supplied;

            $new_product->product_classe = $product->product_classe;
            $new_product->product_compose = $product->product_compose;
            $new_product->qty = $product->qty;

            $new_product->save();

        }

        return "produit dupliqué avec succès";
    }
}
