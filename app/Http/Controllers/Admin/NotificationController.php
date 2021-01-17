<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Notifications\SendNotification;
class NotificationController extends Controller
{

     function __construct()
    {
        $this->middleware('permission:notifications-list', ['only' => ['index']]);
        $this->middleware('permission:notifications-create', ['only' => ['create','store']]);
        $this->middleware('permission:notifications-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:notifications-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    
        $notifications = Notification::orderBy('id', 'desc')->get();

        return view('Admin.notifications.index',compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Admin.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
         $data =  [
                    "type" => "Custom",
                  ];
        $message_title = $request->title_ar;          
        $message_body  = $request->body_ar;  
                  

        new SendNotification('Custom', '', $data, 'Custom',$message_title, $message_body);
       
        return redirect()->route('notifications.index')->withStatus(__('added successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {      
        $notification = Notification::find($id);
        $notification->delete();
        return redirect()->route('Admin.notifications.index')->withStatus(__('deleted successfully'));
    }
}
