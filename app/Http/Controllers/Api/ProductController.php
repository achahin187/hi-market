<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
