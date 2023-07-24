<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Piece;

class PIECE_HELPER extends BASE_HELPER
{
    static function allPieces()
    {
        $pieces =  Piece::all();
        return self::sendResponse($pieces, 'Toutes les pieces récupérés avec succès!!');
    }

    static function _retrievePiece($id)
    {
        $piece = Piece::where('id', $id)->get();
        if ($piece->count() == 0) {
            return self::sendError("Cette pièce n'existe pas!", 404);
        }
        return self::sendResponse($piece, "Pièce récupéré avec succès:!!");
    }
}
