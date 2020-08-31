<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function show($id)
    {
        //
        $request = CartRequest::findOrFail($id);

        if($request)
        {
            return view('Admin.requests.show', compact('request'));
        }
        else
        {
            return redirect('admin/requests')->withStatus('no request have this id');
        }
    }

}
