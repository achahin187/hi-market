<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Client;
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

        $this->validate($request,$rules);

        $client_id = $request->input('client_id');

        $product_id = $request->input('product_id');

        $client = Client::find($client_id);


        if($client)
        {
            $client->products()->attach($product_id,['flag' => $flag]);

            return $this->returnSuccessMessage('This product have been added to your favourites successfully');
        }
        else
        {
            return $this->returnError('','no client exists');
        }

    }

    public function getfavourites($clientid,$flag)
    {

        $client = Client::find($clientid);


        $favourites = array();

        if($client) {
            if ($flag == 1) {

                foreach($client->products as $product)
                {

                    if($this->getCurrentLang() == 'ar')
                    {

                        $productarray =
                        [
                            'name' => $product->arab_name,
                            'description' => $product->arab_description,
                            'rate' => $product->rate,
                            'price' => $product->price,
                            'images' => $product->images,
                            'category' => $product->category->arab_name,
                            'vendor' => $product->vendor->arab_name
                        ];
                    }
                    else
                    {

                        $productarray =
                            [
                                'name' => $product->eng_name,
                                'description' => $product->eng_description,
                                'rate' => $product->rate,
                                'price' => $product->price,
                                'images' => $product->images,
                                'category' => $product->category->eng_name,
                                'vendor' => $product->vendor->eng_name
                            ];
                    }
                    if($product->pivot->flag == 1)
                    {
                        $favourites[] = $productarray;
                    }
                }

                if(count($favourites) < 1)
                {
                    return $this->returnError('4545', 'there is no favourite products for this client');
                }
                return $this->returnData('favourites', $favourites);
            }

            else {

                foreach($client->products as $product)
                {

                    if($this->getCurrentLang() == 'ar')
                    {

                        $productarray =
                            [
                                'name' => $product->arab_name,
                                'description' => $product->arab_description,
                                'rate' => $product->rate,
                                'price' => $product->price,
                                'images' => $product->images,
                                'category' => $product->category->arab_name,
                                'vendor' => $product->vendor->arab_name
                            ];
                    }
                    else
                    {

                        $productarray =
                            [
                                'name' => $product->eng_name,
                                'description' => $product->eng_description,
                                'rate' => $product->rate,
                                'price' => $product->price,
                                'images' => $product->images,
                                'category' => $product->category->eng_name,
                                'vendor' => $product->vendor->eng_name
                            ];
                    }
                    if($product->pivot->flag == 0)
                    {
                        $favourites[] = $productarray;
                    }
                }
                if(count($favourites) < 1)
                {
                    return $this->returnError('4545', 'there is no wishlist products for this client');
                }
                return $this->returnData('wishlist', $favourites);
            }
        }
        else
        {
            return $this->returnError('','no client exists with this id');
        }
    }
}
