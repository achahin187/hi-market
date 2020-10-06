<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
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
        $offers = Offer::orderBy('id', 'desc')->get();
        return view('Admin.dynamic_offers.index',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.dynamic_offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = auth()->user();

        $rules = [

            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'supermarket_id' => 'required|integer|min:0',
            'status' => ['required','string'],
            'offer_type' => ['required','string'],
            'value_type' => ['required','string'],
            'start_date' => 'required|after:yesterday',
            'end_date' => 'required|after:start_date',
        ];

        $this->validate($request, $rules);

        if(!function_exists('assign_value')) {

            function assign_value($num)
            {

                // accepts 1 - 36
                switch ($num) {
                    case "1"  :
                        $rand_value = "a";
                        break;
                    case "2"  :
                        $rand_value = "b";
                        break;
                    case "3"  :
                        $rand_value = "c";
                        break;
                    case "4"  :
                        $rand_value = "d";
                        break;
                    case "5"  :
                        $rand_value = "e";
                        break;
                    case "6"  :
                        $rand_value = "f";
                        break;
                    case "7"  :
                        $rand_value = "g";
                        break;
                    case "8"  :
                        $rand_value = "h";
                        break;
                    case "9"  :
                        $rand_value = "i";
                        break;
                    case "10" :
                        $rand_value = "j";
                        break;
                    case "11" :
                        $rand_value = "k";
                        break;
                    case "12" :
                        $rand_value = "l";
                        break;
                    case "13" :
                        $rand_value = "m";
                        break;
                    case "14" :
                        $rand_value = "n";
                        break;
                    case "15" :
                        $rand_value = "o";
                        break;
                    case "16" :
                        $rand_value = "p";
                        break;
                    case "17" :
                        $rand_value = "q";
                        break;
                    case "18" :
                        $rand_value = "r";
                        break;
                    case "19" :
                        $rand_value = "s";
                        break;
                    case "20" :
                        $rand_value = "t";
                        break;
                    case "21" :
                        $rand_value = "u";
                        break;
                    case "22" :
                        $rand_value = "v";
                        break;
                    case "23" :
                        $rand_value = "w";
                        break;
                    case "24" :
                        $rand_value = "x";
                        break;
                    case "25" :
                        $rand_value = "y";
                        break;
                    case "26" :
                        $rand_value = "z";
                        break;
                    case "27" :
                        $rand_value = "0";
                        break;
                    case "28" :
                        $rand_value = "1";
                        break;
                    case "29" :
                        $rand_value = "2";
                        break;
                    case "30" :
                        $rand_value = "3";
                        break;
                    case "31" :
                        $rand_value = "4";
                        break;
                    case "32" :
                        $rand_value = "5";
                        break;
                    case "33" :
                        $rand_value = "6";
                        break;
                    case "34" :
                        $rand_value = "7";
                        break;
                    case "35" :
                        $rand_value = "8";
                        break;
                    case "36" :
                        $rand_value = "9";
                        break;
                }
                return $rand_value;
            }
        }

        if(!function_exists('assign_value')) {
            function get_rand_alphanumeric($length)
            {
                if ($length > 0) {
                    $rand_id = "";
                    for ($i = 1; $i <= $length; $i++) {
                        mt_srand((double)microtime() * 1000000);
                        $num = mt_rand(1, 36);
                        $rand_id .= assign_value($num);
                    }
                }
                return $rand_id;
            }
        }

        if($request->offer_type == 'promocode') {

            $promocode = get_rand_alphanumeric(6);

        }
        else
        {
            $promocode = null;
        }


        $offer = Offer::create([

            'arab_name' => $request->arab_name,
            'eng_name' => $request->eng_name,
            'arab_description' => $request->arab_description,
            'eng_description' => $request->eng_description,
            'status' => $request->status,
            'promocode' => $promocode,
            'supermarket_id' => $request->supermarket_id,
            'offer_type' => $request->offer_type,
            'value_type' => $request->value_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => $user->id
        ]);


        if($offer)
        {
            return redirect('admin/offers')->withStatus(__('offer created successfully'));
        }
        else
        {
            return redirect('admin/offers')->withStatus(__('something wrong happened, try again'));
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
        $offer = Offer::find($id);

        if($offer)
        {
            return view('Admin.dynamic_offers.create', compact('offer'));
        }
        else
        {
            return redirect('admin/offers')->withStatus('no offer have this id');
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
        $user = auth()->user();

        $offer = Offer::find($id);

        if ($offer->offer_type == 'navigable')
        {

            $rules = [

                'arab_name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
                'eng_name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
                'arab_description' => ['nullable', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                'eng_description' => ['nullable', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                'supermarket_id' => 'required|integer|min:0',
                'offer_type' => ['required','string'],
                'value_type' => ['required', 'string'],
                'start_date' => 'required|after:yesterday',
                'end_date' => 'required|after:start_date',
            ];
        }

        else
        {
            $rules = [

                'arab_name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
                'eng_name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
                'arab_description' => ['nullable', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                'eng_description' => ['nullable', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                'supermarket_id' => 'required|integer|min:0',
                'value_type' => ['required', 'string'],
                'start_date' => 'required|after:yesterday',
                'end_date' => 'required|after:start_date',
            ];
        }

        $this->validate($request, $rules);

        if(!function_exists('assign_value')) {

            function assign_value($num)
            {

                // accepts 1 - 36
                switch ($num) {
                    case "1"  :
                        $rand_value = "a";
                        break;
                    case "2"  :
                        $rand_value = "b";
                        break;
                    case "3"  :
                        $rand_value = "c";
                        break;
                    case "4"  :
                        $rand_value = "d";
                        break;
                    case "5"  :
                        $rand_value = "e";
                        break;
                    case "6"  :
                        $rand_value = "f";
                        break;
                    case "7"  :
                        $rand_value = "g";
                        break;
                    case "8"  :
                        $rand_value = "h";
                        break;
                    case "9"  :
                        $rand_value = "i";
                        break;
                    case "10" :
                        $rand_value = "j";
                        break;
                    case "11" :
                        $rand_value = "k";
                        break;
                    case "12" :
                        $rand_value = "l";
                        break;
                    case "13" :
                        $rand_value = "m";
                        break;
                    case "14" :
                        $rand_value = "n";
                        break;
                    case "15" :
                        $rand_value = "o";
                        break;
                    case "16" :
                        $rand_value = "p";
                        break;
                    case "17" :
                        $rand_value = "q";
                        break;
                    case "18" :
                        $rand_value = "r";
                        break;
                    case "19" :
                        $rand_value = "s";
                        break;
                    case "20" :
                        $rand_value = "t";
                        break;
                    case "21" :
                        $rand_value = "u";
                        break;
                    case "22" :
                        $rand_value = "v";
                        break;
                    case "23" :
                        $rand_value = "w";
                        break;
                    case "24" :
                        $rand_value = "x";
                        break;
                    case "25" :
                        $rand_value = "y";
                        break;
                    case "26" :
                        $rand_value = "z";
                        break;
                    case "27" :
                        $rand_value = "0";
                        break;
                    case "28" :
                        $rand_value = "1";
                        break;
                    case "29" :
                        $rand_value = "2";
                        break;
                    case "30" :
                        $rand_value = "3";
                        break;
                    case "31" :
                        $rand_value = "4";
                        break;
                    case "32" :
                        $rand_value = "5";
                        break;
                    case "33" :
                        $rand_value = "6";
                        break;
                    case "34" :
                        $rand_value = "7";
                        break;
                    case "35" :
                        $rand_value = "8";
                        break;
                    case "36" :
                        $rand_value = "9";
                        break;
                }
                return $rand_value;
            }
        }

        if(!function_exists('assign_value')) {
            function get_rand_alphanumeric($length)
            {
                if ($length > 0) {
                    $rand_id = "";
                    for ($i = 1; $i <= $length; $i++) {
                        mt_srand((double)microtime() * 1000000);
                        $num = mt_rand(1, 36);
                        $rand_id .= assign_value($num);
                    }
                }
                return $rand_id;
            }
        }

        $promocode = get_rand_alphanumeric(6);

        if($offer)
        {

            if($offer->offer_type == 'navigable') {

                if($request->offer_type != "promocode") {

                    $promocode = null;
                }


                $offer->update([

                    'arab_name' => $request->arab_name,
                    'eng_name' => $request->eng_name,
                    'arab_description' => $request->arab_description,
                    'eng_description' => $request->eng_description,
                    'supermarket_id' => $request->supermarket_id,
                    'promocode' => $promocode,
                    'offer_type' => $request->offer_type,
                    'value_type' => $request->value_type,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'updated_by' => $user->id
                ]);
            }

            else {

                $offer->update([

                    'arab_name' => $request->arab_name,
                    'eng_name' => $request->eng_name,
                    'arab_description' => $request->arab_description,
                    'eng_description' => $request->eng_description,
                    'supermarket_id' => $request->supermarket_id,
                    'value_type' => $request->value_type,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'updated_by' => $user->id
                ]);

            }

            return redirect('admin/offers')->withStatus(__('offer updated successfully'));
        }
        else
        {
            return redirect('admin/offers')->withStatus(__('no offer with this id'));
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

        $offer = Offer::find($id);

        if($offer) {
            $offer->delete();
            return redirect('/admin/product_offers')->withStatus('offer successfully deleted.');
        }
        return redirect('/admin/product_offers')->withStatus('no offer with this id.');


    }

    public function supermarketoffers($supermarket_id)
    {
        //
        $offers = Offer::where('supermarket_id',$supermarket_id)->orderBy('id', 'desc')->get();
        return view('Admin.dynamic_offers.index',compact('offers'));
    }

    public function status(Request $request,$id)
    {

        $offer = Offer::find($id);

        if($offer)
        {
            if($offer->status == 'active') {
                $offer->update(['status' => 'inactive']);
            }
            else
            {
                $offer->update(['status' => 'active']);
            }
            return redirect('/admin/offers')->withStatus(__('offer status successfully updated.'));
        }
        return redirect('/admin/offers')->withStatus(__('this id is not in our database'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new AdminExport , 'admins.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'images' => 'image|mimes:csv|max:277'
        ];
        Excel::import(new AdminImport ,request()->file('file'));

        return back();
    }
}
