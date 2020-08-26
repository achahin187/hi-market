<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vendors = Vendor::orderBy('id', 'desc')->paginate(10);

        return view('Admin.vendors.index',compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.vendors.create');
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
            'category_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('vendor_images', $file_to_store);

            Vendor::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'category_id' => $request->category_id,
                'image' => $file_to_store
            ]);
        }
        else
        {
            Vendor::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'category_id' => $request->category_id,
            ]);
        }


        return redirect('admin/vendors')->withStatus(__('vendor created successfully'));

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
        $vendor = Vendor::findOrFail($id);

        if($vendor)
        {
            return view('Admin.vendors.show', compact('vendor'));
        }
        else
        {
            return redirect('admin/vendors')->withStatus('no vendor have this id');
        }
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
        $vendor = Vendor::findOrFail($id);

        if($vendor)
        {
            return view('Admin.vendors.create', compact('vendor'));
        }
        else
        {
            return redirect('admin/vendord')->withStatus('no vendor have this id');
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

        $rules = [
            'arab_name' => 'required|min:2|max:60',
            'eng_name' => 'required|min:2|max:60',
            'category_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];

        $this->validate($request, $rules);

        $vendor = Vendor::findOrFail($id);

        if($file = $request->file('image')) {

            $this->validate($request,$rules);

            $filename = $file->getClientOriginalName();
            $fileextension = $file->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.'.$fileextension;

            if($file->move('vendor_images', $file_to_store)) {
                if($vendor->image != null) {

                    unlink('vendor_images/'.$vendor->image);
                }
            }
            $vendor->update(['arab_name' => $request->arab_name , 'eng_name' => $request->eng_name ,'category_id' => $request->category_id , 'image' => $file_to_store]);
        }
        else {
            if($request->has('checkedimage')) {
                $vendor->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name , 'category_id' => $request->category_id , 'image' => $request->input('checkedimage')]);
            }
            else
            {
                unlink('vendor_images/'.$vendor->image);
                $vendor->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name , 'category_id' => $request->category_id , 'image' => null]);
            }
        }
        return redirect('/admin/vendors')->withStatus('vednor successfully updated.');
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
        $vendor = Vendor::findOrFail($id);

        if($vendor)
        {
            if($vendor->image != null) {
                unlink('vendor_images/' . $vendor->image);
            }
            $vendor->delete();
            return redirect('/admin/vendors')->withStatus(__('vendor successfully deleted.'));
        }
        return redirect('/admin/vendors')->withStatus(__('this id is not in our database'));
    }
}
