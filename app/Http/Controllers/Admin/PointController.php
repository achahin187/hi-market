<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    //

    public function index()
    {
        //
        $points = Point::orderBy('id', 'desc')->paginate(10);
        return view('Admin.points.index',compact('points'));
    }


    public function create()
    {
        //
        return view('Admin.points.create');
    }


    public function store(Request $request)
    {
        $rules = [
            'from' => ['required','min:0','integer'],
            'to' => ['required','min:0','integer'],
            'value' => ['required', 'min:0', 'numeric'],
            'type' => ['required', 'min:0' , 'integer']
        ];

        $this->validate($request,$rules);

        $points = Point::orderBy('id', 'desc')->paginate(10);

        foreach ($points as $oldpoint) {

            if ($oldpoint->from == $request->input('from') || $oldpoint->to == $request->input('to')) {
                return redirect('/admin/points')->withStatus('this range have been chosen already');
            }
        }


        $point = Point::create([

            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'value' => $request->input('value'),
            'type' => $request->input('type')
        ]);

        if($point)
        {
            return redirect('admin/points')->withStatus('range successfully created');
        }
        else
        {
            return redirect('admin/points')->withStatus('something went wrong, try again');
        }


    }

    public function edit($id)
    {
        //
        $point = Point::findOrFail($id);

        $points = Point::orderBy('id', 'desc')->paginate(10);

        if($point)
        {
            return view('Admin.points.index', compact('point','points'));
        }
        else
        {
            return redirect('admin/vendors')->withStatus('no vendor have this id');
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
            'from' => ['required','min:0','integer'],
            'to' => ['required','min:0','integer'],
            'value' => ['required', 'min:0', 'numeric'],
            'type' => ['required', 'min:0' , 'integer']
        ];

        $this->validate($request, $rules);

        $point = Point::findOrFail($id);

        $points = Point::orderBy('id', 'desc')->paginate(10);

        if($point) {

            foreach ($points as $oldpoint) {

                if($oldpoint->id != $point->id) {

                    if ($oldpoint->from == $request->input('from') || $oldpoint->to == $request->input('to')) {

                        return redirect('/admin/points')->withStatus('this range have been chosen already');
                    }
                }
            }

            $point->update(['from' => $request->input('from') , 'to' => $request->input('to') , 'type' => $request->input('type') , 'value' => $request->input('value')]);
            return redirect('/admin/points')->withStatus('range successfully updated.');
        }
        else
        {
            return redirect('/admin/points')->withStatus('no range exist');
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
        $point = Point::findOrFail($id);

        if($point)
        {
            $point->delete();
            return redirect('/admin/points')->withStatus(__('range successfully deleted.'));
        }
        return redirect('/admin/points')->withStatus(__('this range is not in our database'));
    }
}
