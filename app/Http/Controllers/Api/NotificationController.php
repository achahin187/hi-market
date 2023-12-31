<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OrderResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Offer;
use App\Models\NotificationMobile;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
//        if (\request()->header("Authorization")) {
            $this->middleware("auth:client-api");
//        }
    }

    public function index()
    {
        if($client = auth("client-api")->user())
        {
            $orders = NotificationMobile::Where('client_id', $client->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate();
                      
         
            return $this->returnData(["orders", "more"], [OrderResource::collection( $orders), $orders->hasMorePages()]);

        }else{

            return $this->returnError(422,"User No Exists");

        }

    }


    public function getUser()
    {
        return auth("client-api")->user();
    }


}
