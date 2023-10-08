<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class SupplyProductController extends SUPPLY_A_PRODUCT_HELPER
{
    #VERIFIONS SI LE USER EST AUTHENTIFIE
    public function __construct()
    {
        $this->middleware(['auth:api', 'scope:api-access'])->except(['Login']);
        $this->middleware('CheckAgent');
        $this->middleware('CheckSession');
    }

    function Supply_A_Product(Request $request)
    {

        #VERIFICATION DE LA METHOD
        if ($this->methodValidation($request->method(), "POST") == False) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SUPPLY_A_PRODUCT_HELPER
            return $this->sendError("La methode " . $request->method() . " n'est pas supportée pour cette requete!!", 404);
        };

        #VALIDATION DES DATAs DEPUIS LA CLASS BASE_HELPER HERITEE PAR SUPPLY_A_PRODUCT_HELPER
        $validator = $this->Supply_product_Validator($request->all());

        if ($validator->fails()) {
            #RENVOIE D'ERREURE VIA **sendError** DE LA CLASS BASE_HELPER HERITEE PAR SUPPLY_A_PRODUCT_HELPER
            return $this->sendError($validator->errors(), 404);
        }
        
        #ENREGISTREMENT DANS LA DB VIA **_supply_a_product** DE LA CLASS BASE_HELPER HERITEE PAR SUPPLY_A_PRODUCT_HELPER
        return $this->_supply_a_product($request->all());
    }
}
