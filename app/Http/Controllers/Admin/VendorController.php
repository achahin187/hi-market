<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vendor;
use App\Models\Supermarket;

class VendorController extends Controller
{



    function __construct()
    {
        $this->middleware('permission:vendor-list', ['only' => ['index']]);
        $this->middleware('permission:vendor-create', ['only' => ['create','store']]);
        $this->middleware('permission:vendor-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:vendor-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vendors = Vendor::orderBy('id', 'desc')->get();

        return view('Admin.vendors.index',compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
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
  
        $request->validate([
        'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
        'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
        'sponsor' => 'required|integer|min:0',
        'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);


        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('vendor_images', $file_to_store);

            Vendor::create([

                'arab_name' => $request->input('arab_name'),
                'eng_name' => $request->input('eng_name'),
                'sponsor' => $request->input('sponsor'),
                'image' => $file_to_store
            ]);
        }
        else
        {
            Vendor::create([

                'arab_name' => $request->input('arab_name'),
                'eng_name' => $request->input('eng_name'),
                'sponsor' => $request->input('sponsor'),
              
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
        $vendor = Vendor::find($id);

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
        $vendor = Vendor::find($id);

        if($vendor)
        {
            return view('Admin.vendors.create', compact('vendor'));
        }
        else
        {
            return redirect('admin/vendors')->withStatus('no vendor have this id');
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
            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'sponsor' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];


        $this->validate($request, $rules);

        $vendor = Vendor::find($id);

        if($vendor) {

            if ($file = $request->file('image')) {

                $this->validate($request, $rules);

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('vendor_images', $file_to_store)) {
                    if ($vendor->image != null) {

                        unlink('vendor_images/' . $vendor->image);
                    }
                }
                $vendor->update([
                     'arab_name' => $request->arab_name,
                     'eng_name' => $request->eng_name,
                     'sponsor' => $request->sponsor ,
                     'image' => $file_to_store
                 ]);
            } else {

                if ($request->has('checkedimage')) {
                    $vendor->update([
                      'arab_name' => $request->arab_name,
                      'eng_name' => $request->eng_name,
                      'sponsor' => $request->sponsor ,
                      'image' => $request->input('checkedimage')
                  ]);
                } else {

                    if ($vendor->image != null) {
                        unlink('vendor_images/' . $vendor->image);
                    }
                    $vendor->update([
                       'arab_name' => $request->arab_name,
                       'eng_name' => $request->eng_name,
                       'sponsor' => $request->sponsor , 
                       'image' => null
                   ]);
                }
            }
            return redirect('/admin/vendors')->withStatus('vendor successfully updated.');
        }
        else
        {
            return redirect('/admin/vendors')->withStatus('no vendor exist');
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
        $vendor = Vendor::find($id);

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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new VendorExport , 'vendors.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'file' => 'mimes:csv|max:277'
        ];
        Excel::import(new VendorImport ,request()->file('file'));

        return back();
    }
}
