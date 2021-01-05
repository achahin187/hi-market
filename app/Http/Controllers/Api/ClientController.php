<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Http\Resources\ClientResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Client;
use App\Models\Address;
use App\Models\Setting;
use App\Models\Point;
use App\Models\Udid;
use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use File;
use Illuminate\Support\Facades\DB;
class ClientController extends Controller
{
    //

    use GeneralTrait;

    public function __construct()
    {


        $this->middleware("auth:client-api");
    }

    public function client_profile(Request $request)
    {


        $client = getUser();

        return $this->returnData(['client'], [new ClientResource($client)]);
    }

    public function updateprofile(Request $request)
    {
        $client = getUser();

        $rules = [
            'name' => 'nullable|string|min:5|max:30|not_regex:/([%\$#\*<>]+)/',
        ];

        $validator = \Validator::make($request->all(), $rules);


        if ($validator->fails()) {


            return $this->returnError(422, $validator->errors()->first());

        }

        $client->update(
            request()->all()
        );


        return $this->returnSuccessMessage('your data has been updated successfully', 200);
    }

    public function clientpoints(Request $request)
    { 
  
        $client = getUser();

        $points = Point::whereDate("end_date", ">", date("Y-m-d H:i:s", now()->timestamp))->where("status","active")->orderBy("points", "asc")
            ->get()->map(function ($point) use($client){
                
                return [
                    "id"=>$point->id,
                    "point"=>(int) $point->points,
                    "purchase" => $point->value,
                    "is_percentage"=>$point->type == 0 ? false : true,
                    "checked"=> $client->total_points >= $point->points   ? true : false, 
                ];
            });
        $image = DB::table('point_photos')->first();
        return $this->returnData(['myPoints',"points", "pointsImage"], [$client->total_points ?? 0, $points, asset('points/'.$image->image)]);
    }

    public function usePoints(Request $request)
    {

        $validation = \Validator::make(\request()->all(), [
            "total_redeem_point" => "required",
            "total_order_money" => "required"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        
        $setting = Setting::first();



        $client = Auth('client-api')->user();

        $points = Point::orderBy('points', 'desc')
        ->Where('value','<=',$request->total_order_money)
        ->orWhere('points','<=',$request->total_redeem_point)
        ->where('status','active')
        ->first();

        if ($points) {
            
            /*if ($points->type == 0) {
                $total = $request->total_order_money - (( $request->total_order_money * $points->value)/100) ;
            }
            else{

                $total = $request->total_order_money - $points->value ;
            }

            if ($total <=  (( $request->total_order_money * $setting->reedem_point)/100)) {

                $total = (( $request->total_order_money * $setting->reedem_point)/100)  ;
            }*/

            $total = $request->total_order_money - $points->value ;

                if($total <= 0 )
                {
                    $total = (( $request->total_order_money * $setting->reedem_point)/100);
                    
                        # code...
                    if($points->value > $request->total_order_money)
                    {

                        $variable_here = $points->points - (int)(($request->total_order_money / $points->value) * $points->points);
                        $user = Client::where('id', $client->id)->first();
                        $user->update([ 
                            'total_points'=> $variable_here + $user->total_points,
                        ]); 

                    }
                }

              return [
                        'status' => true,
                        'msg'=>'',
                        'data'=>[
                            'totalOrderMoney' => $total,                        
                        ],
                    ];
        }else{

              return [
                        'status' => true,
                        'msg'=>'Collect More Points to get Offers',
                        'data'=>[
                            'totalOrderMoney' => intval($request->total_order_money),                        
                        ],
                    ];
        }

         // return $this->returnData(["user_points","point"], [$user->points,$point]);

        // $point = Point::find(\request("point_id"));
        // $user = \auth()->user();
        // $user->points = $point->points - $user->points;
        // $user->save();
    }

    public function clientaddresses(Request $request)
    {
        $udid = $request->header('udid');


        $client = \auth("client-api")->check() ? \auth("client-api")->user() : Udid::where("body", $udid)->first();

        if ($client) {

            $addresses = $client->addresses()->where('verified',1)->get();

            return $this->returnData(['client addresses'], [AddressResource::collection($addresses)]);
        }
    }

    public function uploadImage(Request $request)
    {

        $validator = \Validator::make($request->all(), [
             'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ]);
         if ($validator->fails()) {
            return $this->returnValidationError(422, $validator);
        }

        $userImage = Auth('client-api')->user()->image;
        
        if ($request->image) {

            if ($userImage != $request->image) {

                 $image_path = app_path("images/".$userImage);

                    if (File::exists($image_path)) {
                        unlink($image_path);
                    }
            }//end of if

            $image = $request->image;
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = $filename;

            $image->move('client', $file_to_store);

            Auth('client-api')->user()->update([
                'image' => $file_to_store,
            ]);

             return $this->returnData(['image'],[asset('client/'.$file_to_store)],'image updated successfully');
        }
    }

    public function changepassword(Request $request)
    {


        $udid = $request->header('udid');

        if (auth("client-api")->check()) {
            $client = \auth("client-api")->user();

        } else {
            $client = Client::where('unique_id', $udid)->first();

        }


        $validator = \Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'different:old_password'],
        ]);


        if ($validator->fails()) {


              return $this->returnValidationError(422, $validator);
        }
 

        if (Hash::check($request->old_password, $client->password)) {
            
            $client->update([
                'password' => Hash::make($request->new_password),
                'device_token'=>$request->device_token
            ]);
            
             $token = $client->createToken("hi-market")->accessToken;
            return $this->returnData(['client', 'token'], [$client, $token], 'password updated successfully');

        } else {

            return $this->returnError(422, 'the old password is not in our records');
        }
    }

    public function setDefault(Request $request)
    {

       $client_address =  Auth('client-api')->user()->addresses->where('default',1)->first();
       $check =  Address::Where('id', $request->address_id)->where('client_id', Auth('client-api')->user()->id )->first();
     
       if ($check) {
           

            $address = Address::find($request->address_id);
       
            if ($address) {

                if($address->default == 1 || $client_address){

                    if ($client_address) {
                        
                        $client_address->update(['default'=>0 ]);
                    }

                 $address->update(['default'=>1 ]);

                }else{

                $address->update(['default'=>1 ]);

                }

                return $this->returnSuccessMessage("updated successfully");

            }else{

                 return $this->returnError(404, 'Address Id Not Found');

            }

       }else{

             return $this->returnError(404, 'Address Id Not Found');

       }
       // if ($address) {

       //     $address->update(['default'=>0]);

       //     $newDefault = Address::where('id',$request->address_id)->first();
       //     return $newDefault;
       //     $newDefault->update(['default'=>1]);

       //      return $this->returnSuccessMessage("updated successfully");
            
       // }else{

       //      $newDefault = Address::find($request->address_id);
       //       return $newDefault;
       //      $newDefault->update(['default'=>0]);
       // }
    }

    public function validateAddress()
    {
        $validation = \Validator::make(\request()->all(), [
            "address_id" => "required|exists:addresses,id",
            "code" => "required"
        ]);

        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        $address = Address::find(\request("address_id"));

        if ($address->verify == request("code")) {
            $address->update(["verified" => 1]);
            return $this->returnSuccessMessage("address verified");
        }

        return $this->returnError(422, "code is invalid");
    }

    public function add_address(Request $request)
    {
        $client = \auth("client-api")->user();

        $validator = \Validator::make($request->all(), [
            'address' => ['required', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
            'label' => ['required', 'string'],
            'default' => ['boolean'],
            'lat' => ['required', 'string'],
            'lon' => ['required', 'string'],
            'phone' => 'required|unique:addresses,phone|digits:11',
            'govern' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);


        if ($validator->fails()) {
            return $this->returnError(300, $validator->errors()->first());
        }

        if($request->default == 1)
        {

            $address = Auth('client-api')->user()->addresses->where('default',1)->first();

            if ($address) {
             
                $address->update([ 'default' => 0 ]);
                $default = 1;

            }else{
                $default = 1;
            }

        }else{
            $default = 0; 
        }

        $rand = "12345";

        $address=Address::create([
            'name' =>  $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'address_lable' => $request->label,
            'client_id' => $request->client_id,
            'default' => $default,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'notes' => $request->additional,
            'govern' => $request->govern,
            "verified" => 0,
            "verify" => $rand,
            "client_id" => $client->id,
        ]);

        #send sms to the number in address


        return response()->json([

            "status" => true,
            'msg' =>'',
            'data'=> [
                'address_id'=>$address->id,
                'code'=>$rand,
            ],
        ],200);  
        return $this->returnSuccessMessage("address created successfully", 200);
    }

    public function get_address(Request $request)
    {


        $client = \auth("client-api")->user();


        if (count($client->addresses) < 1) {

            return $this->returnError('', 'there is no addresses for this client registered');
        }
        return $this->returnData(['client_addresses'], [AddressResource::collection($client->addresses)]);
    }

    public function delete_address(Request $request)
    {


        $client = \auth("client-api")->user();


        if ($client) {
            $address = Address::find($request->id);

            if ($address) {

                $address->delete();

                return $this->returnSuccessMessage('deleted successfully');
            } else {

                return $this->returnError(404, 'id not found');

            }

        } else {


            return $this->returnError(401, 'Unauthorized');

        }
    }

    public function update_address(Request $request)
    {
        $client = \auth()->user();
      
        $validator = \Validator::make($request->all(), [
            'address' => 'required',
            'label' => 'string',
            'default' => 'boolean',
            'lat' => 'string',
            'lon' => 'string',
            'govern' => 'string',
            'name' => 'string',
            'phone' => 'string',
        ]);


       if ($validator->fails()) {
            return $this->returnError(422, $validator->errors()->first());
        }

        

         if ( $client->addresses != null ) {

            $address = $client->addresses()->where('id', $request->address_id)->first();

            $addressWhereDefault  = $client->addresses()->where('default', 1)->first();
          
            if ($address) {

                if ($request->default == 1 &&  $addressWhereDefault ) {
                    $addressWhereDefault->update([ 'default' => 0 ]);
                }
                   
                DB::table('addresses')->Where('id', $request->address_id)->update([
                    "name"               => $request->name,
                    "phone"              => $request->phone,
                    "govern"             => $request->govern,
                    "address"            => $request->address,
                    "default"            => $request->default,
                    "address_lable"      => $request->label,
                    "lat"                => $request->lat,
                    "lon"                => $request->lon,
                    "notes"              => $request->additional,
                    "client_id"          => $client->id,
                
                ]);
                //$address->update($request_data);

            } else {


                return $this->returnError(404, 'address not found');

            }


            return $this->returnSuccessMessage('updated successfully', 200);


        }
    }

    public function contactUs(Request $request)
    {
         $validator = \Validator::make($request->all(), [
            'name'        => 'required',
            'title'       => 'required',
            'message'     => 'required',
        ]);


       if ($validator->fails()) {
            return $this->returnError(422, $validator->errors()->first());
        }

        $client = getUser();

       
            $contact_us = Inbox::create([
                'name'      => $request->name,
                'title'     => $request->title,
                'message'   => $request->message,
                'client_id' => $client != null ? $clinet->id :null ,
                'udid'      => $client == null ? request()->header('udid') : null ,

            ]); 
       
         return $this->returnSuccessMessage('your message sent successfully', 200);
    }//end function
}

