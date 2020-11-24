<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:show-location', ['only' => ['index']]);
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
        //
        $countries = Country::orderBy('id', 'desc')->get();

        return view('Admin.countries.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.countries.create');
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
            'numcode' => 'required|numeric',
            'phonecode' => 'required|numeric',
            'phonelength' => 'required|numeric',
            'status' => 'required|string'
        ];

        $this->validate($request,$rules);

        $city = Country::create([

            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'status' => $request->status,
            'numcode' => $request->numcode,
            'phonecode' => $request->phonecode,
            'phonelength' => $request->phonelength,
            'created_by' => $user->id
        ]);

        if($city)
        {
            return redirect('admin/countries')->withStatus(__('country created successfully'));
        }
        else
        {
            return redirect('admin/countries')->withStatus(__('something wrong happened'));
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

        $country = Country::find($id);

        if($country)
        {
            return view('Admin.countries.create', compact('country'));
        }
        else
        {
            return redirect('admin/countries')->withStatus('no city have this id');
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
        $country = Country::find($id);

        $user = auth()->user();

        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'numcode' => 'required|integer|min:0',
            'phonecode' => 'required|integer|min:0',
            'phonelength' => 'required|integer|min:0',
        ];

        $this->validate($request,$rules);


        if($country)
        {

            $country->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'numcode' => $request->numcode,
                'phonecode' => $request->phonecode,
                'phonelength' => $request->phonelength,
                'updated_by' => $user->id
            ]);
            return redirect('admin/countries')->withStatus(__('city updated successfully'));
        }
        else
        {
            return redirect('admin/countries')->withStatus(__('this id does not exist'));
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
        $country = Country::find($id);

        if($country)
        {
            $country->delete();
            return redirect('/admin/countries')->withStatus(__('country successfully deleted.'));
        }
        return redirect('/admin/countries')->withStatus(__('this id is not in our database'));
    }

    public function status(Request $request,$city_id)
    {

        $country = Country::find($city_id);

        if($country)
        {
            if($country->status == 'active') {

                $country->update(['status' => 'inactive']);
            }
            else
            {
                $country->update(['status' => 'active']);
            }
            return redirect()->back()->withStatus(__('country status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }
}
