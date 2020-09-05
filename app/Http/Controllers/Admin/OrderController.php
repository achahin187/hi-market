<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function index()
    {
        //

        $setting = Setting::all()->first();
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        return view('Admin.orders.index',compact('orders','setting'));
    }

    public function create($request_id)
    {
        //
        $request = CartRequest::find($request_id);

        if($request)
        {
            return view('Admin.orders.create', compact('request'));
        }
        else
        {
            return redirect('admin/requests')->withStatus('no request have this id');
        }

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

            $total_price = 0;

            $cart_request->update(['converted' => 1]);

            $price = $product->price * $quantity;

            $request = $cart_request;

            $order->products()->attach($product->id,['quantity' => $quantity,'price' => $price]);

            foreach ($order->products as $product)
            {
                $total_price = $total_price + $product->pivot->price;
            }
            return view('Admin.orders.edit',compact('order','request','total_price'));
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

        $total_price = 0;

        if($order)
        {

            $request = CartRequest::find($order->request);

            foreach ($order->products as $product)
            {
                $total_price = $total_price + $product->pivot->price;
            }
            return view('Admin.orders.edit', compact('order','total_price','request'));

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
        ];

        $this->validate($request,$rules);

        if($order)
        {
            $order->update(['address' => $request->input('address')]);
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('Order information successfully updated.');
        }
        else
        {
            return redirect('admin/orders/'.$order_id.'/edit')->withStatus('no id found');
        }

    }

    public function editproduct($order_id,$product_id)
    {
        //

        $orderproduct = Product::find($product_id);

        $order = Order::find($order_id);

        $total_price = 0;

        if($orderproduct != null && $order != null)
        {

            $request = CartRequest::find($order->request);

            foreach ($order->products as $product)
            {
                $total_price = $total_price + $product->pivot->price;
                if($orderproduct->id == $product->id)
                {
                    $quantity = $product->pivot->quantity;
                }
            }

            return view('Admin.orders.edit', compact('orderproduct','order','quantity','total_price','request'));
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

            foreach ($product->orders as $orderproduct)
            {
                if($orderproduct->id == $order->id)
                {
                    $status = true;
                }else
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
            else
            {
                $order->update(['status' => 4,'shipped_at' => now()]);
            }
                return redirect('/admin/orders')->withStatus(__('order status successfully updated.'));
        }
        return redirect('/admin/admins')->withStatus(__('this id is not in our database'));
    }

    public function cancel(Request $request)
    {


        $order = Order::find($request->order_id);

        $rules = [
            'reason_id' => 'required|integer|min:0',
            'notes' => ['nullable','not_regex:/([%\$#\*<>]+)/']
        ];

        $this->validate($request,$rules);

        if($order)
        {
            $order->update(['status' => 5,'cancelled_at' => now(),'admin_cancellation' => 1 , 'notes' => $request->notes]);
            return redirect('/admin/orders')->withStatus(__('order status successfully cancelled.'));
        }
        return redirect('/admin/orders')->withStatus(__('this id is not in our database'));
    }
}
