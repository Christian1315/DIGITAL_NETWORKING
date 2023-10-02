<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Agent;
use App\Models\Card;
use App\Models\CardClient;
use App\Models\CardRecharge;
use App\Models\CardType;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

class CARD_RECHARGE_HELPER extends BASE_HELPER
{
    ##======== RECHARGE CARD VALIDATION =======##
    static function Recharge_Card_rules(): array
    {
        return [
            'card_id' => ['required', 'integer',],
            'card_num' => ['required', 'integer',],
            'card_type' => ['required', 'integer'],
            'client' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
            'frais_amount' => ['required', 'integer'],
            'amount_to_pay' => ['required', 'integer'],
        ];
    }

    static function Recharge_Card_messages(): array
    {
        return [
            'card_id.required' => 'L\'ID de la Carte est réquis!',
            'card_num.required' => 'Le numéro de la Carte est réquis!',
            'card_type.required' => 'Le type de la Carte est réquis!',
            'client.required' => 'Le client de la Carte est réquis!',
            'amount.required' => 'Le montant à recharger est réquis!',
            'frais_amount.required' => 'Les frais de course sont réquis!',
            'amount_to_pay.required' => 'Le montant à payer est réquis!',

            'card_id.integer' => 'L\'ID de la Carte est un entier!',
            'card_num.integer' => 'Le numero de la Carte est un entier!',
            'card_type.integer' => 'Le type de la Carte est un entier!',
            'amount.integer' => 'Le montant à recharger est un entier!',
            'frais_amount.integer' => 'Frais de course est un entier!',
            'amount_to_pay.integer' => 'Le montant à payer est un entier!',
        ];
    }

    static function Recharge_Card_Validator($formDatas)
    {
        $rules = self::Recharge_Card_rules();
        $messages = self::Recharge_Card_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##_______

    static function _initiateRechargement($request, $id)
    {
        $formData = $request->all();
        $user = request()->user();

        ##___
        $card = Card::find($id);
        if (!$card) {
            return self::sendError("Cette carte n'existe pas!", 404);
        }

        $cardClient = $card->client;

        ##___Verifions si cette carte est activée ou pas
        if ($card->status != 5) {
            return self::sendError("Cette carte n'est pas activée! Vous ne pouvez pas la recharger!", 404);
        }

        ##___Verifions si ce type de carte existe
        $cardType = CardType::find($formData["card_type"]);
        if (!$cardType) {
            return self::sendError("Ce type de carte n'existe pas", 404);
        }

        ##___Verifions si ce **card_id** corresponds vraiment au **card_id** de la carte.
        if ($card->card_id != $formData["card_id"]) {
            return self::sendError("Ce card_id ne corresponds pas à celui de la carte à recharger!", 404);
        }

        ##___Verifions si ce **card_num** corresponds vraiment au **card_num** de la carte.
        if ($card->card_num != $formData["card_num"]) {
            return self::sendError("Ce card_num ne corresponds pas à celui de la carte à recharger!", 404);
        }

        ##___Verifions si ce **card_type** corresponds vraiment au **card_type** de la carte.
        if ($card->type != $formData["card_type"]) {
            return self::sendError("Ce type de Carte ne corresponds pas à celui de la carte à recharger!", 404);
        }

        ##___Verifions si ce client existe
        $client = Client::find($formData["client"]);
        if (!$client) {
            return self::sendError("Ce client n'existe pas", 404);
        }

        ##___Verifions si ce **client** corresponds vraiment au client lié à la carte.
        if ($cardClient != $formData["client"]) {
            return self::sendError("Ce client ne corresponds pas à celui qui detient la carte!", 404);
        }

        ###L'agent actuel
        $current_agent = Agent::where(["user_id" => $user->id])->get();
        if ($current_agent->count() == 0) {
            return self::sendError("Le compte agent auquel vous êtes associé.e n'existe plus", 404);
        }
        $current_agent = $current_agent[0];

        ##CETTE VARIABLE BOOLEENNE PERMET DE SAVOIR SI L'AGENT APPARTIENT A L'UN DES POS DE L'AGENCE DETENANT CETTE CARTE
        $is_this_current_agent_among_all_agents_affected_to_this_agency_poss = false;

        ####_____
        $agency = Agency::find($card->agency);

        ###tout les POS associciés à cette agence
        $all_poss_affected_to_this_agency = $agency->poss;
        $my_pos = null;

        ###je parcoure tout les pos
        foreach ($all_poss_affected_to_this_agency as $pos) {
            $this_pos_agents = $pos->agents;
            ###je parcoure tout les agents associés à ce pos
            foreach ($this_pos_agents as $agent) {
                if ($agent->id == $current_agent->id) { ###Le current_agent en fait partis
                    $my_pos = $pos;
                    $is_this_current_agent_among_all_agents_affected_to_this_agency_poss = true;
                }
            }
        }

        ###S'il na fait pas partis
        if (!$is_this_current_agent_among_all_agents_affected_to_this_agency_poss) {
            return self::sendError("Désolé! Vous ne faites pas partis des agents de l'un des POS associés à l'agence detenant cette carte", 505);
        }

        ###____VERIFIONS SI LE SOLDE DE L'AGENCE EST SUFFISANT
        if (!Is_Pos_Account_Enough($my_pos->id, $formData["amount"])) {
            return self::sendError("Votre solde est insuffisant! Vous ne pouvez pas recharger cette carte", 505);
        }

        ##___DECREDITATION DU SOLDE DE L'AGENCE
        $countData = [
            "module_type" => 1,
            "comments" => "Décreditation de solde pour recharger une carte!",
            "amount" => $formData["amount"],
            "pos" => $my_pos->id
        ];

        Decredite_Pos_Account($countData);

        ##___....
        $recharge = CardRecharge::create($formData);
        $recharge->owner = $user->id;
        $recharge->card = $id;
        $recharge->status = 4;
        $recharge->save();
        return self::sendResponse($recharge, 'Rechargement initié avec succès!!');
    }

    static function allRechargements()
    {
        $user = request()->user();
        if ($user->is_admin) {
            $rechargement =  CardRecharge::with(["owner", "card", "client", "status"])->orderBy("id", "desc")->get();
        } else {
            $rechargement =  CardRecharge::with(["owner", "card", "client", "status"])->where(['owner' => $user->id, 'visible' => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($rechargement, 'Tout les rechargements récupérés avec succès!!');
    }

    static function _retrieveRechargement($id)
    {
        $user = request()->user();
        if ($user->is_admin) {
            $rechargement =  CardRecharge::with(["owner", "card", "client"])->find($id);
        } else {
            $rechargement =  CardRecharge::with(["owner", "card", "client"])->where(['owner' => $user->id, 'visible' => 1])->find($id);
        }

        if (!$rechargement) {
            return self::sendError("Ce rechargement n'existe pas!", 404);
        }
        return self::sendResponse($rechargement, "Rechargement récupérée avec succès:!!");
    }

    static function _updateRechargement($request, $id)
    {
        $user = request()->user();
        $rechargement =  CardRecharge::with(["owner", "status"])->where(['owner' => $user->id, 'visible' => 1])->find($id);

        if (!$rechargement) {
            return self::sendError("Ce rechargement n'existe pas!", 404);
        }

        ##__S'IL VEUT VALIDER LA CARTE
        if ($request->get("status") == 5) {
            ##___Verifions si ce rechargement est déjà initié
            if ($rechargement->status != 4) {
                return self::sendError("Ce rechargement n'est pas encore initié! Vous ne pouvez pas le valider!", 404);
            }
        }


        $rechargement->update($request->all());
        return self::sendResponse($rechargement, 'Ce rechargement a été modifié avec succès!');
    }

    static function _rechargementDelete($id)
    {
        $user = request()->user();
        $rechargement =  CardRecharge::where(['owner' => $user->id, 'visible' => 1])->find($id);

        if (!$rechargement) {
            return self::sendError("Ce rechargement n'existe pas!", 404);
        }

        $rechargement->visible = false;
        $rechargement->save();
        return self::sendResponse($rechargement, 'Ce rechargement a été supprimé avec succès!');
    }
}
