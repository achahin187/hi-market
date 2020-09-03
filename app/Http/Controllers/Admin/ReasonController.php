<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $reasons = Reason::orderBy('id', 'desc')->paginate(10);
        return view('Admin.reasons.index',compact('reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.reasons.create');
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

        $rules = [
            'arab_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'active' => 'required|string',
        ];

        $this->validate($request,$rules);

        $arab_reason = $request->input('arab_reason');

        $eng_reason = $request->input('eng_reason');

        $status = $request->input('status');

        $reason = Reason::create([

            'arab_reason' => $arab_reason,
            'eng_reason' => $eng_reason,
            'status' => $status,
        ]);

        if($reason)
        {
            return redirect('admin/reasons')->withStatus(__('reason created successfully'));
        }
        else
        {
            return redirect('admin/reasons')->withStatus(__('error happened , try again'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //'
        $reason = Reason::findOrFail($id);

        if($reason)
        {
            return view('Admin.reasons.create', compact('reason'));
        }
        else
        {
            return redirect('admin/reasons')->withStatus('no reason have this id');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'arab_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'status' => 'required|string',
        ];

        $this->validate($request, $rules);

        $reason = Reason::findOrFail($id);

        if($reason)
        {
            $reason->update(['arab_reason' => $request->arab_reason, 'eng_reason' => $request->eng_reason, 'status' => $request->status]);
            return redirect('/admin/reasons')->withStatus('reason successfully updated.');
        }
        else
        {
            return redirect('/admin/reasons')->withStatus('no reason exist');
        }
    }

}
