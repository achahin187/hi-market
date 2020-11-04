<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\Product;
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
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'logo_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'area_id' => 'required|integer|min:0',
            'city_id' => 'required|integer|min:0',
            'country_id' => 'required|integer|min:0',
            'start_time' => ['required','string'],
            'end_time' => ['required','string'],
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

        }
        else
        {
            $file_to_store = null;
        }

        /*if($logoimage = $request->file('logo_image'))
        {
            $filename = $logoimage->getClientOriginalName();
            $fileextension = $logoimage->getClientOriginalExtension();
            $logo = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('supermarket_images', $logo);

        }
        else
        {
            $logo = null;
        }*/

        Supermarket::create([

            'arab_name' => $arab_name,
            'eng_name' => $eng_name,
            'status' => $status,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'area_id' => $request->area_id,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'commission' => $commission,
            'priority' => $priority,
            'image' => $file_to_store,
        ]);


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
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'area_id' => 'required|integer|min:0',
            'city_id' => 'required|integer|min:0',
            'country_id' => 'required|integer|min:0',
            'start_time' => ['required','string'],
            'end_time' => ['required','string'],
        ];

        $this->validate($request, $rules);

        $supermarket = Supermarket::find($id);

        if($supermarket) {


            if ($file = $request->file('image') ) {

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('supermarket_images', $file_to_store)) {
                    if ($supermarket->image != null) {

                        unlink('supermarket_images/' . $supermarket->image);
                    }
                }
            } else {

                if ($request->has('checkedimage')) {
                        $supermarket->update([
                            'arab_name' => $request->arab_name,
                            'eng_name' => $request->eng_name,
                            'status' => $request->status ,
                            'start_time' => $request->start_time,
                            'end_time' => $request->end_time,
                            'commission' => $request->commission ,
                            'priority' => $request->priority ,
                            'area_id' => $request->area_id,
                            'city_id' => $request->city_id,
                            'country_id' => $request->country_id,
                            'image' => $request->checkedimage,
                        ]);
                } else {
                    if ($supermarket->image != null) {
                        unlink('supermarket_images/' . $supermarket->image);
                    }
                    $file_to_store = null;
                }
            }

            /*if ($logoimage = $request->file('logo_image') ) {

                $filename = $logoimage->getClientOriginalName();
                $fileextension = $logoimage->getClientOriginalExtension();
                $logo = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('supermarket_images', $logo)) {
                    if ($supermarket->logo_image != null) {

                        unlink('supermarket_images/' . $supermarket->logo_image);
                    }
                }
            } else {

                if ($request->has('checkedimage')) {
                    $supermarket->update([
                        'arab_name' => $request->arab_name,
                        'eng_name' => $request->eng_name,
                        'commission' => $request->commission ,
                        'priority' => $request->priority,
                        'image' => $request->input('checkedlogoimage'),
                        'logo_image' => $request->input('checkedlogoimage')
                    ]);

                    return redirect('/admin/supermarkets')->withStatus('supermarket successfully updated.');
                } else {
                    if ($supermarket->logo_image != null) {
                        unlink('supermarket_images/' . $supermarket->logo_image);
                    }
                    $logo = null;
                }
            }*/

            $supermarket->update([
                'arab_name' => $request->arab_name,
                'eng_name' => $request->eng_name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'commission' => $request->commission ,
                'priority' => $request->priority ,
                'area_id' => $request->area_id,
                'city_id' => $request->city_id,
                'country_id' => $request->country_id,
                'image' => $file_to_store,
            ]);

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
            if($supermarket->image != null) {
                unlink('supermarket_images/' . $supermarket->image);
            }

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
            return redirect()->back()->withStatus(__('supermarket status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }

//    public function addproduct($supermarket_id,$flag)
//    {
//        //
//        return view('Admin.supermarkets.addproduct',compact('flag','supermarket_id'));
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function storeproduct(Request $request,$supermarket_id,$flag)
//    {
//
//
//        $user = auth()->user();
//
//        $rules = [
//            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
//            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
//            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
//            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
//            'barcode' => ['required','numeric','digits_between:10,16'],
//            'arab_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
//            'eng_spec' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
//            'price' => 'nullable|numeric|min:0',
//            'points' => 'nullable|integer|min:0',
//            'vendor_id' => 'required|integer|min:0',
//            'category_id' => 'required|integer|min:0',
//            'supermarket_id' => 'required|integer|min:0',
//            'subcategory_id' => 'required|integer|min:0',
//            'start_date' => 'required|after:today|date',
//            'end_date' => 'required|after:start_date|date',
//            'exp_date' => 'required|after:today|date',
//            'measure_id' => 'required|integer|min:0',
//            'size_id' => 'required|integer|min:0',
//            'priority' => 'required|integer|min:0',
//            'images' => 'nullable',
//            'images.*' => 'image|mimes:jpeg,png,jpg|max:277'
//        ];
//
//        $this->validate($request, $rules);
//
//        if($flag == 1) {
//            $priority = null;
//        }
//        else
//        {
//            $priority = $request->input('priority');
//        }
//
//
//        $arab_name = $request->input('name_ar');
//
//        $eng_name = $request->input('name_en');
//
//        $arab_description = $request->input('arab_description');
//
//        $eng_description = $request->input('eng_description');
//
//        $arab_spec = $request->input('arab_spec');
//
//        $eng_spec = $request->input('eng_spec');
//
//        $price = $request->input('price');
//
//        $points = $request->input('points');
//
//        $quantity = $request->input('quantity');
//
//        $category = $request->input('category_id');
//
//        $vendor = $request->input('vendor_id');
//
//        $supermarket = $request->input('supermarket_id');
//
//        $subcategory = $request->input('subcategory_id');
//
//        $barcode = $request->input('barcode');
//
//        $start_date = $request->input('start_date');
//
//        $end_date = $request->input('end_date');
//
//        $exp_date = $request->input('exp_date');
//
//        $measuring_unit = $request->input('measure_id');
//
//        $size = $request->input('size_id');
//
//
//        if ($price == null) {
//            $price = 0;
//        }
//
//        if($points == null)
//        {
//            $points == 0;
//        }
//
//
//        if ($request->hasFile('images')) {
//
//            $image_names = [];
//            $files = $request->file('images');
//
//            foreach ($files as $image) {
//                $filename = $image->getClientOriginalName();
//                $fileextension = $image->getClientOriginalExtension();
//                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;
//
//                $image->move('product_images', $file_to_store);
//
//                $image_names[] = $file_to_store;
//            }
//
//            $images = implode(',', $image_names);
//        }
//        else
//        {
//            $images = '';
//        }
//
//
//
//        $product = Product::create([
//            'name_ar' => $arab_name,
//            'name_en' => $eng_name,
//            'price' => $price,
//            'points' => $points,
//            'category_id' => $category,
//            'vendor_id' => $vendor,
//            'supermarket_id' => $supermarket,
//            'subcategory_id' => $subcategory,
//            'images' => $images,
//            'barcode' => $barcode,
//            'arab_description' => $arab_description,
//            'eng_description' => $eng_description,
//            'arab_spec' => $arab_spec,
//            'eng_spec' => $eng_spec,
//            'flag' => $flag,
//            'start_date' => $start_date,
//            'end_date' => $end_date,
//            'exp_date' => $exp_date,
//            'priority' => $priority,
//            'quantity' => $quantity,
//            'measure_id' => $measuring_unit,
//            'size_id' => $size,
//            'created_by' => $user->id
//        ]);
//
//
//        if($product)
//        {
//            if($flag == 1)
//            {
//                return redirect('admin/products/1')->withStatus(__('offer created successfully'));
//            }
//            return redirect('admin/products/0')->withStatus(__('product created successfully'));
//        }
//        else
//        {
//            if($flag == 1)
//            {
//                return redirect('admin/products/1')->withStatus(__('something wrong happened, try again'));
//            }
//            return redirect('admin/products/0')->withStatus(__('something wrong happened, try again'));
//        }
//    }
//
//
//    public function addoffer($supermarket_id)
//    {
//        //
//        return view('Admin.supermarkets.addoffer',compact('supermarket_id'));
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function storeoffer(Request $request,$supermarket_id)
//    {
//
//        $user = auth()->user();
//
//        $rules = [
//
//            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
//            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
//            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
//            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
//            'supermarket_id' => 'required|integer|min:0',
//            'status' => ['required','string'],
//            'offer_type' => ['required','string'],
//            'value_type' => ['required','string'],
//            'start_date' => 'required|after:today',
//            'end_date' => 'required|after:start_date',
//        ];
//
//        $this->validate($request, $rules);
//
//        if(!function_exists('assign_value')) {
//
//            function assign_value($num)
//            {
//
//                // accepts 1 - 36
//                switch ($num) {
//                    case "1"  :
//                        $rand_value = "a";
//                        break;
//                    case "2"  :
//                        $rand_value = "b";
//                        break;
//                    case "3"  :
//                        $rand_value = "c";
//                        break;
//                    case "4"  :
//                        $rand_value = "d";
//                        break;
//                    case "5"  :
//                        $rand_value = "e";
//                        break;
//                    case "6"  :
//                        $rand_value = "f";
//                        break;
//                    case "7"  :
//                        $rand_value = "g";
//                        break;
//                    case "8"  :
//                        $rand_value = "h";
//                        break;
//                    case "9"  :
//                        $rand_value = "i";
//                        break;
//                    case "10" :
//                        $rand_value = "j";
//                        break;
//                    case "11" :
//                        $rand_value = "k";
//                        break;
//                    case "12" :
//                        $rand_value = "l";
//                        break;
//                    case "13" :
//                        $rand_value = "m";
//                        break;
//                    case "14" :
//                        $rand_value = "n";
//                        break;
//                    case "15" :
//                        $rand_value = "o";
//                        break;
//                    case "16" :
//                        $rand_value = "p";
//                        break;
//                    case "17" :
//                        $rand_value = "q";
//                        break;
//                    case "18" :
//                        $rand_value = "r";
//                        break;
//                    case "19" :
//                        $rand_value = "s";
//                        break;
//                    case "20" :
//                        $rand_value = "t";
//                        break;
//                    case "21" :
//                        $rand_value = "u";
//                        break;
//                    case "22" :
//                        $rand_value = "v";
//                        break;
//                    case "23" :
//                        $rand_value = "w";
//                        break;
//                    case "24" :
//                        $rand_value = "x";
//                        break;
//                    case "25" :
//                        $rand_value = "y";
//                        break;
//                    case "26" :
//                        $rand_value = "z";
//                        break;
//                    case "27" :
//                        $rand_value = "0";
//                        break;
//                    case "28" :
//                        $rand_value = "1";
//                        break;
//                    case "29" :
//                        $rand_value = "2";
//                        break;
//                    case "30" :
//                        $rand_value = "3";
//                        break;
//                    case "31" :
//                        $rand_value = "4";
//                        break;
//                    case "32" :
//                        $rand_value = "5";
//                        break;
//                    case "33" :
//                        $rand_value = "6";
//                        break;
//                    case "34" :
//                        $rand_value = "7";
//                        break;
//                    case "35" :
//                        $rand_value = "8";
//                        break;
//                    case "36" :
//                        $rand_value = "9";
//                        break;
//                }
//                return $rand_value;
//            }
//        }
//
//        if(!function_exists('assign_value')) {
//            function get_rand_alphanumeric($length)
//            {
//                if ($length > 0) {
//                    $rand_id = "";
//                    for ($i = 1; $i <= $length; $i++) {
//                        mt_srand((double)microtime() * 1000000);
//                        $num = mt_rand(1, 36);
//                        $rand_id .= assign_value($num);
//                    }
//                }
//                return $rand_id;
//            }
//        }
//
//        if($request->offer_type == 'promocode') {
//
//            $promocode = get_rand_alphanumeric(6);
//
//        }
//        else
//        {
//            $promocode = null;
//        }
//
//
//        $offer = Offer::create([
//
//            'arab_name' => $request->arab_name,
//            'eng_name' => $request->eng_name,
//            'arab_description' => $request->arab_description,
//            'eng_description' => $request->eng_description,
//            'status' => $request->status,
//            'promocode' => $promocode,
//            'supermarket_id' => $request->supermarket_id,
//            'offer_type' => $request->offer_type,
//            'value_type' => $request->value_type,
//            'start_date' => $request->start_date,
//            'end_date' => $request->end_date,
//            'created_by' => $user->id
//        ]);
//
//
//        if($offer)
//        {
//            return redirect('admin/offers')->withStatus(__('offer created successfully'));
//        }
//        else
//        {
//            return redirect('admin/offers')->withStatus(__('something wrong happened, try again'));
//        }
//
//    }
//
//    public function addbranch($supermarket_id)
//    {
//        //
//        return view('Admin.branches.create',compact('supermarket_id'));
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function storebranch(Request $request,$supermarket_id)
//    {
//        //
//        $rules = [
//            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
//            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
//            'status' => ['required','string'],
//            'supermarket_id' => 'required|integer|min:0',
//            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
//        ];
//
//        $this->validate($request,$rules);
//
//        $arab_name = $request->input('name_ar');
//
//        $eng_name = $request->input('name_en');
//
//        $status = $request->input('status');
//
//        $supermarket = $request->input('supermarket_id');
//
//        if($image = $request->file('image'))
//        {
//            $filename = $image->getClientOriginalName();
//            $fileextension = $image->getClientOriginalExtension();
//            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;
//
//            $image->move('images', $file_to_store);
//
//            Branch::create([
//
//                'name_ar' => $arab_name,
//                'name_en' => $eng_name,
//                'status' => $status,
//                'supermarket_id' => $supermarket,
//                'image' => $file_to_store
//            ]);
//        }
//        else
//        {
//            Branch::create([
//
//                'name_ar' => $arab_name,
//                'name_en' => $eng_name,
//                'status' => $status,
//                'supermarket_id' => $supermarket,
//            ]);
//        }
//
//
//        return redirect('admin/branches')->withStatus(__('branch created successfully'));
//    }

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
