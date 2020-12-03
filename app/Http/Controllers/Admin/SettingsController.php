<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{


    function __construct()
    {
    
        $this->middleware('permission:setting-list', ['only' => ['edit','update']]);
        
    }

    public function edit($id)
    {
        //
        $setting = Setting::find($id);

        if ($setting) {
            return view('Admin.settings.edit',compact('setting'));
        } else {
            return redirect('admin/admins')->withStatus('no settings saved in database with this id');
        }
    }

    public function update(Request $request,$id)
    {
        //
        $rules = [
            'tax' => 'required|integer|min:0',
            'tax_on_product' => 'required|integer|min:0',
            'tax_value' => 'required|numeric|min:0',
            'delivery' => 'required|numeric|min:0',
            'cancellation' => 'required|integer|min:0',
            'splash' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request, $rules);


        $setting = Setting::find($id);

        if($setting) {

            if ($file = $request->file('splash')) {

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('splash', $file_to_store)) {
                    if ($setting->splash != null) {

                        unlink('splash/' . $setting->splash);
                    }
                }
                $setting->update(['tax' => $request->input('tax') , 'tax_value' => $request->input('tax_value') , 'tax_on_product' => $request->input('tax_on_product') , 'delivery' => $request->input('delivery'), 'cancellation' => $request->cancellation , 'splash' => $file_to_store]);
            } else {

                if ($request->has('checkedimage')) {
                    $setting->update(['tax' => $request->input('tax') , 'tax_value' => $request->input('tax_value') , 'tax_on_product' => $request->input('tax_on_product') , 'delivery' => $request->input('delivery'), 'cancellation' => $request->cancellation ,'splash' => $request->input('checkedimage')]);
                } else {

                    if ($setting->splash != null) {
                        unlink('splash/' . $setting->image);
                    }
                    $setting->update(['tax' => $request->input('tax') , 'tax_value' => $request->input('tax_value') , 'tax_on_product' => $request->input('tax_on_product') , 'delivery' => $request->input('delivery'), 'cancellation' => $request->cancellation , 'image' => null]);
                }
            }
            return redirect('/admin/settings/'.$id.'/edit')->withStatus('settings successfully updated.');
        }
        else
        {
            return redirect('/admin/settings/'.$id.'/edit')->withStatus('no id exist');
        }
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
