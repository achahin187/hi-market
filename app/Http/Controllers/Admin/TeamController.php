<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teams = Team::orderBy('id', 'desc')->paginate(10);
        return view('Admin.teams.index',compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.teams.create');
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
        ];

        $this->validate($request, $rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        $user = auth()->user();

        $team = Team::create([
            'arab_name' => $arab_name,
            'eng_name' => $eng_name,
            'created_by' => $user->id,
        ]);

        if($team)
        {
            return redirect('admin/teams')->withStatus(__('teams created successfully'));
        }
        else
        {
            return redirect('admin/teams')->withStatus(__('something wrong happened, try again'));
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
        $team = team::find($id);

        if($team)
        {
            return view('Admin.products.show', compact('team'));
        }
        else
        {
            return redirect('admin/teams')->withStatus('no product have this id');
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
        $team = team::find($id);

        if($team)
        {
            return view('Admin.teams.create', compact('team'));
        }
        else
        {
            return redirect('admin/teams')->withStatus('no product have this id');
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
        $team = Team::find($id);

        if($team)
        {
            $team->delete();
            return redirect('/admin/teams')->withStatus(__('teams successfully deleted.'));
        }
        return redirect('/admin/teams')->withStatus(__('this id is not in our database'));
    }
}
