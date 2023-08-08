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
            'active' => ['required', 'integer'],
        ];
    }

    static function product_category_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'active.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
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
        $session = GetSession(request()->user()->id);
        $product_category = StoreCategory::create($formData); #ENREGISTREMENT DU STORE DANS LA DB
        $product_category->owner = request()->user()->id;
        $product_category->session = $session->id;
        $product_category->save();
        return self::sendResponse($product_category, 'Catégory de produit crée avec succès!!');
    }

    static function allProductCategory()
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        // return GetSession(request()->user()->id);
        $product_category =  StoreCategory::with(['owner'])->where(["owner" => request()->user()->id, "session" => $session_id, "visible" => 1],)->orderBy('id', 'desc')->get();
        return self::sendResponse($product_category, 'Tout les categories de produits récupérés avec succès!!');
    }

    static function _retrieveProductCategory($id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $product_category = StoreCategory::with(['owner'])->where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if ($product_category->count() == 0) {
            return self::sendError("Ce product_category n'existe pas!", 404);
        }
        return self::sendResponse($product_category, "Categorie de produit récupérée avec succès:!!");
    }

    static function _updateProductCategory($formData, $id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSION DANS LAQUELLE LA CATEGORY A ETE CREE
        $product_category = StoreCategory::where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
        if (count($product_category) == 0) {
            return self::sendError("Ce product_category n'existe pas!", 404);
        };
        $product_category = StoreCategory::find($id);
        $product_category->update($formData);
        return self::sendResponse($product_category, 'Cette Catégorie de produit a été modifié avec succès!');
    }

    static function productCategoryDelete($id)
    {
        $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSION DANS LAQUELLE LA CATEGORY A ETE CREE
        $product_category = StoreCategory::where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();

        if (count($product_category) == 0) {
            return self::sendError("Cette Catégorie de produit n'existe pas!", 404);
        };
        $product_category = StoreCategory::find($id);
        $product_category->visible = 0;
        $product_category->delete_at = now();

        $product_category->save();
        return self::sendResponse($product_category, 'Cette Catégorie de produit a été supprimée avec succès!');
    }
}