<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Master;
use App\Models\Module;
use App\Models\Pos;
use App\Models\Sold;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SOLD_HELPER extends BASE_HELPER
{
    static function sold_rules(): array
    {
        return [
            'comments' => ['required'],
            'amount' => ['required', "integer"],
            'module_type' => ['required', "integer"],
        ];
    }

    static function sold_messages(): array
    {
        return [
            'comments.required' => "Veuillez renseigner un  text décrivant cette opération!",
            'amount.required' => 'Veuillez préciser le montant à créditer!',
            'module_type.required' => 'Veuillez préciser le type de module que vous voulez utiliser créditer ce solde!',

            'amount.integer' => 'Le solde amount doit être un entier!',
            'module_type.integer' => 'Le type de module doit être un entier!',
        ];
    }

    static function Sold_Validator($formDatas)
    {
        $rules = self::sold_rules();
        $messages = self::sold_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ####INITIATION DE SOLDE
    static function initiateSolde($request)
    {
        $user = request()->user();
        $formData = $request->all();

        $session = GetSession($user->id);

        $module = Module::find($request["module_type"]);
        if (!$module) {
            return self::sendError("Ce module n'existe pas!", 404);
        }

        $solde = Sold::where(["owner" => $user->id, "visible" => 1])->get();
        if ($solde->count() == 0) {
            return self::sendError("Ce solde n'existe pas", 404);
        }

        $old_solde = $solde[0];

        if ($old_solde->status == 1) {
            return self::sendError("Ce solde est déjà en cours d'initiation. Merci d'attendre la validation de cette initiation avant de lancer une nouvelle!", 505);
        }

        ##~~old solde
        $old_solde->visible = 0;
        $old_solde->status = null;
        $old_solde->save();

        ##~~le nouveau solde
        $new_solde = new Sold();
        $new_solde->amount = $old_solde->amount + $formData["amount"]; ##creditation du compte
        $new_solde->owner = $user->id;
        $new_solde->module = $request["module_type"];
        $new_solde->comments = $formData["comments"];
        $new_solde->agency = $old_solde->agency;
        $new_solde->status = 1; ###STATUS INITIE
        $new_solde->credited_at = now();
        $new_solde->session = $session->id;
        $new_solde->save();

        $master_or_admin_of_this_agency = User::find($user->owner);

        $message = "L'agence (ou le partenanire) " . $user->username . " vient d'initier son Solde de " . $formData["amount"] . " sur DIGITAL NETWORK. Veuillez vous connecter pour éffectuer la validation!";

        #=====ENVOIE DE NOTIFICATION =======~####
        try {
            Send_Notification(
                $master_or_admin_of_this_agency,
                "SOLDE INITIE SUR DIGITAL NETWORK",
                $message,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
        // Send_Email(
        //     $master_or_admin_of_this_agency->email,
        //     "Solde Initié sur DIGITAL NETWORK",
        //     $message,
        // );

        // #=====ENVOIE D'SMS =======~####
        // $sms_login =  Login_To_Frik_SMS();
        // if ($sms_login['status']) {
        //     $token =  $sms_login['data']['token'];
        //     Send_SMS(
        //         $master_or_admin_of_this_agency->phone,
        //         $message,
        //         $token
        //     );
        // }
        return self::sendResponse($new_solde, "Solde initié de " . $formData["amount"] . " avec succès!!");
    }

    ####VALIDATE AN INITIATION
    static function validateSolde($agency_id)
    {
        $user = request()->user();

        ###___VERIFIONS D'ABORD SI CETTE AGENCE EXISTE
        $agency = Agency::find($agency_id);
        if (!$agency) {
            return self::sendError("Cette agence n'existe pas!", 404);
        }

        ##S'IL N'EST PAS UN ADMIN
        if (!$user->is_admin) {
            $master = Master::where(["user_id" => $user->id])->get();
            if ($master->count() == 0) {
                return self::sendError("Le compte master auquel vous etes associés n'existe plus", 404);
            }
            $master = $master[0];

            ####___SI LE CURRENT MASTER A UN PARENT
            if ($master->parent) {
                return self::sendError("Désolé! Seul le Master parent a le droit de valider un solde", 505);
            }
        }

        ###___VERIFIONS D'ABORD SI CETTE AGENCE LUI APPARTIENT

        if ($agency->owner != $user->id) {
            return self::sendError("Cette agence ne vous appartient pas!", 404);
        }

        ###___VERIFIONS D'ABORD SI CE SOLDE EXISTE
        $solde = Sold::where(["agency" => $agency_id, "visible" => 1])->get();
        if ($solde->count() == 0) {
            return self::sendError("Ce solde n'existe pas", 404);
        }

        ###VALIDATION DU SOLDE
        $solde = $solde[0];
        $solde->status = 2;
        $solde->save();

        if (!$user->is_admin) {
            $message = "Le Master " . $user->username . " vient de valider votre Solde sur DIGITAL NETWORK.";
        } else {
            $message = "L'admin " . $user->username . " vient de valider votre Solde sur DIGITAL NETWORK.";
        }

        #=====ENVOIE D'EMAIL =======~####
        try {
            Send_Notification(
                $user,
                "SOLDE VALIDE SUR DIGITAL NETWORK",
                $message,
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
        // Send_Email(
        //     $user->email,
        //     "Solde validé sur DIGITAL NETWORK",
        //     $message,
        // );

        #=====ENVOIE D'SMS =======~####
        // $sms_login =  Login_To_Frik_SMS();
        // if ($sms_login['status']) {
        //     $token =  $sms_login['data']['token'];
        //     Send_SMS(
        //         $user->phone,
        //         $message,
        //         $token
        //     );
        // }
        return self::sendResponse($solde, "Solde validé avec succès!!");
    }

    ####VALIDATE AN INITIATION
    static function creditateSoldeForPos($request)
    {
        $user = request()->user();
        $formData = $request->all();

        $user_sold = Sold::where(["owner" => $user->id, "visible" => 1])->get();
        if ($user_sold->count() == 0) {
            return self::sendError("Vous ne disposez pas de solde", 404);
        }
        $user_sold = $user_sold[0];
        if ($user_sold->status == 1) {
            return self::sendError("Votre solde n'est pas encore validé! Vous ne pouvez pas créditer le solde d'un pos!", 505);
        }

        $user_agency = Agency::where(["user_id" => $user->id])->first();
        if (!$user_agency) {
            return self::sendError("L'agence auquelle vous etes liés, n'existe pas", 404);
        }

        $pos = Pos::find($request["pos"]);
        if (!$pos) {
            return self::sendError("Ce Pos n'existe pas!", 404);
        }

        if ($pos->agency_id != $user_agency->id) {
            return self::sendError("Ce pos ne vous appartient pas! Vous ne pouvez donc pas créditer son solde!", 404);
        }

        $module = Module::find($request["module_type"]);
        if (!$module) {
            return self::sendError("Ce module n'existe pas!", 404);
        }

        $pos_solde = Sold::where(["pos" => $request["pos"], "visible" => 1])->get();
        if ($pos_solde->count() == 0) {
            return self::sendError("Le solde de ce pos n'existe pas! Vous ne pouvez donc pas le créditer", 404);
        }

        $pos_solde = $pos_solde[0];

        if ($pos_solde->status == 1) {
            return self::sendError("Ce solde est déjà en cours d'initiation. Merci d'attendre la validation de cette initiation avant de lancer une nouvelle!", 505);
        }

        ###____VERIFIONS SI LE SOLDE DE L'AGENCE EST SUFFISANT
        if (!Is_User_Account_Enough($user->id, $formData["amount"])) {
            return self::sendError("Votre solde est insuffisant! Vous ne pouvez pas créditer le compte de ce POS de " . $formData["amount"], 505);
        }

        ##___DECREDITATION DU SOLDE DE L'AGENCE

        Decredite_User_Account($user->id, $formData);

        ##___CREDITATION DU SOLDE DU POS
        CreditateSoldForPos($formData);

        $message = "L'agence (ou le partenanire) " . $user->username . " vient de créditer votre Solde de " . $formData["amount"] . " sur DIGITAL NETWORK.";

        #=====ENVOIE D'SMS =======~####
        try {
            $sms_login =  Login_To_Frik_SMS();
            if ($sms_login['status']) {
                $token =  $sms_login['data']['token'];
                Send_SMS(
                    $pos->phone,
                    $message,
                    $token
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return self::sendResponse($pos_solde, "Solde crédité avec succès!!");
    }

    static function retrieveSolde($id)
    {
        $user = request()->user();
        if ($user->is_admin) {
            $Solde = Sold::with(["owner", "module", "pos", "agency", "manager"])->find($id);
        } else {
            $Solde = Sold::with(["owner", "module", "pos", "agency", "manager"])->where(["visible" => 1])->find($id);
        }
        if (!$Solde) { #QUAND **$Solde** n'existe pas
            return self::sendError('Ce Solde n\'existe pas!', 404);
        };
        return self::sendResponse($Solde, 'Solde récupéré avec succès!!');
    }

    static function allSoldes()
    {
        $user = request()->user();
        $Soldes = Sold::orderBy("id", "desc")->get();
        return self::sendResponse($Soldes, 'Soldes récupérés avec succès!!');
    }
}
