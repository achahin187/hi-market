<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Category;
use Illuminate\Http\Request;

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

        $client = Client::where('remember_token',$token)->first();

        if($client)
        {

            $supermarket_id = json_decode($request->getContent());

            $supermarket = supermarket::find($supermarket_id->id);

            if($supermarket)
            {

                $categories = Category::select('');

                return $this->returnData(['categories'], [$categories]);
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
                return $this->returnError(305,'لم نجد هذا العميل');
            }
            return $this->returnError(305 ,'there is no client found');
        }
    }
}
