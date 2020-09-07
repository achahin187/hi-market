<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{


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
            'splash' => 'image|mimes:jpeg,png,jpg|max:277'
        ];

        $this->validate($request, $rules);

        $setting = Setting::find($id);

        if($setting) {

            $setting->update(['tax' => $request->input('tax') , 'tax_value' => $request->input('tax_value') , 'tax_on_product' => $request->input('tax_on_product') , 'delivery' => $request->input('delivery'), 'cancellation' => $request->cancellation]);
            return redirect('/admin/settings/'.$id.'/edit')->withStatus('settings successfully updated.');
        }
        else
        {
            return redirect('/admin/settings/'.$id.'/edit')->withStatus('no id exist');
        }
    }
}
