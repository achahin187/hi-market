<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Supermarket;
use Illuminate\Http\Request;
use App\Http\Traits\generaltrait;

class ProductController extends Controller
{
    //

    use generaltrait;

    public function index()
    {

        $products = Product::all();


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

    public function homedata(Request $request)
    {
        $lang = $request->header('lang');

        $token = $request->header('token');

        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }

        if($token)
        {
            $client = Client::where('remember_token',$token)->first();

            if($client)
            {
                if($lang == 'ar')
                {
                    $supermarkets = Supermarket::where('status','active')->select('arab_name as name','supermarkets.*')->orderBy('priority','asc')->get();

                    $offers = offer::where('status','active')->select('id','arab_name as name','arab_description as description','promocode')->get();
                }
                else
                {
                    $supermarkets = Supermarket::where('status','active')->select('eng_name as name','supermarkets.*')->orderBy('priority','asc')->get();

                    $offers = offer::where('status','active')->select('eng_name as name','offers.*')->get();
                }

                foreach ($supermarkets as $supermarket)
                {
                    $supermarket->imagepath = asset('images/'.$supermarket->image);
                }

                foreach ($offers as $offer)
                {
                    $offer->imagepath = asset('images'.$offer->image);
                }

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
            if($lang == 'ar')
            {
                $supermarkets = Supermarket::where('status','active')->select('arab_name as name','supermarkets.*')->orderBy('priority','asc')->get();

                $offers = offer::where('status','active')->select('id','arab_name as name','arab_description as description','promocode')->get();
            }
            else
            {
                $supermarkets = Supermarket::where('status','active')->select('eng_name as name','supermarkets.*')->orderBy('priority','asc')->get();

                $offers = offer::where('status','active')->select('eng_name as name','offers.*')->get();
            }

            foreach ($supermarkets as $supermarket)
            {
                $supermarket->imagepath = asset('images/'.$supermarket->image);
            }

            foreach ($offers as $offer)
            {
                $offer->imagepath = asset('images'.$offer->image);
            }

            return $this->returnData(['supermarkets','offers'],[$supermarkets,$offers]);
        }


    }

    public function productdetails($id)
    {

        $product = Product::find($id);

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
