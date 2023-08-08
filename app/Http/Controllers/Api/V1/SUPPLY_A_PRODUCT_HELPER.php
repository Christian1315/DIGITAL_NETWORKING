<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\StoreProduit;
use App\Models\StoreStock;
use App\Models\StoreSupply;
use App\Models\SupplyProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SUPPLY_A_PRODUCT_HELPER extends BASE_HELPER
{
    ##======== SUPPLY VALIDATION =======##

    static function supply_product_rules(): array
    {
        return [
            'supply' => ['required', 'integer'],
            'product' => ['required', 'integer'],
            'comments' => ['required'],
            'quantity' => ['required', 'integer'],
        ];
    }

    static function supply_product_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'acti.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Supply_product_Validator($formDatas)
    {
        $rules = self::supply_product_rules();
        $messages = self::supply_product_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _supply_a_product($formData)
    {
        $supply = StoreSupply::where(["id" => $formData["supply"], "owner" => request()->user()->id, "visible" => 1])->get();
        $product = StoreProduit::where(["id" => $formData["product"], "owner" => request()->user()->id, "visible" => 1])->get();

        if ($supply->count() == 0) {
            return self::sendError("Ce supply n'existe pas", 404);
        }
        if ($product->count() == 0) {
            return self::sendError("Ce Produit n'existe pas", 404);
        }

        //Verifions si le produit a déjà été approvisionné dans ce store
        $store_stock = SupplyProduct::where(["product" => $formData["product"], "supply" => $formData["supply"]])->get();
        if (!$store_stock->count() == 0) {
            return self::sendError("Ce produit a déjà été approvisionné", 505);
        } #dans le cas contraire, on passe outre
        $supply = SupplyProduct::create($formData); #ENREGISTREMENT DE LA TABLE DANS LA DB
        $session = GetSession(request()->user()->id);
        $supply->session = $session->id;
        $supply->save();

        #MARQUONS QUE CE PRODUIT A ETE AFFECTE A UN APPROVISIONNEMENT(supply)
        $product = $product[0];
        $product->supplied = true;
        $product->save();

        #AJOUTONS CE PRODUIT AU STOCK DU STORE EN QUESTION
        $stock = new StoreStock();
        $stock->session = $session->id;
        $stock->owner = request()->user()->id;
        $stock->product = $product->id;
        $stock->store = $product->store;
        $stock->quantity = $formData["quantity"];

        $stock->comments = "Ajout du produit (" . $product->name . ") au stock";
        //Verifions si le produit a déjà été ajouté au stock
        $store_stock = StoreStock::where(["product" => $product->id])->get();
        if ($store_stock->count() == 0) {
            #S'il n'a pa été ajouté au stock,on le fait
            $stock->save();
        } #dans le cas contraire, on passe outre

        return self::sendResponse($supply, 'Produit ajouté au Supply avec succès!!');
    }

    // static function allSupplyProducts()
    // {
    //     $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
    //     $supplies =  StoreSupply::with(['owner', "pos", "store"])->where(["owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->orderBy('id', 'desc')->get();
    //     return self::sendResponse($supplies, 'Tout les supplies récupérés avec succès!!');
    // }

    // static function _retrieveSupplyProduct($id)
    // {
    //     $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
    //     $table = StoreSupply::with(['owner', "pos", "store"])->where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
    //     if ($table->count() == 0) {
    //         return self::sendError("Ce supply n'existe pas!", 404);
    //     }
    //     return self::sendResponse($table, "Supply récupérée avec succès:!!");
    // }

    // static function deleteSupplyProduct($id)
    // {
    //     // return $id;
    //     $session_id = GetSession(request()->user()->id)->id; #L'ID DE LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
    //     $supply = StoreSupply::where(["id" => $id, "owner" => request()->user()->id, "session" => $session_id, "visible" => 1])->get();
    //     if (count($supply) == 0) {
    //         return self::sendError("Ce Supply n'existe pas!", 404);
    //     };

    //     $supply = $supply[0];
    //     $supply->visible = 0;
    //     $supply->delete_at = now();
    //     $supply->save();
    //     return self::sendResponse($supply, 'Ce Supply a été supprimée avec succès!');
    // }
}