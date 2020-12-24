<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Product;
use App\Models\Order;
use App\Models\DeliveryCompany;
use App\Models\ManualOrder;
use App\Models\Category;
use App\Models\Supermarket;
class ClientOrdersController extends Controller
{
    public function create($id)
    {
    	$client = Client::find($id);

      
 
    	$supermarkets =  Supermarket::Where('status', 'active')->get();
    	return view('Admin.client_order.create',compact('client', 'supermarkets')); 
    } 

    public function getBranchCategory(Request $request)
    {
    	$categories  = Category::WhereHas('branches', function($q) use($request){
    			$q->where('branch_id', $request->branch_id);
    	})->get();

    	return response()->json($categories);
    }

   	public function getCategoryProducts(Request $request)
    {
    	$products  = Product::Where('category_id', $request->category_id)->get();

    	return response()->json($products);
    }

    public function getProduct(Request $request)
    {
    	$product  = Product::Where('id',$request->product_id)->first();

    	return response()->json($product);
    }

    public function storeOrder(Request $request)
    {       
        $request_data = $request->all();
        dd($request_data);
        $orders = collect($request_data["order"]) ;
        // $total_price = $orders->sum('price');

        $manual_orders = ManualOrder::Where('id', $request->order_id)->get();

        $prices = collect([]);
        foreach ($orders as $order) {
            $order = json_decode($order);

            $prices->add($order->price* $order->quantity);
        }

         $total_price = $prices->sum();
      $products = collect([]);
        foreach ($orders as $order) {
            $products->add(json_decode($order));
       
       
        }
        $product = Product::find($products[0]->product_id)->branches->pluck('id')[0];

        $store_order = Order::create([
            'num' => 'jbfe651',
            "order_price"=>$total_price,
            'address'=>  Client::find($products[0]->client_id)->addresses->first()->name,
            'client_id' => $products[0]->client_id,
            'status'=> 1,
            'company_id' => DeliveryCompany::WhereHas('branches', function ($q) use ($request){
                $q->Where('branches.id', $request->branch_id);
            })->first()->id,

        ]);

         $store_order->products()->attach($products->pluck('product_id'));

         $delete = ManualOrder::Where('id', $request->order_id)->delete();

         $destroy_session = session()->forget('branch_id');

        return redirect()->route('clients.index')->withStatus('Order Added Successfully');
    }


    public function changeManualOrder(Request $request)
    {
        //dd($request->all());
        $deleteOrder     = ManualOrder::Where('client_id', $request->client_id)->delete();
         session()->forget('supermarket_id');
         session()->forget('branch_id');

        return redirect()->back();
    }
}
