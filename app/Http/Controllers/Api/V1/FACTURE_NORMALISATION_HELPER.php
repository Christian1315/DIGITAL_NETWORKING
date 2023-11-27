<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agent;
use App\Models\StoreFacturation;
use Illuminate\Support\Facades\Validator;
use PDF;

class FACTURE_NORMALISATION_HELPER extends BASE_HELPER
{
    ##======== REGISTER VALIDATION =======##
    static function facture_normalisation_rules(): array
    {
        return [
            'client' => 'required|integer',
        ];
    }

    static function facture_normalisation_messages(): array
    {
        return [
            'client.required' => 'Veuillez precisez l\'id du client à facturer!',
            'client.integer' => 'Le champ client doit être un entier!',
        ];
    }

    static function Facture_normalisation_Validator($formDatas)
    {
        $rules = self::facture_normalisation_rules();
        $messages = self::facture_normalisation_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function demandeFactureNormalisation($facture)
    {
        $user = request()->user();
        $facture = StoreFacturation::with(["client", "facturier"])->where(["visible" => 1])->find($facture);
        if (!$facture) {
            return self::sendError("Cette facture n'existe pas!", 404);
        }

        ##__VOYONS SI CETTE FACTURE EST DEJA NORMALISEE
        if ($facture->normalized) {
            return self::sendError("Cette facture est déjà noemalisée!", 404);
        }

        if (!Is_User_An_Admin($user->id)) {
            if ($facture->facturier != $user->id) {
                return self::sendError("Cette facture ne vous appartient pas! Vous ne pouvez donc pas la normaliser!", 505);
            }
        }

        return self::sendResponse($facture, 'Demande de normalisation de facture effectuée avec succès!!');
    }

    static function retrieveFactureNormalisation($id)
    {
        $facture = StoreFacturation::with(["client", "facturier"])->find($id);
        if (!$facture) {
            return self::sendError("Cette facture n'est pas disponible", 404);
        }
        return self::sendResponse($facture, "Facture récupérée avec succès");
    }

    static function facturesNormalisations()
    {
        $factures = StoreFacturation::with(["client", "facturier"])->orderBy("id", "desc")->get();
        if ($factures->count() == 0) {
            return self::sendError("Aucune facture n'est disponible", 404);
        }
        return self::sendResponse($factures, 'Liste des factures récupérés avec succès!!');
    }

    static function updateFactureNormalisation($request, $id)
    {
        $facture = StoreFacturation::find($id);
        if (!$facture) {
            return self::sendError('Cette facture n\'existe pas!', 404);
        };

        if ($request->get("paid")) {
            $facture->paid = $request->get("paid");
            $facture->save();
        }
        $facture->update($request->all());
        return self::sendResponse($facture, "Facture modifiée avec succès!!");
    }

    static function deleteFactureNormalisation($id)
    {
        $facture = StoreFacturation::find($id);
        if (!$facture) {
            return self::sendError('Cette facture n\'existe pas!', 404);
        };
        $facture->delete();
        return  self::sendResponse($facture, "Facture supprimée avec succès!");
    }
}
