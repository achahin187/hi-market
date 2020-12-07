<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Offer;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        if (\request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }

    public function index()
    {
        $orders = getUser()->orders;
        $offers = Offer::all();
        return $this->returnData(["offers", "orders"], [$offers, $orders]);
    }
}
