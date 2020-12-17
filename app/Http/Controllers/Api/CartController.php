<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\PromocodeResource;
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
            'supermarket_id' => 'required',
            'total_money' => 'required',
            'deliver_money' => 'required'
       
        ]);


        try {

            $offer = Offer::CheckPromoCode($request->promoCode)->CheckSuperMarket($request->supermarket_id)->firstOrFail();

        } catch (\Exception $e) {
            return $this->returnError(404, "Offer Not Found");
        }

        if ( $offer->promocode_name == $request->promoCode ) {
            
             if ($offer->source == 'Branch') {

                 $promo_result =  $this->branchType($request->supermarket_id, $offer->branch_id, $offer->value, $offer->discount_on, $offer->promocode_type, $request->total_money, $request->deliver_money);
                 dd($promo_result);

             }else{

                 $promo_result =  $this->checkType($offer->promocode_type, $offer->discount_on, $offer->value,  $request->total_money, $request->deliver_money);
             }
            
          return response()->json($promo_result);
           
           
        }


    }//end function

    #check branch
    private function branchType($branch, $offer_branch, $value, $dicount_on, $promocode_type, $total_money, $deliver_money)
    {
        if ($branch == $offer_branch) {
                
            return $this->checkType($promocode_type, $dicount_on, $value, $total_money, $deliver_money);
          
        }

        
    }

    #promocode type value of percantage
    private function checkType($promocode_type, $dicount_on, $value, $total_money, $deliver_money)
    {

        if ($promocode_type == 'Value') {

            return $this->promocodeTypeValue($dicount_on, $total_money , $value, $deliver_money);

          

        }elseif($promocode_type == 'Percentage')
        {
            return $this->promocodeTypePercentage($dicount_on, $total_money , $value, $deliver_money);


        }
    }
    
    #dicount on
    private function promocodeTypeValue($dicount_on, $total_money, $value, $deliver_money)
    {
          if ($dicount_on == 'Order') {

                $total =  $total_money - $value ; 

                return [
                    'discount_on' => $dicount_on,
                    'OrderMoney_AfterDiscount'=>$total,
                    'DeliveryMoney'=>$deliver_money, 
                    'Total'=>$total + $deliver_money,

                ];
            #Delivery
            }else{

                $total =  $deliver_money - $value  ; 

                return [
                    'discount_on' => $dicount_on,
                    'OrderMoney'=>$total_money,
                    'DeliveryMoney_AfterDiscount'=>$total, 
                    'Total'=>$total + $total_money,

                ];

            }
    }
    #dicount on
    private function promocodeTypePercentage($dicount_on, $total_money, $value, $deliver_money)
    {

             if ($dicount_on == 'Order') {
               
               $total = $total_money - ( $total_money * $value)/100; 

                return [
                    'discount_on' => $dicount_on,
                    'OrderMoney_AfterDiscount'=>$total,
                    'DeliveryMoney'=>$deliver_money, 
                    'Total'=>$total + $deliver_money,

                ];

            #Delivery  
            }else{

               $total = $deliver_money - ( $deliver_money * $value)/100; 

                return [
                    'discount_on' => $dicount_on,
                    'OrderMoney'=>$total_money,
                    'DeliveryMoney_AfterDiscount'=>$total, 
                    'Total'=>$total_money + $total,
                ];
            }
    }
}//end class
