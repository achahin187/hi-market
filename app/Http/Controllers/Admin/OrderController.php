<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\NotificationMobile;
use App\Models\DeliveryCompany;
use App\Models\Setting;
use App\Models\Team;
use App\Models\Supermarket;
use App\Models\ManualOrder;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Constants;
use App\Notifications\SendNotification;
use DB;
class OrderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:order-list', ['only' => ['index']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request, $cancel = false)
    {
        $setting = Setting::all()->first();
       
      
        if($cancel) {
   
            if(auth()->user()->hasRole('delivery'))
            {
                $cancelledorders = auth()->user()->orders()->where('status',5)->orderBy('id', 'desc')->paginate(10);
            }
            else
            {
                $cancelledorders = Order::where('status',5)->orderBy('id', 'desc')->paginate(10);
            }
            return view('Admin.orders.index', compact('cancelledorders'));
        }
        elseif(request()->driver_id)
        {
            if (auth()->user()->id == request()->driver_id) {
                
                $driver = User::find(request()->driver_id);

                $orders = $driver->orders()->whereNotIn('status',array(0))->get();

                return view('Admin.orders.index',compact('orders','setting','driver'));

            }else{

             return redirect()->back()->withStatus('no request have this id');

            }
        }
        elseif(request()->company_id)
        {
            if(auth()->user()->company_id == request()->company_id ){

                $company = DeliveryCompany::find(request()->company_id);
               
                $orders = $company->orders()->get();
       

             return view('Admin.orders.index',compact('orders','setting'));

            }else{

             return redirect()->back()->withStatus('no request have this id');

            }
        }
        elseif(request()->delivery_id)
        {

            $driver = User::find(request()->driver_id);

            $orders = $driver->orders()->whereNotIn('status',array(0,1,5))->get();

            return view('Admin.orders.index',compact('orders','setting','driver'));
        }
        else
        {
            if(auth()->user()->hasRole(['driver']))
            {
                $orders = auth()->user()->orders()->whereNotIn('status',array(0,1,5))->get();
            }
            elseif(auth()->user()->hasRole(['delivery-manager']))
            {
                $orders = Order::whereNotIn('status',array(0,1,5))->get();
            }
            else
            {
                if (auth()->user()->hasAnyRole(['super_admin'])) {
                    # code...
                    $orders = Order::orderBy('id', 'desc')->get();
                }else{

                return redirect()->back()->withStatus('You  dont  have permission ');
                }
            }

            return view('Admin.orders.index', compact('orders', 'setting'));
        }
    }

    public function create()
    {



    }


    public function store(Request $request,$request_id)
    {
       

        $rules = [
            'product_id' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request,$rules);


        $cart_request = CartRequest::find($request_id);


        $client_id = $cart_request->client->id;

        $product = Product::find($request->input('product_id'));

        $quantity = $request->input('quantity');


        if($cart_request)
        {
            $order = Order::create([

                'address' => $request->input('address'),
                'status' => 0,
                'client_id' => $client_id,
                'request' => $request_id
            ]);

            $total_product_offers_price = 0;

            $total_products_price = 0;

            $cart_request->update(['converted' => 1]);

            $price = $product->price * $quantity;

            $request = $cart_request;

            $order->products()->attach($product->id,['quantity' => $quantity,'price' => $price]);

            foreach ($order->products()->where('flag',0)->get() as $product)
            {
                $total_products_price = $total_products_price + $product->pivot->price;
            }
            foreach ($order->products()->where('flag',1)->get() as $product)
            {
                $total_product_offers_price = $total_product_offers_price + $product->pivot->price;
            }
            return view('Admin.orders.edit',compact('order','request','total_product_offers_price','total_products_price'));
        }
        else
        {
            return redirect('admin/requests')->withStatus('no request have this id');
        }

    }

    public function editorder($order_id)
    {
       
        $order = Order::find($order_id);

        $total_product_offers_price = 0;

        $total_products_price = 0;



        if($order)
        {


            $request = CartRequest::find($order->request);

            foreach ($order->products()->where('flag',0)->get() as $product)
            {
                $total_products_price = $total_products_price + $product->pivot->price;
            }
            foreach ($order->products()->where('flag',1)->get() as $product)
            {
                $total_product_offers_price = $total_product_offers_price + $product->pivot->price;
            }
            return view('Admin.orders.edit', compact('order','total_products_price','total_product_offers_price','request'));

        }
        else
        {
            return redirect('admin/orders')->withStatus('no order have this id');
        }
    }

     public function assignorder($order_id)
    {
         $order = Order::find($order_id);

          /*        $driver_team = Team::where('eng_name','drivers')->first();

        $drivers = $driver_team->users;*/

        if($order)
        {
            return view('Admin.orders.assign',compact('order'));
        }
        return redirect('/admin/orders')->withStatus(__('this id is not in our database'));

    }

    public function updateorder(Request $request,$order_id)
    {
        
        $order = Order::find($order_id);
        
        $request->validate([
            'driver' => ['sometimes','required','min:0','integer'],

        ]);

        $order->update(['user_id' => $request->driver ]);
   
        return redirect()->route('orders.index')->withStatus('assign successfully');
        

    }

    public function updateclient(Request $request,$order_id)
    {
        //
        $order = Order::find($order_id);

        if($order->status == "7" && $order->client_review != null) {

            $rules = [
                'address' => ['required', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                'mobile_number' => ['required', 'digits:11'],
                'review_status' => 'required|min:0|integer'
            ];


        }
        else
        {
            $rules = [
                'address' => ['required', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                'mobile_number' => ['required', 'digits:11'],
            ];
        }

        $this->validate($request,$rules);

        if($order)
        {
            if($order->status == "7" && $order->client_review != null) {

                $order->update(['address' => $request->input('address') , 'mobile_delivery' => $request->mobile_number , 'review_status' => $request->review_status]);

            }
            else
            {
                $order->update(['address' => $request->input('address') , 'mobile_delivery' => $request->mobile_number]);
            }

            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('client information successfully updated.');
        }
        else
        {
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('no order found');
        }

    }

    public function editproduct($order_id,$product_id)
    {
        //

        $productorder = Product::find($product_id);

        $order = Order::find($order_id);

        $total_product_offers_price = 0;

        $total_products_price = 0;


        if($productorder != null && $order != null)
        {

            $request = CartRequest::find($order->request);


            foreach ($order->products()->where('flag',0)->get() as $product)
            {
                $total_products_price = $total_products_price + $product->pivot->price;

                if($productorder->id == $product->id)
                {
                    $quantity = $product->pivot->quantity;
                }
            }
            foreach ($order->products()->where('flag',1)->get() as $product)
            {
                $total_product_offers_price = $total_product_offers_price + $product->pivot->price;

                $offer = true;

                if($productorder->id == $product->id)
                {
                    $quantity = $product->pivot->quantity;
                }
            }

        if($productorder->flag == 1)
        {
            return view('Admin.orders.edit', compact('productorder','offer','order','quantity','total_products_price','total_product_offers_price','request'));
        }

            return view('Admin.orders.edit', compact('productorder','order','quantity','total_products_price','total_product_offers_price','request'));
        }
        else
        {
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('no order have this id');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateproduct(Request $request,$order_id,$product_id)
    {
        //

        $order = Order::find($order_id);

        $rules = [
            'product_id' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
        ];

        $this->validate($request,$rules);

        $price = $request->input('price');


        $quantity = $request->input('quantity');

        if($order)
        {

            $new_product_id = $request->input('product_id');

            $order->products()->detach($product_id);

            $order->products()->attach($new_product_id,['quantity' => $quantity , 'price' => $price]);
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('product information successfully updated.');
        }
        else
        {
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('no id found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function addproduct(Request $request,$order_id)
    {
        
        $order = Order::find($order_id);

        $rules = [
            'product_id' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1'
        ];

        $request->validate($rules);

        $quantity = $request->input('quantity');

        $price = $request->input('price');


        if($order)
        {
            $product_id = $request->input('product_id');

            $product = Product::find($product_id);
            $status = [];
            foreach ($order->products as $orderproduct)
            {
                if($orderproduct->id == $product->id)
                {
                    $status[] .= true;
                }
                else
                {
                    $status[] .= false;
                }
            }
         

            if($status)
            {

                $order->products()->detach($product_id);

                $order->products()->attach($product_id,['quantity' => $quantity , 'price' => $price]);
            }
            else
            {
                $order->products()->attach($product_id,['quantity' => $quantity , 'price' => $price]);
            }

            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('product successfully added to order');
        }
        else
        {
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('no id found');
        }
    }

    public function productdelete($order_id,$product_id)
    {
        $order = Order::find($order_id);

        if($order)
        {
            $order->products()->detach($product_id);
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus(__('product successfully deleted.'));
        }
        return redirect('admin/orders/'.$order_id.'/edit')->withStatus(__('this id is not in our database'));
    }

    public function orderdelete($order_id)
    {
        $order = Order::find($order_id);

        if($order)
        {
            $order->delete();
            return redirect('admin/orders')->withStatus(__('order successfully deleted.'));
        }
        return redirect('admin/orders')->withStatus(__('this id is not in our database'));
    }

    public function status(Request $request,$id)
    {

        $order = Order::find($id);

        if($order)
        {
            if($order->status == 0) {
                $order->update(['status' => 1,'approved_at' => now()]);
            }
            elseif ($order->status == 1)
            {
                $order->update(['status' => 2,'prepared_at' => now()]);
            }
            elseif ($order->status == 2)
            {
                $order->update(['status' => 3,'shipping_at' => now()]);
            }
            elseif($order->status == 3)
            {
                $order->update(['status' => 4,'shipped_at' => now()]);
            }
            elseif($order->status == 4)
            {
                $order->update(['status' => 4,'shipped_at' => now()]);
            }
            elseif($order->status == 6)
            {
                $order->update(['status' => 4,'shipped_at' => now()]);
            }
            else
            {
                $order->update(['status' => 4,'shipped_at' => now()]);
            }

            
            return redirect('/admin/orders')->withStatus(__('order status successfully updated.'));
        }
        return redirect('/admin/admins')->withStatus(__('this id is not in our database'));
    }

    public function cancelorreject(Request $request,$flag)
    {

        $order = Order::find($request->order_id);

        $rules = [
            'reason_id' => 'required|integer|min:0',
            'notes' => ['nullable','not_regex:/([%\$#\*<>]+)/']
        ];

        $this->validate($request,$rules);

        if($order)
        {

            if($flag == 'cancel') {
                $order->update(['status' => 6, 'cancelled_at' => now(), 'admin_cancellation' => 1, 'notes' => $request->notes , 'user_id' => null]);
                return redirect('/admin/orders')->withStatus(__('order status successfully cancelled.'));
            }
            else
            {
                if($order->status == 1) {
                    $order->update(['status' => 7, 'notes' => $request->notes]);
                }
                elseif($order->status == 2)
                {
                    $order->update(['status' => 8, 'notes' => $request->notes]);
                }
                elseif($order->status == 3)
                {
                    $order->update(['status' => 9, 'notes' => $request->notes]);
                }
                elseif($order->status == 4)
                {
                    $order->update(['status' => 10, 'notes' => $request->notes]);
                }
                return redirect('/admin/orders')->withStatus(__('order status successfully rolled back.'));
            }
        }
        return redirect('/admin/orders')->withStatus(__('this id is not in our database'));
    }


    public function show($order_id)
    {

        $order = Order::find($order_id);

/*        $driver_team = Team::where('eng_name','drivers')->first();

        $drivers = $driver_team->users;*/

        if($order)
        {
            return view('Admin.orders.show',compact('order'));
        }
        return redirect('/admin/orders')->withStatus(__('this id is not in our database'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new AdminExport , 'admins.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'images' => 'image|mimes:csv|max:277'
        ];
        Excel::import(new AdminImport ,request()->file('file'));

        return back();
    }

    public function changeStatusOrder(Request $request)
    {
        
        $order = Order::find($request->order_id);
        
        $data =  [
                  "type" => "order",
                  "orderId" => $order->id,
                 ];

        if($request->type == 'next')
        {
            $order->update(['status'=>$request->order_status + 1]);
            if ($order->status == 4) {

                $getClientPoints = DB::table('order_product')->where('order_id' ,$order->id)->sum('points');

                $total_points = $order->client->total_points + $getClientPoints + $this->totalOfferPoints($order) ;
              
                $order->client->update(['total_points'=>$total_points]);
            }
            if(in_array($order->status, [1,3,4]))
            {
                new SendNotification($order->client->device_token, $order, $data);
            }  
           
        }else
        {
            $order->update(['status'=>$request->order_status - 1]);

              if ($request->order_status == 4) {

              
                $getClientPoints = DB::table('order_product')->where('order_id' ,$order->id)->sum('points');

                $total_points = $order->client->total_points - $getClientPoints - $this->totalOfferPoints($order) ;
                $order->client->update(['total_points'=>$total_points]);
            }
 

            if(in_array($order->status, [1,3,4]))
            {
                new SendNotification($order->client->device_token, $order, $data);
            }  
            


        }
        return back();
    }

     private function totalOfferPoints($order)
    {
        
       $offer         =  DB::table('offers')->where('type','point')->where('source', 'Delivertto')->first();
       $offerBranches =  DB::table('offers')->where('type','point')->where('source', 'Branch')->get();

           if ($offer) {

            if ($order->total_before >= $offer->total_order_money) {
                                 
                   return strval($offer->value);
                 }else{
                    return '';
                 }
                
               
           }elseif($offerBranches){

                 foreach ($offerBranches as $key => $offerBranch) {
                   
                        if ($offerBranch->branch_id == $order->branch_id) {

                             if ($order->total_before >= $offerBranch->total_order_money) {
                                 
                                return strval($offerBranch->value);
                             }else{
                                return '';
                             }
                        }//end if
                 }//end foreach  



           }else{

             return "";

           }//end if 

    }

    public function addProductOrder(Request $request)
    {
        $product = Product::Where('id', $request->product_id)->first();
        $supermarkets =  Supermarket::Where('status', 'active')->get();

        $orders = ManualOrder::create([
            'client_id' => $request->client_id,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        $client = Client::where('id', $orders->client_id)->first();

        $orders = ManualOrder::Where('client_id',$client->id)->get();

        session()->put("branch_id",$request->branch_id);
        session()->put("supermarket_id",$request->supermarket_id);

        return redirect()->route('client.order.create',
            ['client_id'=> $request->client_id])->with(['orders'=>$orders, 'supermarkets'=>$supermarkets]);
    }

    public function manualOrderDelete($id)
    {
        $order = ManualOrder::find($id);
        $order->delete();

        return redirect()->route('client.order.create',['client_id'=> $order->client_id])->withStatus(__('deleted successfully'));
    }

    public function rollbackChangeCompany(Request $request)
    {
        

        $order = Order::Where('id', $request->order_id)->first();

        $order->update([
             'company_id' => $request->company_id,
             'status' => $request->status
         ]);
        return redirect()->back()->withStatus(__('RollBack successfully'));
    }

    public function showDetails($id)
    {
            
        $order = Order::find($id);
        return view('Admin.orders.show_order')->with('order', $order);
    }

    public function getMessage($order)
    {
        $messages = [
            0 => "New Order Created, waiting for Acceptance",
            1 => "Your Order $order->num Was Accepted",
            2 => "Your Order $order->num Was Process",
            3 => "Your Order $order->num Was Pickup",
            4 => "Your Order $order->num Was Delivered Rate Your Order",
            5 => "Your Order $order->num was Cancelled",
            null => ""
        ];

         return $messages[$order->status];
    }

    public function testNotification($device_token, $stauts, $data=[])
    {

        //$client = Client::find(auth('client-api')->user()->id);
       // dd ($data, $device_token, $stauts);
        //dd($data);
        $data = [
            "to" => $device_token,

            "data"=> $data,


            "notification" =>
                [
                    "title" => $this->getMessage($stauts),
                    "body" => "Sample Notification",
                    "icon" => url('/logo.png'),
                    "requireInteraction" => true,
                    "click_action"=> "HomeActivity",
                    "android_channel_id"=> "fcm_default_channel",
                    "high_priority"=> "high",
                    "show_in_foreground"=> true
                ],

            "android"=>
                [
                 "priority"=>"high",
                ],

                "priority" => 10,
                    "webpush"=> [
                          "headers"=> [
                            "Urgency"=> "high",
                          ],
                    ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=AAAAT5xxAlY:APA91bHptl1T_41zusVxw_wJoMyOOCozlgz2J4s6FlwsMZgFDdRq4nbNrllEFp6CYVPxrhUl6WGmJl5qK1Dgf1NHOSkcPLRXZaSSW_0TwlWx7R3lY-ZqeiwpgeG00aID2m2G22ZtFNiu',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);

        return response()->json('send');
    }
}
