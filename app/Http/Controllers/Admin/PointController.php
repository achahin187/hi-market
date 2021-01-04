<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\PointPhoto;
use Illuminate\Http\Request;

class PointController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:point-list', ['only' => ['index']]);
        $this->middleware('permission:point-create', ['only' => ['create','store']]);
        $this->middleware('permission:point-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:point-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
        $points = Point::orderBy('id', 'desc')->get();
        return view('Admin.points.index',compact('points'));
    }


    public function create()
    {
        //
        return view('Admin.points.create');
    }


    public function store(Request $request)
    {

        $user = auth()->user();

        $request->validate([
            'points' => ['required', 'min:1', 'unique:points,points','integer'],
            /*'type' => ['required', 'min:0', 'integer'],
            'offer_type' => ['sometimes','string'],*/
            'value' => ['required', 'min:0', 'numeric'],
            'status' => ['required','string'],
            'start_date' => 'sometimes|after:today',
            'end_date' => 'sometimes|after:start_date|date'

        ]);
        

/*        if($request->type == 2)
        {
            $offer_type = $request->offer_type;
        }
        else
        {
            $offer_type = 'not an offer';
        }
*/
        if($request->has('start_date'))
        {
            $start = $request->start_date;
        }
        else
        {
            $start = now();
        }


/*        $points = Point::orderBy('id', 'desc')->get();

        foreach ($points as $oldpoint) {

            if ($request->input('from') < $oldpoint->to) {

                return redirect('/admin/points')->withStatus('this range have been chosen already');
            }
        }*/

            $point = Point::create([

                'points' => $request->input('points'),
                'value' => $request->input('value'),
 /*               'type' => $request->input('type'),
                'offer_type' => $offer_type,*/
                'status' => $request->input('status'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'created_by' => $user->id
            ]);


        if($point)
        {
            return redirect('admin/points')->withStatus('point successfully created');
        }
        else
        {
            return redirect('admin/points')->withStatus('something went wrong, try again');
        }


    }

    public function edit($id)
    {
        //
        $point = Point::find($id);

        if($point)
        {
            return view('Admin.points.create', compact('point'));
        }
        else
        {
            return redirect('admin/points')->withStatus('no point have this id');
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
        $user = auth()->user();


            $rules = [
                'points' => ['required', 'min:1', 'integer'],
               /* 'type' => ['required', 'min:0', 'integer'],
                'offer_type' => ['sometimes','string'],*/
                'value' => ['required', 'min:0', 'numeric'],
                'start_date' => 'sometimes|after:today',
                'end_date' => 'sometimes|after:start_date|date'
            ];


        $this->validate($request, $rules);

        $point = Point::find($id);

/*        if($request->type == 2)
        {
            $offer_type = $request->offer_type;
        }
        else
        {
            $offer_type = 'not an offer';
        }*/


//        $points = Point::orderBy('id', 'desc')->get();



/*            if($point->from != $request->from || $point->to != $request->to) {

                foreach ($points as $oldpoint) {

                    if ($oldpoint->id == $point->id) {

                        continue;
                    }

                    if ($request->input('from') < $oldpoint->to) {

                        return redirect('/admin/points')->withStatus('this point have been chosen already');
                    }
                }
            }*/


        if($point) {

                $point->update([

                    'points' => $request->input('points'),
                    'value' => $request->input('value'),
                    /*'type' => $request->input('type'),
                    'offer_type' => $offer_type,*/
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'updated_by' => $user->id
                ]);



            return redirect('/admin/points')->withStatus('point successfully updated.');
        }
        else
        {
            return redirect('/admin/points')->withStatus('no range exist');
        }
    }

    public function status(Request $request,$id)
    {

        $point = Point::find($id);

        if($point)
        {
            if($point->status == 'active') {
                $point->update(['status' => 'inactive']);
            }
            else
            {
                $point->update(['status' => 'active']);
            }
            return redirect()->back()->withStatus(__('point status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
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
        $point = Point::find($id);

        if($point)
        {
            $point->delete();
            return redirect('/admin/points')->withStatus(__('range successfully deleted.'));
        }
        return redirect('/admin/points')->withStatus(__('this range is not in our database'));
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


    public function pointImage(Request $request)
    {
        
        $image = PointPhoto::first();       
        
        if ($image) {

            $image->delete();

            $this->uploadImage($request->image);
            
        }else{
          $this->uploadImage($request->image);

        }
     


        return redirect('/admin/points')->withStatus(__('upload_successfuly'));
    }


    private function uploadImage($image)
    {
            $filename = $image->getClientOriginalName();

            $fileextension = $image->getClientOriginalExtension();

            $fileNameToStore = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $image->move('points', $fileNameToStore);

            PointPhoto::create(['image'=>$fileNameToStore]);
    }
}
