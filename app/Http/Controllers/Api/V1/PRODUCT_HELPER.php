<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Store;
use App\Models\StoreCategory;
use App\Models\StoreProduit;
use Illuminate\Support\Facades\Validator;

class PRODUCT_HELPER extends BASE_HELPER
{
    ##======== PRODUCT VALIDATION =======##

    static function product_rules(): array
    {
        return [
            'name' => ['required'],
            'price' => ['required'],
            'img' => ['required'],
            'description' => ['required'],
            'category' => ['required', "integer"],
            'store' => ['required', "integer"],
            'active' => ['required', "integer"],
        ];
    }

    static function product_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'active.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Product_Validator($formDatas)
    {
        $rules = self::product_rules();
        $messages = self::product_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createProduct($request)
    {
        $formData = $request->all();
        $product_category = StoreCategory::where(['owner' => request()->user()->id, 'id' => $formData["category"]])->get();
        $store = Store::where(['id' => $formData["store"]])->get();

        if ($product_category->count() == 0) {
            return self::sendError("Cette categorie de produit n'existe pas!!", 404);
        }

        if ($store->count() == 0) {
            return self::sendError("Ce Store n'existe pas!!", 404);
        }

        ##GESTION DE L'IMAGE
        $prod_img = $request->file('img');
        $prod_img_name = $prod_img->getClientOriginalName();

        $request->file('img')->move("products", $prod_img_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE **STORE PRODUCTS**
        $formData["img"] = asset("products/" . $prod_img_name);

        $product = StoreProduit::create($formData); #ENREGISTREMENT DU PRODUIT DANS LA DB
        $product->img = $formData["img"];

        $product->owner = request()->user()->id;
        $session = GetSession(request()->user()->id);
        $product->session = $session->id;

        $product->save();
        return self::sendResponse($product, 'Produit crée avec succès!!');
    }

    static function allProduct()
    {
        $product =  StoreProduit::with(['owner', 'store'])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($product, 'Tout les produits récupérés avec succès!!');
    }

    static function _retrieveProduct($id)
    {
        $product = StoreProduit::with(['owner', "store"])->where(["id" => $id, "owner" => request()->user()->id])->get();
        if ($product->count() == 0) {
            return self::sendError("Ce Product n'existe pas!", 404);
        }
        return self::sendResponse($product, "Produit récupéré avec succès:!!");
    }

    static function _updateProduct($request, $id)
    {
        $formData = $request->all();
        $product = StoreProduit::where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if (count($product) == 0) {
            return self::sendError("Ce Product n'existe pas!", 404);
        };

        // return $request->file("img");
        if ($request->file("img")) {
            $img = $request->file('img');

            $img_name = $img->getClientOriginalName();
            $request->file('img')->move("products", $img_name);

            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["img"] = asset("products/" . $img_name);
        }
        // return $formData["img"];
        $product = StoreProduit::find($id);
        $product->update($formData);
        $product->img = $formData["img"];
        $product->save();
        return self::sendResponse($product, 'Ce Produit a été modifié avec succès!');
    }

    static function productDelete($id)
    {
        $product = StoreProduit::where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if (count($product) == 0) {
            return self::sendError("Ce Produit n'existe pas!", 404);
        };
        $product = StoreProduit::find($id);
        $product->visible = 0;
        $product->delete_at = now();
        $product->save();
        return self::sendResponse($product, 'Ce Produit a été supprimé avec succès!');
    }
}
