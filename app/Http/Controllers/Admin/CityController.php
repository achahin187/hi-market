<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cities = City::orderBy('id', 'desc')->get();

        return view('Admin.cities.index',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.cities.create');
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
            'status' => 'required|string'
        ];

        $this->validate($request,$rules);

        $city = City::create([

            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'status' => $request->status,
            'country' => $request->country,
            'created_by' => $user->id
        ]);

        if($city)
        {
            return redirect('admin/cities')->withStatus(__('city created successfully'));
        }
        else
        {
            return redirect('admin/cities')->withStatus(__('something wrong happened'));
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
        $city = City::find($id);

        if($city)
        {
            return view('Admin.cities.create', compact('city'));
        }
        else
        {
            return redirect('admin/cities')->withStatus('no city have this id');
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
        $city = City::find($id);

        $user = auth()->user();

        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'country' => 'required|integer|min:0',
        ];

        $this->validate($request,$rules);


        if($city)
        {

            $city->update([

                'name_ar' => $request->name_ar,
                'name' => $request->name_en,
                'country' => $request->country,
                'updated_by' => $user->id
            ]);
            return redirect('admin/cities')->withStatus(__('city updated successfully'));
        }
        else
        {
            return redirect('admin/cities')->withStatus(__('this id does not exist'));
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
        $city = City::find($id);

        if($city)
        {
            $city->delete();
            return redirect('/admin/cities')->withStatus(__('city successfully deleted.'));
        }
        return redirect('/admin/city')->withStatus(__('this id is not in our database'));
    }

    public function status(Request $request,$city_id)
    {

        $city = City::find($city_id);

        if($city)
        {
            if($city->status == 'active') {

                $city->update(['status' => 'inactive']);
            }
            else
            {
                $city->update(['status' => 'active']);
            }
            return redirect()->back()->withStatus(__('city status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }
}
