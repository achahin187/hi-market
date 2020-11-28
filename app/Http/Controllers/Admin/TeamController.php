<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\Role;

class TeamController extends Controller
{



    function __construct()
    {
        $this->middleware('permission:team-list', ['only' => ['index']]);
        $this->middleware('permission:team-create', ['only' => ['create','store']]);
        $this->middleware('permission:team-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:team-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $teams = Team::orderBy('id', 'desc')->get();
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

        $roles = Role::orderBy('id', 'desc')->get();
        return view('Admin.teams.create',compact('roles'));
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
            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'role_id' => 'required|integer|min:0',
        ];

        $this->validate($request, $rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        $arab_description = $request->input('arab_description');

        $eng_description = $request->input('eng_description');

        $user = auth()->user();


        $team = Team::create([
            'arab_name' => $arab_name,
            'eng_name' => $eng_name,
            'arab_description' => $arab_description,
            'eng_description' => $eng_description,
            'role_id' => $request->role_id,
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
        $roles = Role::all();
        $teamRole = $team->role->pluck('name','name')->all();

        if($team)
        {
            return view('Admin.teams.create', compact('team','roles','teamRole'));
        }
        else
        {
            return redirect('admin/teams')->withStatus('no team have this id');
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

        $team = team::find($id);

        $rules = [
            'arab_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'eng_name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'arab_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'eng_description' => ['nullable','min:2','not_regex:/([%\$#\*<>]+)/'],
            'role_id' => 'required|integer|min:0',
        ];

        $this->validate($request, $rules);

        $arab_name = $request->input('arab_name');

        $eng_name = $request->input('eng_name');

        $arab_description = $request->input('arab_description');

        $eng_description = $request->input('eng_description');

        $user = auth()->user();

        if($team)
        {
            $team->update([
                'arab_name' => $arab_name,
                'eng_name' => $eng_name,
                'arab_description' => $arab_description,
                'eng_description' => $eng_description,
                'role_id' => $request->role_id,
                'updated_by' => $user->id,
            ]);
            return redirect('/admin/teams')->withStatus('team successfully updated.');
        }
        else
        {
            return redirect('/admin/team')->withStatus('no team exist');
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
        $team = Team::find($id);

        if($team)
        {
            $team->delete();
            return redirect('/admin/teams')->withStatus(__('teams successfully deleted.'));
        }
        return redirect('/admin/teams')->withStatus(__('this id is not in our database'));
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
