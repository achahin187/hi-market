<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.settings.edit');
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
            'arab_name' => 'required|min:2|max:60',
            'eng_name' => 'required|min:2|max:60',
            'sponsor' => 'required|integer|min:0',
            'category_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        $sponsor = $request->input('sponsor');

        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('vendor_images', $file_to_store);

            Vendor::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'sponsor' => $sponsor,
                'category_id' => $request->category_id,
                'image' => $file_to_store
            ]);
        }
        else
        {
            Vendor::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'sponsor' => $sponsor,
                'category_id' => $request->category_id,
            ]);
        }


        return redirect('admin/vendors')->withStatus(__('vendor created successfully'));

    }

    public function edit($id)
    {
        //
        $setting = Setting::find($id);

        if ($setting) {
            return view('Admin.settings.edit');
        } else {
            return view('Admin.settings.edit',compact('setting'));
        }
    }

    public function update(Request $request,$id)
    {
        //
        return view('Admin.settings.edit');
    }
}
