<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Client;
use App\Models\Fav_product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouritesController extends Controller
{
    //

    use generaltrait;

    public function addfavourite(Request $request,$flag)
    {
        //
        $rules = [
            'client_id' => 'required|integer',
            'product_id' => 'required|integer',
        ];


        if($this->validate($request,$rules))
        {

            $client_id = $request->input('client_id');

            $product_id = $request->input('product_id');

            $flag = $request->input('flag');

            Fav_product::create($request->all());

            return $this->returnSuccessMessage('This product have been added to your favourites successfully');
        }
        else
        {
            return $this->returnError('','error happened in validation');
        }

    }

    public function getfavourites($clientid,$flag)
    {
        if($flag == "favourites") {

            $client = Client::find($clientid);
            $favourites =  $client->
            returnData('favourites', $favourites);
        }
        else {
            $wishlist = Wishlist::all();
            return $this->returnData('wishlist', $wishlist);
        }
    }
}
