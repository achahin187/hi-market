<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Imports\ProductImport;
use App\Exports\ProductExport;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
/*
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }*/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($flag)
    {
        //
        if($flag == 1)
        {
            $offers = Product::where('flag',$flag)->orderBy('id', 'desc')->get();
            return view('Admin.product_offers.index',compact('offers','flag'));
        }
        $products = Product::where('flag',$flag)->orderBy('id', 'desc')->get();
        return view('Admin.products.index',compact('products','flag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($flag,$supermarket_id = null)
    {
        //
        if($supermarket_id != null) {
            return view('Admin.products.create', compact('flag','supermarket_id'));
        }
        else
        {
            return view('Admin.products.create', compact('flag'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$flag,$supermarket_id = null)
    {


        $user = auth()->user();

        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'barcode' => ['required','numeric','digits_between:10,16',Rule::unique((new Product)->getTable())->ignore(auth()->id())],
            'arab_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'price' => 'nullable|numeric|min:0',
            'points' => 'nullable|integer|min:0',
            'vendor_id' => 'required|integer|min:0',
            'category_id' => 'required|integer|min:0',
            'supermarket_id' => 'required|integer|min:0',
            'branch_id' => 'required|integer|min:0',
            'subcategory_id' => 'required|integer|min:0',
            'start_date' => 'required|after:today|date',
            'end_date' => 'required|after:start_date|date',
            'exp_date' => 'required|after:today|date',
            'measure_id' => 'required|integer|min:0',
            'size_id' => 'required|integer|min:0',
            'priority' => 'required|integer|min:0',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:277'
        ];

        $this->validate($request, $rules);

        if($flag == 1) {
            $priority = null;
        }
        else
        {
            $priority = $request->input('priority');
        }


        $arab_name = $request->input('name_ar');

        $eng_name = $request->input('name_en');

        $arab_description = $request->input('arab_description');

        $eng_description = $request->input('eng_description');

        $arab_spec = $request->input('arab_spec');

        $eng_spec = $request->input('eng_spec');

        $price = $request->input('price');

        $points = $request->input('points');

        $quantity = $request->input('quantity');

        $category = $request->input('category_id');

        $vendor = $request->input('vendor_id');

        if($supermarket_id != null)
        {
            $supermarket = $supermarket_id;
        }
        else
        {
            $supermarket = $request->input('supermarket_id');
        }

        $subcategory = $request->input('subcategory_id');

        $barcode = $request->input('barcode');

        $start_date = $request->input('start_date');

        $end_date = $request->input('end_date');

        $exp_date = $request->input('exp_date');

        $measuring_unit = $request->input('measure_id');

        $size = $request->input('size_id');


        if ($price == null) {
            $price = 0;
        }

        if($points == null)
        {
            $points == 0;
        }


        if ($request->hasFile('images')) {

            $image_names = [];
            $files = $request->file('images');

            foreach ($files as $image) {
                $filename = $image->getClientOriginalName();
                $fileextension = $image->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                $image->move('product_images', $file_to_store);

                $image_names[] = $file_to_store;
            }

            $images = implode(',', $image_names);
        }
        else
        {
            $images = '';
        }



        $product = Product::create([
            'name_ar' => $arab_name,
            'name_en' => $eng_name,
            'price' => $price,
            'points' => $points,
            'category_id' => $category,
            'vendor_id' => $vendor,
            'supermarket_id' => $supermarket,
            'branch_id' => $request->branch_id,
            'subcategory_id' => $subcategory,
            'images' => $images,
            'barcode' => $barcode,
            'arab_description' => $arab_description,
            'eng_description' => $eng_description,
            'arab_spec' => $arab_spec,
            'eng_spec' => $eng_spec,
            'flag' => $flag,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'exp_date' => $exp_date,
            'priority' => $priority,
            'quantity' => $quantity,
            'measure_id' => $measuring_unit,
            'size_id' => $size,
            'created_by' => $user->id
        ]);


        if($product && $supermarket_id == null)
        {
            if($flag == 1)
            {
                return redirect('admin/products/1')->withStatus(__('product offer created successfully'));
            }
            return redirect('admin/products/0')->withStatus(__('product created successfully'));
        }
        elseif ($product && $supermarket_id != null)
        {
            return redirect('admin/supermarkets/products/'.$supermarket_id.'/'.$flag)->withStatus(__('product created successfully'));
        }
        else
        {
            if($flag == 1)
            {
                return redirect('admin/products/1')->withStatus(__('something wrong happened, try again'));
            }
            return redirect('admin/products/0')->withStatus(__('something wrong happened, try again'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$flag)
    {
        //

        $columns = $request->columns;

        if($flag == 1)
        {
            $offers = Product::where('flag',$flag)->orderBy('id', 'desc')->get();
            return view('Admin.product_offers.index',compact('offers','columns','flag'));
        }
        $products = Product::where('flag',$flag)->orderBy('id', 'desc')->get();
        return view('Admin.products.index',compact('products','columns','flag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$flag)
    {
        //
        $product = Product::find($id);

        if($product)
        {
            $productimages = explode(',',$product->images);
            return view('Admin.products.create', compact('product','productimages','flag'));
        }
        else
        {
            if($flag == 1)
            {
                return redirect('admin/products/1')->withStatus('no product have this id');
            }
            return redirect('admin/products/0')->withStatus('no product have this id');
        }
    }

    public function clone($id,$flag)
    {
        //
        $product = Product::find($id);

        if($product)
        {
            $clone = true;
            $productimages = explode(',',$product->images);
            return view('Admin.products.create', compact('product','productimages','flag','clone'));
        }
        else
        {
            return redirect('admin/products/0')->withStatus('no product have this id');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id,$flag)
    {
        //

        $product = Product::find($id);

        $user = auth()->user();

        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'barcode' => ['required','numeric','digits_between:10,16',Rule::unique((new Product)->getTable())->ignore(auth()->id())],
            'arab_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'price' => 'required|numeric|min:0',
            'points' => 'nullable|integer|min:0',
            'vendor_id' => 'required|integer|min:0',
            'category_id' => 'required|integer|min:0',
            'supermarket_id' => 'required|integer|min:0',
            'branch_id' => 'required|integer|min:0',
            'subcategory_id' => 'required|integer|min:0',
            'start_date' => 'required|after:today|date',
            'end_date' => 'required|after:start_date|date',
            'exp_date' => 'required|after:today|date',
            'measure_id' => 'required|integer|min:0',
            'size_id' => 'required|integer|min:0',
            'priority' => 'required|integer|min:0',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:277'
        ];

        $this->validate($request, $rules);

        if($product) {

            if($flag == 1) {

                $priority = null;
            }
            else {
                $priority = $request->input('priority');
            }

            $arab_name = $request->input('name_ar');

            $eng_name = $request->input('name_en');

            $arab_description = $request->input('arab_description');

            $eng_description = $request->input('eng_description');

            $arab_spec = $request->input('arab_spec');

            $eng_spec = $request->input('eng_spec');

            $price = $request->input('price');

            $points = $request->input('points');

            $category = $request->input('category_id');

            $vendor = $request->input('vendor_id');

            $supermarket = $request->input('supermarket_id');

            $subcategory = $request->input('subcategory_id');

            $barcode = $request->input('barcode');

            $start_date = $request->input('start_date');

            $end_date = $request->input('end_date');

            $exp_date = $request->input('exp_date');

            $priority = $request->input('priority');

            $measuring_unit = $request->input('measuring_unit');

            $size = $request->input('size');


            if ($price == null) {
                $price = 0;
            }

            if($points == null)
            {
                $points == 0;
            }


            if ($request->hasFile('images')) {

                $image_names = $request->file('images');

                foreach ($image_names as $image) {

                    $filename = $image->getClientOriginalName();
                    $fileextension = $image->getClientOriginalExtension();
                    $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                    $image->move('product_images', $file_to_store);

                    $file_names[] = $file_to_store;
                }

                if ($request->has('image')) {

                    $productimages = explode(',', $product->images);

                    $checkedimages = $request->input('image');

                    $deletedimages = array_diff($productimages, $checkedimages);


                    if (!empty($deletedimages)) {
                        foreach ($deletedimages as $deletedimage) {
                            if (($key = array_search($deletedimage, $productimages)) !== false) {
                                unset($productimages[$key]);
                                unlink('product_images/' . $deletedimage);
                            }
                        }
                    }

                    $productimages = array_merge($productimages, $file_names);
                }
                else
                {
                    $productimages = $file_names;
                }

                $images = implode(',', $productimages);

                $product->update([
                    'arab_name' => $arab_name,
                    'eng_name' => $eng_name,
                    'price' => $price,
                    'points' => $points,
                    'category_id' => $category,
                    'vendor_id' => $vendor,
                    'supermarket_id' => $supermarket,
                    'branch_id' => $request->branch_id,
                    'subcategory_id' => $subcategory,
                    'images' => $images,
                    'barcode' => $barcode,
                    'arab_description' => $arab_description,
                    'eng_description' => $eng_description,
                    'arab_spec' => $arab_spec,
                    'eng_spec' => $eng_spec,
                    'flag' => $flag,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'exp_date' => $exp_date,
                    'priority' => $priority,
                    'measuring_unit' => $measuring_unit,
                    'size' => $size,
                    'updated_by' => $user->id
                ]);

                if($flag == 1)
                {
                    return redirect('admin/products/1')->withStatus(__('offer updated successfully'));
                }
                else
                {
                    return redirect('admin/products/0')->withStatus(__('product updated successfully'));
                }

            } else {

                if ($request->has('image')) {

                    $productimages = explode(',', $product->images);

                    $checkedimages = $request->input('image');

                    $deletedimages = array_diff($productimages, $checkedimages);


                    if (!empty($deletedimages)) {
                        foreach ($deletedimages as $deletedimage) {
                            if (($key = array_search($deletedimage, $productimages)) !== false) {
                                unset($productimages[$key]);
                                unlink('product_images/' . $deletedimage);
                            }
                        }
                    }

                    $images = implode(',', $productimages);

                    $product->update([
                        'arab_name' => $arab_name,
                        'eng_name' => $eng_name,
                        'price' => $price,
                        'points' => $points,
                        'category_id' => $category,
                        'vendor_id' => $vendor,
                        'supermarket_id' => $supermarket,
                        'branch_id' => $request->branch_id,
                        'subcategory_id' => $subcategory,
                        'images' => $images,
                        'barcode' => $barcode,
                        'arab_description' => $arab_description,
                        'eng_description' => $eng_description,
                        'arab_spec' => $arab_spec,
                        'eng_spec' => $eng_spec,
                        'flag' => $flag,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'exp_date' => $exp_date,
                        'priority' => $priority,
                        'measuring_unit' => $measuring_unit,
                        'size' => $size,
                        'updated_by' => $user->id
                    ]);

                    if($flag == 1)
                    {
                        return redirect('admin/product_offers')->withStatus(__('offer updated successfully'));
                    }
                    else
                    {
                        return redirect('admin/products/0')->withStatus(__('product updated successfully'));
                    }

                } else {

                    $product->update([
                        'arab_name' => $arab_name,
                        'eng_name' => $eng_name,
                        'price' => $price,
                        'points' => $points,
                        'category_id' => $category,
                        'vendor_id' => $vendor,
                        'supermarket_id' => $supermarket,
                        'branch_id' => $request->branch_id,
                        'subcategory_id' => $subcategory,
                        'barcode' => $barcode,
                        'arab_description' => $arab_description,
                        'eng_description' => $eng_description,
                        'arab_spec' => $arab_spec,
                        'eng_spec' => $eng_spec,
                        'flag' => $flag,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'exp_date' => $exp_date,
                        'priority' => $priority,
                        'measuring_unit' => $measuring_unit,
                        'size' => $size,
                        'updated_by' => $user->id,
                        'images' => null
                    ]);
                    if($flag == 1)
                    {
                        return redirect('admin/product_offers')->withStatus(__('offer updated successfully'));
                    }
                    else
                    {
                        return redirect('admin/products/0')->withStatus(__('product updated successfully'));
                    }
                }
            }
        }

        else
        {
            if($flag == 1)
            {
                return redirect('admin/products/1')->withStatus(__('no offer exists'));
            }
            else
            {
                return redirect('admin/products/0')->withStatus(__('no product exists'));
            }
        }

    }

    public function supermarketproducts($supermarket_id,$flag)
    {
        //
        $products = Product::where('supermarket_id',$supermarket_id)->orderBy('id', 'desc')->get();
        return view('Admin.products.index',compact('products','flag','supermarket_id'));
    }

    public function branchproducts($branch_id,$flag)
    {
        //
        $products = Product::where('branch_id',$branch_id)->orderBy('id', 'desc')->get();
        return view('Admin.products.index',compact('products','flag'));
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

        $product = Product::find($id);

        $images = $product->images;

        if($images) {
            $productimages = explode(',', $images);

            foreach ($productimages as $image)
            {
                unlink('product_images/'.$image);
            }
        }

        $product->delete();

        if($product->flag == 1)
        {
            return redirect('admin/products/1')->withStatus(__('offer deleted successfully'));
        }
        else
        {
            return redirect('admin/products/0')->withStatus(__('product deleted successfully'));
        }
    }


    public function status(Request $request,$id,$flag)
    {

        $product = Product::find($id);

        if($product)
        {
            if($product->status == 'active') {

                $product->update(['status' => 'inactive']);
            }
            else
            {
                $product->update(['status' => 'active']);
            }
            return redirect()->back()->withStatus(__('product status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new ProductsExport , 'admins.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'images' => 'image|mimes:csv|max:277'
        ];
        Excel::import(new ProductImport ,request()->file('file'));

        return back();
    }
}
