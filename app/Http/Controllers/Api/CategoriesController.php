<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Category;
use App\Models\Client;
use App\Models\Supermarket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    //

    use generaltrait;

    public function supermarketcategories(Request $request)
    {
        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,'no lang');
        }

        $token = $request->header('token');

        $supermarket_id = $request->id;


        if($token)
        {
            $client = Client::where('remember_token',$token)->first();

            if($client)
            {

                $supermarket = supermarket::find($supermarket_id);

                if($supermarket) {

                    $categories = $supermarket->categories()->select('id','name_'.$lang.' as name', 'image')->get();

                    if($lang == 'ar')
                    {
                        $supermarketname = Supermarket::where('id',$supermarket_id)->select('arab_name as name')->first();
                    }
                    else
                    {
                        $supermarketname = Supermarket::where('id',$supermarket_id)->select('eng_name as name')->first();
                    }

                    foreach ($categories as $category)
                    {
                        $category->imagepath = asset('images/'.$category->image);
                    }

                    return $this->returnData(['categories','supermarket'], [$categories,$supermarketname]);
                }
                else
                {
                    if($lang == 'ar')
                    {
                        return $this->returnError(305,'لم نجد هذا السوبر ماركت');
                    }
                    return $this->returnError(305 ,'there is no supermarket found');
                }

            }
            else
            {
                if($lang == 'ar')
                {
                    return $this->returnError(305,'لم نجد هذا العميل');
                }
                return $this->returnError(305 ,'there is no client found');
            }
        }
        else
        {

            $supermarket = supermarket::find($supermarket_id);


            if($supermarket) {

                $categories = $supermarket->categories()->select('categories.id','name_'.$lang.' as name', 'image')->get();

                if($lang == 'ar')
                {
                    $supermarketname = Supermarket::where('id',$supermarket_id)->select('arab_name as name')->first();
                }
                else
                {
                    $supermarketname = Supermarket::where('id',$supermarket_id)->select('eng_name as name')->first();
                }

                foreach ($categories as $category)
                {
                    $category->imagepath = asset('images/'.$category->image);
                }

                return $this->returnData(['categories','supermarket'], [$categories,$supermarketname]);
            }
            else
            {
                if($lang == 'ar')
                {
                    return $this->returnError(305,'لم نجد هذا السوبر ماركت');
                }
                return $this->returnError(305 ,'there is no supermarket found');
            }
        }
    }

    public function categoryproducts(Request $request)
    {
        $lang = $request->header('lang');

        $udid = $request->header('udid');

        if(!$lang || $lang == ''){
            return $this->returnError(402,'no lang');
        }

        $token = $request->header('token');

        $category_id = $request->id;

        $favproducts = DB::table('client_product')->where('udid',$udid)->select('product_id')->get();


        if($token) {

            $client = Client::where('remember_token', $token)->first();

            if ($client) {


                $category = Category::find($category_id);

                if ($category) {

                    $products = $category->products()->select('name_'.$lang.'as name','products.*')->get();

                    foreach ($products as $product)
                    {
                        foreach ($favproducts as $favproduct)
                        {
                            if($product->id == $favproduct->id)
                            {
                                $product->favourite = 1;
                            }
                        }
                    }

                    foreach ($products as $product)
                    {
                        $product->imagepath = asset('images/'.$product->images);
                    }

                    return $this->returnData(['products'], [$products]);

                } else {
                    if ($lang == 'ar') {
                        return $this->returnError(305, 'لم نجد هذا القسم');
                    }
                    return $this->returnError(305, 'there is no category found');
                }

            } else {
                if ($lang == 'ar') {
                    return $this->returnError(305, 'لم نجد هذا العميل');
                }
                return $this->returnError(305, 'there is no client found');
            }
        }
        else
        {

            $category = Category::find($category_id);

            if ($category) {

                $products = $category->products()->select('name_'.$lang.' as name','products.*')->get();

                foreach ($products as $product)
                {
                    foreach ($favproducts as $favproduct)
                    {
                        if($product->id == $favproduct->product_id)
                        {
                            $product->favourite = 1;
                        }
                    }
                }

                foreach ($products as $product)
                {
                    $product->imagepath = asset('images/'.$product->images);
                }

                return $this->returnData(['products'], [$products]);

            } else {
                if ($lang == 'ar') {
                    return $this->returnError(305, 'لم نجد هذا القسم');
                }
                return $this->returnError(305, 'there is no category found');
            }
        }
    }
}
