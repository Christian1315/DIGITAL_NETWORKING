<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ProductClasse;
use App\Models\ProductComposant;
use App\Models\ProductType;
use App\Models\Store;
use App\Models\StoreCategory;
use App\Models\StoreProduit;
use App\Models\StoreSupply;
use App\Models\User;
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
            'active' => ['required', "boolean"],
            'product_type' => ['required', "integer"],
        ];
    }

    static function product_messages(): array
    {
        return [
            'name.required' => 'Le champ name est réquis!',
            'description.required' => 'Le champ description est réquis!',
            'category.required' => 'Le champ category est réquis!',
            'product_type.required' => 'Le champ product_type est réquis!',
            'product_classe.required' => 'La classe du produit est réquise!',
            'active.required' => 'Le champ active est réquis!',

            'active.boolean' => 'Le champ active est un boolean!',
            'category.integer' => 'Le champ category est un entier!',
            'store.integer' => 'Le champ store est un entier!',
            'product_type.integer' => 'Le champ product_type est un entier!',
            'product_classe.integer' => 'Le champ product_classe doit être de type entier!',
        ];
    }

    static function Product_Validator($formDatas)
    {
        $rules = self::product_rules();
        $messages = self::product_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== SUPPLY PRODUCT VALIDATION =======##

    static function supply_product_rules(): array
    {
        return [
            'product_id' => ['required', 'integer'],
            'supply_id' => ['required', 'integer'],
        ];
    }

    static function supply_product_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'active.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Supply_Product_Validator($formDatas)
    {
        $rules = self::supply_product_rules();
        $messages = self::supply_product_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }


    static function _createProduct($request)
    {
        $formData = $request->all();
        $user = request()->user();

        $product_type = ProductType::where(['id' => $formData["product_type"]])->get();
        $product_classe = ProductClasse::where(['id' => $formData["product_classe"]])->get();

        $product_category = StoreCategory::where(['id' => $formData["category"]])->get();
        $store = Store::where(['id' => $formData["store"]])->get();

        if ($product_type->count() == 0) {
            return self::sendError("Ce type de produit n'existe pas!!", 404);
        }

        if ($product_classe->count() == 0) {
            return self::sendError("Cette classe de produit n'existe pas!!", 404);
        }

        if ($product_category->count() == 0) {
            return self::sendError("Cette categorie de produit n'existe pas!!", 404);
        }

        if ($store->count() == 0) {
            return self::sendError("Ce Store n'existe pas!!", 404);
        }

        ####____TRAITEMENT DE L'AJOUT DU PRODUIT QUAND SA CLASSE EST UN PRODUIT ¨COMPOSE¨
        $products = $request->get("products");

        // $products = [
        //     [
        //         "id" => 3,
        //         "qty" => "20L",
        //     ],
        //     [
        //         "id" => 4,
        //         "qty" => "3L",
        //     ],
        // ];

        // $products = explode()

        if ($formData["product_classe"] == 3) {
            if (!$request->get("products")) {
                return self::sendError("Veuillez préciser les produits composants inclus dans ce produit composé", 505);
            }

            foreach ($products as $product) {
                ####___ON VERIFIE L'EXISTENCE DES PRODUITS
                $_product = StoreProduit::find($product["id"]);

                if ($_product->owner != $user->id) {
                    return self::sendError("Ce produit ne vous appartient pas!", 404);
                }

                if ($_product->product_compose) {
                    return self::sendError("Ce produit appartient déjà à un produit composé!", 404);
                }

                if (!$_product) {
                    return self::sendError("Le produit d'ID " . $product["id"] . " n'existe pas!", 404);
                }

                ####____QUAND LE PRODUIT N'EST PAS UN COMPOSANT
                if ($_product->product_classe != 2) {
                    return self::sendError("Le produit <<" . $_product->name . " >> n'est pas de la classe des composants.", 505);
                }
            }
        }

        ##GESTION DE L'IMAGE
        $prod_img = $request->file('img');
        $prod_img_name = $prod_img->getClientOriginalName();

        $request->file('img')->move("products", $prod_img_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE **STORE PRODUCTS**
        $formData["img"] = asset("products/" . $prod_img_name);

        $productCreated = StoreProduit::create($formData); #ENREGISTREMENT DU PRODUIT DANS LA DB
        $productCreated->img = $formData["img"];
        $productCreated->owner = $user->id;
        $productCreated->save();

        ##__QUAND LE PRODUIT CREE EST UN COMPOSE
        if ($formData["product_classe"] == 3) {
            ####___ASSOCIONS CHAQUE PRODUIT COMPOSANT AU PRODUIT COMPOSE(Si le produit crée est de la classe des produits composés)
            foreach ($products as $product) {
                $is_this_relation_exist = ProductComposant::where(["compose" => $productCreated->id, "composant" => $product["id"]])->first();

                ####__ON VERIFIE SI CE COMPOSANT EXISTAIT DEJA SOUS CE COMPOSE
                if (!$is_this_relation_exist) {
                    $compose_composant_relation = new ProductComposant();
                    $compose_composant_relation->compose = $productCreated->id; ###Le produit compose auquel ce produit appartient
                    $compose_composant_relation->composant = $product["id"]; ###Le produit composant associé
                    $compose_composant_relation->qty = $product["qty"];
                    $compose_composant_relation->save();
                }
            }
        }
        return self::sendResponse($productCreated, 'Produit crée avec succès!!');
    }

    static function allProduct()
    {
        $user = request()->user();

        $product = [];

        if (Is_User_An_Agent($user->id)) {
            ####___le proprietaire(admin ou master) de l'agent
            $his_owner = User::find($user->owner);
            if ($his_owner->is_admin) { ####___si c'est un admin
                return [];
            }

            if (Is_User_A_Master($his_owner->id)) { ###___si c'est un master
                $product =  StoreProduit::with(['owner', "store", "session", "category", "product_type", "product_stock", "classe_product", "composants"])->where(["owner" => $his_owner->id, "visible" => 1])->orderBy('id', 'desc')->get();
            }
        }

        if ($user->is_admin) {
            $product =  StoreProduit::with(['owner', "store", "session", "category", "product_type", "product_stock", "classe_product", "composants"])->where(["visible" => 1])->orderBy('id', 'desc')->get();
        }

        if (Is_User_A_Master($user->id)) {
            $product =  StoreProduit::with(['owner', "store", "session", "category", "product_type", "product_stock", "composants"])->where(["owner"=> $user->id,"visible"=>1])->orderBy('id', 'desc')->get();
        }

        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LE PRODUIT A ETE CREE
        return self::sendResponse($product, 'Tout les produits récupérés avec succès!!');
    }

    static function _retrieveProduct($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LE PRODUIT A ETE CREE
        $product = StoreProduit::with(['owner', "store", "session", "category", "product_type", "product_stock", "classe_product","composants"])->where(["visible"=>1])->find($id);
        if (!$product) {
            return self::sendError("Ce Product n'existe pas!", 404);
        }
        return self::sendResponse($product, "Produit récupéré avec succès:!!");
    }

    static function _updateProduct($request, $id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LE PRODUIT A ETE CREE

        $formData = $request->all();
        $product = StoreProduit::where(["visible" => 1])->find($id);
        if (!$product) {
            return self::sendError("Ce Product n'existe pas!", 404);
        };

        if ($product->owner != $user->id) {
            return self::sendError("Ce Product ne vous appartient pas!", 404);
        }

        // return $request->file("img");
        if ($request->file("img")) {
            $img = $request->file('img');

            $img_name = $img->getClientOriginalName();
            $request->file('img')->move("products", $img_name);

            //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA TABLE 
            $formData["img"] = asset("products/" . $img_name);
        }

        $product->update($formData);
        return self::sendResponse($product, 'Ce Produit a été modifié avec succès!');
    }

    static function productDelete($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LE PRODUIT A ETE CREE

        $product = StoreProduit::where(["visible" => 1])->find($id);
        if (!$product) {
            return self::sendError("Ce Produit n'existe pas!", 404);
        };

        if ($product->owner != $user->id) {
            return self::sendError("Ce Product ne vous appartient pas!", 404);
        }

        $product->visible = 0;
        $product->delete_at = now();
        $product->save();
        return self::sendResponse($product, 'Ce Produit a été supprimé avec succès!');
    }

    static function supplyProduct($request)
    {

        $user = request()->user();
        $product_id = $request->get("product_id");
        $supply_id = $request->get("supply_id");

        $product = StoreProduit::where(["visible" => 1])->find($product_id);
        $supply = StoreSupply::where(["visible" => 1])->find($supply_id);

        if (!$product) {
            return self::sendError("Ce produit n'existe pas", 404);
        }

        if ($product->owner != $user->id) {
            return self::sendError("Ce Product ne vous appartient pas!", 404);
        }

        if (!$supply) {
            return self::sendError("Ce approvisionnement n'existe pas", 404);
        }

        if ($product->owner != $user->id) {
            return self::sendError("Ce approvisionnement ne vous appartient pas!", 404);
        }

        if ($product->product_type = 2) { #Le produit n'est pas stockable
            return self::sendError("Ce produit n'est pas Stockable", 404);
        }

        #SI LE PRODUIT EST STOCKABLE
        #voyons s'il est déjà stocké
        if ($product->supplied) {
            return self::sendError("Ce produit est déjà stocké", 505);
        }
        #S'il n'est pas deja stocké, on passe à son stockage
        $product->supply = $supply_id;
        $product->supplied = true;
        $product->save();

        return self::sendResponse($product, 'Ce Produit a été stocké avec succès!');
    }
}
