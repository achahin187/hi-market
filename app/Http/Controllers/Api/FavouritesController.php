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

            return $this->returnError(402,'language is missing');
        }


        $product_id = $request->product_id;
        $flag = $request->flag;

        if($flag == 1) {

            if ($token) {


                $client = Client::where('remember_token', $token)->first();


                if ($client) {

                    $client_devices = DB::table('client_product')->where('udid', $udid)->where('client_id', '=', null)->update(['client_id' => $client->id]);

                    $client->products()->attach($product_id, ['udid' => $udid]);

                    if ($lang == 'ar') {
                        return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', 200);
                    } else {
                        return $this->returnSuccessMessage('This product have been added to your favourites successfully', 200);
                    }
                } else {
                    if ($lang == 'ar') {
                        return $this->returnError(400, 'لم نجد هذا العميل');
                    }
                    return $this->returnError(400, 'no client exists');
                }
            } else {


                $client_device = DB::table('client_product')->where('udid', $udid)->where('client_id', '!=', null)->first();


                if ($client_device) {
                    $client = Client::find($client_device->client_id);

                    $client->products()->attach($product_id, ['udid' => $udid]);

                    if ($lang == 'ar') {
                        return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', '');
                    } else {
                        return $this->returnSuccessMessage('This product have been added to your favourites successfully', '');
                    }
                } else {
                    $device = DB::table('client_product')->insert(['udid' => $udid, 'product_id' => $product_id]);

                    if ($lang == 'ar') {
                        return $this->returnSuccessMessage('لقد اصبح هذا المنتج في المفضلات', '');
                    } else {
                        return $this->returnSuccessMessage('This product have been added to your favourites successfully', '');
                    }
                }

            }
        }
        else
        {
            DB::table('client_product')->where('udid',$udid)->where('product_id',$product_id)->delete();

            if($token) {

                $client = Client::where('remember_token', $token)->first();

                if ($client) {

                    if ($lang == 'ar') {
                        return $this->returnSuccessMessage('لقد تم ازالة المنتج من المفضلات','');
                    }
                    else {
                        return $this->returnSuccessMessage('This product have been removed from favourites successfully', '');
                    }

                } else {
                    if ($lang == 'ar') {
                        return $this->returnError(400, 'لم نجد هذا العميل');
                    }
                    return $this->returnError(400, 'no client exists');
                }
            }
            else
            {
                if ($lang == 'ar') {
                    return $this->returnSuccessMessage('لقد تم ازالة المنتج من المفضلات','');
                }
                else {
                    return $this->returnSuccessMessage('This product have been removed from favourites successfully', '');
                }
            }
        }

    }

    public function getfavourites(Request $request)
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

        $product_id = $request->product_id;

        $client = Client::where('remember_token',$token)->first();


        if ($client) {

            $favproducts = $client->products()->where('udid',$udid)->select()->get();

            return $this->returnData(['favourite products'], [$favproducts]);

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
    

}
