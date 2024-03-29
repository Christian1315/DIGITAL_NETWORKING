<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agency;
use App\Models\Agent;
use App\Models\Card;
use App\Models\CardStatus;
use App\Models\CardType;
use App\Models\Client;
use App\Models\Piece;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CARD_HELPER extends BASE_HELPER
{
    ##======== CARD VALIDATION =======##
    static function Card_rules(): array
    {
        return [
            'card_id' => ['required', 'integer', Rule::unique("cards")],
            'card_num' => ['required', 'integer', Rule::unique("cards")],
            'type' => ['required', 'integer'],
            'expire_date' => ['required', 'date'],
        ];
    }

    static function Card_messages(): array
    {
        return [
            'card_id.required' => 'L\'ID de la Carte est réquis!',
            'card_num.required' => 'Le numéro de la Carte est réquis!',
            'type.required' => 'Le type de la Carte est réquis!',
            'expire_date.required' => 'La date d\'expiration de la Carte est réquise!',

            'card_id.integer' => 'L\'ID de la Carte est un entier!',
            'card_num.integer' => 'Le numero de la Carte est un entier!',
            'type.integer' => 'Le type de la Carte est un entier!',
            'expire_date.date' => 'La date d\'expiration doit avoir un format date',
        ];
    }

    static function Card_Validator($formDatas)
    {
        $rules = self::Card_rules();
        $messages = self::Card_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##VALIDATION DE L'AFFECTION DES CARTES AUX AGENCES

    static function Affect_Card_rules(): array
    {
        return [
            'card_id' => ['required', 'integer'],
            'agency_id' => ['required', 'integer'],
        ];
    }

    static function Affect_Card_messages(): array
    {
        return [
            'card_id.required' => 'L\'ID de la Carte est réquis!',
            'agency_id.required' => 'L\'ID de l\'agence est réquis!',

            'card_id.integer' => 'L\'ID de la Carte est un entier!',
            'agency_id.integer' => 'L\'ID de  l\'agence est un entier!',
        ];
    }

    static function Affect_Card_Validator($formDatas)
    {
        $rules = self::Affect_Card_rules();
        $messages = self::Affect_Card_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }


    ##VALIDATION DE LA VERIFICATION DES CARTES

    static function Verify_Card_rules(): array
    {
        return [
            'card_id' => ['required'],
            'card_num' => ['required'],
        ];
    }

    static function Verify_Card_messages(): array
    {
        return [
            'card_id.required' => 'L\'ID de la Carte est réquis!',
            'card_num.required' => 'Le numéro de la carte est réquise!',
        ];
    }

    static function Verify_Card_Validator($formDatas)
    {
        $rules = self::Verify_Card_rules();
        $messages = self::Verify_Card_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    ##_______

    static function _PartialValidation($request, $card)
    {
        $formData = $request->all();
        $user = request()->user();
        $session = GetSession($user->id);

        ##___VALIDATION DU CLIENT
        $validator = CLIENT_HELPER::Client_Validator($formData);

        if ($validator->fails()) {
            return self::sendError($validator->errors(), 404);
        }

        ##____
        $card = Card::find($card);
        if (!$card) {
            return self::sendError("Cette carte n'existe pas!", 404);
        }

        ##__Vérifions si la carte a vraiment été affectée
        if (!$user->is_admin) { ##S'il n'est pas un admin
            if (!$card->affected) {
                return self::sendError("Désolé! Cette carte n'a pas encore été affectée! Vous ne pouvez pas l'activer", 505);
            }
        }


        ##__Vérifions si la carte a été activée partiellement
        if ($card->status == 4) {
            return self::sendError("Cette carte a déjà été activée partiellement!", 505);
        }

        ##__Vérifions si la carte a été activée complètement
        if ($card->status == 5) {
            return self::sendError("Cette carte a déjà été activée complètement par le Master!", 505);
        }

        ##___Vérifions si cette pièce existe
        $piece = Piece::find($formData["type_piece"]);
        if (!$piece) {
            return self::sendError("Ce type de piece d'identité n'existe pas", 404);
        }

        $current_agent = Agent::where(["user_id" => $user->id])->get();
        if ($current_agent->count() == 0) {
            return self::sendError("Le compte agent auquel vous êtes associé.e n'existe plus", 404);
        }

        ###L'agent actuel
        $current_agent = $current_agent[0];

        ##CETTE VARIABLE BOOLEENNE PERMET DE SAVOIR SI L'AGENT APPARTIENT A L'UN DES POS DE L'AGENCE DETENANT CETTE CARTE
        $is_this_current_agent_among_all_agents_affected_to_this_agency_poss = false;

        ####_____
        $agency = Agency::find($card->agency);

        ###tout les POS associciés à cette agence
        $all_poss_affected_to_this_agency = $agency->poss;

        ###je parcoure tout les pos
        foreach ($all_poss_affected_to_this_agency as $pos) {
            $this_pos_agents = $pos->agents;
            ###je parcoure tout les agents associés à ce pos
            foreach ($this_pos_agents as $agent) {
                if ($agent->id == $current_agent->id) { ###Le current_agent en fait partis
                    $is_this_current_agent_among_all_agents_affected_to_this_agency_poss = true;
                }
            }
        }

        ###S'il ne fait pas partis
        if (!$is_this_current_agent_among_all_agents_affected_to_this_agency_poss) {
            return self::sendError("Désolé! Vous ne faites pas partis des agents de l'un des POS associés à l'agence detenant cette carte", 505);
        }

        ##__Verifions si la carte a été affectée au user au cas ou ce dernier est une Agence.
        if (!$user->is_admin) {
            ##s'il n'est pas un admin, il est une agence dans ce cas,
            if (!$card->agency == $user->id) { ##on verifie si **agency** de la Card corresponds au **userId** du user
                return self::sendError("Désolé! Cette carte ne vous a pas été affectée!", 505);
            }
        }

        ##GESTION DES IMAGES
        $piece_picture = $request->file('piece');
        $piece_picture_name = $piece_picture->getClientOriginalName();
        $request->file('piece')->move("pieces", $piece_picture_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA DB
        $formData["piece"] = asset("pieces/" . $piece_picture_name);
        $formData["owner"] = $user->id;


        $client = Client::create($formData);

        #### ACTUALISATION DE LA CARTE
        $card->client = $client->id;
        ##__

        ##__ACTIVATION DE LA CARTE
        $card->status = 4;

        ##__SESSSION
        $card->session = $session->id;

        ###__
        $card->save();
        return self::sendResponse($card, 'Carte partiellement activée avec succès!! Attendez le master pour une activation complete');
    }

    static function _createCard($formData)
    {
        $user = request()->user();
        ##___Verifions si ce type de carte existe
        $cardType = CardType::find($formData["type"]);
        if (!$cardType) {
            return self::sendError("Ce type de carte n'existe pas", 404);
        }

        $card = Card::create($formData);
        $card->owner = $user->id;
        $card->status = 1;
        $card->save();
        return self::sendResponse($card, 'Carte ajoutée avec succès!!');
    }

    static function allCards()
    {
        $user = request()->user();
        if ($user->is_admin) {
            $cards =  Card::with(["owner", "status", "type", "client", "agency", "rechargement", "session"])->orderBy("id", "desc")->get();
        } else {
            $cards =  Card::with(["owner", "status", "type", "client", "agency", "rechargement", "session"])->where(['owner' => $user->id, 'visible' => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($cards, 'Toute les Cartes récupérés avec succès!!');
    }

    static function _retrieveCard($id)
    {
        $user = request()->user();
        if ($user->is_admin) {
            $card =  Card::with(["owner", "status", "type", "client", "agency", "rechargement", "session"])->find($id);
        } else {
            $card =  Card::with(["owner", "status", "type", "client", "agency", "rechargement", "session"])->where(['owner' => $user->id, 'visible' => 1])->find($id);
        }

        if (!$card) {
            return self::sendError("Cette Carte n'existe pas!", 404);
        }
        return self::sendResponse($card, "Carte récupérée avec succès:!!");
    }

    static function _updateCard($request, $id)
    {
        $user = request()->user();
        $card =  Card::with(["owner"])->where(['owner' => $user->id, 'visible' => 1])->find($id);

        if (!$card) {
            return self::sendError("Cette Carte n'existe pas!", 404);
        }

        if ($request->get("card_id")) {
            if (!is_numeric($request->get("card_id"))) {
                return self::sendError("L'ID de la Carte doit être un entier!", 505);
            }
        }

        if ($request->get("card_num")) {
            if (!is_numeric($request->get("card_num"))) {
                return self::sendError("Le numéro de la Carte doit être en entier!", 505);
            }
        }

        if ($request->get("client")) {
            $cardClient = Card::where(["client" => $request->get("client")])->get();

            if ($cardClient->count() != 0) {
                return self::sendError("Une carte existe déjà au nom de ce client", 505);
            }
        }

        if ($request->get("status")) {
            if (!is_numeric($request->get("status"))) {
                return self::sendError("Le status de la Carte doit être en entier!", 505);
            }

            #ETUDE DU STATUS
            $status = CardStatus::find($request->get("status"));
            if (!$status) {
                return self::sendError("Ce status de carte n'existe pas!", 505);
            }

            ##__S'IL VEUT ACTIVER LA CARTE
            if ($request->get("status") == 5) {
                ##___Verifions si cette carte est déjà activée partiellement
                if ($card->status != 5) {
                    if ($card->status != 4) {
                        return self::sendError("Cette carte n'est pas encore activée partiellement! Vous ne pouvez pas l'activer complètement!", 404);
                    }
                }
            }

            #Changement de status
            $card->status = $request->get("status");
            $card->save();
        }

        $card->update($request->all());
        return self::sendResponse($card, 'Cette carte a été modifiée avec succès!');
    }

    static function CardDelete($id)
    {
        $user = request()->user();
        $card =  Card::with(["owner"])->where(['id' => $id, 'owner' => $user->id, 'visible' => 1])->find($id);

        if (!$card) {
            return self::sendError("Cette Carte n'existe pas!", 404);
        }

        $card->visible = false;
        $card->save();
        return self::sendResponse($card, 'Cette carte a été supprimée avec succès!');
    }

    static function _AffectCartToAgency($request)
    {
        $formData = $request->all();
        $user = request()->user();
        if ($user->is_admin) {
            $card = Card::where(['id' => $formData['card_id'], "visible" => 1])->get();
            $agency = Agency::where(['id' => $formData['agency_id'], "visible" => 1])->get();
        } else {
            $card = Card::where(['owner' => $user->id, 'id' => $formData['card_id'], "visible" => 1])->get();
            $agency = Agency::where(['owner' => $user->id, 'id' => $formData['agency_id'], "visible" => 1])->get();
        }

        if ($card->count() == 0) {
            return  self::sendError("Cette carte n'existe pas!!", 404);
        }

        if ($agency->count() == 0) {
            return  self::sendError("Cette Agence n'existe pas!!", 404);
        }

        $card = $card[0];
        $agency = $agency[0];

        ##____VERIFIONS SI CETTE CARTE A DEJA ETE AFFECTEE
        if ($card->affected) {
            return self::sendError("Cette carte a déjà été affectée à une agence", 505);
        }

        ##__
        $card->agency = $formData["agency_id"];
        $card->affected = true;

        $card->save();

        return self::sendResponse($card, "Affectation effectuée avec succès!!");
    }

    function _VerifyCard($request)
    {
        $formData = $request->all();
        $card = Card::where(["card_id" => $formData["card_id"], "card_num" => $formData["card_num"]])->get();
        if ($card->count() == 0) {
            return self::sendError("Cette carte n'existe pas!", 404);
        }

        return self::sendResponse($card, "Carte vérifiée!");
    }
}
