<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouritesController extends Controller
{
    //

    use generaltrait;

    public function addfavourite(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            "product_id" => "required"
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

                $client->products()->attach($product_id, ['udid' => $udid]);
                return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', '');

            } else {


                $client_device = DB::table('client_product')
                    ->where('udid', $udid)
                    ->where('client_id', '!=', null)
                    ->first();

                if ($client_device) {


                    $client = Client::find($client_device->client_id);

                    $client->products()->attach($product_id, ['udid' => $udid]);
//return $client->products;
                    return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', '');

                } else {

                    $device = DB::table('client_product')->insert(['udid' => $udid, 'product_id' => $product_id]);


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

        $client = getUser();


        if ($client) {

            $favproducts = $client->products()->where(function ($query) {
                if ($udid = \request()->header("udid")) {
                    $query->where("udid", $udid);
                };
            })->select()->get();

            return $this->returnData(['favourite products'], [$favproducts]);

        } else {

            return $this->returnError(404, 'no client exists');
        }

    }


}
