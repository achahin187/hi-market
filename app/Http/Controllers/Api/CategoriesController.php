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


        if($token)
        {
            $client = Client::where('remember_token',$token)->first();

            if($client)
            {

                $supermarket_id = $request->header('supermarket');

                $supermarket = supermarket::find($supermarket_id);

                if($supermarket) {

                    if ($lang) {
                        $categories = $supermarket->categories()->select('arab_name as name', 'categories.*')->get();
                    }
                    else
                    {
                        $categories = $supermarket->categories()->select('eng_name as name', 'categories.*')->get();
                    }

                    return $this->returnData(['categories'], [$categories]);
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
            $supermarket_id = $request->header('supermarket');

            $supermarket = supermarket::find($supermarket_id);

            if($supermarket) {

                if ($lang) {
                    $categories = $supermarket->categories()->select('arab_name as name', 'categories.*')->get();
                }
                else
                {
                    $categories = $supermarket->categories()->select('eng_name as name', 'categories.*')->get();
                }

                return $this->returnData(['categories'], [$categories]);
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

        if(!$lang || $lang == ''){
            return $this->returnError(402,'no lang');
        }

        $token = $request->header('token');

        if($token) {

            $client = Client::where('remember_token', $token)->first();

            if ($client) {

                $category_id = $request->header('category');

                $category = Category::find($category_id);

                if ($category) {

                    if ($lang == 'ar') {

                        $products = $category->products()->select('arab_name as name', 'categories.*')->get();
                    }
                    else
                    {
                        $products = $category->products()->select('eng_name as name', 'categories.*')->get();
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
            $category_id = $request->header('category');

            $category = Category::find($category_id);

            if ($category) {

                if ($lang == 'ar') {

                    $products = $category->products()->select('arab_name as name', 'categories.*')->get();
                }
                else
                {
                    $products = $category->products()->select('eng_name as name', 'categories.*')->get();
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
