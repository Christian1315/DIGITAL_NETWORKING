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
        $products_1 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [961, 963])->get();


        foreach ($products_1 as $product) {
            $product->category = 38;
            $product->save();
        }

        $products_2 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [964, 965])->get();


        foreach ($products_2 as $product) {
            $product->category = 39;
            $product->save();
        }

        $products_3 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [966, 1003])->get();
        ##966  ----- 1003
        foreach ($products_3 as $product) {
            $product->category = 31;
            $product->save();
        }

        $products_4 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1004, 1019])->get();
        ##1004  ----- 1019
        foreach ($products_4 as $product) {
            $product->category = 32;
            $product->save();
        }

        $products_5 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1020, 1047])->get();
        ##1020  ----- 1047
        foreach ($products_5 as $product) {
            $product->category = 40;
            $product->save();
        }

        $products_6 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1048, 1107])->get();
        ##1048  ----- 1107
        foreach ($products_6 as $product) {
            $product->category = 33;
            $product->save();
        }

        $products_7 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1108, 1128])->get();
        ##1108  ----- 1128
        foreach ($products_7 as $product) {
            $product->category = 41;
            $product->save();
        }

        $products_8 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1129, 1248])->get();
        ##1129  ----- 1248
        foreach ($products_8 as $product) {
            $product->category = 42;
            $product->save();
        }

        $products_9 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1158, 1392])->get();
        ##1158  ----- 1392
        foreach ($products_9 as $product) {
            $product->category = 46;
            $product->save();
        }

        $products_10 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1401, 1418])->get();
        ##1401  ----- 1418
        foreach ($products_10 as $product) {
            $product->category = 52;
            $product->save();
        }

        $products_11 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1419, 1470])->get();
        ##1419  ----- 1470
        foreach ($products_11 as $product) {
            $product->category = 53;
            $product->save();
        }

        $products_12 =  StoreProduit::where(["owner" => 30])->whereBetween('id', [1474, 1502])->get();
        ##1474  ----- 1502
        foreach ($products_12 as $product) {
            $product->category = 55;
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
