<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Photo;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::orderBy('id', 'desc')->paginate(10);

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
            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request,$rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        if($image = $request->file('image'))
        {
                $filename = $image->getClientOriginalName();
                $fileextension = $image->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                $image->move('category_images', $file_to_store);

            Category::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'image' => $file_to_store
            ]);
        }
        else
        {
            Category::create([

                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
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
            'arab_name' => 'required|min:2|max:100',
            'eng_name' => 'required|min:2|max:100',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];

        $this->validate($request, $rules);

        $category = Category::find($id);

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
                $category->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name, 'image' => $file_to_store]);
            } else {
                if ($request->has('checkedimage')) {
                    $category->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name, 'image' => $request->input('checkedimage')]);
                } else {
                    unlink('category_images/' . $category->image);
                    $category->update(['arab_name' => $request->arab_name, 'eng_name' => $request->eng_name, 'image' => null]);
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
}
