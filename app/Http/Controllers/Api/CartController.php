<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\PromocodeResource;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Setting;
use App\Models\Point;
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

        $validation = \Validator::make(\request()->all(), [
            'promoCode' => 'required',
            'total_money' => 'required',
            'deliver_money' => 'required'
            
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        try {

             $offer = Offer::CheckPromoCode($request->promoCode)->Where('status', 1 )->first();

            if ( $offer->source == 'Branch') {

                $promocode = $request->promoCode;
                $supermarket_id = $request->supermarket_id;

                $offer = Offer::WhereHas('branches', function ($q) use($supermarket_id){
                        $q->where('branch_offer.branch_id', $supermarket_id);
                         
                })->where('promocode_name', $promocode)->first();

                
            }

        } catch (\Exception $e) {
          
            return $this->returnError(404, "Offer Not Found");
        }
        
        if ($offer) {
        
            if ( $offer->promocode_name == $request->promoCode ) {
                
                 if ($offer->source == 'Branch') {

                     $promo_result =  $this->branchType($request->supermarket_id, $offer->value, $offer->discount_on, $offer->promocode_type, $request->total_money, $request->deliver_money);
                    
                    

                 }else{

                     $promo_result =  $this->checkType($offer->promocode_type, $offer->discount_on, $offer->value,  $request->total_money, $request->deliver_money);
                 }
                
              return response()->json($promo_result);
               
               
            }

        }else{
            
            return $this->returnError(404, "Offer Not Found");
        }

    }//end function

    #check branch
    private function branchType($branch, $value, $dicount_on, $promocode_type, $total_money, $deliver_money)
    {
       
            return $this->checkType($promocode_type, $dicount_on, $value, $total_money, $deliver_money);
          
        

        
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
                    'status' => true,
                    'msg'=>'',
                    'data'=>[
                        'discount_on' => $dicount_on,
                        'OrderMoney'=>(string)$total,
                        'DeliveryMoney'=>(int)$deliver_money, 
                        'Total'=>$total + $deliver_money,
                     ],

                ];
            #Delivery
            }else{

                $total =  $deliver_money - $value  ; 

                return [
                    'status' => true,
                    'msg'=>'',
                    'data'=>[
                        'discount_on' => $dicount_on,
                        'OrderMoney'=>(string)$total_money,
                        'DeliveryMoney'=>(int)$total, 
                        'Total'=>$total + $total_money,
                    ],

                ];

            }
    }
    #dicount on
    private function promocodeTypePercentage($dicount_on, $total_money, $value, $deliver_money)
    {

             if ($dicount_on == 'Order') {
               
               $total = $total_money - ( $total_money * $value)/100; 

                return [
                    'status' => true,
                    'msg'=>'',
                    'data'=>[
                        'discount_on' => $dicount_on,
                        'OrderMoney'=>(string)$total,
                        'DeliveryMoney'=>$deliver_money, 
                        'Total'=>$total + $deliver_money,
                    ],

                ];

            #Delivery  
            }else{

               $total = $deliver_money - ( $deliver_money * $value)/100; 

                return [
                    'status' => true,
                    'msg'=>'',
                    'data'=>[
                        'discount_on' => $dicount_on,
                        'OrderMoney'=>(string)$total_money,
                        'DeliveryMoney'=>(int)$total, 
                        'Total'=>$total_money + $total,
                    ],
                ];
            }
    } 

    public function cartpoint(Request $request)
    {
        #supermarket_id 
        #address_id
        $validation = \Validator::make(\request()->all(), [
            'supermarket_id'         => 'required',
            'address_id'             => 'required',
            'total_cart'             => 'required',
        ]);

        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        $client = Auth('client-api')->user();
        $deliveryOffer  = Offer::Where('type', 'free delivery')->where('status', 1)->first();

        $points = Point::orderBy('points', 'desc')
        ->Where('value','<=',$request->total_cart)
        ->orWhere('points','<=',$client->total_points)
        ->where('status','active')
        ->first();
        dd($points);

        if ($deliveryOffer) {
            
            if ($deliveryOffer->total_order_money <= $request->total_cart) {
                $shipping = 0;
            }else{

                $shipping = Setting::first()->delivery;

            }
        }else{

                $shipping = Setting::first()->delivery;
        }

        return [
                    'status' => true,
                    'msg'=>'',
                    'data'=>[
                        'clinetPoints'=>$client->total_points,
                        'points' => $points->points ??0,
                        'Value'=>$points->value??0, 
                        'type'=>$points->type??0,
                        'vat' => 5,
                        'shippingFee'=>$shipping, 

                    ],
                ];
    }

}//end class
