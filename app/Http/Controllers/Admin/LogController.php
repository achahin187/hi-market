<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Systemlog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $logs = Systemlog::all();

        return view('Admin.systemlogs.index',compact('logs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request,$filter)
    {

        if($filter == 'user_id') {

            $logs = Systemlog::where('causer_id', $request->user_id)->get();
        }
        else
        {
            $datefrom = date("Y-m-d", strtotime(explode('-',$request->daterange)[0]));

            $dateto = date("Y-m-d", strtotime(explode('-',$request->daterange)[1]));

            $logs = Systemlog::whereBetween('created_at',array($datefrom,$dateto))->get();

        }

        return view('Admin.systemlogs.index',compact('logs'));
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
     * @param  \App\Systemlog  $systemlog
     * @return \Illuminate\Http\Response
     */
    public function show(Systemlog $systemlog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Systemlog  $systemlog
     * @return \Illuminate\Http\Response
     */
    public function edit(Systemlog $systemlog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Systemlog  $systemlog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Systemlog $systemlog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Systemlog  $systemlog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Systemlog $systemlog)
    {
        //
    }
}
