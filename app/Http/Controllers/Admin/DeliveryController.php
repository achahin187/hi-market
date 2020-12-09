<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Team;
use App\Models\DeliveryCompany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\User;
use DB;

class DeliveryController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:delivery-list', ['only' => ['index']]);
        $this->middleware('permission:delivery-create', ['only' => ['create','store']]);
        $this->middleware('permission:delivery-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:delivery-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery = User::role(['driver'])->orderBy('id', 'desc')->get();

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
        $companies = DeliveryCompany::all();
        return view('Admin.delivery.create',compact('roles','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

//dd($request->all());
       $request->validate([

        'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
        'email' => ['required', 'email', Rule::unique((new User)->getTable()), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
        'password' => ['required', 'min:8', 'max:50'],
        'company_id' => ['required'],

       ]);


        $driver = User::create(request()->all());
    
        $role = Role::where('name','driver' )->first();
        
        $assignRole = $driver->assignRole($role);

        $Permissions = $role->permissions;
            
       
        return redirect('admin/delivery')->withStatus(trans('admin.successfully_created'));
        

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
        
        $companies = DeliveryCompany::all();

        if($driver)
        {
            return view('Admin.delivery.create', compact('driver','companies'));
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
       
        $driver = User::find($id);

        if ($driver) {
            
            $request->validate([
                'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($driver->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
              
                'company_id' => ['required'],

            ]); 

            $request_data = $request->all();
            
            if ($request->password == null) {
                 $request_data = $request->except('password');
             }
            
            $driver->update($request_data);

            return redirect('/admin/delivery')->withStatus(trans('admin.update_successfully'));
        }else{

            return redirect('/admin/delivery')->withStatus(trans('admin.not_id'));
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
