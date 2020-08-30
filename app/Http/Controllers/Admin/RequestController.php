<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('Admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //not_regex:/^[`~<>;':"/[\]|{}=_+]*$/|

        $rules = [
            'arab_name' => 'required|min:2|max:60',
            'eng_name' => 'required|min:2|max:60',
            'description' => '',
            'vendor_id' => 'required|integer',
            'category_id' => 'required|integer',
            'barcode' => 'required|string|regex:/^[0-9]+$/|digits_between:10,16',
        ];

        $this->validate($request, $rules);


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

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');


        $price = $request->input('price');

        if($price == null)
        {
            $price = 0;
        }

        $category = $request->input('category_id');

        $vendor = $request->input('vendor_id');

        $barcode = $request->input('barcode');

        $description = $request->input('description');

        $product = Product::create([
            'arab_name' => $arab_name,
            'eng_name' => $eng_name,
            'price' => $price,
            'category_id' => $category,
            'vendor_id' => $vendor,
            'images' => $images,
            'barcode' => $barcode,
            'description' => $description
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
    public function edit($id)
    {
        //
        $product = Product::findOrFail($id);

        if($product)
        {
            $productimages = explode(',',$product->images);
            return view('Admin.products.create', compact('product','productimages'));
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
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'arab_name' => 'required|min:2|max:60',
            'eng_name' => 'required|min:2|max:60',
            'description' => '',
            'vendor_id' => 'required|integer',
            'category_id' => 'required|integer',
            'barcode' => 'required|string|regex:/^[0-9]+$/|digits_between:10,16',
        ];

        $this->validate($request,$rules);


        if($request->hasFile('images'))
        {

            $product = Product::findOrFail($id);

            $image_names = $request->file('images');

            foreach ($image_names as $image) {

                $filename = $image->getClientOriginalName();
                $fileextension = $image->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                $image->move('product_images',$file_to_store);

                $file_names[] = $file_to_store;
            }

            if( $request->has('image') ) {

                $productimages = explode(',',$product->images);

                $checkedimages = $request->input('image');

                $deletedimages = array_diff($productimages,$checkedimages);


                if(!empty($deletedimages))
                {
                    foreach ($deletedimages as $deletedimage)
                    {
                        if (($key = array_search($deletedimage, $productimages)) !== false) {
                            unset($productimages[$key]);
                            unlink('product_images/'.$deletedimage);
                        }
                    }
                }

                $productimages = array_merge($productimages,$file_names);


            }

            else
            {
                $productimages = $file_names;

            }



            $arab_name = $request->input('arab_name');

            $eng_name = $request->input('eng_name');

            $price = $request->input('price');

            if($price == null)
            {
                $price = 0;
            }

            $vendor = $request->input('vendor_id');

            $category = $request->input('category_id');

            $barcode = $request->input('barcode');

            $description = $request->input('description');

            $images = implode(',',$productimages);


            $product = Product::findOrFail($id);

            if($product)
            {
                $product->update([
                    'arab_name' => $arab_name,
                    'eng_name' => $eng_name,
                    'price' => $price,
                    'vendor_id' => $vendor,
                    'category_id' => $category,
                    'barcode' => $barcode,
                    'description' => $description,
                    'images' => $images
                ]);
                return redirect('admin/products')->withStatus(__('product updated successfully'));
            }
            else
            {
                return redirect('admin/products')->withStatus(__('no product with this id , try again'));
            }


        } else {

            if ($request->has('image')) {

                $product = Product::findOrFail($id);

                $productimages = explode(',',$product->images);

                $checkedimages = $request->input('image');

                $deletedimages = array_diff($productimages,$checkedimages);


                if(!empty($deletedimages))
                {
                    foreach ($deletedimages as $deletedimage)
                    {
                        if (($key = array_search($deletedimage, $productimages)) !== false) {
                            unset($productimages[$key]);
                            unlink('product_images/'.$deletedimage);
                        }
                    }
                }


                $images = implode(',', $productimages);

                $arab_name = $request->input('arab_name');

                $eng_name = $request->input('eng_name');

                $price = $request->input('price');

                $vendor = $request->input('vendor_id');

                $category = $request->input('category_id');

                $barcode = $request->input('barcode');

                $description = $request->input('description');


                $product = Product::findOrFail($id);

                $product->update([
                    'arab_name' => $arab_name,
                    'eng_name' => $eng_name,
                    'price' => $price,
                    'vendor_id' => $vendor,
                    'category_id' => $category,
                    'barcode' => $barcode,
                    'description' => $description,
                    'images' => $images,
                ]);

                return redirect('admin/products')->withStatus(__('product updated successfully'));

            } else {

                $arab_name = $request->input('arab_name');

                $eng_name = $request->input('eng_name');

                $price = $request->input('price');

                $vendor = $request->input('vendor_id');

                $category = $request->input('category_id');

                $barcode = $request->input('barcode');

                $description = $request->input('description');

                $product = Product::findOrFail($id);

                $product->update([
                    'arab_name' => $arab_name,
                    'eng_name' => $eng_name,
                    'price' => $price,
                    'vendor_id' => $vendor,
                    'category_id' => $category,
                    'barcode' => $barcode,
                    'description' => $description,
                ]);
                return redirect('admin/products')->withStatus(__('product updated successfully'));
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
        return redirect('/admin/products')->withStatus('product successfully deleted.');
    }
}
