<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\AllFavoriteResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouritesController extends Controller
{
    //

    use GeneralTrait;

    public function addfavourite(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            "product_id" => "required",
            "supermarket_id"=>"required"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $udid = $request->header('udid');
        $product_id = $request->product_id;
        $flag = $request->flag;

        $client = getUser();


        // flag = 1 add
        //flag = 0 remove

        if ($flag == 1) {
            #check if user login
            if (auth("client-api")->check()) {
                #check if asset client udid and client id == null update client id
                $client_devices = DB::table('client_product')
                    ->where('udid', $udid)
                    ->where('client_id', '=', null)
                    ->update(['client_id' => $client->id]);

                $client->products()->attach($product_id, ['udid' => $udid,"category_id"=>$request->category_id,"supermarket_id"=>$request->supermarket_id]);
                return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', '');

            } else {


                $client_device = DB::table('client_product')
                    ->where('udid', $udid)
                    ->where('client_id', '!=', null)
                    ->first();

                if ($client_device) {


                    $client = Client::find($client_device->client_id);

                    $client->products()->attach($product_id, ['udid' => $udid, "category_id" => request("category_id"),"supermarket_id"=>$request->supermarket_id]);

                    return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', '');

                } else {

                    $device = DB::table('client_product')->insert(['udid' => $udid, 'product_id' => $product_id,"category_id"=>$request->category_id,"supermarket_id"=>$request->supermarket_id]);


                    return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', '');

                }

            }
        } else {
            DB::table('client_product')->where('udid', $udid)->where('product_id', $product_id)->delete();

            return $this->returnSuccessMessage('تم الغاء الاعجاب', '');

        }

    }

    public function getfavourites(Request $request)
    {
       
        $validation = \Validator::make($request->all(), [
            "supermarket_id" => "required",
            "category_id" => "required"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $client = getUser();


        if (!$client) {
            return $this->returnError(422, "Client Not Found");
        }
        $favproducts = $client->products()->where(function ($query) {
            if ($udid = \request()->header("udid")) {
                $query->where("udid", $udid)->where("category_id",\request("category_id"))->where("supermarket_id",\request("supermarket_id"));
            };
        })->get();

        return $this->returnData(['favourite products'], [ProductResource::collection($favproducts)]);

    }

    public function getAllFavourites(Request $request)
    {
        $client = getUser();


        if (!$client) {
            return $this->returnError(422, "Client Not Found");
        }
        
        // $favproducts = $client->products()->where(function ($query) {
        //     if ($udid = \request()->header("udid")) {
        //         $query->where("udid", $udid);
        //     };
        // })->first();
        $favproducts = $client->products;
        #get -> first() ->id
        //dd($favproducts->branches);
        return $this->returnData(['favourite products'], [AllFavoriteResource::collection($favproducts)]);
    }

}


