<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inbox;
class InboxController extends Controller
{
    private $blade;
    private $route;
    private $model;
    private $title;
    const NUMBER = 10;

    
    public function __construct()
    {
       
       $this->blade = 'Admin.contact_us.';
       $this->route = 'Admin.inboxes.' ;
       $this->model = 'App\Models\Inbox';
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $inboxes = $this->model::all();

        return view($this->blade.__FUNCTION__)->with(['inboxes'=>$inboxes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function show(Inbox $inbox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function edit(Inbox $inbox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inbox $inbox)
    {
        
        if ($inbox->statuse == 0) {
             $inbox->update(['statuse'=> 1]);
        }
        
       $count_inbox = $this->model::Where('statuse', 0 )->count();
        return response()->json($count_inbox);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inbox $inbox)
    {            
        $inbox->delete();
        return response()->json(['success'=>'deleted successfully']);
    }
}
