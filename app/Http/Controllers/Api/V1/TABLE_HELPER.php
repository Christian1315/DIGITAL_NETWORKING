<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Store;
use App\Models\StoreTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TABLE_HELPER extends BASE_HELPER
{
    ##======== TABLE VALIDATION =======##

    static function table_rules(): array
    {
        return [
            'name' => ['required', Rule::unique("store_tables")],
            'capacity' => ['required', 'integer'],
            'store' => ['required', 'integer'],
            'status' => ['required', 'integer'],
        ];
    }

    static function table_messages(): array
    {
        return [
            // 'name.required' => 'Le champ name est réquis!',
            // 'acti.unique' => 'Cette action existe déjà',
            // 'description.required' => 'Le champ description est réquis!',
        ];
    }

    static function Table_Validator($formDatas)
    {
        $rules = self::table_rules();
        $messages = self::table_messages();

        $validator = Validator::make($formDatas, $rules, $messages);
        return $validator;
    }

    static function _createTable($formData)
    {
        $store = Store::where(["id" => $formData["store"], "owner" => request()->user()->id, "visible" => 1])->get();
        if ($store->count() == 0) {
            return self::sendError("Ce store n'existe pas", 404);
        }
        // return $formData;
        $table = StoreTable::create($formData); #ENREGISTREMENT DE LA TABLE DANS LA DB
        $table->owner = request()->user()->id;
        $table->save();
        return self::sendResponse($table, 'Table crée avec succès!!');
    }

    static function allTables()
    {
        $tables =  StoreTable::with(['owner'])->where(["owner" => request()->user()->id, "visible" => 1])->orderBy('id', 'desc')->get();
        return self::sendResponse($tables, 'Toutes les tables récupérés avec succès!!');
    }

    static function _retrieveTable($id)
    {
        $table = StoreTable::with(['owner'])->where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if ($table->count() == 0) {
            return self::sendError("Cette table n'existe pas!", 404);
        }
        return self::sendResponse($table, "Table récupérée avec succès:!!");
    }

    static function _updateTable($formData, $id)
    {
        $table = StoreTable::where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if (count($table) == 0) {
            return self::sendError("Cette Table n'existe pas!", 404);
        };
        $table = StoreTable::find($id);
        $table->update($formData);
        return self::sendResponse($table, 'Cette Table a été modifié avec succès!');
    }

    static function tableDelete($id)
    {
        $table = StoreTable::where(["id" => $id, "owner" => request()->user()->id, "visible" => 1])->get();
        if (count($table) == 0) {
            return self::sendError("Cette Table n'existe pas!", 404);
        };

        $table = $table[0];
        $table->visible = 0;
        $table->delete_at = now();

        $session = GetSession(request()->user()->id);
        $table->session = $session->id;

        $table->save();
        return self::sendResponse($table, 'Cette table a été supprimée avec succès!');
    }
}
