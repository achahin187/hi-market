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
        //

        $udid = $request->header('udid');

        $token = $request->header('token');

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){

            if ($lang == 'ar') {
                return $this->returnError(402,'اللغة غير موجودة');
            }
            else
            {
                return $this->returnError(402,'language is missing');
            }
        }


        $product_id = json_decode($request->getContent())->product_id;

        if($token) {


            $client = Client::where('remember_token',$token)->first();


            if ($client) {

                $client_devices = DB::table('client_product')->where('udid',$udid)->where('client_id','=',null)->update(['client_id' => $client->id]);

                $client->products()->attach($product_id,['udid' => $udid]);

                if ($lang == 'ar') {
                    return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات',200);
                }
                else {
                    return $this->returnSuccessMessage('This product have been added to your favourites successfully', 200);
                }
            }
            else
            {
                if($lang == 'ar')
                {
                    return $this->returnError(400,'لم نجد هذا العميل');
                }
                return $this->returnError(400,'no client exists');
            }
        }
        else {


            $client_device = DB::table('client_product')->where('udid',$udid)->where('client_id','!=',null)->first();


            if($client_device)
            {
                $client = Client::find($client_device->client_id);

                $client->products()->attach($product_id,['udid' => $udid]);

                if ($lang == 'ar') {
                    return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات','');
                }
                else {
                    return $this->returnSuccessMessage('This product have been added to your favourites successfully', '');
                }
            }
            else
            {
                $device = DB::table('client_product')->insert(['udid' => $udid , 'product_id' => $product_id]);

                if ($lang == 'ar') {
                    return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات','');
                }
                else {
                    return $this->returnSuccessMessage('This product have been added to your favourites successfully', '');
                }
            }

        }

    }
}
