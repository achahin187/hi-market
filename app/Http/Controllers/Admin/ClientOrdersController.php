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
        $orders = collect($request_data["order"]) ;
        $manual_ordes = ManualOrder::Where('id', $request->order_id)->get();
        foreach ($orders as $order) {
            $order =json_decode($order);
          //  dd(  Client::find($order->client_id)->addresses->first());
        $product = Product::find($order->product_id)->branches->pluck('id');
         $store_order = Order::create([
            'num' => 'jbfe651',
            
            'address'=>  Client::find($order->client_id)->addresses->first()->name,
            'client_id' => $order->client_id,
            'status'=> 1,
            'company_id' => DeliveryCompany::WhereHas('branches', function ($q) use ($product){
                $q->WhereIn('branches.id', $product);
            })->first()->id,

         ]);
        }
        
        return redirect()->route('clients.index')->withStatus('Order Added Successfully');
    }
}
