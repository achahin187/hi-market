<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{





    function __construct()
    {
        $this->middleware('permission:category-list', ['only' => ['index']]);
        $this->middleware('permission:category-list', ['only' => ['create','store']]);
        $this->middleware('permission:category-list', ['only' => ['edit','update']]);
        $this->middleware('permission:category-list', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $sizes = Size::orderBy('id', 'desc')->get();

        return view('Admin.product_size.index',compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.product_size.create');
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

    
        $request->validate([
            'value' => ['required','numeric','not_regex:/([%\$#\*<>]+)/','min:1'],
        ]);
     

        $size = Size::create([

            'value' => $request->value,
            'created_by' => $user->id
        ]);

        if($size)
        {
            return redirect('admin/sizes')->withStatus(__('size created successfully'));
        }
        else
        {
            return redirect('admin/sizes')->withStatus(__('something wrong happened , try again'));
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
        $size = Size::find($id);

        $sizes = Size::orderBy('id', 'desc')->get();

        if($size)
        {
            return view('Admin.product_size.index', compact('sizes','size'));
        }
        else
        {
            return redirect('admin/sizes')->withStatus('no size have this id');
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
            'value' => ['required','not_regex:/([%\$#\*<>]+)/'],
        ];

        $this->validate($request,$rules);

        $size = Size::find($id);

        if($size)
        {
            $size->update([

                'value' => $request->value,
                'updated_by' => $user->id
            ]);
            return redirect('admin/sizes')->withStatus(__('size updated successfully'));
        }
        else
        {
            return redirect('admin/sizes')->withStatus(__('something wrong happened , try again'));
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

        $size = Size::find($id);

        if($size)
        {
            $size->delete();
            return redirect('/admin/sizes')->withStatus(__('size successfully deleted.'));
        }
        return redirect('/admin/sizes')->withStatus(__('this id is not in our database'));
    }
}
