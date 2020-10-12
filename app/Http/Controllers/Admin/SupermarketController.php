<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supermarket;
use Illuminate\Http\Request;

class SupermarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $supermarkets = Supermarket::orderBy('id', 'desc')->get();
        return view('Admin.supermarkets.index',compact('supermarkets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.supermarkets.create');
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
            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'status' => ['required','string'],
            'commission' => ['required','min:0','numeric'],
            'priority' => ['required','min:0','integer'],
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        $status = $request->input('status');

        $commission = $request->input('commission');

        $priority = $request->input('priority');

        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('supermarket_images', $file_to_store);

            Supermarket::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'status' => $status,
                'commission' => $commission,
                'priority' => $priority,
                'image' => $file_to_store
            ]);
        }
        else
        {
            Supermarket::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'status' => $status,
                'commission' => $commission,
                'priority' => $priority,
            ]);
        }


        return redirect('admin/supermarkets')->withStatus(__('supermarket created successfully'));
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
        $supermarket = Supermarket::find($id);

        if($supermarket)
        {
            return view('Admin.supermarkets.create', compact('supermarket'));
        }
        else
        {
            return redirect('admin/supermarkets')->withStatus('no supermarket have this id');
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
            'commission' => ['required','min:0','numeric'],
            'priority' => ['required','min:0','integer'],
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request, $rules);

        $supermarket = Supermarket::find($id);

        if($supermarket) {

            if ($file = $request->file('image')) {

                $this->validate($request, $rules);

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('supermarket_images', $file_to_store)) {
                    if ($supermarket->image != null) {

                        unlink('supermarket_images/' . $supermarket->image);
                    }
                }
                $supermarket->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name, 'status' => $request->status , 'commission' => $request->commission , 'priority' => $request->priority ,'image' => $file_to_store]);
            } else {

                if ($request->has('checkedimage')) {
                    $supermarket->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name,'commission' => $request->commission ,'image' => $request->input('checkedimage')]);
                } else {
                    if ($supermarket->image != null) {
                        unlink('supermarket_images/' . $supermarket->image);
                    }
                    $supermarket->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name,'commission' => $request->commission , 'image' => null]);
                }
            }
            return redirect('/admin/supermarkets')->withStatus('supermarket successfully updated.');
        }
        else
        {
            return redirect('/admin/supermarkets')->withStatus('no supermarket exist');
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
        $supermarket = Supermarket::find($id);

        if($supermarket)
        {
            $supermarket->delete();
            return redirect('/admin/supermarkets')->withStatus(__('supermarket successfully deleted.'));
        }
        return redirect('/admin/supermarkets')->withStatus(__('this id is not in our database'));
    }

    public function status(Request $request,$id)
    {

        $supermarket = Supermarket::find($id);

        if($supermarket)
        {
            if($supermarket->status == 'active') {
                $supermarket->update(['status' => 'inactive']);
            }
            else
            {
                $supermarket->update(['status' => 'active']);
            }
            return redirect('/admin/supermarkets')->withStatus(__('supermarket status successfully updated.'));
        }
        return redirect('/admin/supermarkets')->withStatus(__('this id is not in our database'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new SupermarketExport , 'supermarkets.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'file' => 'image|mimes:csv|max:277'
        ];
        Excel::import(new SupermarketImport ,request()->file('file'));

        return back();
    }
}
