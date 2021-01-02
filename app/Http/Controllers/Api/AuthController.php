<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\HelpResource;
use App\Http\Resources\SocialLoginResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Client;
use App\Models\Help;
use App\Models\Client_Devices;
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

        $url = 'https://dashboard.mobile-sms.com/api/sms/send?api_key=aTJuUTJzRElWMUJMUFpMeEVoeW93OWJCSkZsMWRmUGhYc2Rsa3VveVdXYWtsNXlJeGNOSERZWWMxMm9u5feda9be3e6d2&name='. $name .'&message='. $msg .'&numbers='.$mobile.'&sender='. $name .'&language='.$lang;

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

            $client->update(['verify'=>1, 'activation_code' => null]);

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
             
         ])) 
        {

            $client = Auth::guard('client-web')->user();

            $token = $client->createToken("hi-market")->accessToken;

            $msg = "you have been logged in successfully";

            $client->update(['device_token'=>$request->device_token]);

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


        $code = rand(0,99999);

        $client->update(['activation_code' => $code]);


        $activation_msg = trans('admin.activation_code') . $code;

        $client->update(['device_token'=>$request->device_token]);

        $this->send_sms('Delivertto', $request->mobile_number, $activation_msg, app()->getLocale());

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
          
            $client->update(['password' => $request->new_password, 'device_token'=>$request->device_token, 'activation_code'=>null]);

            $token = $client->createToken("hi-market")->accessToken;

            return $this->returnData(
                ['client', 'token'], [new ClientResource($client), $token], 'password updated successfully');

           
          
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


        $code = rand(0,99999);

        $client->update(['activation_code' => $code]);

        $activation_msg = trans('admin.activation_code') . $code;

        $this->send_sms('Delivertto', $mobile, $activation_msg, app()->getLocale());

        $msg = "we sent an activation code to verify your mobile number";


        return $this->returnData(['code'], [$code], $msg);
    }

    public function social(Request $request)
    {

        $udid = $request->header('udid');
     
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
            'email'=> ['required','email'],
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        }

        try {

            $client = Client::Where('email', $request->email)->first();

            if (!$client) {

                $client = Client::create([
                    'name'  => $request->name,
                    'email' => $request->email,
                    'type'  => $request->type,
                    'device_token'=>$request->device_token,
                    "unique_id" => Udid::where("body", $udid)->firstOrCreate([
                        "body"=>request()->header("udid")
                    ])->body
                ]);
            }

        } catch (\Exception $exception) {
            
            return response()->json([
                "success" => false,
                "msg" => "Client Not Exists With this Udid"
            ], 404);
        }
        
       $client->update(['device_token'=>$request->device_token]);
       $msg = 'login Successfully';

        return $this->returnData(['client',"token"], [new SocialLoginResource($client),$client->createToken("hi-market")->accessToken], $msg);
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

    public function getHelp()
    {
        $help = Help::all();
        return $this->returnData(['helps'], [ HelpResource::collection($help)]);

    }

    public function testNotification(Request $request)
    {

        //$client = Client::find(auth('client-api')->user()->id);

        $data = [
            "to" => $request->device_token,

            "data"=> 
                [
                    "type" => "order",
                    "orderId" => "13",
                ],

            "notification" =>
                [
                    "title" => 'Web Push',
                    "body" => "Sample Notification",
                    "icon" => url('/logo.png'),
                    "requireInteraction" => true,
                    "click_action"=> "HomeActivity",
                    "android_channel_id"=> "fcm_default_channel",
                    "high_priority"=> "high",
                    "show_in_foreground"=> true
                ],

            "android"=>
                [
                 "priority"=>"high",
                ],

                "priority" => 10,
                    "webpush"=> [
                          "headers"=> [
                            "Urgency"=> "high",
                          ],
                    ],
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=AAAAT5xxAlY:APA91bHptl1T_41zusVxw_wJoMyOOCozlgz2J4s6FlwsMZgFDdRq4nbNrllEFp6CYVPxrhUl6WGmJl5qK1Dgf1NHOSkcPLRXZaSSW_0TwlWx7R3lY-ZqeiwpgeG00aID2m2G22ZtFNiu',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        curl_exec($ch);

        return response()->json('send');
    }
}
