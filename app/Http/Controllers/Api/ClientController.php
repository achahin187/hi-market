<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Address;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //

    use generaltrait;

    public function client_profile($client_id)
    {
        $client = Client::find($client_id);

        if($client)
        {
            return $this->returnData('client', $client);
        }
        else
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError('','لم نجد هذا العميل');
            }
            return $this->returnError('','there is no client found');
        }
    }

    public function add_address(Request $request)
    {
        $rules = [
            'client_id' => 'required|integer|min:0',
            'description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
        ];

        $this->validate($request,$rules);

        $address = Address::create($request->all());

        if($address)
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnSuccessMessage('لقد اضفت هذا العنوان بنجاح ');
            }
            return $this->returnSuccessMessage('This address have been added successfully');
        }
        else
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError('','هناك مشكلة في اضافة العنوان , حاول مرة اخري');
            }
            return $this->returnError('','something wrong happened');
        }
    }

    public function get_addresses($client_id)
    {
        $client = Client::find($client_id);

        if($client)
        {
            if(count($client->addresses) < 1)
            {
                if($this->getCurrentLang() == 'ar')
                {
                    return $this->returnError('','ليس هناك عناوين مسجلة باسمك');
                }
                return $this->returnError('','there is no addresses for this client registered');
            }
            return $this->returnData('client', $client->addresses);
        }
        else
        {
            if($this->getCurrentLang() == 'ar')
            {
                return $this->returnError('','لم نجد هذا العميل');
            }
            return $this->returnError('','there is no client found');
        }
    }
}
