<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Model\Client;
use App\Model\Client_Devices;
use App\Models\Clientdevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    //
    use generaltrait;

    public function send_sms($name,$mobile,$msg,$lang)
    {
        $url = 'https://dashboard.mobile-sms.com/api/sms/send?api_key=NVV2TzQxTHl5cThvcVFzWmozMEkwWWxxczRKT0k1VTRrUHNkaDJ0ZDhZcUtoMlN5WXBIcUVpekl2SlpZ5f4a28289ba33&name='.$name.'&message='.$msg.'&numbers='.$mobile.'&sender='.$name.'&language='.$lang;

        $client = new \GuzzleHttp\Client();

        $response = $client->request('get',$url);
    }

    public function verifycode(Request $request)
    {

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $mobile = $request->mobile_number;

        $code = $request->code;

        $client = Client::where('mobile_number',$mobile)->first();

        if($client) {

            if ($client->activation_code == $code) {

                if ($lang == 'ar') {
                    return $this->returnData(['client'] ,[$client] , 'الكود صحيح');
                }
                else
                {
                    return $this->returnData(['client'] ,[$client] , 'the code is valid');
                }

            } else {

                if ($lang == 'ar') {
                    return $this->returnError(300, 'الكود الذي أدخلته غير صحيح تأكد من الكود في الرسالة');
                }
                else
                {
                    return $this->returnError(300, 'this code is invalid please check the code sent to your mobile');
                }

            }
        }
        else
        {

            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError(300,'لم نجد هذا العميل');
            }
            return $this->returnError(300,'there is no client found');

        }

    }

    public function login(Request $request)
    {

        $lang = $request->header('lang');
        $udid = $request->header('udid');


        if(!$lang || $lang == ''){

            if ($lang == 'ar') {
                return $this->returnError(402,'اللغة غير موجودة');
            }
            else
            {
                return $this->returnError(402,'language is missing');
            }
        }


        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required'],
            'password' => ['required'],
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


        try {

            //login

            $credentials = $request->only(['mobile_number','password']);

            $token =  Auth::guard('client-api')->attempt($credentials);


            if(!$token) {
                if ($lang == 'ar') {
                    return $this->returnError(300, 'بيانات الدخول غير موجودة');
                }
                else
                {
                    return $this->returnError(300, 'These credentials are not in our records');
                }
            }

            $client = Auth::guard('client-api')->user();

            $client->update(['remember_token' => $token]);


            if ($lang == 'ar') {
                $msg = "لقد تمت عملية تسجيل دخولك بنجاح";
            }
            else
            {
                $msg = "you have been logged in sucessfully";
            }


            //return token
            return $this->returnData(['client'] ,[$client] , $msg);

        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }


    }

    public function register(Request $request)
    {

        $lang = $request->header('lang');
        $udid = $request->header('udid');

        if(!$lang || $lang == ''){

            if ($lang == 'ar') {
                return $this->returnError(402,'اللغة غير موجودة');
            }
            else
            {
                return $this->returnError(402,'language is missing');
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'mobile_number' => ['required','digits:11',Rule::unique((new Client)->getTable())],
            'email' => ['nullable','email', Rule::unique((new Client)->getTable()), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
            'password' => ['required'],
        ]);

        if($validator->fails()) {

            if ($lang == 'ar') {
                return $this->returnError(300, 'بيانات الدخول غير صحيحة');
            }
            else
            {
                return $this->returnError(300, 'These data is not valid');
            }
        }

        else
        {
            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'password' => Hash::make($request->password),
            ]);

            $token = auth()->guard('client-api')->login($client);

            $code = '123456';

            $client->update(['remember_token' => $token ,'activation_code' => $code ]);


            $activation_msg = 'your activation code is'.$code;


            $this->send_sms('Eramint',$request->mobile_number,$activation_msg,$lang);

            $msg = "you have been registered sucessfully";

            return $this->returnData(['client'], [$client] , $msg);
        }
    }

    public function forgetpassword(Request $request)
    {
        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $mobile = $request->mobile_number;


        $client = Client::where('mobile_number',$mobile)->first();


        if($client) {

            $code = '123456';

            $client->update(['activation_code' => $code ]);

            $activation_msg = 'your activation code is '.$code;

            $this->send_sms('Eramint',$mobile,$activation_msg,$lang);


            if ($lang == 'ar') {
                $msg = "لقد تم ارسال كود الي رقم حضرتك";
            }
            else
            {
                $msg = "we sent an activation code to verify your mobile number";
            }

            return $this->returnData(['code'], [$code] , $msg);

        }
        else
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError(300,'لم نجد هذا العميل');
            }
            return $this->returnError(300,'there is no client found');
        }
    }

    public function social(Request $request,$flag)
    {

        $lang = $request->header('lang');
        $udid = $request->header('udid');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $email = $request->email;

        $client = Client::where('email',$email)->first();

        if($flag == 0)
        {
            if ($lang == 'ar') {
                $data = $this->returnData(['client'], [$client], 'لقد تم تسجيل الدخول بنجاح');
            } else {
                $data = $this->returnData(['client'], [$client], 'you have been logged in successfully');
            }
        }
        else
        {
            if ($lang == 'ar') {
                $data = $this->returnData(['client'], [$client],'لقد تم تسجيل معلوماتك بنجاح');
            } else {
                $data = $this->returnData(['client'], [$client], 'you have been registered successfully');
            }
        }

        if($client) {

            return $data;
        }
        else
        {
            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
            ]);


            $client_device = Client_Devices::create([

                'client_id' => $client->id,
                'udid' => $udid

            ]);


            $token = auth()->guard('client-api')->login($client);

            $client->update(['remember_token' => $token , 'status' => 0]);

            return $data;
        }
    }


    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
