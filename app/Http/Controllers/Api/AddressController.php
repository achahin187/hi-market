<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Traits\generaltrait;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    use generaltrait;

     public function updateaddress(Request $request)
     {

         $udid = $request->header('udid');

         $token = $request->header('token');

         $lang = $request->header('lang');

         if(!$lang || $lang == ''){

             return $this->returnError(402,'language is missing');
         }

         $client = Client::where('remember_token',$token)->select('id','mobile_number','name')->first();

         if($client)
         {
             $validator = Validator::make($request->all(), [
                 'address' => ['required','not_regex:/([%\$#\*<>]+)/'],
             ]);

             if($validator->fails()) {

                 if ($lang == 'ar') {
                     return $this->returnError(400, 'بيانات الدخول غير صحيحة');
                 }
                 else
                 {
                     return $this->returnError(400, 'These data is not valid');
                 }
             }

             $address = $request->address;
             $label = $request->label;
             $default = $request->default;
             $address_id = $request->address_id;

             Address::where('client_id',$client->id)->where('id',$address_id)->update(['description' => $address,'address_lable' => $label, 'default'=> $default]);

             if ($lang == 'ar') {
                 return $this->returnSuccessMessage('لقد تم تعديل العنوان بنجاح', 200);
             } else {
                 return $this->returnSuccessMessage('This address have been updated successfully', 200);
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

    public function addaddress(Request $request)
    {

        $udid = $request->header('udid');

        $token = $request->header('token');

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){

            return $this->returnError(402,'language is missing');
        }

        $client = Client::where('remember_token',$token)->select('id','mobile_number','name')->first();

        // if($client)
        // {
        //     $validator = Validator::make($request->all(), [
        //         'address' => ['required','not_regex:/([%\$#\*<>]+)/'],
        //         'label' => ['required','not_regex:/([%\$#\*<>]+)/'],

        //     ]);

        //     if($validator->fails()) {

        //         if ($lang == 'ar') {
        //             return $this->returnError(400, 'بيانات الدخول غير صحيحة');
        //         }
        //         else
        //         {
        //             return $this->returnError(400, 'These data is not valid');
        //         }
        //     }

            $address    = $request->address;
            $label      = $request->label;
            $client_id  = $client->id;
            $default    = $request->default;
            $name       = $request->name;
            $phone      = $request->phone;

            Address::create(['description' => $address,'address_lable' => $label, 'client_id'=> $client_id, 'default' => $default,'name'=>$name, 'phone'=>$phone]);

            if ($lang == 'ar') {
                return $this->returnSuccessMessage('لقد تم اضافة العنوان بنجاح', 200);
            } else {
                return $this->returnSuccessMessage('This address have been added successfully', 200);
            }
        // }
        // else
        // {
        //     if($lang == 'ar')
        //     {
        //         return $this->returnError(305,'لم نجد هذا العميل');
        //     }
        //     return $this->returnError(305 ,'there is no client found');
        // }

    }



}
