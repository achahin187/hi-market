<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
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
        $branches = Branch::orderBy('id', 'desc')->get();
        return view('Admin.branches.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($supermarket_id = null)
    {
        //
        if($supermarket_id != null) {
            return view('Admin.branches.create',compact('supermarket_id'));
        }
        else {
            return view('Admin.branches.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$supermarket_id = null)
    {
        //

        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'status' => ['required','string'],
            'supermarket_id' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('name_ar');

        $eng_name = $request->input('name_en');

        $status = $request->input('status');

        $supermarket = $request->input('supermarket_id');


        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('images', $file_to_store);

            $branch = Branch::create([

                'name_ar' => $arab_name,
                'name_en' => $eng_name,
                'status' => $status,
                'supermarket_id' => $supermarket,
                'image' => $file_to_store
            ]);
        }
        else
        {

           $branch = Branch::create([

                'name_ar' => $arab_name,
                'name_en' => $eng_name,
                'status' => $status,
                'supermarket_id' => $supermarket,
            ]);
        }

        if($branch)
        {
            if($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus(__('supermarket branch created successfully'));
            }
            else
            {
                return redirect('admin/branches')->withStatus(__('branch created successfully'));
            }
        }
        else
        {

            if ($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus(__('supermarket branch not created'));
            }
            else
            {
                return redirect('admin/branches')->withStatus(__('something wrong happened in branch creation '));
            }
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
    public function edit($id,$supermarket_id = null)
    {
        //
        $branch = Branch::find($id);

        if($branch)
        {
            if($supermarket_id != null)
            {
                return view('Admin.branches.create', compact('branch','supermarket_id'));
            }
            else {
                return view('Admin.branches.create', compact('branch'));
            }
        }
        else
        {
            if($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus('no branch have this id');
            }
            else {
                return redirect('admin/branches')->withStatus('no branch have this id');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$supermarket_id = null)
    {
        //
        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'supermarket_id' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request, $rules);

        $branch = Branch::find($id);

        if($branch) {

            if ($file = $request->file('image')) {

                $this->validate($request, $rules);

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('images', $file_to_store)) {
                    if ($branch->image != null) {

                        unlink('images/' . $branch->image);
                    }
                }
                $branch->update(['name_ar' => $request->name_ar, 'name_en' => $request->name_en,'supermarket_id' => $request->supermarket_id,'image' => $file_to_store]);
            } else {

                if ($request->has('checkedimage')) {
                    $branch->update(['name_ar' => $request->name_ar, 'name_en' => $request->name_en,'supermarket_id' => $request->supermarket_id,'image' => $request->input('checkedimage')]);
                } else {
                    if ($branch->image != null) {
                        unlink('images/' . $branch->image);
                    }
                    $branch->update(['name_ar' => $request->name_ar, 'name_en' => $request->name_en,'supermarket_id' => $request->supermarket_id,'image' => null]);
                }
            }
            if($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus('supermarket branch updated successfully');
            }
            else {
                return redirect('admin/branches')->withStatus('branch updated successfully');
            }
        }
        else
        {
            if($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus('no branch have this id');
            }
            else {
                return redirect('admin/branches')->withStatus('no branch have this id');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$supermarket_id = null)
    {
        //
        $branch = Branch::find($id);

        if($branch)
        {

            if($branch->image != null) {
                unlink('images/' . $branch->image);
            }

            $branch->delete();

            if($supermarket_id != null)
            {
                return redirect()->back()->withStatus(__('supermarket branch deleted successfully'));
            }
            else {
                return redirect()->back()->withStatus(__('branch deleted successfully'));
            }
        }
        else {
            if ($supermarket_id != null) {
                return redirect()->back()->withStatus(__('no branch with this id in the supermarket'));
            }
            else {
                return redirect()->back()->withStatus(__('no branch with this id'));
            }
        }
    }

    public function status(Request $request,$id)
    {

        $branch = Branch::find($id);

        if($branch)
        {
            if($branch->status == 'active') {
                $branch->update(['status' => 'inactive']);
            }
            else
            {
                $branch->update(['status' => 'active']);
            }
            return redirect()->back()->withStatus(__('branch status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }

    public function supermarketbranches($supermarket_id)
    {
        //
        $branches = Branch::where('supermarket_id',$supermarket_id)->orderBy('id', 'desc')->get();
        return view('Admin.branches.index',compact('branches','supermarket_id'));
    }
}
