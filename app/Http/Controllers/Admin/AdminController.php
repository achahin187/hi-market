<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\User;

class AdminController extends Controller
{


    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $admins = User::orderBy('id', 'desc')->paginate(10);
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
        $roles = Role::pluck('name','name')->all();
        return view('Admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable()), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
            'password' => ['required', 'min:8', 'confirmed','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
            'password_confirmation' => ['required', 'min:8'],
            'roles' => 'required'
        ];

        $this->validate($request,$rules);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $admin = User::create($input);
        $admin->assignRole($request->input('roles'));


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
        $roles = Role::pluck('arab_name','arab_name')->all();
        $userRole = $admin->roles->pluck('arab_name','arab_name')->all();

        if($admin)
        {
            return view('Admin.admins.create', compact('admin'));
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

        $admin = User::find($id);

        if($request->input('password') == null )
        {
            $rules = [
                'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($admin->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/']
            ];

            $this->validate($request,$rules);

            if($admin->update(['name' => $request->name , 'email' => $request->email]))
            {
                return redirect('/admin/admins')->withStatus('admin information successfully updated.');
            }
            else
            {
                return redirect('admin/admins')->withStatus('no information updated');
            }
        }
        else {
            $rules = [
                'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($admin->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
                'password' => ['required', 'min:8', 'confirmed', 'different:old_password', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
                'password_confirmation' => ['required', 'min:8']
            ];

            $this->validate($request,$rules);


            $password = password_hash($request->password,PASSWORD_DEFAULT);


                if($admin->update(['name' => $request->name , 'email' => $request->email , 'password' => $password]))
                {
                    return redirect('/admin/admins')->withStatus('admin information successfully updated.');
                }
                else
                {
                    return redirect('admin/admins')->withStatus('no information updated');
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

}
