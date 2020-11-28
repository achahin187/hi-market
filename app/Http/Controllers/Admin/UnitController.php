<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Measures;
use Illuminate\Http\Request;

class UnitController extends Controller
{



     function __construct()
    {
        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $measures = Measures::orderBy('id', 'desc')->get();

        return view('Admin.product_measuring_unit.index',compact('measures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.product_measuring_unit.create');
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

        $user = auth()->user();


        $rules = [
            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
        ];

        $this->validate($request,$rules);

        $measure = Measures::create([

            'arab_name' => $request->arab_name,
            'eng_name' => $request->eng_name,
            'created_by' => $user->id
        ]);

        if($measure)
        {
            return redirect('admin/measures')->withStatus(__('measuring unit created successfully'));
        }
        else
        {
            return redirect('admin/measures')->withStatus(__('something wrong happened , try again'));
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
        //
        $unit = Measures::find($id);

        $measures = Measures::orderBy('id', 'desc')->get();

        if($unit)
        {
            return view('Admin.product_measuring_unit.index', compact('measures','unit'));
        }
        else
        {
            return redirect('admin/measures')->withStatus('no measuring unit have this id');
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
            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/']
        ];

        $this->validate($request,$rules);

        $measure = Measures::find($id);


        if($measure)
        {
            $measure->update([

                'arab_name' => $request->arab_name,
                'eng_name' => $request->eng_name,
                'updated_by' => $user->id
            ]);
            return redirect('admin/measures')->withStatus(__('measure unit updated successfully'));
        }
        else
        {
            return redirect('admin/measures')->withStatus(__('something wrong happened , try again'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $measure = Measures::find($id);

        if($measure)
        {
            $measure->delete();
            return redirect('/admin/measures')->withStatus(__('measuring unit successfully deleted.'));
        }
        return redirect('/admin/measures')->withStatus(__('this id is not in our database'));
    }
}
