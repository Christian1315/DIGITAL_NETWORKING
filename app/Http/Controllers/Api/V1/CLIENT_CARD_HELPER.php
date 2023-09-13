<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Card;
use App\Models\CardClient;
use App\Models\CardStatus;
use App\Models\CardType;
use App\Models\Piece;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CLIENT_CARD_HELPER extends BASE_HELPER
{
    ##======== CARD CLIENT VALIDATION =======##
    static function Client_rules(): array
    {
        return [
            'firstname' => ['required'],
            'lastname' => ['required'],
            'card_type' => ['required', 'integer'],
            'birthday' => ['required', 'date'],

            'country' => ['required'],
            'gender' => ['required'],
            'resid_adress' => ['required'],

            'city' => ['required'],
            'departement' => ['required'],
            'phone' => ['required'],
            'email' => ['required', "email"],
            'piece' => ['required', "integer"],
            'piece_picture' => ['required', "file"],
            'souscrib_form_picture' => ['required', "file"],
        ];
    }

    static function Client_messages(): array
    {
        return [
            'firstname.required' => 'Le firstname est réquis!',
            'lastname.required' => 'Le lastname est réquis!',

            'country.required' => 'Le pays est réquis!',
            'gender.required' => 'Le genre est réquis!',
            'resid_adress.required' => 'L\'adresse de la résidence est réquise!',
            'city.required' => 'La ville est réquise!',
            'departement.required' => 'Le département est réquise!',
            'phone.required' => 'Le téléphone est réquis!',

            'email.required' => 'Le mail est réquis!',
            'email.email' => 'Le format mail n\'est pas repecté',


            'birthday.required' => 'La date de naissance est réquise!',
            'birthday.date' => 'La date de naissance doit avoir un format date',

            'card_type.required' => 'Le type de la Carte est réquis!',
            'card_type.integer' => 'L\'ID de la Carte est un entier!',

            'piece.required' => 'La pièce d\'identité est réquise!',
            'piece.integer' => 'Le pièce d\'identité est un entier!',

            'piece_picture.required' => 'La photo de la pièce d\'identité est réquise!',
            'piece_picture.file' => 'La photo de la pièce d\'identité est une image ou un fichier!',

            'souscrib_form_picture.required' => 'La photo du formulaire d\'inscription est réquise!',
            'souscrib_form_picture.file' => 'La photo du du formulaire de souscription est une image ou un fichier!',
        ];
    }

    static function Client_Validator($formDatas)
    {
        $rules = self::Client_rules();
        $messages = self::Client_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _PartialValidation($request, $card)
    {
        $formData = $request->all();
        $user = request()->user();

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

        ##___Verifions si ce type de carte existe
        $cardType = CardType::find($formData["card_type"]);
        if (!$cardType) {
            return self::sendError("Ce type de carte n'existe pas", 404);
        }

        ##___Verifions si cette pièce existe
        $piece = Piece::find($formData["piece"]);
        if (!$piece) {
            return self::sendError("Ce type de piece d'identité n'existe pas", 404);
        }

        ##__Verifions si la carte a été affectée au user au cas ou ce dernier est une Agence.
        if (!$user->is_admin) {
            ##s'il n'est pas un admin, il est une agence dans ce cas,
            if (!$card->agency == $user->id) { ##on verifie si **agency** de la Card corresponds au **userId** du user
                return self::sendError("Désolé! Cette carte ne vous a pas été affectée!", 505);
            }
        }

        ##GESTION DES IMAGES
        $piece_picture = $request->file('piece_picture');
        $piece_picture_name = $piece_picture->getClientOriginalName();
        $request->file('piece_picture')->move("pieces", $piece_picture_name);

        $souscrib_form_picture = $request->file('souscrib_form_picture');
        $souscrib_form_picture_name = $souscrib_form_picture->getClientOriginalName();
        $request->file('souscrib_form_picture')->move("souscrib_form_pictures", $souscrib_form_picture_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA DB
        $formData["piece_picture"] = asset("pieces/" . $piece_picture_name);
        $formData["souscrib_form_picture"] = asset("souscrib_form_pictures/" . $piece_picture_name);

        ##___ENREGISTREMENT DU CLIENT
        $client = CardClient::create($formData);
        $client->owner =  $user->id;
        $client->save();

        #### ACTUALISATION DE LA CARTE
        $card->client = $client->id;
        ##__

        ##__ACTIVATION DE LA CARTE
        $card->status = 4;

        ###__
        $card->save();
        return self::sendResponse($card, 'Carte partellement activée avec succès!! Attendez le master pour une activation complete');
    }

    static function allClients()
    {
        $user = request()->user();
        if ($user->is_admin) {
            $client =  CardClient::with(["card_type", "card"])->orderBy("id", "desc")->get();
        } else {
            $client =  CardClient::with(["card_type", "card"])->where(['owner' => $user->id, 'visible' => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($client, 'Tout les clients récupérés avec succès!!');
    }

    static function _retrieveClient($id)
    {
        $user = request()->user();
        if ($user->is_admin) {
            $client =  CardClient::with(["owner", "status", "type", "client", "agency"])->find($id);
        } else {
            $client =  CardClient::with(["owner", "status", "type", "client", "agency"])->where(['owner' => $user->id, 'visible' => 1])->find($id);
        }
        return self::sendResponse($client, "Client récupéré avec succès:!!");
    }

    static function _updateClient($request, $id)
    {
        $user = request()->user();
        $client =  CardClient::with(["owner"])->where(['id' => $id, 'owner' => $user->id, 'visible' => 1])->find($id);

        if (!$client) {
            return self::sendError("Ce Client n'existe pas!", 404);
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
            #Changement de status
            $card->status = $request->get("status");
            $card->save();
        }

        $card->update($request->all());
        return self::sendResponse($card, 'Cette carte a été modifiée avec succès!');
    }

    static function ClientDelete($id)
    {
        $user = request()->user();
        $client =  CardClient::with(["owner"])->where(['id' => $id, 'owner' => $user->id, 'visible' => 1])->find($id);

        if (!$client) {
            return self::sendError("Cette Carte n'existe pas!", 404);
        }

        ##__
        $client->visible = false;
        $client->save();
        return self::sendResponse($client, 'Ce client a été supprimé avec succès!');
    }
}
