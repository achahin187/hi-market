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
        if ($this->getCurrentLang() == 'en') {
            $products = Product::select('id','eng_name as name','rate','price','images','category_id','vendor_id','barcode','description')->get();
        }
        else {
            $products = Product::select('id','arab_name as name','rate','price','images','category_id','vendor_id','barcode','description')->get();
        }

        return $this->returnData('products',$products);
    }

    public function productdetails($id)
    {

        $product = Product::find($id);

        if($product)
        {
            if($this->getCurrentLang() == 'en')
            {
                $product = Product::select('id','eng_name as name','rate','price','images','category_id','vendor_id','barcode','description')->where('id',$id)->get();
            }
            else
            {
                $product = Product::select('id','arab_name as name','rate','price','images','category_id','vendor_id','barcode','description');
            }
            return $this->returnData('product',$product);
        }
        else {
            return $this->returnError('','there is no product found');
        }
    }

    public function getproductsearch($value)
    {

        $type = intval($value);

        if($type == 0)
        {
            $products = Product::where('arab_name','LIKE','%'.$value."%")->orWhere('eng_name','LIKE','%'.$value."%")->first();

            if($products)
            {
                if($this->getCurrentLang() == 'en')
                {
                    $products = Product::select('id','eng_name as name','rate','price','images','category_id','vendor_id','barcode','description')->where('arab_name','LIKE','%'.$value."%")->orWhere('eng_name','LIKE','%'.$value."%")->get();
                }
                else
                {
                    $products = Product::select('id','arab_name as name','rate','price','images','category_id','vendor_id','barcode','description')->where('arab_name','LIKE','%'.$value."%")->orWhere('eng_name','LIKE','%'.$value."%")->get();
                }
                return $this->returnData('product',$products);
            }
            else {
                return $this->returnError('','there is no product found');
            }
        }

        else
        {
            $product = Product::where('barcode',$value)->first();

            if($product)
            {
                if($this->getCurrentLang() == 'en')
                {
                    $product = Product::select('id','eng_name as name','rate','price','images','category_id','vendor_id','barcode','description')->where('barcode',$value)->get();
                }
                else
                {
                    $product = Product::select('id','arab_name as name','rate','price','images','category_id','vendor_id','barcode','description')->where('barcode',$value)->get();
                }
                return $this->returnData('product',$product);
            }
            else {
                return $this->returnError('','there is no product found');
            }


        }

    }
}
