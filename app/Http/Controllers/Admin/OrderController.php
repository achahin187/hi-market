<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    //

    public function index($cancel = false)
    {
        //
        $setting = Setting::all()->first();

        if($cancel) {

            $cancelledorders = Order::where('status',5)->orderBy('id', 'desc')->paginate(10);
            return view('Admin.orders.index', compact('cancelledorders'));
        }
        else
        {
            $orders = Order::whereIn('status',array(0,1,2,3,4,6,7,8))->orderBy('id', 'desc')->paginate(10);
            return view('Admin.orders.index', compact('orders', 'setting'));
        }
    }

    public function create()
    {



    }


    public function store(Request $request,$request_id)
    {
        //

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
        //
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

    public function updateorder(Request $request,$order_id)
    {
        //

        $order = Order::find($order_id);

        $rules = [
            'address' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'status' => ['required','min:0','integer'],
            'delivery_date' => 'required|after:today',
            'driver_id' => 'nullable|min:0|integer'
        ];

        $this->validate($request,$rules);


        if($order)
        {

            if($request->status == 0) {
                $order->update(['status' => $request->status]);
            }
            elseif ($request->status == 1)
            {
                $order->update(['status' => $request->status,'approved_at' => now()]);
            }
            elseif ($request->status == 2)
            {
                $order->update(['status' => $request->status,'prepared_at' => now()]);
            }
            elseif($request->status == 3)
            {
                $order->update(['status' => $request->status,'shipping_at' => now()]);
            }
            elseif($request->status == 4)
            {
                $order->update(['status' => $request->status,'shipped_at' => now()]);
            }
            elseif($request->status == 6)
            {
                $order->update(['status' => $request->status,'rejected_at' => now()]);
            }
            else
            {
                $order->update(['status' => $request->status,'received_at' => now()]);
            }
            $order->update(['address' => $request->input('address') , 'status' => $request->status , 'delivery_date' => $request->delivery_date , 'driver_id' => $request->driver_id]);
            return redirect()->route('',$order_id)->withStatus('Order information successfully updated.');
        }
        else
        {
            return redirect()->route('order_details',$order_id)->withStatus('no id found');
        }

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
        //
        $order = Order::find($order_id);


        $rules = [
            'product_id' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request,$rules);

        $quantity = $request->input('quantity');

        $price = $request->input('price');


        if($order)
        {
            $product_id = $request->input('product_id');

            $product = Product::find($product_id);


            foreach ($order->products as $orderproduct)
            {
                if($orderproduct->id == $product->id)
                {
                    $status = true;
                }
                else
                {
                    $status = false;
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
                $order->update(['status' => 5, 'cancelled_at' => now(), 'admin_cancellation' => 1, 'notes' => $request->notes]);
                return redirect('/admin/orders')->withStatus(__('order status successfully cancelled.'));
            }
            else
            {
                $order->update(['status' => 6, 'rejected_at' => now(), 'admin_cancellation' => 1, 'notes' => $request->notes]);
                return redirect('/admin/orders')->withStatus(__('order status successfully rejected.'));
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
}
