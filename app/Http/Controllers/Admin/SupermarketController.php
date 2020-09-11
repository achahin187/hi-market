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
        $supermarkets = Supermarket::orderBy('id', 'desc')->paginate(10);
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
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');;

        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('supermarket_images', $file_to_store);

            Supermarket::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'image' => $file_to_store
            ]);
        }
        else
        {
            Supermarket::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
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
                $supermarket->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name,'image' => $file_to_store]);
            } else {

                if ($request->has('checkedimage')) {
                    $supermarket->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name, 'category_id' => $request->category_id, 'sponsor' => $request->sponsor ,'image' => $request->input('checkedimage')]);
                } else {
                    unlink('supermarket_images/' . $supermarket->image);
                    $supermarket->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name,'image' => null]);
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
}
