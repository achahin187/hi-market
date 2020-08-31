<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function index()
    {
        //
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        return view('Admin.orders.index',compact('orders'));
    }

    public function editorder($order_id)
    {
        //
        $order = Order::find($order_id);

        $total_price = 0;

        if($order)
        {
            foreach ($order->products as $product)
            {
                $total_price = $total_price + $product->pivot->price;
            }
            return view('Admin.orders.edit', compact('order','total_price'));
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
            'address' => 'required|string',
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
            foreach ($order->products as $product)
            {
                $total_price = $total_price + $product->pivot->price;
                if($orderproduct->id == $product->id)
                {
                    $quantity = $product->pivot->quantity;
                }
            }

            return view('Admin.orders.edit', compact('orderproduct','order','quantity','total_price'));
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
            'quantity' => 'required|integer|min:0',
        ];

        $this->validate($request,$rules);

        if($order)
        {

            $new_product_id = $request->input('product_id');
            $quantity = $request->input('quantity');

            $order->products()->detach($product_id);

            $order->products()->attach($new_product_id,['quantity' => $quantity]);
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
            'quantity' => 'required|integer|min:0',
        ];

        $this->validate($request,$rules);

        if($order)
        {
            $product_id = $request->input('product_id');

            $product = Product::find($product_id);

            foreach ($product->orders as $orderproduct)
            {
                if($orderproduct->id == $order->id)
                {
                    $status = true;
                }
            }

            if($status)
            {

                $order->products()->detach($product_id);

                $quantity = $request->input('quantity');

                $order->products()->attach($product_id,['quantity' => $quantity]);
            }
            else
            {
                $quantity = $request->input('quantity');

                $order->products()->attach($product_id,['quantity' => $quantity]);
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
                $order->update(['status' => 1]);
            }
            else
            {
                $order->update(['status' => 0]);
            }
                return redirect('/admin/orders')->withStatus(__('order status successfully updated.'));
        }
        return redirect('/admin/admins')->withStatus(__('this id is not in our database'));
    }
}
