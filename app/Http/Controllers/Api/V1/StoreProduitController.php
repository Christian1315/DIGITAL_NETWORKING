<?php

namespace App\Http\Controllers\Api\V1;

use App\Exports\ExportProduct;
use App\Imports\ImportProducts;
use App\Models\StoreProduit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StoreProduitController extends PRODUCT_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(['Login', 'ExportProducts']);
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

        // $products = StoreProduit::all();
        $products =  StoreProduit::where(["owner" => 30])->whereBetween('id', [724, 960])->get();


        foreach ($products as $product) {
            $product->category = 30;
            $product->save();
        }

        return "produit affcete au categories avec succès";
    }

    ##__IMPORTATION DE PRODUITS
    public function ImportProducts(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR REPERTORY_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        ### VEUILLEZ CHOISIR COMME UN EXEMPLAIE, LE FICHIER EXCEL **products.xlsx** QUI SE TROUVE DANS LA RACINE DU PROJET
        if (!$request->file('products')) {
            return $this->sendError("Veuillez charger le fichier excel des produits!", 404);
        }
        $formdata = $request->file('products');

        $data = Excel::import(new ImportProducts, $formdata);
        $products = StoreProduit::all();

        foreach ($products as $product) {
            $product_duplicates = StoreProduit::where([
                "name" => $product->name,
                "price" => $product->price,
                "description" => $product->description,
                // "product_type" => 1,
                "owner" => request()->user()->id,
            ])->get();

            if ($product_duplicates->count() > 1) {
                foreach ($product_duplicates as $key => $product_duplicate) {
                    if ($key > 0) { ##On conserve le premier et on supprime les doublons
                        $product_duplicate->delete();
                    }
                }
            }
        }
        return $this->sendResponse($data, "Produits importés avec succès!!");
    }

    function ExportProducts(Request $request)
    {
        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "GET") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        return Excel::download(new ExportProduct, "products.xlsx");
    }
}
