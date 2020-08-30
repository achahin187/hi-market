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
            return $this->returnError('','there is no client found');
        }
    }

    public function add_address(Request $request)
    {
        $rules = [
            'client_id' => 'required|integer|min:0',
            'description' => 'required|string|min:2'
        ];

        $this->validate($request,$rules);

        $client_id = $request->input('client_id');

        $description = $request->input('description');

        $address = Address::create($request->all());

        if($address)
        {
            return $this->returnSuccessMessage('This address have been added successfully');
        }
        else
        {
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
                return $this->returnError('','there is no addresses for this client registered');
            }
            return $this->returnData('client', $client->addresses);
        }
        else
        {
            return $this->returnError('','there is no client found');
        }
    }
}
