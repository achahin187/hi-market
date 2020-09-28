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

            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'promocode' => ['nullable','numeric','digits:6'],
            'status' => ['required','string'],
            'value_type' => ['required','string'],
            'start_date' => 'required|after:today|date',
            'end_date' => 'required|after:start_date|date',
        ];

        $this->validate($request, $rules);


        $offer = Offer::create([

            'arab_description' => $request->arab_description,
            'eng_description' => $request->eng_description,
            'status' => $request->status,
            'promocode' => $request->promocode,
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

        $rules = [

            'arab_description' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['required','min:2','not_regex:/([%\$#\*<>]+)/'],
            'promocode' => ['nullable','numeric','digits:6'],
            'value_type' => ['required','string'],
            'start_date' => 'required|after:today|date',
            'end_date' => 'required|after:start_date|date',
        ];

        $this->validate($request, $rules);


        if($offer)
        {
            $offer->update([

                'arab_description' => $request->arab_description,
                'eng_description' => $request->eng_description,
                'promocode' => $request->promocode,
                'value_type' => $request->value_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'updated_by' => $user->id
            ]);

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
