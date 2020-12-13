<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Client;
use App\Models\Client_Devices;
use App\Models\Clientdevice;
use App\Models\Udid;
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
    use GeneralTrait;

   
    public function send_sms($name, $mobile, $msg, $lang)
    {
        $url = 'https://dashboard.mobile-sms.com/api/sms/send?api_key=NVV2TzQxTHl5cThvcVFzWmozMEkwWWxxczRKT0k1VTRrUHNkaDJ0ZDhZcUtoMlN5WXBIcUVpekl2SlpZ5f4a28289ba33&name=' . $name . '&message=' . $msg . '&numbers=' . $mobile . '&sender=' . $name . '&language=' . $lang;

        $client = new \GuzzleHttp\Client();

        $response = $client->request('get', $url);
    }

    public function verifycode(Request $request)
    {


        $mobile = $request->mobile_number;

        $code = $request->code;


        try {
            $client = Client::where('mobile_number', $mobile)->firstOrFail();
        } catch (\Exception $e) {
            return $this->returnError(404, "Client Not Found");
        }

        if ($client->activation_code == $code) {


            return $this->returnData(['client',"token"], [new ClientResource($client),$client->createToken("hi-market")->accessToken], 'the code is valid');

        } else {

            return $this->returnError(422, 'this code is invalid please check the code sent to your mobile');
        }
    }


    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'mobile_number' => ['required'],
            'password' => ['required'],
        ]);


        if ($validator->fails()) {

            return $this->returnValidationError(422, $validator);

        }


        //login
        if (auth("client-web")->attempt([

            "mobile_number" => $request->mobile_number,
             "password" => $request->password,
             'verify'=>1,
         ])) 
        {

            $client = Auth::guard('client-web')->user();

            $token = $client->createToken("hi-market")->accessToken;

            $msg = "you have been logged in successfully";


            return $this->returnData(
                ['client', 'token'], [new ClientResource($client), $token], $msg);
        }

        return $this->returnError(422, 'These credentials are not in our records');
    }

    public function register(Request $request)
    {

        $udid = $request->header('udid');

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
            'mobile_number' => ['required', 'digits:11', Rule::unique('clients', 'mobile_number')],
            'email' => ['email', Rule::unique('clients', 'email')],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        }

        try {
            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'password' => $request->password,
                "unique_id" => Udid::where("body", $udid)->firstOrCreate([
                    "body"=>request()->header("udid")
                ])->body
            ]);
        } catch (\Exception $exception) {

            return response()->json([
                "success" => false,
                "status" => "Client Not Exists With this Udid"
            ]);
        }


        //$accessToken = $client->createToken("hi-market")->accessToken;


        $code = '12345';

        $client->update(['activation_code' => $code]);


        $activation_msg = 'your activation code is' . $code;


        $this->send_sms('Eramint', $request->mobile_number, $activation_msg, app()->getLocale());

        $msg = "you have been registered sucessfully";

        return $this->returnData(['client',"token"], [new ClientResource($client),$client->createToken("hi-market")->accessToken], $msg);
    }

    public function resetpassword(Request $request)
    {

       
        $validator = \Validator::make($request->all(), [
            'mobile_number' => ['required','numeric','digits:11'],
            'new_password'  => ['required', 'confirmed'],
        ]);


        if ($validator->fails()) {


            return $this->returnError(300, 'These data is not valid');
        }

        $client= Client::where('mobile_number',$request->mobile_number)->first();

        if (isset($client)) {
          
            $client->update(['password' => $request->new_password]);


            return $this->returnData(['client'], [$client], 'password updated successfully');

          
        }else{

                return $this->returnError(422, 'the phone number is no correct');
        }
    }
    #ssend sms 
    public function forgetpassword(Request $request)
    {


        $mobile = $request->mobile_number;

        try {

            $client = Client::where('mobile_number', $mobile)->firstOrFail();

        } catch (\Exception $e) {
            return $this->returnError(404, "mobile number Not Found");
        }


        $code = '123456';

        $client->update(['activation_code' => $code]);

        $activation_msg = 'your activation code is ' . $code;

        $this->send_sms('Eramint', $mobile, $activation_msg, app()->getLocale());

        $msg = "we sent an activation code to verify your mobile number";


        return $this->returnData(['code'], [$code], $msg);
    }


    public function social(Request $request, $flag)
    {


        $udid = $request->header('udid');


        $email = $request->email;

        $client = Client::where('email', $email)->first();

        if ($flag == 0) {

            $data = $this->returnData(['client'], [new ClientResource($client)], 'you have been logged in successfully');

        } else {


            $data = $this->returnData(['client'], [new ClientResource($client)], 'you have been registered successfully');

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


            $client->update(['status' => 0]);

            return $data;
        }
    }


    public function getAuthUser(Request $request)
    {
        return response()->json(new ClientResource(auth()->user()));
    }

    public function logout()
    {
        auth("client-api")->user()->tokens()->delete();
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
