<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminExport;
use App\Http\Controllers\Controller;
use App\Imports\AdminImport;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Role;
use App\User;

class AdminController extends Controller
{

    function __construct()
    {
        //$this->middleware('permission:admin-list', ['only' => ['index']]);
        // $this->middleware('permission:admin-create', ['only' => ['create','store']]);
        // $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $admins = User::where('flag',0)->orderBy('id', 'desc')->get();

        return view('Admin.admins.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $roles = Role::whereNotIn('eng_name',['delivery','driver'])->get();
        return view('Admin.admins.create',compact('roles'));
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
            'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable()), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
            'password' => ['required', 'min:8', 'confirmed','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
            'password_confirmation' => ['required', 'min:8'],
            'roles' => 'required',
            'team_id' => 'required|integer|min:0',
        ];

        $this->validate($request,$rules);


        $team = Team::find($request->team_id);

        $teamrole = $team->role()->pluck('id')->all();

        $admin = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'team_id' => $request->team_id,
            'created_by' => $user->id


        ]);

        $admin->assignRole([$request->input('roles'),$teamrole[0]]);

        if($admin)
        {
            return redirect('admin/admins')->withStatus('admin successfully created');
        }
        else
        {
            return redirect('admin/admins')->withStatus('something went wrong, try again');
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

        $admin = User::find($id);
        return view('Admin.admins.show',compact('admin'));
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

        $admin = User::find($id);
        $roles = Role::whereNotIn('eng_name',['delivery','driver'])->get();
        $userRole = $admin->roles->pluck('name','name')->all();

        if($admin)
        {
            return view('Admin.admins.create', compact('admin','roles','userRole'));
        }
        else
        {
            return redirect('admin/admins')->withStatus('no product have this id');
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

        $admin = User::find($id);

        if($request->input('password') == null )
        {
            $rules = [
                'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($admin->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
                'roles' => 'required',
                'team_id' => 'required|integer|min:0',
            ];

            $this->validate($request,$rules);


            if($admin)
            {

                $admin->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'team_id' => $request->team_id,
                    'updated_by' => $user->id
                ]);

                DB::table('model_has_roles')->where('model_id',$id)->delete();

                $team = Team::find($request->team_id);

                $teamrole = $team->role()->pluck('id')->all();

                $admin->assignRole($request->input('roles'),$teamrole[0]);
                return redirect('/admin/admins')->withStatus('admin information successfully updated.');
            }
            else
            {
                return redirect('admin/admins')->withStatus('no admin with this id');
            }
        }
        else {
            $rules = [
                'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($admin->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
                'password' => ['required', 'min:8', 'confirmed', 'different:old_password', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
                'password_confirmation' => ['required', 'min:8'],
                'roles' => 'required',
                'team_id' => 'required|integer|min:0',
            ];

            $this->validate($request,$rules);


            $password = password_hash($request->password,PASSWORD_DEFAULT);


                if($admin)
                {

                    $admin->update([

                        'name' => $request->name ,
                        'email' => $request->email ,
                        'password' => $password,
                        'team_id' => $request->team_id,
                        'updated_by' => $user->id

                    ]);

                    DB::table('model_has_roles')->where('model_id',$id)->delete();

                    $admin->assignRole($request->input('roles'));
                    return redirect('/admin/admins')->withStatus('admin information successfully updated.');
                }
                else
                {
                    return redirect('admin/admins')->withStatus('no admin with this id');
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
        $admin = User::find($id);

        if($admin)
        {
            $admin->delete();
            return redirect('/admin/admins')->withStatus(__('Admin successfully deleted.'));
        }
        return redirect('/admin/admins')->withStatus(__('this id is not in our database'));
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
            'file' => 'mimes:csv|max:2048'
        ];

        $this->validate($request,$rules);


        Excel::import(new AdminImport ,$request->file('file'));

        return back();
    }

}
