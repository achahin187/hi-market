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
        $reasons = Reason::orderBy('id', 'desc')->get();
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
        $user = auth()->user();

        $rules = [
            'arab_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
        ];

        $this->validate($request,$rules);

        $arab_reason = $request->input('arab_reason');

        $eng_reason = $request->input('eng_reason');

        $status = $request->input('status');

        $reason = Reason::create([

            'arab_reason' => $arab_reason,
            'eng_reason' => $eng_reason,
            'created_by' => $user->id
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
        $user = auth()->user();

        $rules = [
            'arab_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_reason' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
        ];

        $this->validate($request, $rules);

        $reason = Reason::find($id);

        if($reason)
        {
            $reason->update(['arab_reason' => $request->arab_reason, 'eng_reason' => $request->eng_reason , 'updated_by' => $user->id]);
            return redirect('/admin/reasons')->withStatus('reason successfully updated.');
        }
        else
        {
            return redirect('/admin/reasons')->withStatus('no reason exist');
        }
    }

    public function status(Request $request,$id)
    {

        $reason = Reason::find($id);

        if($reason)
        {
            if($reason->status == 'active') {
                $reason->update(['status' => 'inactive']);
            }
            else
            {
                $reason->update(['status' => 'active']);
            }
            return redirect('/admin/reasons')->withStatus(__('reason status successfully updated.'));
        }
        return redirect('/admin/reasons')->withStatus(__('this id is not in our database'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new AdminExport , 'admins.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'images' => 'image|mimes:csv|max:277'
        ];
        Excel::import(new AdminImport ,request()->file('file'));

        return back();
    }

}
