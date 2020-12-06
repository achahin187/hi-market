<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Http\Traits\GeneralTrait;

class CartController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        if (\request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }
    #function to send promo code
    #return dicount value
    public function sendPromoCode(Request $request)
    {
        $request->validate([
            'promoCode' => 'required',
            'supermarket_id' => 'required'
        ]);


        try {

            $getDisount = Offer::CheckPromoCode($request->promoCode)->CheckSuperMarket($request->supermarket_id)->firstOrFail();

        } catch (\Exception $e) {
            return $this->returnError(404, "Offer Not Found");
        }

        switch ($getDisount) {

            case $getDisount->value_type === 'discount by value':
                return $this->returnData(['discount', 'type'], [$getDisount->money, $getDisount->value_type]);
                break;

            case $getDisount->value_type == 'discount by percentage':
                return $this->returnData(['discount', 'type'], [$getDisount->money, $getDisount->value_type]);
                break;

            case $getDisount->value_type == 'free delivery':
                return $this->returnData(['discount', 'type'], [0, $getDisount->value_type]);
                break;

            default:
                return response()->json(['msg' => 'this type not avilable']);
                break;
        }//end case


    }//end function
}//end class
