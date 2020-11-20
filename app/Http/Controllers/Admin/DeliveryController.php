<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\User;
use DB;

class DeliveryController extends Controller
{


/*    public function __construct() {
        $this->middleware('auth');
        $this->middleware('permission:admin-list|admin-create|admin-edit|admin-delete', ['only' => ['index','show']]);
        $this->middleware('permission:admin-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery = User::role(['delivery','driver'])->orderBy('id', 'desc')->get();

        return view('Admin.delivery.index',compact('delivery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereIn('eng_name',['driver'])->get();
        return view('admin.delivery.create',compact('roles'));
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
            'password' => ['required', 'min:8', 'confirmed', 'max:50'],

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
            return redirect('admin/delivery')->withStatus(trans('admin.successfully_created'));
        }
        else
        {
            return redirect('admin/delivery')->withStatus(trans('admin.something went wrong, try again'));
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = User::find($id);
        $roles = Role::Wherein('name', ['delivery', 'driver'])->get();

        $userRole = $driver->roles->pluck('name','name')->all();

        if($driver)
        {
            return view('Admin.delivery.create', compact('driver','roles','userRole'));
        }
        else
        {
            return redirect('admin/delivery')->withStatus(trans('admin.not_id'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user = auth()->user();

        $admin = User::find($id);

        if($request->input('password') == null )
        {
            $rules = [
                'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($admin->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],

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
                return redirect('/admin/delivery')->withStatus(trans('admin.update_successfully'));
            }
            else
            {
                return redirect('admin/delivery')->withStatus(trans('admin.not_id'));
            }
        }
        else {
            $rules = [
                'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($admin->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
                'password' => ['required', 'min:8', 'confirmed', 'different:old_password', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
                'password_confirmation' => ['required', 'min:8'],

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
                return redirect('/admin/delivery')->withStatus(trans('admin.update_successfully'));
            }
            else
            {
                return redirect('admin/delivery')->withStatus(trans('admin.no_id'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = User::find($id);

        if($admin)
        {
            $admin->delete();
            return redirect('/admin/delivery')->withStatus(trans('admin.deleted_successfully'));
        }
        return redirect('/admin/delivery')->withStatus(trans('admin.not_id'));
    }
}
