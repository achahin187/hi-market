<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Category;
use App\Models\Client;
use App\Models\Offer;
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


        $supermarket = supermarket::find($supermarket_id);


        if($supermarket) {

            $categories = $supermarket->categories()->select('categories.id','name_'.$lang.' as name', 'image')->get();

            if($lang == 'ar')
            {
                $supermarketname = Supermarket::where('id',$supermarket_id)->select('arab_name as name')->first();

                $offers = offer::where('status','active')->where('supermarket_id',$supermarket_id)->select('id','arab_name as name','arab_description as description','promocode','offer_type','value_type','image')->where('supermarket_id',$supermarket_id)->limit(4)->get();
            }
            else
            {
                $supermarketname = Supermarket::where('id',$supermarket_id)->select('eng_name as name')->first();

                $offers = offer::where('status','active')->where('supermarket_id',$supermarket_id)->select('id','eng_name as name','eng_description as description','promocode','offer_type','value_type','image')->where('supermarket_id',$supermarket_id)->limit(4)->get();
            }

            foreach ($categories as $category)
            {
                $category->imagepath = asset('images/'.$category->image);
            }

            foreach ($offers as $offer)
            {
                $offer->imagepath = asset('images/'.$offer->image);
            }

            if($token)
            {
                $client = Client::where('remember_token', $token)->first();

                if ($client) {
                    return $this->returnData(['categories','offers','supermarket'], [$categories,$offers,$supermarketname]);
                }
                else {
                    if ($lang == 'ar') {
                        return $this->returnError(305, 'لم نجد هذا العميل');
                    }
                    return $this->returnError(305, 'there is no client found');
                }
            }
            else {

                return $this->returnData(['categories', 'offers', 'supermarket'], [$categories, $offers, $supermarketname]);
            }
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


    public function supermarketoffers(Request $request)
    {
        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,'no lang');
        }

        $token = $request->header('token');

        $udid = $request->header('udid');

        $supermarket_id = $request->supermarket_id;

        $supermarket = supermarket::find($supermarket_id);

        $favproducts = DB::table('client_product')->where('udid',$udid)->select('product_id')->get();


        if($supermarket) {

            if ($lang == 'ar') {

                $products = $supermarket->products()->select('id', 'name_' . $lang . ' as name', 'arab_description as description', 'price','offer_price','images','rate','flag')->where('status','active')->where('flag',1)->get();
            } else {
                $products = $supermarket->products()->select('id', 'name_' . $lang . ' as name', 'eng_description as description', 'price','offer_price','images','rate','flag')->where('status','active')->where('flag',1)->get();
            }
                foreach ($products as $product) {

                    $product->favourite = 0;

                    if (count($favproducts) > 0) {


                        foreach ($favproducts as $favproduct) {
                            if ($product->id == $favproduct->product_id) {
                                $product->favourite = 1;
                            }
                        }
                    }

                    $product->ratings = '170';
                    $product->imagepath = asset('images/' . $product->images);

            }



            if($token)
            {
                $client = Client::where('remember_token', $token)->first();

                if ($client) {
                    return $this->returnData(['products'], [$products]);
                }
                else {
                    if ($lang == 'ar') {
                        return $this->returnError(305, 'لم نجد هذا العميل');
                    }
                    return $this->returnError(305, 'there is no client found');
                }
            }
            else {

                return $this->returnData(['products'], [$products]);
            }
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

    public function categoryproducts(Request $request)
    {
        $lang = $request->header('lang');

        $udid = $request->header('udid');

        if(!$lang || $lang == ''){
            return $this->returnError(402,'no lang');
        }

        $token = $request->header('token');

        $category_id = $request->category_id;

        $favproducts = DB::table('client_product')->where('udid',$udid)->select('product_id')->get();


        if ($category_id) {

            $category = Category::find($category_id);

            if($category) {

                if ($lang == 'ar') {

                    $products = $category->products()->select('id', 'name_' . $lang . ' as name', 'arab_description as description', 'price','offer_price','images','rate','flag')->where('status','active')->get();
                } else {
                    $products = $category->products()->select('id', 'name_' . $lang . ' as name', 'eng_description as description', 'price','offer_price','images','rate','flag')->where('status','active')->get();
                }

                foreach ($products as $product) {

                    $product->favourite = 0;

                    if(count($favproducts) > 0) {


                        foreach ($favproducts as $favproduct) {
                            if ($product->id == $favproduct->product_id) {
                                $product->favourite = 1;
                            }
                        }
                    }

                    $product->ratings = '170';
                    $product->imagepath = asset('images/' . $product->images);
                }

                if ($token) {

                    $client = Client::where('remember_token', $token)->first();

                    if ($client) {
                        return $this->returnData(['products'], [$products]);
                    } else {
                        if ($lang == 'ar') {
                            return $this->returnError(305, 'لم نجد هذا العميل');
                        }
                        return $this->returnError(305, 'there is no client found');
                    }

                } else {
                    return $this->returnData(['products'], [$products]);
                }
            }
            else
            {
                if($lang == 'ar')
                {
                    return $this->returnError(305,'لم نجد هذا القسم');
                }
                return $this->returnError(305 ,'there is no category found');
            }
        }
    }
}
