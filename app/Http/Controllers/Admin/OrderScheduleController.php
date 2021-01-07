<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderScheduleController extends Controller
{
    public function index()
    {
        $orders = Order::where("asap", 0)->paginate();
        return view("Admin.orders_schedule.index", compact("orders"));
    }
    public function changeStatus($id)
    {
        $order = Order::find($id);
        $order->update([
            "asap"=>(int) !$order->asap,
            "type"=>"asap"
        ]);
        return back();
    }
}
