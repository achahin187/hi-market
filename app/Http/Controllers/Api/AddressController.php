<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\generaltrait;

class AddressController extends Controller
{
    use generaltrait;

    public function addAddress(Request $request)
    {

    	$request->validate([
    		'lat' => 'required',
    		'lon' => 'required',
    		'location' => 'string|required',
    		'status' => 'required|boolean',
    		'additional' => 'required',
    	]);
    }
}
