<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        if (\request()->header("Authorization")) {

            $this->middleware("auth:client-api");

        }
    }

    public function updateaddress(Request $request)
    {


        $client = getUser();


        $validator = Validator::make($request->all(), [
            'address' => ['required', 'not_regex:/([%\$#\*<>]+)/'],

        ]);

        if ($validator->fails()) {


            return $this->returnValidationError(422, $validator);
        }


        $address = $request->address;
        $label   = $request->label;
        $default = $request->default;
        $address_id = $request->address_id;

        Address::where('client_id', $client->id)->where('id', $address_id)->update(['description' => $address, 'address_lable' => $label, 'default' => $default]);


        return $this->returnSuccessMessage('This address have been updated successfully', 200);


    }

    public function addaddress(Request $request)
    {

       $client= getUser();


        $address = $request->address;
        $label = $request->label;
        $client_id = $client->id;
        $default = $request->default;
        $name = $request->name;
        $phone = $request->phone;

        Address::create(['description' => $address, 'address_lable' => $label, 'client_id' => $client_id, 'default' => $default, 'name' => $name, 'phone' => $phone]);


        return $this->returnSuccessMessage('This address have been added successfully', 200);


    }


}
