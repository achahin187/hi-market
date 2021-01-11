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
        
        $request->validate([

            'delivery'       => 'required|numeric',
            'reedem_point'   => 'required|numeric|min:0|max:100',
        
        ]);

       


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
                $setting->update([
                   
                    'reedem_point' => $request->reedem_point,
                 
                    'delivery' => $request->input('delivery'),
                   
                     ]);
            } else {

                if ($request->has('checkedimage')) {
                    $setting->update([
                        'reedem_point' => $request->reedem_point,
                 
                        'delivery' => $request->input('delivery'),
                        ]);
                } else {

                    $setting->update([
                    'reedem_point' => $request->reedem_point,
                 
                    'delivery' => $request->input('delivery'),
                     ]);
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
