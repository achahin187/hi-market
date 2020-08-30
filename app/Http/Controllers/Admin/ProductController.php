<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::where('flag',0)->orderBy('id', 'desc')->paginate(10);
        return view('Admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($flag)
    {
        //
        return view('Admin.products.create',compact('flag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$flag)
    {
        if($flag == 1) {

            $rules = [
                'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'arab_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                'eng_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                'price' => '',
                'vendor_id' => 'required|integer|min:0',
                'category_id' => 'required|integer|min:0',
                'barcode' => 'required|string|regex:/^[0-9]+$/|digits_between:10,16',
                'status' => 'required|string',
                'start_date' => 'required|date_format:Y-m-d H:i:s',
                'end_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
            ];

            $this->validate($request, $rules);


            $arab_name = $request->input('arab_name');

            $eng_name = $request->input('eng_name');


            $arab_description = $request->input('arab_description');

            $eng_description = $request->input('eng_description');


            $price = $request->input('price');

            if ($price == null) {
                $price = 0;
            }

            $category = $request->input('category_id');

            $vendor = $request->input('vendor_id');

            $barcode = $request->input('barcode');

            $status = $request->input('status');

            $start_date = $request->input('start_date');

            $end_date = $request->input('end_date');
        }
        else
        {
            $rules = [
                'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'arab_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                'eng_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                'price' => '',
                'vendor_id' => 'required|integer',
                'category_id' => 'required|integer',
                'barcode' => 'required|string|regex:/^[0-9]+$/|digits_between:10,16',
            ];

            $this->validate($request, $rules);


            $arab_name = $request->input('arab_name');

            $eng_name = $request->input('eng_name');


            $arab_description = $request->input('arab_description');

            $eng_description = $request->input('eng_description');


            $price = $request->input('price');

            if ($price == null) {
                $price = 0;
            }

            $category = $request->input('category_id');

            $vendor = $request->input('vendor_id');

            $barcode = $request->input('barcode');

            $status = null;

            $start_date = null;

            $end_date = null;

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
            'arab_name' => $arab_name,
            'eng_name' => $eng_name,
            'price' => $price,
            'category_id' => $category,
            'vendor_id' => $vendor,
            'images' => $images,
            'barcode' => $barcode,
            'arab_description' => $arab_description,
            'eng_description' => $eng_description,
            'flag' => $flag,
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

        if($product)
        {
            return redirect('admin/products')->withStatus(__('product created successfully'));
        }
        else
        {
            return redirect('admin/products')->withStatus(__('something wrong happened, try again'));
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
        $product = Product::findOrFail($id);

        if($product)
        {
            return view('Admin.products.show', compact('product'));
        }
        else
        {
            return redirect('admin/products')->withStatus('no product have this id');
        }
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
        $product = Product::findOrFail($id);

        if($product)
        {
            $productimages = explode(',',$product->images);
            return view('Admin.products.create', compact('product','productimages','flag'));
        }
        else
        {
            return redirect('admin/products')->withStatus('no product have this id');
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

        $product = Product::findOrFail($id);

        if($product) {

            if ($flag == 1) {

                $rules = [
                    'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                    'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                    'arab_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                    'eng_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                    'price' => '',
                    'vendor_id' => 'required|integer',
                    'category_id' => 'required|integer',
                    'barcode' => 'required|string|regex:/^[0-9]+$/|digits_between:10,16',
                    'status' => 'required|string',
                ];

                $this->validate($request, $rules);


                $status = $request->input('status');

                $start_date = $request->input('start_date');

                $end_date = $request->input('end_date');

            }
            else {
                $rules = [
                    'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                    'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                    'arab_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                    'eng_description' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
                    'price' => '',
                    'vendor_id' => 'required|integer',
                    'category_id' => 'required|integer',
                    'barcode' => 'required|string|regex:/^[0-9]+$/|digits_between:10,16',
                ];

                $this->validate($request, $rules);


                $status = null;

                $start_date = null;

                $end_date = null;

            }

            $arab_name = $request->input('arab_name');

            $eng_name = $request->input('eng_name');


            $arab_description = $request->input('arab_description');

            $eng_description = $request->input('eng_description');


            $price = $request->input('price');

            if ($price == null) {
                $price = 0;
            }

            $category = $request->input('category_id');

            $vendor = $request->input('vendor_id');

            $barcode = $request->input('barcode');


            if ($request->hasFile('images')) {

                $product = Product::findOrFail($id);

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
                } else {
                    $productimages = $file_names;
                }

                $images = implode(',', $productimages);

                $product->update([
                    'arab_name' => $arab_name,
                    'eng_name' => $eng_name,
                    'price' => $price,
                    'category_id' => $category,
                    'vendor_id' => $vendor,
                    'barcode' => $barcode,
                    'arab_description' => $arab_description,
                    'eng_description' => $eng_description,
                    'flag' => $flag,
                    'status' => $status,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'images' => $images,
                ]);

                if($flag == 1)
                {
                    return redirect('admin/offers')->withStatus(__('offer updated successfully'));
                }
                else
                {
                    return redirect('admin/products')->withStatus(__('product updated successfully'));
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
                        'category_id' => $category,
                        'vendor_id' => $vendor,
                        'barcode' => $barcode,
                        'arab_description' => $arab_description,
                        'eng_description' => $eng_description,
                        'flag' => $flag,
                        'status' => $status,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'images' => $images,
                    ]);

                    if($flag == 1)
                    {
                        return redirect('admin/offers')->withStatus(__('offer updated successfully'));
                    }
                    else
                    {
                        return redirect('admin/products')->withStatus(__('product updated successfully'));
                    }

                } else {

                    $product->update([
                        'arab_name' => $arab_name,
                        'eng_name' => $eng_name,
                        'price' => $price,
                        'category_id' => $category,
                        'vendor_id' => $vendor,
                        'barcode' => $barcode,
                        'arab_description' => $arab_description,
                        'eng_description' => $eng_description,
                        'flag' => $flag,
                        'status' => $status,
                        'start_date' => $start_date,
                        'end_date' => $end_date
                    ]);
                    if($flag == 1)
                    {
                        return redirect('admin/offers')->withStatus(__('offer updated successfully'));
                    }
                    else
                    {
                        return redirect('admin/products')->withStatus(__('product updated successfully'));
                    }
                }
            }
        }

        else
        {
            if($flag == 1)
            {
                return redirect('admin/offers')->withStatus(__('no offer exists'));
            }
            else
            {
                return redirect('admin/products')->withStatus(__('no product exists'));
            }
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

        $product = Product::findOrFail($id);

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
            return redirect('admin/offers')->withStatus(__('offer deleted successfully'));
        }
        else
        {
            return redirect('admin/products')->withStatus(__('product deleted successfully'));
        }
    }
}
