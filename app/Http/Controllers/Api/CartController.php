<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
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

    public function addToCart()
    {
        $validation = \Validator::make(\request()->all(), [
            "branch_id" => "required|exists:branches,id",
            "category_id" => "required|exists:categories,id",
            "products" => "required"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $user = getUser();
        if (!$user) {
            return $this->returnError(422, "User Not Exists");
        }
        $cart = [];
        foreach (explode(",", request("products")) as $product) {
            $cart[] = Cart::create([
                "user_id" => $user->id,
                "product_id" => explode(":", $product)[0],
                "qty" => explode(":", $product)[1]
            ]);
        }
        return $this->returnData(["cart"], [CartResource::collection($cart)]);
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

            case $getDisount->value_type == 'discount by percentage':
            case $getDisount->value_type === 'discount by value':
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
