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
use App\Models\Setting;
use App\Models\Supermarket;
use DB;
class ClientOrdersController extends Controller
{
    public function create($id)
    {
    	$client = Client::find($id);
        $setting = Setting::first();
    	$supermarkets =  Supermarket::Where('status', 'active')->get();
    	return view('Admin.client_order.create',compact('client', 'supermarkets', 'setting')); 
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
    #function to store manual order
    public function storeOrder(Request $request)
    {          
        $request_data = $request->all();
        #get company
        $company = DB::table('delivery_companies_branches')
                    ->where('branch_id',$request_data['branch_id'])
                    ->first();
         #store order           
         $order = Order::create([
                'num' => '#'.str_pad(rand() + 1, 8, "0", STR_PAD_LEFT),
                'order_price'=> $request_data['order_price'],
                'client_id'  => $request_data['client_id'],
                'status'     => 0,
                'shipping_fee'=> $request_data['delivery'],
                'address'=> 1,//static
                'branch_id'=> $request_data['branch_id'],
                'company_id' => $company->delivery_company_id, 
               
            ]);

         #get comapnt and auto approve the order to it 
         $getCompany = DeliveryCompany::Where('id', $company->delivery_company_id)->first();
         if ($getCompany) { 
         #change to the stauts to status 1             
            if ($getCompany->status = 1) {
                $order->update(['status'=> 1]);
            }
         }
         # store order realation   
        foreach ($request->products as $index => $product) {

            $getProduct = $product;

            $quantity = $request->quantity[$index];

            $data = Product::find($getProduct);

            DB::table('order_product')->insert([
                 'order_id' => $order->id,
                 'quantity' => $quantity,
                 'price' => $data->price * $quantity,
                 'product_id' => $getProduct,
            ]);   
        }

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
