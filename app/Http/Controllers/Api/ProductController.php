<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Supermarket;
use Illuminate\Http\Request;
use App\Http\Traits\generaltrait;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //

    use generaltrait;

    public function homedata(Request $request)
    {
        $lang = $request->header('lang');

        $token = $request->header('token');

        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }


        if($lang == 'ar')
        {
            $supermarkets = Supermarket::where('status','active')->select('id','arab_name as name','state','start_time','end_time','image')->orderBy('priority','asc')->limit(4)->get();

            $offers = offer::where('status','active')->select('id','arab_name as name','arab_description as description','promocode','offer_type','value_type','image')->limit(4)->get();
        }
        else
        {
            $supermarkets = Supermarket::where('status','active')->select('id','eng_name as name','state','start_time','end_time','image')->orderBy('priority','asc')->limit(4)->get();

            $offers = offer::where('status','active')->select('id','eng_name as name','eng_description as description','promocode','offer_type','value_type','image')->limit(4)->get();
        }


        foreach ($supermarkets as $supermarket)
        {
            $supermarket->imagepath = asset('images/'.$supermarket->image);
            $supermarket->logopath = asset('images/'.$supermarket->logo_image);
        }

        foreach ($offers as $offer)
        {
            $offer->imagepath = asset('images/'.$offer->image);
        }

        if($token)
        {
            $client = Client::where('remember_token',$token)->first();

            if($client)
            {
                return $this->returnData(['supermarkets','offers'],[$supermarkets,$offers]);
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
            return $this->returnData(['supermarkets','offers'],[$supermarkets,$offers]);
        }


    }

    public function productdetails(Request $request)
    {

        $lang = $request->header('lang');

        $token = $request->header('token');

        $udid = $request->header('udid');

        $product_id = $request->id;

        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }

        if($lang == 'ar') {

            $product_details = Product::where('id',$product_id)->select('id', 'name_' . $lang . ' as name', 'arab_description as description' ,'arab_spec as specification','price','images')->first();
        }
        else
        {
            $product_details = Product::where('id',$product_id)->select('id', 'name_' . $lang . ' as name', 'arab_description as description' ,'arab_spec as specification','price','images')->first();
        }

        if ($product_details) {

            $product_images = explode(',',$product_details->images);

            $favproduct = DB::table('client_product')->where('udid',$udid)->where('product_id',$product_id)->first();


            if($favproduct)
            {
                $product_details->favourite = 1;
            }
            else
            {
                $product_details->favourite = 0;
            }

            $imagepaths = [];

            foreach ($product_images as $image) {
                array_push($imagepaths,asset('images/'.$image));
            }

            $product_details->imagepaths = $imagepaths;

            if($token) {

                $client = Client::where('remember_token', $token)->first();

                if ($client) {
                    return $this->returnData(['product'], [$product_details]);
                }
                else {
                    if ($lang == 'ar') {
                        return $this->returnError(305, 'لم نجد هذا العميل');
                    }
                    return $this->returnError(305, 'there is no client found');
                }

            }
            else {
                return $this->returnData(['product'], [$product_details]);
            }
        }
        else
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError('','لا يوجد هذا المنتج');
            }
            return $this->returnError('','there is no product found');
        }

    }

    public function getproductsearch($value)
    {

        $type = intval($value);

        if(strlen($type) < 10 )
        {
            $products = Product::where('arab_name','LIKE','%'.$value."%")->orWhere('eng_name','LIKE','%'.$value."%")->get();

            if(count($products) < 1)
            {
                if($this->getCurrentLang() == 'ar')
                {
                    return $this->returnError('','ليس هناك منتج بهذا الاسم');
                }
                return $this->returnError('','there is no product found');
            }
            else {
                foreach($products as $product) {

                    if ($this->getCurrentLang() == 'ar') {

                        $productarray =
                            [
                                'name' => $product->arab_name,
                                'description' => $product->arab_description,
                                'rate' => $product->rate,
                                'price' => $product->price,
                                'images' => $product->images,
                                'category' => $product->category->arab_name,
                                'vendor' => $product->vendor->arab_name
                            ];
                    } else {

                        $productarray =
                            [
                                'name' => $product->eng_name,
                                'description' => $product->eng_description,
                                'rate' => $product->rate,
                                'price' => $product->price,
                                'images' => $product->images,
                                'category' => $product->category->eng_name,
                                'vendor' => $product->vendor->eng_name
                            ];
                    }
                    $all_products [] = $productarray;
                }

                return $this->returnData('products',$all_products);
            }
        }

        else
        {
            $product = Product::where('barcode',$value)->first();

            if($product)
            {
                if ($this->getCurrentLang() == 'ar') {

                    $productarray =
                        [
                            'name' => $product->arab_name,
                            'description' => $product->arab_description,
                            'rate' => $product->rate,
                            'price' => $product->price,
                            'images' => $product->images,
                            'category' => $product->category->arab_name,
                            'vendor' => $product->vendor->arab_name
                        ];
                } else {

                    $productarray =
                        [
                            'name' => $product->eng_name,
                            'description' => $product->eng_description,
                            'rate' => $product->rate,
                            'price' => $product->price,
                            'images' => $product->images,
                            'category' => $product->category->eng_name,
                            'vendor' => $product->vendor->eng_name
                        ];
                }
                return $this->returnData('product',$productarray);
            }
            else {
                return $this->returnError('','there is no product found');
            }


        }

    }
}
