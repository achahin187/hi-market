<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAsapController extends Controller
{
    public function index()
    {
        $orders = Order::where("asap", 1)->orWhereDate("delivery_date",now()->format("Y-m-d"))->paginate();
        return view("Admin.orders_asap.index", compact("orders"));
    }

}
