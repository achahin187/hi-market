<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:subCategory-list', ['only' => ['index']]);
        $this->middleware('permission:subCategory-create', ['only' => ['create','store']]);
        $this->middleware('permission:subCategory-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subCategory-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $subcategories = SubCategory::orderBy('id', 'desc')->get();

        return view('Admin.subcategories.index',compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.subcategories.create');
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
            'category_id' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        $category = $request->input('category_id');

        $user = auth()->user();

        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('category_images', $file_to_store);

            SubCategory::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'image' => $file_to_store,
                'category_id' => $category,
                'created_by' => $user->id
            ]);
        }
        else
        {
            SubCategory::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'category_id' => $category,
                'created_by' => $user->id
            ]);
        }


        return redirect('admin/subcategories')->withStatus(__('subcategory created successfully'));
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
        $subcategory = SubCategory::find($id);

        if($subcategory)
        {
            return view('Admin.subcategories.create', compact('subcategory'));
        }
        else
        {
            return redirect('admin/subcategories')->withStatus('no category have this id');
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
            'category_id' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request, $rules);

        $subcategory = SubCategory::find($id);

        $user = auth()->user();

        if($subcategory) {

            if ($file = $request->file('image')) {

                $this->validate($request, $rules);

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('subcategory_images', $file_to_store)) {
                    if ($subcategory->image != null) {

                        unlink('subcategory_images/' . $subcategory->image);
                    }
                }
                $subcategory->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name, 'image' => $file_to_store , 'updated_by' => $user->id]);
            } else {
                if ($request->has('checkedimage')) {
                    $subcategory->update([

                        'arab_name' => $request->arab_name,
                        'eng_name' => $request->eng_name,
                        'image' => $request->input('checkedimage'),
                        'updated_by' => $user->id,
                        'category_id' => $request->input('category_id')
                    ]);
                } else {

                    if($subcategory->image) {
                        unlink('subcategory_images/' . $subcategory->image);
                    }
                    $subcategory->update([

                        'arab_name' => $request->arab_name,
                        'eng_name' => $request->eng_name,
                        'image' => null ,
                        'updated_by' => $user->id,
                        'category_id' => $request->input('category_id')
                    ]);
                }

            }
            return redirect('/admin/subcategories')->withStatus('subcategory successfully updated.');
        }
        else{
            return redirect('/admin/subcategories')->withStatus('there is no subcategory found');
        }
    }

    public function destroy($id)
    {
        //
        $subcategory = SubCategory::find($id);

        if($subcategory)
        {
            if($subcategory->image != null) {
                unlink('subcategory_images/' . $subcategory->image);
            }
            $subcategory->delete();
            return redirect('/admin/subcategories')->withStatus(__('subcategory successfully deleted.'));
        }
        return redirect('/admin/subcategories')->withStatus(__('this id is not in our database'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new SubcategoryExport , 'subcategories.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'file' => 'mimes:csv|max:277'
        ];

        $this->validate($request,$rules);

        Excel::import(new SubcategoryImport ,request()->file('file'));

        return back()->withStatus('SubCategory Data imported successfully');
    }
}
