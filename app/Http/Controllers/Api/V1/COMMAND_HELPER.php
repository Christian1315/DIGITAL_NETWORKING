<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\Client;
use App\Models\CommandStatus;
use App\Models\ProductCommand;
use App\Models\ProductComposant;
use App\Models\Store;
use App\Models\StoreCommand;
use App\Models\StoreProduit;
use App\Models\StoreStock;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class COMMAND_HELPER extends BASE_HELPER
{
    ##======== COMMAND VALIDATION =======##

    static function command_rules(): array
    {
        return [
            // 'store' => ['required', 'integer'],
            // 'table' => ['required', 'integer'],
            'products' => ['required'],
            'client' => ['required'],

            // "amount" => ['required', 'integer']
            // "rate"=> ['required']
        ];
    }

    static function command_messages(): array
    {
        return [
            // 'store.required' => 'Le champ store est réquis!',
            'product.required' => 'Le champ products est réquis!',
            // 'qty.required' => 'Le champ qty est réquis!',
            'client.integer' => 'Le client est réquis!',
        ];
    }

    static function Command_Validator($formDatas)
    {
        $rules = self::command_rules();
        $messages = self::command_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createCommand($request)
    {
        $user = request()->user();
        $formData = $request->all();
        $session = GetSession($user->id);

        // $store = Store::where(["id" => $formData["store"], "visible" => 1])->get();
        // // $table = StoreTable::where(["id" => $formData["table"], "owner" => request()->user()->id, "visible" => 1])->get();
        // if ($store->count() == 0) {
        //     return self::sendError("Ce Store n'existe pas", 404);
        // }

        ####____verifions si cet agent a été affecté à un store

        if (Is_User_An_Agent($user->id)) {
            $agent = Agent::where(["user_id" => $user->id])->first();
            if ($agent) {
                if ($agent->store) {
                    $formData["store"] = $agent->store->id;
                } else {
                    return self::sendError("Vous n'avez pas été affecté à un store! Impossible d'effectuer cette opération", 505);
                }
            }
        }

        // $client = $formData["client"];
        $client_datas = explode(" ", $formData["client"]);
        $lastname = isset($client_datas[0]) ? $client_datas[0] : "";
        $firstname = isset($client_datas[1]) ? $client_datas[1] : "";

        $client = Client::where(["lastname" => $lastname, "firstname" => $firstname])->first();
        if (!$client) {
            ####____creons le client
            $client = new Client();
            $client->firstname = $firstname;
            $client->lastname = $lastname;

            if (Is_User_An_Agent($user->id)) {
                ####___le proprietaire(admin ou master) de l'agent
                $his_owner = User::find($user->owner);

                if (Is_User_A_Master($his_owner->id)) { ###___si c'est un master
                    $client->owner = $his_owner->id;
                }
            }
            $client->save();
        }

        $products = $formData["products"];

        // $products = [
        //     [
        //         "id" => 5,
        //         "qty" => 1,
        //     ]
        // ];

        $current_agent = Agent::where(["user_id" => $user->id])->get();
        if ($current_agent->count() == 0) {
            return self::sendError("Le compte agent auquel vous êtes associé.e n'existe plus", 404);
        }

        ###L'agent actuel
        $current_agent = $current_agent[0];
        $this_agent_pos = $current_agent->pos;

        ####_____TRAITEMENT DES PRODUITS
        $total_command_amount = [];
        $total_command_qty = [];

        foreach ($products as $product) {

            #ON VERIFIE L'EXISTENCE DES PRODUITS
            $_product = StoreProduit::find($product["id"]);
            if (!$_product) {
                return self::sendError("Le product d'ID " . $product["id"] . " n'existe pas!", 404);
            }

            #####____produit composé
            #####____QUANT IL S'AGIT D'UNPRODUIT COMPOSE
            #####____ON ATTAQUE PLUTÖT SES PRODUITS COMPOSANTS
            if ($_product->product_classe == 3) {
                $prod_composants = $_product->composants;

                if (count($prod_composants) == 0) {
                    return self::sendError("Ce produit composé " . $_product->name . " ne dispose pas de produits composants", 505);
                }

                foreach ($prod_composants as $prod_composant) {
                    #ON VERIFIE L'EXISTENCE DES PRODUITS COMPOSANTS
                    $_product = StoreProduit::where(["visible" => 1])->find($prod_composant->id);
                    if (!$_product) {
                        return self::sendError("Le product composant " . $prod_composant->name . " n'existe pas!", 404);
                    }

                    #####____produit stockable
                    if ($prod_composant->product_type == 1) {

                        #ON VERIFIE L'EXISTENCE DU PRODUIT DANS LE STOCK DU STORE
                        $product_stock = StoreStock::with(["product", "store"])->where(["product" => $prod_composant->id, "store" => $formData["store"], "visible" => 1])->get();
                        return self::sendResponse([], $prod_composant->id . " " . $formData["store"]);
                        if ($product_stock->count() == 0) {
                            return self::sendError("Le Produit composant <<" . $prod_composant->name . ">> n'existe pas dans le stock du store! Veuillez l'approvisionner!", 404);
                        }
                        $product_stock = $product_stock[0];

                        #Verifions la quantité du produit
                        if ($product_stock->quantity < 0 || $product_stock->quantity == 0) {
                            return self::sendError("Le produit composant <<" . $prod_composant->name . ">> est fini dans le stock! Veuillez approvisionner le stock avant de passer aux commandes", 505);
                        }

                        #Verifions si la quantité de la commande est inferieur à celle du produit existant dans le stock
                        if ($product_stock->quantity < $prod_composant->qty) {
                            return self::sendError("Stock insuffisant dans le store pour ce produit composant <<" . $prod_composant->name . ">>", 505);
                        }
                    }
                }
            } else {
                #####____produit stockable
                if ($_product->product_type == 1) {

                    #ON VERIFIE L'EXISTENCE DU PRODUIT DANS LE STOCK DU STORE
                    $product_stock = StoreStock::with(["product", "store"])->where(["product" => $product["id"], "visible" => 1])->get();

                    if ($product_stock->count() == 0) {
                        return self::sendError("Le Produit <<" . $_product->name . ">> n'existe pas dans le stock du store! Veuillez l'approvisionner!", 404);
                    }
                    $product_stock = $product_stock[0];

                    #Verifions la quantité du produit
                    if ($product_stock->quantity < 0 || $product_stock->quantity == 0) {
                        return self::sendError("Le produit <<" . $_product->name . ">> est fini dans le stock! Veuillez approvisionner le stock avant de passer aux commandes", 505);
                    }

                    #Verifions si la quantité de la commande est inferieur à celle du produit existant dans le stock
                    if ($product_stock->quantity < $product["qty"]) {
                        return self::sendError("Stock insuffisant dans le store pour ce produit <<" . $_product->name . ">> ! Dimuniez la quantité de votre commande", 505);
                    }
                }
            }

            $this_product_command_amount = intval($product["qty"]) * $_product->price;

            ###___
            array_push($total_command_amount, $this_product_command_amount);
            array_push($total_command_qty, intval($product["qty"]));
        }

        $formData["qty"] = array_sum($total_command_qty); ###__somme des qty lies à chaque produit
        $formData["amount"] = array_sum($total_command_amount); ###__somme des soldes lies à chaque produit et quantite

        $formData["client"] = $client->id;


        $formData["session"] = $session->id;
        $formData["owner"] = $user->id;

        ####___TRAITEMENT DE LA COMMANDE
        $previous_command = StoreCommand::where(["client" => $client->id, "factured" => 0, "visible" => 1])->first();

        // if ($_product->product_classe == 3) {
        #####____produit composé
        #####____QUANT IL S'AGIT D'UNPRODUIT COMPOSE
        #####____ON ATTAQUE PLUTÖT SES PRODUITS COMPOSANTS
        $prod_composants = $_product->composants;

        // foreach ($prod_composants as $prod_composant) {
        //     if ($previous_command) {
        //         ####S'IL AVAIT UNE COMMANDE NON FACTUREE, ON AJOUTE CETTE NOUVELLE COMMANDE A CETTE FACTURE
        //         $command = $previous_command;
        //         $command->firstname = $firstname;
        //         $command->lastname = $lastname;
        //         $command->amount = $previous_command->amount + $prod_composant->price;
        //     } else {
        //         #Passons à la validation de la commande
        //         $command = new StoreCommand(); #ENREGISTREMENT DE LA COMMANDE DANS LA DB
        //         $command->firstname = $firstname;
        //         $command->lastname = $lastname;
        //         $command->amount = $prod_composant->price;
        //     }
        //     $command->save();
        // }
        // } else {
        if ($previous_command) {
            ####S'IL AVAIT UNE COMMANDE NON FACTUREE, ON AJOUTE CETTE NOUVELLE COMMANDE A CETTE FACTURE
            $command = $previous_command;
            $command->firstname = $firstname;
            $command->lastname = $lastname;
            $command->qty = $previous_command->qty + $formData["qty"];
            $command->amount = $previous_command->amount + $formData["amount"];
            $command->save();
        } else {
            #Passons à la validation de la commande
            $command = StoreCommand::create($formData); #ENREGISTREMENT DE LA COMMANDE DANS LA DB
            $command->firstname = $firstname;
            $command->lastname = $lastname;
        }
        $command->save();
        // }

        ####ENREGISTREMENT DES PRODUITS ASSOCIES A CETTE COMMANDE
        foreach ($products as $product) {
            $_product = StoreProduit::find($product["id"]);

            #####____produit composé
            #####____QUANT IL S'AGIT D'UN PRODUIT COMPOSE
            #####____ON ATTAQUE PLUTÖT SES PRODUITS COMPOSANTS
            if ($_product->product_classe == 3) {
                $prod_composants = $_product->composants;

                if (count($prod_composants) == 0) {
                    return self::sendError("Ce produit composé " . $_product->name . " ne dispose pas de produits composants", 505);
                }

                foreach ($prod_composants as $prod_composant) {
                    ###___
                    // $productCommand = new ProductCommand();
                    // $productCommand->product_id = $prod_composant["id"];
                    // $productCommand->command_id = $command->id;
                    // $productCommand->qty = intval($prod_composant["qty"]);
                    // $productCommand->total_amount = intval(explode(" ", $prod_composant["qty"])[0]) * $prod_composant->price;
                    // $productCommand->save();

                    if ($prod_composant->product_type == 1) { ####____quand le produit est stockble

                        #Decreditons l'ancienne ligne 
                        $old_product_stock = StoreStock::with(["product", "store"])->where(["product" => $prod_composant["id"], "store" => $formData["store"], "visible" => 1])->first();

                        // $old_product_stock->quantity = $old_product_stock->quantity - intval($product["qty"]);
                        $this_product_composant = ProductComposant::where([
                            "compose" => $product["id"],
                            "composant" => $prod_composant["id"]
                        ])->first();

                        if (!$this_product_composant) {
                            return self::sendError("La relation qui lie le composant <<" . $prod_composant["name"] . ">> au composé <<" . $product["name"] . ">> n'existe plus!", 505);
                        }

                        if ($old_product_stock->quantity < intval(explode(" ", $this_product_composant["qty"])[0])) {
                            return self::sendError("La quantité de ce produit composant <<" . $prod_composant["name"] . ">> est insuffisant dans son stock! ", 505);
                        }

                        $old_product_stock->visible = 0;
                        $old_product_stock->save();

                        #& Recréeons une nouvelle ligne de ce produit dans la table des stocks


                        $new_stock = new StoreStock();
                        $new_stock->session = $session->id;
                        $new_stock->owner = $old_product_stock->owner;
                        $new_stock->product = $old_product_stock->product;
                        $new_stock->store = $old_product_stock->store;
                        $new_stock->quantity = $old_product_stock->quantity - intval(explode(" ", $prod_composant["qty"])[0]);
                        $new_stock->comments = $old_product_stock->comments;
                        $new_stock->save();
                    }
                }
            } else {
                ###___
                $productCommand = new ProductCommand();
                $productCommand->product_id = $product["id"];
                $productCommand->command_id = $command->id;
                $productCommand->qty = intval($product["qty"]);
                $productCommand->total_amount = $command->amount;
                $productCommand->save();

                if ($_product->product_type == 1) { ####_______quand le produit est stockble

                    #Decreditons l'ancienne ligne 
                    $old_product_stock = StoreStock::with(["product", "store"])->where(["product" => $product["id"], "visible" => 1])->first();
                    // $old_product_stock->quantity = $old_product_stock->quantity - intval($product["qty"]);
                    $old_product_stock->visible = 0;
                    $old_product_stock->save();

                    #& Recréeons une nouvelle ligne de ce produit dans la table des stocks
                    $new_stock = new StoreStock();
                    $new_stock->session = $session->id;
                    $new_stock->owner = $old_product_stock->owner;
                    $new_stock->product = $old_product_stock->product;
                    $new_stock->store = $old_product_stock->store;
                    $new_stock->quantity = $old_product_stock->quantity - intval($product["qty"]);
                    $new_stock->comments = $old_product_stock->comments;
                    $new_stock->save();
                }
            }
        }

        ##___DECREDITATION DU SOLDE DE L'AGENCE
        // $countData = [
        //     "module_type" => 1,
        //     "comments" => "Décreditation de solde du Pos par " . $user->username . ", pour initier une souscription!",
        //     "amount" => $formData["amount"],
        //     "pos" => $this_agent_pos->id
        // ];
        // Decredite_Pos_Account($countData);

        return self::sendResponse($command, 'Commande éffectuée avec succès!!');
    }


    static function allCommands()
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE

        if ($user->is_admin) {
            $commands =  StoreCommand::with(['owner', "store", "session", "products", "factures"])->where(["visible" => 1])->orderBy('id', 'desc')->get();
        } else {
            $commands =  StoreCommand::with(['owner', "store", "session", "products", "factures"])->where(["owner" => $user->id, "visible" => 1])->orderBy('id', 'desc')->get();
        }
        return self::sendResponse($commands, 'Toutes les commandes récupérés avec succès!!');
    }

    static function _retrieveCommand($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::with(['owner', "store", "session", "products", "factures"])->where(["visible" => 1])->find($id);
        if (!$command) {
            return self::sendError("Cette commande n'existe pas!", 404);
        }
        return self::sendResponse($command, "Commande récupérée avec succès:!!");
    }

    static function _updateCommand($request, $id)
    {
        $formData = $request->all();
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::where(["visible" => 1])->find($id);
        if (!$command) {
            return self::sendError("Cette Commande n'existe pas!", 404);
        };

        if ($command->owner != $user->id) {
            return self::sendError("Cette Commande ne vous appartient pas!", 404);
        };

        if ($request->get("status")) {
            $status = CommandStatus::find($request->get("status"));
            if (!$status) {
                return self::sendError("Ce status de commande n'existe pas!", 404);
            }
        }

        $command->update($formData);
        return self::sendResponse($command, 'Cette Commande a été modifiée avec succès!');
    }

    static function commandDelete($id)
    {
        $user = request()->user();
        $session = GetSession($user->id); #LA SESSTION DANS LAQUELLE LA CATEGORY A ETE CREE
        $command = StoreCommand::where(["visible" => 1])->find($id);
        if (!$command) {
            return self::sendError("Cette Commande n'existe pas!", 404);
        };

        if ($command->owner != $user->id) {
            return self::sendError("Cette Commande ne vous appartient pas!", 404);
        };

        $command->visible = 0;
        $command->delete_at = now();

        $command->save();
        return self::sendResponse($command, 'Cette commande a été supprimée avec succès!');
    }
}
