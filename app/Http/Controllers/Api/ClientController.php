<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Client;
use App\Models\Address;
use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ClientController extends Controller
{
    //

    use generaltrait;

    public function client_profile(Request $request)
    {
        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $token = $request->header('token');

        $client = Client::where('remember_token',$token)->first();

        if($client)
        {
            return $this->returnData(['client'], [$client]);
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

    public function updateprofile(Request $request)
    {

        $lang = $request->header('lang');

        $token = $request->header('token');

        $client = Client::where('remember_token',$token)->first();

        if($client)
        {

            $rules = [
                'name' =>'required|string|min:5|max:30|not_regex:/([%\$#\*<>]+)/',
                'email' => ['required','email',Rule::unique((new Client)->getTable()),'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
                'mobile_number' => ['required','digits:11',Rule::unique((new Client)->getTable())->ignore($client->id)],
            ];

            $validator = Validator::make($request->all(),$rules);


            if($validator->fails()) {

                if ($lang == 'ar') {
                    return $this->returnError(300, 'بيانات الدخول غير صحيحة');
                }
                else
                {
                    return $this->returnError(300, 'These data is not valid');
                }
            }

            $client->update([
                'name' => $request->name ,
                'email' => $request->email ,
                'mobile_number' => $request->mobile_number
            ]);


            if ($lang == 'ar') {
                return $this->returnSuccessMessage('لقد تم تعديل بياناتك بنجاح',500);
            }
            else
            {
                return $this->returnSuccessMessage( 'your data has been updated successfully' , 500);
            }
        }
        else
        {
            if($lang == 'ar')
            {
                return $this->returnError(303,'لم نجد هذا العميل');
            }
            return $this->returnError(303,'there is no client found');
        }
    }

    public function clientpoints(Request $request)
    {
        $udid = $request->header('udid');

        $token = $request->header('token');

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){

            return $this->returnError(402,'language is missing');
        }

        $client = Client::where('remember_token',$token)->first();

        if($client)
        {
            return $this->returnData(['client points'],[$client->total_points]);
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

    public function clientaddresses(Request $request)
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
            $addresses = $client->addresses()->select('id','name','phone','description','default','address_lable','lat','lon','govern','additional')->get();

            foreach ($addresses as $address)
            {
                $address->name = $client->name;
                $address->name = $client->name;
                $address->mobile_number = $client->mobile_number;
                $address->default = $address->default;
                $address->address_lable = $address->address_lable;
                $address->lat = $address->lat;
                $address->lon = $address->lon;
                $address->govern = $address->govern;
                $address->additional = $address->additional;

            }
            
            return $this->returnData(['client addresses'],[$addresses]);
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

    public function resetpassword(Request $request)
    {

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $mobile = $request->mobile;

        $client = Client::where('mobile_number',$mobile)->first();

        if($client)
        {

            $validator = Validator::make($request->all(), [
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

            $token = auth()->guard('client-api')->login($client);

            $client->update(['remember_token' => $token,'password' => Hash::make($request->password),]);

            if ($lang == 'ar') {
                return $this->returnData(['client'], [$client] , 'لقد تم تعديل كلمة السر بنجاح');
            }
            else
            {
                return $this->returnData(['client'], [$client] , 'password updated successfully');
            }
        }
        else
        {

            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError(205,'لم نجد هذا العميل');
            }
            return $this->returnError(205,'there is no client found');
        }
    }

    public function changepassword(Request $request)
    {

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $token = $request->header('token');

        $client = Client::where('remember_token',$token)->first();


        if($client)
        {


            $validator = Validator::make($request->all(), [
                'old_password' => ['required'],
                'new_password' => ['required','confirmed','different:old_password'],
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

            if(Hash::check($request->old_password,$client->password))
            {
                $client->update(['password' => Hash::make($request->new_password),]);

                if ($lang == 'ar') {
                    return $this->returnData(['client'], [$client] , 'لقد تم تعديل كلمة السر بنجاح');
                }
                else
                {
                    return $this->returnData(['client'], [$client] , 'password updated successfully');
                }
            }
            else
            {
                if($this->getCurrentLang() == 'ar')
                {
                    return $this->returnError(205,'كلمة السر الخاصة بك غير مطابقة');
                }
                return $this->returnError(205,'the old password is not in our records');
            }
        }
        else
        {

            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError(205,'لم نجد هذا العميل');
            }
            return $this->returnError(205,'there is no client found');
        }
    }

    public function add_address(Request $request)
    {

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $token = $request->header('token');

        $client = Client::where('remember_token',$token)->first();

        
        if($client) {

            $validator = \Validator::make($request->all(), [
                'address'        => ['required', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                'label'          => ['required', 'string'],
                'label'          => ['required', 'string'],
                'default'        => ['boolean'],
                'lat'            => ['required','string'],
                'lon'            => ['required', 'string'],
                'additional'     => ['nullable'],
            ]);


            if ($validator->fails()) {

                if ($lang == 'ar') {
                    return $this->returnError(300, 'بيانات الدخول غير صحيحة');
                } else {
                    return $this->returnError(300, 'These data is not valid');
                }
            }   


            $name       = $request->name;
            $phone      = $request->phone;
            $address    = $request->address;
            $label      = $request->label;
            $client_id  = $client->id;
            $default    = $request->default;
            $lat        = $request->lat;
            $lon        = $request->lon;
            $additional = $request->additional;
            $govern     = $request->govern;
       
            Address::create([
                'name'=>$name, 'phone'=>$phone, 'description' => $address,
                'address_lable' => $label, 'client_id'=> $client_id,
                 'default' => $default, 'lat'=>$lat, 'lon'=>$lon, 
                'additional'=>$additional,'govern'=>$govern,
            ]);

            if ($address) {
                if ($this->getCurrentLang() == 'ar') {
                    return $this->returnSuccessMessage('لقد اضفت هذا العنوان بنجاح ',200);
                }
                return $this->returnSuccessMessage('This address have been added successfully',200);
            } else {
                if ($this->getCurrentLang() == 'ar') {
                    return $this->returnError('', 'هناك مشكلة في اضافة العنوان , حاول مرة اخري');
                }
                return $this->returnError('', 'something wrong happened');
            }
        }
        else
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError(404,'لم نجد هذا العميل');
            }
            return $this->returnError(404,'there is no client found');
        }
    }

    public function get_address(Request $request)
    {

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $token = $request->header('token');

        $client = Client::where('remember_token',$token)->first();

        if($client)
        {
            if(count($client->addresses) < 1)
            {
                if($lang == 'ar')
                {
                    return $this->returnError('','ليس هناك عناوين مسجلة باسمك');
                }
                return $this->returnError('','there is no addresses for this client registered');
            }
            return $this->returnData(['client_addresses'],[$client->addresses]);
        }
        else
        {
            if($lang == 'ar')
            {
                return $this->returnError('','لم نجد هذا العميل');
            }
            return $this->returnError('','there is no client found');
        }
    }

    public function delete_address(Request $request)
    {
        
        $token = $request->header('token');

        $client = Client::where('remember_token',$token)->first();


        if($client)
        {
            $address = Address::find($request->id);

            if ($address) {

                $address->delete();

                return $this->returnSuccessMessage('delted successfully');
            }else{

                return $this->returnError(404,'id not found');

            }

        }else{


            return $this->returnError(401,'Unauthorized');
            
        }

    }

    public function update_address(Request $request)
    {
         $lang = $request->header('lang');

        if(!$lang || $lang == ''){
            return $this->returnError(402,Lang::get('message.missingLang'));
        }

        $token = $request->header('token');

        $client = Client::where('remember_token',$token)->first();

        if($client)
        {
            if(count($client->addresses) >= 1)
            {
                $address = $client->addresses()->where('id',$request->address_id)->first();
                if ($address) {
                    
                $request_data = $request->except('address_id');
                $address->update($request_data);
                }else{
                    if($lang == 'ar')
                    {
                        return $this->returnError(404,'العنوان غير موجود');
                    }else{

                        return $this->returnError(404,'address not dound');
                    }
                }

                if($lang == 'ar')
                {
                    return $this->returnSuccessMessage('تم التعديل بنجاح',200);
                }else{
                    return $this->returnSuccessMessage('updated successfully', 200);
                }
            }
           
        }
        else
        {
            if($lang == 'ar')
            {
                return $this->returnError(404,'لم نجد هذا العميل');
            }
            return $this->returnError(404,'there is no client found');
        }
    }
}
