<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Barcode;
use App\Models\Supermarket;
use App\Imports\Productimport;
use App\Exports\ProductExport;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create','store','edit']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($flag)
    {
     
        if($flag == 1)
        {
            $products = Product::where('flag',$flag)->orderBy('id', 'desc')->get();
            return view('Admin.product_offers.index',compact('products','flag'));
        }
        $products = Product::where('flag',$flag)->orderBy('id', 'desc')->get();
        return view('Admin.products.index',compact('products','flag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($flag,$supermarket_id = null,$branch_id = null)
    {
        //

        if($supermarket_id != null && $supermarket_id != -1 ) {
              $superMarkets = Supermarket::all();
            return view('Admin.products.create', compact('flag','supermarket_id','superMarkets'));
        }
        elseif ($branch_id != null && $supermarket_id == -1)
        {   
             $superMarkets = Supermarket::all();
            return view('Admin.products.create', compact('flag','branch_id','superMarkets'));
        }
        else
        {
            $superMarkets = Supermarket::all();
            return view('Admin.products.create', compact('flag','superMarkets'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$flag,$supermarket_id = null,$branch_id = null)
    {


        $user = auth()->user();

      

        $request->validate([
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            // 'barcode' => ['required','numeric','digits_between:10,16',Rule::unique((new Product)->getTable())->ignore(auth()->id())],
            'barcode' => ['required','numeric','digits_between:10,16',Rule::unique((new Product)->getTable())->ignore(auth()->id())],
            'arab_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'price' => 'nullable|numeric|min:0',
            'offer_price' => 'sometimes|required|numeric|lt:price|min:0',
            'points' => 'nullable|integer|min:0',
            'vendor_id' => 'required|integer|min:0',
            'category_id' => 'required|integer|min:0',
            'supermarket_id' => 'required|integer|min:0',
            'branch_id'     => 'required|array',
            'rate'     => 'required|numeric',
           // 'subcategory_id' => 'required|integer|min:0',
            'start_date' => 'sometimes|required|after:today|date',
            'end_date' => 'sometimes|required|after:start_date|date',
            'production_date' => 'required|after:today|date',
            'exp_date' => 'required|after:production_date|date',
            'measure_id' => 'required|integer|min:0',
            'size_id' => 'required|integer|min:0',
            'priority' => 'required|integer|min:0',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:277'
        ]);

        $priority = $request->input('priority');

        $arab_name = $request->input('name_ar');

        $eng_name = $request->input('name_en');
        $rate = $request->input('rate');

        $arab_description = $request->input('arab_description');

        $eng_description = $request->input('eng_description');

        $arab_spec = $request->input('arab_spec');

        $eng_spec = $request->input('eng_spec');

        $price = $request->input('price');

        $points = $request->input('points');

        $quantity = $request->input('quantity');

        $category = $request->input('category_id');

        $vendor = $request->input('vendor_id');

        if($supermarket_id != null && $supermarket_id != -1)
        {
            $supermarket = $supermarket_id;
        }
        else
        {
            $supermarket = $request->input('supermarket_id');
        }

        if($branch_id != null && $supermarket_id == -1)
        {
            $branch = $branch_id;
        }


        //$subcategory = $request->input('subcategory_id');

        $barcode = $request->input('barcode');

        $start_date = $request->input('start_date');

        $end_date = $request->input('end_date');

        $exp_date = $request->input('exp_date');

        $measuring_unit = $request->input('measure_id');

        $size = $request->input('size_id');

        $offer_price = $request->offer_price;


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


        $barcodes = Product::Where('supermarket_id',$supermarket)->get()->toArray();
        $haveBarcode = in_array($barcode, $barcodes);

        if ($haveBarcode) {
         return redirect('admin/products/'.$flag)->withStatus(__('product is already exist '));
            
        }else{
              
            $product = Product::create([
                'name_ar' => $arab_name,
                'name_en' => $eng_name,
                'price' => $price,
                'offer_price' => $offer_price,
                'points' => $points,
                'category_id' => $category,
                'vendor_id' => $vendor,
                'supermarket_id' => $supermarket,
                //'subcategory_id' => $subcategory,
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
                'production_date' => $request->production_date,
                'priority' => $priority,
                'quantity' => $quantity,
                'measure_id' => $measuring_unit,
                'size_id' => $size,
                'created_by' => $user->id,
                'rate' => $rate
            ]);
        }


        // $haveBarcode = Barcode::Where('supermarket_id',$supermarket)->get()->toArray();
        // $search = in_array($barcode, $haveBarcode);
     
      

        // foreach ($barcodes as $key => $barcodes) {
        //     if ($barcodee->barcode == $barcode) {
        //         dd($barcodee->barcode , $barcode);
        //     }
        // }
     
   
      

        $product->branches()->sync($request->branch_id);

        if($product)
        {
            if($supermarket_id != null && $supermarket_id != -1)
            {
                return redirect('admin/supermarkets/products/'.$supermarket_id.'/'.$flag)->withStatus(__('supermarket product created successfully'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect('admin/branches/products/'.$branch_id.'/'.$flag)->withStatus(__('branch product created successfully'));
            }
            else
            {
                return redirect('admin/products/'.$flag)->withStatus(__('product created successfully'));
            }
        }
        else
        {

            if ($supermarket_id != null && $supermarket_id != -1)
            {
                return redirect('admin/supermarkets/products/'.$supermarket_id.'/'.$flag)->withStatus(__('supermarket product not created'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect('admin/branches/products/'.$branch_id.'/'.$flag)->withStatus(__('branch product not created'));
            }
            else
            {
                return redirect('admin/products/'.$flag)->withStatus(__('something wrong happened in product creation '));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$flag,$supermarket_id = null,$branch_id = null)
    {
        //

        $columns = $request->columns;

        if($supermarket_id != null && $supermarket_id != -1)
        {
            $products = Product::where('flag',$flag)->where('supermarket_id',$supermarket_id)->orderBy('id', 'desc')->get();
            return view('Admin.products.index', compact('products', 'columns', 'flag','supermarket_id'));
        }
        elseif ($branch_id != null && $supermarket_id == -1)
        {
            $products = Product::where('flag',$flag)->where('branch_id',$branch_id)->orderBy('id', 'desc')->get();
            return view('Admin.products.index', compact('products', 'columns', 'flag','branch_id'));
        }
        else {

            if ($flag == 1) {
                $products = Product::where('flag', $flag)->orderBy('id', 'desc')->get();
                return view('Admin.product_offers.index', compact('products', 'columns', 'flag'));
            }
            $products = Product::where('flag', $flag)->orderBy('id', 'desc')->get();
            return view('Admin.products.index', compact('products', 'columns', 'flag'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$flag,$supermarket_id = null,$branch_id = null)
    {
        //
        $product = Product::find($id);
        $superMarkets = Supermarket::all();

        if($product)
        {
            if($supermarket_id != null && $supermarket_id != -1)
            {
                $productimages = explode(',',$product->images);
                return view('Admin.products.create', compact('product','productimages','flag','supermarket_id','superMarkets'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                $productimages = explode(',',$product->images);
                return view('Admin.products.create', compact('product','productimages','flag','branch_id','superMarkets'));
            }
            else {
                $productimages = explode(',', $product->images);
                return view('Admin.products.create', compact('product', 'productimages', 'flag','superMarkets'));
            }
        }
        else
        {
            if($supermarket_id != null && $supermarket_id != -1)
            {
                return redirect('admin/supermarkets/products/'.$supermarket_id.'/'.$flag)->withStatus(__('no product with this id in the supermarket'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect('admin/supermarkets/products/'.$branch_id.'/'.$flag)->withStatus(__('no product with this id in the branch'));
            }
            else {
                return redirect('admin/products/'.$flag)->withStatus(__('no product with this id'));
            }
        }
    }

    public function clone($id,$flag,$supermarket_id = null,$branch_id = null)
    {
        
        $product      = Product::find($id);
        $superMarkets = Supermarket::all();

        if($product)
        {
            if($supermarket_id != null && $supermarket_id != -1)
            {
                $clone = true;
                $productimages = explode(',',$product->images);
                return view('Admin.products.create', compact('superMarkets','product','productimages','flag','clone','supermarket_id'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                $clone = true;
                $productimages = explode(',',$product->images);
                return view('Admin.products.create', compact('superMarkets','product','productimages','flag','clone','branch_id'));
            }
            else {
                $clone = true;
                $productimages = explode(',', $product->images);
                return view('Admin.products.create', compact('superMarkets','product', 'productimages', 'flag', 'clone'));
            }
        }
        else
        {
            if($supermarket_id != null && $supermarket_id != -1)
            {
                return redirect('admin/supermarkets/products/'.$supermarket_id.'/'.$flag)->withStatus(__('no product with this id in the supermarket'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect('admin/supermarkets/products/'.$branch_id.'/'.$flag)->withStatus(__('no product with this id in the branch'));
            }
            else {
                return redirect('admin/products/'.$flag)->withStatus(__('no product with this id'));
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
    public function update(Request $request,$id,$flag,$supermarket_id = null,$branch_id = null)
    {
        //

        $product = Product::find($id);

        $user = auth()->user();

        $rules = [
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'barcode' => ['required','numeric','digits_between:10,16',Rule::unique((new Product)->getTable())->ignore($product->id)],
            'arab_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'price' => 'required|numeric|min:0',
            'offer_price' => 'sometimes|required|numeric|min:0',
            'points' => 'nullable|integer|min:0',
            'vendor_id' => 'required|integer|min:0',
            'category_id' => 'required|integer|min:0',
            'supermarket_id' => 'required|integer|min:0',
            'branch_id' => 'required|array',
            //'subcategory_id' => 'required|integer|min:0',
            'start_date' => 'sometimes|required',
            'end_date' => 'sometimes|required',
            'exp_date' => 'required|after:today|date',
            'production_date' => 'required',
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

            $offer_price = $request->input('offer_price');

            $points = $request->input('points');

            $category = $request->input('category_id');

            $vendor = $request->input('vendor_id');

            //$subcategory = $request->input('subcategory_id');

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

            if($supermarket_id != null && $supermarket_id != -1)
            {
                $supermarket = $supermarket_id;
            }
            else
            {
                $supermarket = $request->input('supermarket_id');
            }

            if($branch_id != null && $supermarket_id == -1)
            {
                $branch = $branch_id;
            }
            else
            {
                $branch = $request->input('branch_id');
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
                    'name_ar' => $arab_name,
                    'name_en' => $eng_name,
                    'price' => $price,
                    'offer_price' => $offer_price,
                    'points' => $points,
                    'category_id' => $category,
                    'vendor_id' => $vendor,
                    'supermarket_id' => $supermarket,
                    'branch_id' => $branch,
                    //'subcategory_id' => $subcategory,
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
                    'production_date' => $request->production_date,
                    'priority' => $priority,
                    'measuring_unit' => $measuring_unit,
                    'size' => $size,
                    'updated_by' => $user->id
           
                ]);


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
                        'name_ar' => $arab_name,
                        'name_en' => $eng_name,
                        'price' => $price,
                        'points' => $points,
                        'category_id' => $category,
                        'vendor_id' => $vendor,
                        'supermarket_id' => $supermarket,
                         'offer_price' => $offer_price,
                        
                        //'subcategory_id' => $subcategory,
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
                        'production_date' => $request->production_date,
                        'priority' => $priority,
                        'measuring_unit' => $measuring_unit,
                        'size' => $size,
                        'updated_by' => $user->id
                    ]);
                         $product->branches()->sync($request->branch_id);

                } else {

                    $product->update([
                        'name_ar' => $arab_name,
                        'name_en' => $eng_name,
                        'price' => $price,
                        'points' => $points,
                        'category_id' => $category,
                        'vendor_id' => $vendor,
                        'supermarket_id' => $supermarket,
                      
                        //'subcategory_id' => $subcategory,
                        'barcode' => $barcode,
                        'arab_description' => $arab_description,
                        'eng_description' => $eng_description,
                        'arab_spec' => $arab_spec,
                        'eng_spec' => $eng_spec,
                        'flag' => $flag,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'exp_date' => $exp_date,
                        'production_date' => $request->production_date,
                        'priority' => $priority,
                        'measuring_unit' => $measuring_unit,
                        'size' => $size,
                        'updated_by' => $user->id,
                        'images' => null
                    ]);
                         $product->branches()->sync($request->branch_id);
                }
            }
            if($supermarket_id != null && $supermarket_id != -1)
            {
                return redirect('admin/supermarkets/products/'.$supermarket_id.'/'.$flag)->withStatus(__('supermarket product updated successfully'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect('admin/branches/products/'.$branch_id.'/'.$flag)->withStatus(__('branch product updated successfully'));
            }
            else {
                return redirect('admin/products/'.$flag)->withStatus(__('product updated successfully'));
            }
        }

        else
        {
            if($supermarket_id != null && $supermarket_id != -1)
            {
                return redirect('admin/supermarkets/products/'.$supermarket_id.'/'.$flag)->withStatus(__('no product with this id in the supermarket'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect('admin/branches/products/'.$branch_id.'/'.$flag)->withStatus(__('no product with this id in the branch'));
            }
            else {
                return redirect('admin/products/'.$flag)->withStatus(__('no product with this id'));
            }
        }

    }

    public function supermarketproducts($supermarket_id,$flag)
    {
        //
        $products = Product::where('supermarket_id',$supermarket_id)->where('flag',$flag)->orderBy('id', 'desc')->get();
        return view('Admin.products.index',compact('products','flag','supermarket_id'));
    }

    public function branchproducts($branch_id,$flag)
    {  

        $products = Product::where('flag',$flag)->WhereHas('branches', function ($q) use ($branch_id){
            $q->where('branches.id',$branch_id);
        })->get();  

          
        return view('Admin.products.index',compact('products','flag','branch_id'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$supermarket_id = null,$branch_id = null)
    {
        //

        $product = Product::find($id);

        if($product) {

            $images = $product->images;

            if ($images) {
                $productimages = explode(',', $images);

                foreach ($productimages as $image) {
                    unlink('product_images/' . $image);
                }
            }

            $product->delete();

            if($supermarket_id != null && $supermarket_id != -1)
            {
                return redirect()->back()->withStatus(__('supermarket product deleted successfully'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect()->back()->withStatus(__('branch product deleted successfully'));
            }
            else {
                return redirect()->back()->withStatus(__('product deleted successfully'));
            }
        }
        else
        {

            if ($supermarket_id != null && $supermarket_id != -1) {
                return redirect()->back()->withStatus(__('no product with this id in the supermarket'));
            }
            elseif ($branch_id != null && $supermarket_id == -1)
            {
                return redirect()->back()->withStatus(__('no product with this id in the branch'));
            }
            else {
                return redirect()->back()->withStatus(__('no product with this id'));
            }
        }
    }


    public function status(Request $request,$id,$flag)
    {

        $product = Product::Where('id', $id )->where('flag', $flag)->first();
       
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

         return  Excel::download(new ProductsExport , 'products.xlsx');
    }

    

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
    
        Excel::import(new Productimport , $request->file);

         return redirect()->back()->withStatus(__('Added successfully'));
    }

    public function download()
    {
        return response()->download('Book1.xlsx');

    }

    public function supermarketBranch(Request $request)
    {
        $superMarket = $request->supermarket_id;
        $branches = Branch::Where('supermarket_id',$superMarket)->get();

        return response()->json($branches);
    }

    public function getBranchProduct(Request $request)
    {
         $products = Product::WhereHas('branches', function ($q) use($request){

            $q->Where('branches.id',$request->branch_id);

        })->get();
        
        return response()->json($products);
    }

    public function getProduct(Request $request)
    {
         $products = Product::Where('id', $request->product_id)->first();
        
        return response()->json($products);
    }

   
}
