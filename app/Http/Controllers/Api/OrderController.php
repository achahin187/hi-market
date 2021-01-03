<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\SimilarProductsResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductDetailesResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\OrderRateResource;
use App\Http\Resources\WishlistResource;
use App\Http\Resources\GetReasonsResource;
use App\Http\Resources\ShippingAddressResource;
use App\Http\Resources\ConfirmationOrderResource;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\MyOrdersResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Branch;
use App\Models\Reason;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\DeliveryCompany;
use App\Models\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Notifications\SendNotification;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;
use DateTime;
class OrderController extends Controller
{
    //

    use GeneralTrait;

    public function __construct()
    {
        if (\request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }

    // public function clientorders(Request $request)
    // {


    //     $client = getUser();

    //     if ($client) {

    //         if (count($client->orders) > 0) {
    //             return $this->returnData(['orders'], [OrderResource::collection($client->orders)]);
    //         } else {


    //             return $this->returnError(404, 'there is no orders for this client');
    //         }
    //     } else {

    //         return $this->returnError(404, 'there is no client found');
    //     }
    // }

    public function getorder($order_id)
    {
        $order = Order::find($order_id);

        if ($order) {
            return $this->returnData(['products'], [ProductDetailesResource::collection($order->products)]);
        } else {
            return $this->returnError(404, 'there is no order found');
        }
    }

    public function addorder(Request $request)
    {

        $order_details = $request->all();

        $company = DeliveryCompany::WhereHas('branches', function ($q) use ($request) {
            $q->Where('supermarket_id', $request->branch_id);
        })->first();

        if ($order_details["promocode"]) {

           $promocodeId = Offer::where('type', 'promocode')->where('promocode',$order_details["promocode"] )->first()->id;

           $order_details["promocode"] = $promocodeId;
        }



        $client = getUser();

        $date = now();

        $date = $date->addDays($request->day_index - 1);



        if ($client) {

            if (request("asap") == 1) {
                $order_details["delivery_date"] = Carbon::now();
            } else {

                $order_details["delivery_date"] = str_replace("/","-",date('Y/m/d', strtotime($request->day)) ).' ' .date('H:i', strtotime($request->time));
            }


            $order = Order::create([

                'num' => '#'.str_pad(rand() + 1, 8, "0", STR_PAD_LEFT),

                'client_id' => $client->id,
                'address' => $order_details["address_id"],

                'delivery_date' =>  str_replace("PM","",$order_details["delivery_date"]) ,

                'promocode' => $promocodeId??null,

                'total_money' => $order_details["total_money"],
                'total_before' => $order_details["total_before"],

                'shipping_fee' => $order_details["shipping_fee"],
                'shipping_before' => $order_details["shipping_before"],

                'branch_id' =>  $order_details["supermarket_id"],

                'point_redeem' => $order_details["redeem"],

                //'promocode' => $order_details["promocode"],
                //'mobile_delivery' => '01060487345',

                'status' => 0,
                'company_id' => $company ?? 17,

            ]);

            foreach ( explode(",", request("cart")) as $product) {

                    DB::table('order_product')->insert([
                    'order_id'   => $order->id,
                    "product_id" => explode(":", $product)[0],
                    "quantity"   => explode(":", $product)[1],
                    "price"      => explode(":", $product)[2] *  explode(":", $product)[1],
                    "points"     => Product::Where('id', explode(":", $product)[0] )->first()->points * explode(":", $product)[1],
                ]);

             }

            #if client have points and use points

            if ($client->total_points > 0 || $client->total_points!= null) {

               $finalClientPoint = $client->total_points - $order_details["redeem"];

               $client->update(['total_points'=> $finalClientPoint]);

            }
            #get comapny and auto approve the order to it
            if ($company) {
            #change to the stauts to status 1
                if ($company->status = 1) {
                    $order->update(['status'=> 1]);
                }
            }

             $data =  [
                  "type" => "order",
                  "orderId" => $order->id,
                 ];
            #send notification to mobile
            new SendNotification($order->client->device_token, $order, $data);

            #send notification to dashboard
             $super_admins = User::role(['super_admin','supermarket_admin'])->get();
             $delivery_admins =  User::role(['delivery_admin'])->where('company_id',8)->get();
             $sendToAdmins = $super_admins->merge($delivery_admins);

             Notification::send($sendToAdmins,new OrderNotification($order));

            return response()->json([
                "status" => true,
                "msg" => 'The order has been completed successfully',
                'data'    => ['order_id'=>$order->id],
        ]);
        } else {

            return $this->returnError(404, 'client donst exist');

        }
    }

    public function addcart(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            "category_ids" => "required",
            "supermarket_id" => "required",
            "products" => "required"

        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        $udid = $request->header('udid');
        $user = getUser();

        if (!$user) {
            return $this->returnError(422, "user not exists");
        }

        $category_ids = explode(",", $request->category_ids);

        $categories = $category_ids;

        $supermarket_id = $request->supermarket_id;

        $fav_ids = [];

        $favproducts = DB::table('client_product')->where('udid', $udid)->select('product_id')->get();

        $similar_products = Product::similar($categories, $supermarket_id)->get();

        foreach ($favproducts as $product) {
            array_push($fav_ids, $product->product_id);
        }

        $setting = Setting::select('delivery')->first();


        $wishlist = Product::whereIn('id', $fav_ids)->whereHas("branches", function ($query) {
            $query->where("branches.id", request("supermarket_id"));
        })->get();

        $cart = collect([]);

        foreach (explode(",", request("products")) as $index => $product) {

            $cart->add(Cart::create([
                "user_id" => getUser()->id,
                "product_id" => explode(":", $product)[0],
                "qty" => explode(":", $product)[1],

            ]));
        }


        $cart = $cart->filter(function ($cart) {
            return $cart->product != null;
        });
        return $this->returnData(['similar products', 'wishlist', 'setting', "cart"], [
            SimilarProductsResource::collection($similar_products)
            , WishlistResource::collection($wishlist)
            , $setting->delivery ?? 0
            , CartResource::collection($cart)
        ]);
    }

    public function selectDate()
    {

        $branch = Branch::find(request("supermarket_id"));

        $days = [
            [
                "id" => 1,
                "text" => trans("admin.Today"),
            ],
            [
                "id" => 2,
                "text" => trans("admin.Tomorrow"),

            ],
            [
                "id" => 3,
                "text" => trans('admin.'.now()->addDays(2)->format("l"))
            ],
            [
                "id" => 4,
                "text" => trans('admin.'.now()->addDays(3)->format("l"))
            ]

        ];

        $branch_start_time = Carbon::parse($branch->start_time)->subHour();
        $branch_end_time = Carbon::parse($branch->end_time);
       

        $time = [];
        for ($i = 1; $i <= 24; $i++) {
            $time[] = [
                "id" => $i,
                "text" =>  $branch_start_time->addHours(1)->format("g A"),
            ];

            if ($i > 1 && $time[$i-1]['text'] == $branch_end_time->format("g A")) {
                break;
            }

        }


        return $this->returnData(["days", "time", "state"], [$days, $time, $this->getState($branch)]);
    }


    public function getState($branch)
    {
           $now = now();

           $start_time =  Carbon::parse($branch->start_time)->format('H:i');
           $end_time   =  Carbon::parse($branch->end_time)->format('H:i');


          if ($start_time == $end_time) {

              return trans('admin.open)';
          }

          elseif($start_time < $end_time)
          {

            $between = $now->between($start_time, $end_time);

                if ($between) {

                    return trans('admin.open') ;
                }else{

                    return 'closed';
                }//end if
          }else{
                if (Carbon::now()->toTimeString() > $start_time) {

                    return trans('admin.open') ;
                }
                elseif(Carbon::now()->toTimeString() < $end_time){

                    return trans('admin.open') ;
                }else{

                    return  trans('admin.closed');

                }//end if
          }//end if
    }

    public function getClientOrder(Request $request)
    {
        $udid = $request->header('udid');

        $client = getUser();

        if ($client) {

            $clientOrders = Order::Where('client_id', $client->id)->orderBy('created_at', 'desc')->get();

                return MyOrdersResource::collection($clientOrders);
        } else {

            return $this->returnError(422, "user not exists");

        }
    }

    public function getReasons()
    {
        $reasons = Reason::Where('status','active')->get();

        return $this->returnData(['reasons'], [GetReasonsResource::collection($reasons)]);
    }

    public function CancelOrder(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            "order_id" => "required",
            "reason_id" => "required",
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        $getOrder = Order::find($request->order_id);

        if ($getOrder) {

            $getOrder->update(['status'=>6, 'resone_id'=>$request->reason_id]);


            if ($getOrder->point_redeem != 0) {

               $finalClientPoint = $getOrder->client->total_points + $getOrder->point_redeem;

               $getOrder->client->update(['total_points'=> $finalClientPoint]);

            }

            return $this->returnSuccessMessage('order Canceled successfully', 200);

        }else{

            return $this->returnError(404, "This order id not found");
        }
    }

    public function orderDetails(Request $request)
    {

        $validation = \Validator::make($request->all(), [
            "order_id" => "required",
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        $client = getUser();
        if (!$client) {
            return $this->returnError(422, "user not exists");
        }

        $order = Order::Where('id',$request->order_id)->Where('client_id',$client->id)->first();

        if($order){

            return response()->json([
                "status" => true,
                'data'    => new OrderDetailResource($order),
             ]);
            //return $this->returnData(['data'], [OrderDetailResource::collection($order)]);
        }else{

             return $this->returnError(404, "This Order ID Not Found");
        }
    }

    public function rateOrder(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order) {
                $store_rate = $order->update([
                                    'delivery_rate' => $request->delivery_rate,
                                    'seller_rate'   => $request->seller_rate,
                                    'pickup_rate'   => $request->pickup_rate,
                                    'time_rate'     => $request->time_rate,
                                    'comment'       => $request->comment,
                                    'status'        =>  5,
                                ]);

                return response()->json([
                    "status"  => true,
                    "msg"     => 'rate send successfully',
                    'data'    => new OrderRateResource($store_rate),
                ]);

        }else{

             return $this->returnError(404, "This Order ID Not Found");
        }
    }

    private function sendNotification()
    {

            $url = 'https://fcm.googleapis.com/fcm/send';
            $api_key = 'Key=AAAAT5xxAlY:APA91bHptl1T_41zusVxw_wJoMyOOCozlgz2J4s6FlwsMZgFDdRq4nbNrllEFp6CYVPxrhUl6WGmJl5qK1Dgf1NHOSkcPLRXZaSSW_0TwlWx7R3lY-ZqeiwpgeG00aID2m2G22ZtFNiu';
            $fields = array(
                'to' => 'c4wEkQfiRw6xpqzeqjSb72:APA91bGn3LQaR8IhIGuGMekyUQjhrMbvC8KX_DLzQljljnvVJZ7r02oolp59-MkE8yLaTRxhSz8QJwxlVL7m0WXIF2wQBcctsZskrzcdz9nsvpkLZhsuJU7LdXxs-KcpdxCuIt2NZqaD',
                "data" => [
                     "Nick" => "Mario",
                     "body" => "great match!",
                     "Room" => "PortugalVSDenmark",
                   ],
                'notification' => [
                    'title' => 'test data',
                    'text' => 'test data',
                    'click_action' => 'HomeActivity',
                ],
                'android' => [
                    "priority" => "high"
                ],
                'priority' => 10
            );
            $headers = array(
                'Content-Type:application/json',
                'Authorization:' . $api_key
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            return $result;
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            $result = json_decode($result);
    }

    public function orderConfirmation(Request $request)
    {
        #Validation
        $validation = \Validator::make($request->all(), [
            "order_id" => "required",
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        $order = Order::find($request->order_id);

        return response()->json([
            "status" => true,
           'data'=> new ConfirmationOrderResource($order),
        ]);
    }

}
