<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Client;
use App\Models\Piece;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CLIENT_HELPER extends BASE_HELPER
{
    ##======== CLIENT VALIDATION =======##
    static function Client_rules(): array
    {
        return [
            'firstname' => ['required'],
            'lastname' => ['required'],
            // 'phone' => ['required', "numeric", Rule::unique("clients")],
            // 'email' => ['required', "email", Rule::unique("clients")],
            // 'piece' => ['required', "file"],
            // 'type_piece' => ['required', "integer"],
            // 'adresse' => ['required'],
            // 'birthday' => ['required', 'date'],
            // 'sexe' => ['required'],
        ];
    }

    static function Client_messages(): array
    {
        return [
            'firstname.required' => 'Le firstname est réquis!',
            'lastname.required' => 'Le lastname est réquis!',
            'phone.required' => 'Votre numéro de téléphone est réquis',
            'phone.unique' => 'Ce phone existe déjà!',
            'phone.numeric' => 'Votre numéro de téléphone doit être numéric',
            'email.required' => 'Le mail est réquis!',
            'email.email' => 'Le mail n\'est pas valide!',
            'email.unique' => 'Ce mail existe déjà!',

            'sexe.required' => 'Le sexe est réquis!',
            'birthday.required' => 'La date de naissance est réquise!',
            'birthday.date' => 'La date de naissance doit avoir un format date',
            'adress.required' => 'L\'adresse du client est réquise!',
            'piece.required' => 'La pièce d\'identité est réquise!',
            'piece.file' => 'La pièce d\'identité doit être un fichier!',
            'type_piece.required' => 'Le type de la pièce d\'identité est réquise!',
            'type_piece.integer' => 'Le type de la pièce d\'identité doit être un entier!',
        ];
    }

    static function Client_Validator($formDatas)
    {
        $rules = self::Client_rules();
        $messages = self::Client_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _addClient($request)
    {
        $formData = $request->all();
        $user = request()->user();

        ##___Verifions si cette pièce existe
        $piece = Piece::find($formData["type_piece"]);
        if (!$piece) {
            return self::sendError("Ce type de piece d'identité n'existe pas", 404);
        }

        ##GESTION DES IMAGES
        $piece_picture = $request->file('piece');
        $piece_picture_name = $piece_picture->getClientOriginalName();
        $request->file('piece')->move("pieces", $piece_picture_name);

        //REFORMATION DU $formData AVANT SON ENREGISTREMENT DANS LA DB
        $formData["piece"] = asset("pieces/" . $piece_picture_name);
        $formData["owner"] = $user->id;

        ##___ENREGISTREMENT DU CLIENT
        $client = Client::create($formData);
        return self::sendResponse($client, 'Client ajouté avec succès!!');
    }

    static function allClients()
    {
        $user = request()->user();
        if ($user->is_admin) {
            $client =  Client::with(["owner", "type_piece"])->orderBy("id", "desc")->get();
        } else {
            $client =  Client::with(["owner", "type_piece"])->where(['owner' => $user->id, 'visible' => 1])->orderBy("id", "desc")->get();
        }
        return self::sendResponse($client, 'Tout les clients récupérés avec succès!!');
    }

    static function _retrieveClient($id)
    {
        $user = request()->user();
        if ($user->is_admin) {
            $client =  Client::with(["owner", "type_piece"])->find($id);
        } else {
            $client =  Client::with(["owner", "type_piece"])->where(['owner' => $user->id, 'visible' => 1])->find($id);
        }

        if (!$client) {
            return self::sendError("Ce client n'existe pas!", 404);
        }
        return self::sendResponse($client, "Client récupéré avec succès:!!");
    }

    static function _updateClient($request, $id)
    {
        $user = request()->user();
        $formData = $request->all();

        $client =  Client::where(['owner' => $user->id, 'visible' => 1])->find($id);
        if (!$client) {
            return self::sendError("Ce Client n'existe pas!", 404);
        }

        if ($request->get("type_piece")) {
            ##___Verifions si cette pièce existe
            $piece = Piece::find($formData["type_piece"]);
            if (!$piece) {
                return self::sendError("Ce type de piece d'identité n'existe pas", 404);
            }
        }

        ##GESTION DES IMAGES
        if ($request->file("piece")) {
            $piece_picture = $request->file('piece_picture');
            $piece_picture_name = $piece_picture->getClientOriginalName();
            $request->file('piece_picture')->move("pieces", $piece_picture_name);
            $formData["piece_picture"] = asset("pieces/" . $piece_picture_name);
        }

        ##___
        $client->update($formData);
        return self::sendResponse($client, 'Ce Client a été modifié avec succès!');
    }

    static function clientDelete($id)
    {
        $user = request()->user();
        $client =  Client::where(['owner' => $user->id, 'visible' => 1])->find($id);

        if (!$client) {
            return self::sendError("Ce Client n'existe pas!", 404);
        }

        ##__
        $client->visible = false;
        $client->save();
        return self::sendResponse($client, 'Ce client a été supprimé avec succès!');
    }
}
