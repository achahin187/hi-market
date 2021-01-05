<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Polygon;
use Illuminate\Http\Request;

class AreaController extends Controller
{


    function __construct()
    {
        //$this->middleware('permission:show-location', ['only' => ['index']]);
        // $this->middleware('permission:product-create', ['only' => ['create','store']]);
        // $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $All_lat = Polygon::all();
         
        $areas = Area::orderBy('id', 'desc')->get();

        return view('Admin.areas.index',compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.areas.create');
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
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'country' => 'required|integer|min:0',
            'city' => 'required|integer|min:0',
            'status' => 'required|string'
        ];

        $this->validate($request,$rules);

        $area = Area::create([

            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'status' => $request->status,
            'country' => $request->country,
            'city' => $request->city,
            'created_by' => $user->id
        ]);

        if($area)
        {
            return redirect('admin/areas')->withStatus(__('araea created successfully'));
        }
        else
        {
            return redirect('admin/areas')->withStatus(__('something wrong happened'));
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
        $area = Area::find($id);

        if($area)
        {
            return view('Admin.areas.create', compact('area'));
        }
        else
        {
            return redirect('admin/areas')->withStatus('no area have this id');
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

        $area = Area::find($id);

        $user = auth()->user();

        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'country' => 'required|integer|min:0',
            'city' => 'required|integer|min:0',
        ];

        $this->validate($request,$rules);


        if($area)
        {

            $area->update([

                'name_ar' => $request->name_ar,
                'name' => $request->name_en,
                'country' => $request->country,
                'city' => $request->city,
                'updated_by' => $user->id
            ]);
            return redirect('admin/areas')->withStatus(__('araea updated successfully'));
        }
        else
        {
            return redirect('admin/areas')->withStatus(__('this id does not exist'));
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
        $area = Area::find($id);

        if($area)
        {
            $area->delete();
            return redirect('/admin/areas')->withStatus(__('area successfully deleted.'));
        }
        return redirect('/admin/areas')->withStatus(__('this id is not in our database'));
    }

    public function status(Request $request,$id)
    {

        $area = Area::find($id);

        if($area)
        {
            if($area->status == 'active') {

                $area->update(['status' => 'inactive']);
            }
            else
            {
                $area->update(['status' => 'active']);
            }
            return redirect()->back()->withStatus(__('area status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }
}
