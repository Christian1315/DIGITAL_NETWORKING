<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\StoreCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CATEGORY_PRODUCT_HELPER extends BASE_HELPER
{
    ##======== STORE VALIDATION =======##

    static function product_category_rules(): array
    {
        return [
            'name' => ['required', Rule::unique("store_categories")],
            'active' => ['required', 'boolean'],
        ];
    }

    static function product_category_messages(): array
    {
        return [
            'name.required' => 'Le champ name est réquis!',
            'name.unique' => 'Cette categorie existe déjà',
            'active.required' => 'Le champ active est réquis!',
            'active.boolean' => 'Le champ active est un boolean!',
        ];
    }

    static function Product_category_Validator($formDatas)
    {
        $rules = self::product_category_rules();
        $messages = self::product_category_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createProductCategory($formData)
    {
        $user = request()->user();
        $session = GetSession($user->id);
        $product_category = StoreCategory::create($formData); #ENREGISTREMENT DU STORE DANS LA DB
        $product_category->owner = $user->id;
        // $product_category->session = $session->id;
        $product_category->save();
        return self::sendResponse($product_category, 'Catégory de produit crée avec succès!!');
    }

    static function allProductCategory()
    {
        $user = request()->user();
        // $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $product_category =  StoreCategory::with(['owner'])->where(["visible" => 1],)->orderBy('id', 'desc')->get();
        return self::sendResponse($product_category, 'Toute les categories de produits récupérés avec succès!!');
    }

    static function _retrieveProductCategory($id)
    {
        $user = request()->user();
        // $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $product_category = StoreCategory::with(['owner'])->where(["visible" => 1])->find($id);
        if (!$product_category) {
            return self::sendError("Cette categorie de produit n'existe pas!", 404);
        }
        return self::sendResponse($product_category, "Categorie de produit récupérée avec succès:!!");
    }

    static function _updateProductCategory($formData, $id)
    {
        $user = request()->user();
        // $session = GetSession($user->id); #LA SESSION DANS LAQUELLE LA CATEGORY A ETE CREE
        $product_category = StoreCategory::where(["visible" => 1])->find($id);
        if (!$product_category) {
            return self::sendError("Cette categorie de produit n'existe pas!", 404);
        };

        if ($product_category->owner != $user->id) {
            return self::sendError("Cette categorie de produit ne vous appartient pas!", 404);
        };
        $product_category->update($formData);
        return self::sendResponse($product_category, 'Cette Catégorie de produit a été modifié avec succès!');
    }

    static function productCategoryDelete($id)
    {
        $user = request()->user();
        // $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $product_category = StoreCategory::where(["visible" => 1])->find($id);

        if (!$product_category) {
            return self::sendError("Cette Catégorie de produit n'existe pas!", 404);
        };

        if ($product_category->owner != $user->id) {
            return self::sendError("Cette categorie de produit ne vous appartient pas!", 404);
        };

        $product_category->visible = 0;
        $product_category->delete_at = now();

        $product_category->save();
        return self::sendResponse($product_category, 'Cette Catégorie de produit a été supprimée avec succès!');
    }
}
