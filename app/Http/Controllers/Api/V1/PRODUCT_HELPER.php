<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Store;
use App\Models\StoreCategory;
use App\Models\StoreProduit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PRODUCT_HELPER extends BASE_HELPER
{
    ##======== PRODUCT VALIDATION =======##

    static function product_rules(): array
    {
        return [
            'name' => ['required', Rule::unique("store_produits")],
            'price' => ['required'],
            'description' => ['required'],
            'category' => ['required',"integer"],
            'store' => ['required',"integer"],
            'active' => ['required',"integer"],
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

    static function _createProduct($formData)
    {
        // return $formData;
        $product_category = StoreCategory::where(['owner'=>request()->user()->id,'id'=>$formData["category"]])->get();
        $store = Store::where(['id'=>$formData["store"]])->get();

        if ($product_category->count()==0) {
            return self::sendError("Cette categorie de produit n'existe pas!!",404);
        }

        if ($store->count()==0) {
            return self::sendError("Ce Store n'existe pas!!",404);
        }
        $product = StoreProduit::create($formData); #ENREGISTREMENT DU PRODUIT DANS LA DB
        $product->owner = request()->user()->id;

        $product->save();
        return self::sendResponse($product, 'Produit crée avec succès!!');
    }

    static function allProduct()
    {
        $product =  StoreProduit::with(['owner'])->where(["owner" => request()->user()->id])->orderBy('id', 'desc')->get();
        return self::sendResponse($product, 'Tout les produits récupérés avec succès!!');
    }

    static function _retrieveProduct($id)
    {
        $product= StoreProduit::with(['owner'])->where(["id" => $id, "owner" => request()->user()->id])->get();
        if ($product->count() == 0) {
            return self::sendError("Ce Product n'existe pas!", 404);
        }
        return self::sendResponse($product, "Produit récupéré avec succès:!!");
    }

    static function _updateProduct($formData, $id)
    {
        $product = StoreProduit::where(["id" => $id, "owner" => request()->user()->id])->get();
        if (count($product) == 0) {
            return self::sendError("Ce Product n'existe pas!", 404);
        };
        $product = StoreProduit::find($id);
        $product->update($formData);
        return self::sendResponse($product, 'Ce Produit a été modifié avec succès!');
    }

    static function productDelete($id)
    {
        // return $id;
        $product = StoreProduit::where(["id" => $id, "owner" => request()->user()->id])->get();
        if (count($product) == 0) {
            return self::sendError("Ce Produit n'existe pas!", 404);
        };
        $product = StoreProduit::find($id);

        $product->delete();
        return self::sendResponse($product, 'Ce Produit a été supprimé avec succès!');
    }
}
