<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    function homedata(Request $request)
    {
        $lang = $request->header('lang');
        $udid = $request->header('udid');

        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }

        $device = Client_Devices::where('udid', $udid)->first();


        if ($device == null) {

            $client_device = Client_Devices::create([

                'udid' => $udid
            ]);
        }

        $supermarkets = Supermarket::where('status','active')->get();

        $offers = offer::where('status','active')->get();

        return $this->returnData(['supermarkets','offers'],[$supermarkets,$offers]);


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
