<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\CanalFormula;
use App\Models\CanalSubscription;
use App\Models\CanalSubscriptionOption;
use App\Models\CanalSubscriptionStatus;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CANAL_SUBSCRIPTION_HELPER extends BASE_HELPER
{
    ##======== SUBSCRIPTION VALIDATION =======##
    static function subscription_rules(): array
    {
        return [
            'decodeur_num' => ['required', 'numeric'],
            'option' => ['required', 'integer'],
            'formule' => ['required', 'integer'],
            'month' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'country_prefix' => ['required', 'numeric'],
            'detail' => ["required"]
        ];
    }

    static function subscription_messages(): array
    {
        return [
            'decodeur_num.required' => 'Le numero du decodeur est réquis!',
            'option.required' => 'Veuillez préciser l\'option de cette souscription!',
            'formule.required' => 'Veuillez préciser la formule de cette souscription!',
            'month.required' => 'Veuillez préciser le nombre de mois pour cette souscription!',
            'amount.required' => 'Veuillez préciser le montant de cette souscription!',

            'decodeur_num.numeric' => 'Le numero du decodeur doit être de caractère numéric!',
            'option.integer' => 'L\'option de la souscription doit être de caractère numéric!',
            'formule.integer' => 'La formule de la souscription doit être de caractère numéric!',
            'month.integer' => 'Le numero du decodeur doit être de caractère numéric!',
            'amount.numeric' => 'Le numero du decodeur doit être de caractère numéric!',
            'detail' => 'Veuillez préciser un commentaire sur cette initiation'
        ];
    }

    static function Subscription_Validator($formDatas)
    {
        $rules = self::subscription_rules();
        $messages = self::subscription_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##======== validate a SUBSCRIPTION  =======##
    static function validate_subscription_rules(): array
    {
        return [
            'receipt' => ['required', 'file'],
            'validation_details' => ['required'],
        ];
    }

    static function validate_subscription_messages(): array
    {
        return [
            'receipt.required' => 'Le reçu est réquis!',
            'receipt.file' => 'Le reçu doit être un fichier!',
            'validation_details.required' => 'Veuillez préciser un detail (commentaire) sur cette validation!',
        ];
    }

    static function Validate_Subscription_Validator($formDatas)
    {
        $rules = self::validate_subscription_rules();
        $messages = self::validate_subscription_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##VALIDATION DU SEARCH DES SOUSCRIPTIONS

    static function search_subscription_rules(): array
    {
        return [
            'decodeur_num' => ['required'],
        ];
    }

    static function search_subscription_messages(): array
    {
        return [
            'decodeur_num.required' => 'Le numéro du décodeur est réquis!',
        ];
    }

    static function Search_subscription_Validator($formDatas)
    {
        $rules = self::search_subscription_rules();
        $messages = self::search_subscription_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }
    ##_______

    function _searchSubscription($request)
    {
        $formData = $request->all();
        $subscription = CanalSubscription::with(["manager", "session", "client", "agency", "option", "status"])->where(["decodeur_num" => $formData["decodeur_num"]])->get();
        if ($subscription->count() == 0) {
            return self::sendError("Cette souscription n'existe pas!", 404);
        }
        return self::sendResponse($subscription, "Cette souscription existe!");
    }

    static function _initiateSubscription($request)
    {
        $formData = $request->all();
        $user = request()->user();
        $session = GetSession($user->id);

        $option = CanalSubscriptionOption::find($formData["option"]);
        $formule = CanalFormula::find($formData["formule"]);

        if (!$option) {
            return self::sendError("Cette option n'existe pas!", 404);
        }

        if (!$formule) {
            return self::sendError("Cette formule n'existe pas!", 404);
        }

        $clientData = [
            "firstname" => $formData["firstname"],
            "lastname" => $formData["lastname"],
            "phone" => $formData["phone"],
            "country_prefix" => $formData["country_prefix"],
            "piece" => 1,
        ];

        $current_agent = Agent::where(["user_id" => $user->id])->get();
        if ($current_agent->count() == 0) {
            return self::sendError("Le compte agent auquel vous êtes associé.e n'existe plus", 404);
        }


        ###L'agent actuel
        $current_agent = $current_agent[0];
        $this_agent_pos = $current_agent->pos;
        // $this_agent_pos_sold = $this_agent_pos->sold;


        ####VOYONS SI LE POS DISPOSE D'UN SOLDE SUFFISANT

        if (!Is_Pos_Account_Enough($this_agent_pos->id, $formData["amount"])) {
            return self::sendError("Désolé! Votre Pos ne dispose pas de solde suffisant pour éffectuer cette opération!", 505);
        }

        $formData["status"] = 1;
        $formData["session"] = $session->id;
        $formData["manager"] = $user->id;

        ###___ENREGISTREMENT DE LA SOUSCRIPTION
        $subscription = CanalSubscription::create($formData);


        ###~~~VOYONS D'ABORD SI LE CLIENT EXISTE~~##
        $clt = Client::where(["firstname" => $formData["firstname"], "lastname" => $formData["lastname"], "phone" => $formData["phone"]])->get();
        if ($clt->count() == 0) { ##si le client n'existe pas déjà
            ###___ENREGISTREMENT DU CLIENT
            $client = Client::create($clientData);
        } else {
            $client = $clt[0];
        }


        ###___ACTUALISATION DE LA SOUSCRIPTION
        $subscription->client = $client->id;
        $subscription->save();
        ###___


        ##___DECREDITATION DU SOLDE DE L'AGENCE
        $countData = [
            "module_type" => 1,
            "comments" => "Décreditation de solde du Pos par " . $user->username . ", pour initier une souscription!",
            "amount" => $formData["amount"],
            "pos" => $this_agent_pos->id
        ];
        Decredite_Pos_Account($countData);

        return self::sendResponse($subscription, 'Souscription initiée avec succès!! Attendez le master pour une vailidation complete');
    }

    static function _validateSubscription($request, $id)
    {
        $formData = $request->all();
        $user = request()->user();

        $subscription = CanalSubscription::where(["visible" => 1])->find($id);

        if (!$subscription) {
            return self::sendError("Cette souscription n'existe pas!", 404);
        }

        if ($subscription->status == 3) {
            return self::sendError("Cette souscription est déjà validée!", 404);
        }

        $subscription_owner = User::find($subscription->manager);
        $subscription_agent = Agent::where(["user_id" => $subscription_owner->id])->get();

        if ($subscription_agent->count() == 0) {
            return self::sendError("L'agent associé à cette souscription n'existe plus!", 404);
        }
        $subscription_agent = $subscription_agent[0];

        if ($subscription_agent->owner != $user->id) {
            return self::sendError("L'agent initiateur de cette souscription ne vous appartient pas! Vous ne pouvez donc pas valider sa souscription!", 201);
        }

        $receipt = $request->file('receipt');
        $img_name = $receipt->getClientOriginalName();
        $request->file('receipt')->move("soubscribe_receipts", $img_name);
        $formData["receipt"] = asset("soubscribe_receipts/" . $img_name);

        ###___ACTUALISATION DE LA SOUSCRIPTION
        $subscription->status = 3;
        $subscription->receipt = $formData["receipt"];
        $subscription->validation_details = $formData["validation_details"];
        $subscription->save();
        ###___

        #=====ENVOIE DE MAIL =======~####
        try {
            Send_Notification(
                $subscription_owner,
                "Validation de souscription",
                "Votre souscription a été validée avec succès, par " . $user->username . " . Voici ci-dessous votre reçu :" . $formData["receipt"],
            );
        } catch (\Throwable $th) {
            //throw $th;
        }

        return self::sendResponse($subscription, 'Souscription validée avec succès!!');
    }

    static function subscriptions()
    {
        $user = request()->user();
        if ($user->is_admin) {
            $subscriptions =  CanalSubscription::with(["manager", "status", "session", "client", "option", "formule", "session"])->orderBy("id", "desc")->get();
        } else {
            $subscriptions =  CanalSubscription::with(["manager", "status", "session", "client", "option", "formule", "session"])->where(['manager' => $user->id, 'visible' => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($subscriptions, 'Toute les Subscriptions récupérées avec succès!!');
    }

    static function _retrieveSubscription($id)
    {
        $user = request()->user();
        if ($user->is_admin) {
            $subscription =  CanalSubscription::with(["manager", "status", "session", "client", "option", "formule", "session"])->find($id);
        } else {
            $subscription =  CanalSubscription::with(["manager", "status", "session", "client", "option", "formule", "session"])->where(['manager' => $user->id, 'visible' => 1])->find($id);
        }

        if (!$subscription) {
            return self::sendError("Cette subscription n'existe pas!", 404);
        }
        return self::sendResponse($subscription, "Subscription récupérée avec succès:!!");
    }

    static function _updateSubscription($request, $id)
    {
        $user = request()->user();
        $subscription =  CanalSubscription::where(['manager' => $user->id, 'visible' => 1])->find($id);

        if (!$subscription) {
            return self::sendError("Cette subscription n'existe pas!", 404);
        }

        if ($request->get("formule")) {
            if (!is_numeric($request->get("formule"))) {
                return self::sendError("La formule de l'inscription doit être un entier!", 505);
            }

            $formule = CanalFormula::find($request->get("formule"));
            if (!$formule) {
                return self::sendError("Cette formule n'existe pas!", 404);
            }
        }

        if ($request->get("option")) {
            if (!is_numeric($request->get("option"))) {
                return self::sendError("L'option de l'inscription doit être un entier!", 505);
            }

            $option = CanalSubscriptionOption::find($request->get("option"));
            if (!$option) {
                return self::sendError("Cette option n'existe pas!", 404);
            }
        }


        if ($request->get("client")) {
            return self::sendError("Impossible de changer le client!", 505);
        }

        if ($request->get("agency")) {
            return self::sendError("Impossible de changer l'agence'!", 505);
        }

        if ($request->get("status")) {

            if (!Is_User_A_Master_Or_Admin($user->id)) {
                return self::sendError("Désolé! Seuls les masters ou admins ont le droit de changer le status d'une souscription!", 505);
            };

            if (!is_numeric($request->get("status"))) {
                return self::sendError("Le status de souscription doit être en entier!", 505);
            }

            #ETUDE DU STATUS
            $status = CanalSubscriptionStatus::find($request->get("status"));
            if (!$status) {
                return self::sendError("Ce status de souscription n'existe pas!", 505);
            }

            ##__S'IL VEUT VALIDER LA SOUSCRIPTION
            if ($request->get("status") == 3) {
                return self::sendError("Il ne vous est pas permis de valider une souscription de cette façon! Veuillez bien suivre la procédure normale!", 505);
            }

            #Changement de status
            $subscription->status = $request->get("status");
            $subscription->save();
        }

        $subscription->update($request->all());
        return self::sendResponse($subscription, 'Cette souscription a été modifiée avec succès!');
    }

    static function SubscriptionDelete($id)
    {
        $user = request()->user();
        $subscription =  CanalSubscription::where(['manager' => $user->id, 'visible' => 1])->find($id);

        if (!$subscription) {
            return self::sendError("Cette souscription n'existe pas!", 404);
        }

        $subscription->visible = false;
        $subscription->save();
        return self::sendResponse($subscription, 'Cette subscription a été supprimée avec succès!');
    }
}
