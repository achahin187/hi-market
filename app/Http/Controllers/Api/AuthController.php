<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Client;
use App\Models\Client_Devices;
use App\Models\Clientdevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JWTAuth;

class AuthController extends Controller
{
    //
    use generaltrait;

    public function send_sms($name, $mobile, $msg, $lang)
    {
        $url = 'https://dashboard.mobile-sms.com/api/sms/send?api_key=NVV2TzQxTHl5cThvcVFzWmozMEkwWWxxczRKT0k1VTRrUHNkaDJ0ZDhZcUtoMlN5WXBIcUVpekl2SlpZ5f4a28289ba33&name=' . $name . '&message=' . $msg . '&numbers=' . $mobile . '&sender=' . $name . '&language=' . $lang;

        $client = new \GuzzleHttp\Client();

        $response = $client->request('get', $url);
    }

    public function verifycode(Request $request)
    {

        $lang = $request->header('lang');

        if (!$lang || $lang == '') {
            return $this->returnError(402, Lang::get('message.missingLang'));
        }

        $mobile = $request->mobile_number;

        $code = $request->code;

        $client = Client::where('mobile_number', $mobile)->first();

        if ($client) {

            if ($client->activation_code == $code) {

                if ($lang == 'ar') {
                    return $this->returnData(['client'], [$client], 'الكود صحيح');
                } else {
                    return $this->returnData(['client'], [$client], 'the code is valid');
                }

            } else {

                if ($lang == 'ar') {
                    return $this->returnError(300, 'الكود الذي أدخلته غير صحيح تأكد من الكود في الرسالة');
                } else {
                    return $this->returnError(300, 'this code is invalid please check the code sent to your mobile');
                }

            }
        } else {

            if ($this->getCurrentLang() == 'ar') {
                return $this->returnError(300, 'لم نجد هذا العميل');
            }
            return $this->returnError(300, 'there is no client found');

        }

    }

    public function login(Request $request)
    {


        $udid = $request->header('udid');


        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required'],
            'password' => ['required'],
        ]);


        if ($validator->fails()) {

            return $this->returnValidationError(422, $validator);


        }


        //login


        if (auth("client-web")->attempt(["mobile_number" => $request->mobile_number, "password" => $request->password])) {
            $client = Auth::guard('client-web')->user();
            $token = $client->createToken("hi-market")->accessToken;
            $msg = "you have been logged in successfully";
            return $this->returnData(['client', 'token'], [$client, $token], $msg);
        }

        return $this->returnError(422, 'These credentials are not in our records');


    }

    public function register(Request $request)
    {


        $udid = $request->header('udid');

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
            'mobile_number' => ['required', 'digits:11', Rule::unique('clients', 'email')],
            'email' => ['required', 'email', Rule::unique('clients', 'email'), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        }


        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
        ]);


        $accessToken = $client->createToken("hi-market")->accessToken;


        $code = '123456';

        $client->update(['activation_code' => $code]);


        $activation_msg = 'your activation code is' . $code;


        $this->send_sms('Eramint', $request->mobile_number, $activation_msg, app()->getLocale());

        $msg = "you have been registered sucessfully";

        return $this->returnData(['client', 'token'], [$client, $accessToken], $msg);

    }

    public function forgetpassword(Request $request)
    {
        $lang = $request->header('lang');

        $mobile = $request->mobile_number;


        $client = Client::where('mobile_number', $mobile)->firstOrFail();


        $code = '123456';

        $client->update(['activation_code' => $code]);

        $activation_msg = 'your activation code is ' . $code;

        $this->send_sms('Eramint', $mobile, $activation_msg, $lang);


        if ($lang == 'ar') {
            $msg = "لقد تم ارسال كود الي رقم حضرتك";
        } else {
            $msg = "we sent an activation code to verify your mobile number";
        }

        return $this->returnData(['code'], [$code], $msg);


    }

    public function social(Request $request, $flag)
    {


        $udid = $request->header('udid');


        $email = $request->email;

        $client = Client::where('email', $email)->first();

        if ($flag == 0) {

            $data = $this->returnData(['client'], [$client], 'you have been logged in successfully');

        } else {


            $data = $this->returnData(['client'], [$client], 'you have been registered successfully');

        }

        if ($client) {

            return $data;
        } else {
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

            $client->update(['status' => 0]);

            return $data;
        }
    }


    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
