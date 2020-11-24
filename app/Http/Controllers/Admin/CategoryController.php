<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Photo;
use Illuminate\Http\Request;

class CategoryController extends Controller
{   


    function __construct()
    {
        $this->middleware('permission:show-mainCategory', ['only' => ['index']]);
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
        $categories = Category::orderBy('id', 'desc')->get();

        return view('Admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.categories.create');
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
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('name_ar');

        $eng_name = $request->input('name_en');

        $user = auth()->user();

        if($image = $request->file('image'))
        {
                $filename = $image->getClientOriginalName();
                $fileextension = $image->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                $image->move('category_images', $file_to_store);

            Category::create([

                'name_ar' => $arab_name,
                'name_en' => $eng_name,
                'image' => $file_to_store,
                'created_by' => $user->id
            ]);
        }
        else
        {
            Category::create([

                'name_ar' => $arab_name,
                'name_en' => $eng_name,
                'created_by' => $user->id
            ]);
        }


        return redirect('admin/categories')->withStatus(__('category created successfully'));
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
        $category = Category::findOrFail($id);

        if($category)
        {
            return view('Admin.categories.show', compact('category'));
        }
        else
        {
            return redirect('admin/categories')->withStatus('no category have this id');
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
        $category = Category::find($id);

        if($category)
        {
            return view('Admin.categories.create', compact('category'));
        }
        else
        {
            return redirect('admin/categories')->withStatus('no category have this id');
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
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request, $rules);

        $category = Category::find($id);

        $user = auth()->user();

        if($category) {

            if ($file = $request->file('image')) {

                $this->validate($request, $rules);

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('category_images', $file_to_store)) {
                    if ($category->image != null) {

                        unlink('category_images/' . $category->image);
                    }
                }
                $category->update(['name_ar' => $request->name_ar, 'name_en' => $request->name_en, 'image' => $file_to_store , 'updated_by' => $user->id]);
            } else {
                if ($request->has('checkedimage')) {
                    $category->update(['name_ar' => $request->name_ar, 'name_en' => $request->name_en, 'image' => $request->input('checkedimage') , 'updated_by' => $user->id]);
                } else {

                    if($category->image) {
                        unlink('category_images/' . $category->image);
                    }
                    $category->update(['name_ar' => $request->name_ar, 'name_en' => $request->name_en, 'image' => null , 'updated_by' => $user->id]);
                }

            }
            return redirect('/admin/categories')->withStatus('category successfully updated.');
        }
        else{
            return redirect('/admin/categories')->withStatus('there is no category found');
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
        $category = Category::find($id);

        if($category)
        {
            if($category->image != null) {
                unlink('category_images/' . $category->image);
            }
            $category->delete();
            return redirect('/admin/categories')->withStatus(__('category successfully deleted.'));
        }
        return redirect('/admin/categories')->withStatus(__('this id is not in our database'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new CategoryExport , 'categories.csv');
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

        Excel::import(new CategoryImport ,request()->file('file'));

        return back()->withStatus('Category Data imported successfully');
    }
}
