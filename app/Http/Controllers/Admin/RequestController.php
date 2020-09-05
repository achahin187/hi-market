<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\CartRequest;

class RequestController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $requests = CartRequest::orderBy('id', 'desc')->paginate(10);
        return view('Admin.requests.index',compact('requests'));
    }

    public function show($request_id)
    {
        //
        $request = CartRequest::find($request_id);

        if($request)
        {
            if($request->converted == 1)
            {
                $order = Order::where('request',$request->id)->first();
                return view('Admin.requests.show', compact('order','request'));
            }
            else
            {
                return view('Admin.requests.show', compact('request'));
            }
        }
        else
        {
            return redirect('admin/requests')->withStatus('no request have this id');
        }
    }

}
