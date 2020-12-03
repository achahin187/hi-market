<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
class DeliveryManagerController extends Controller
{
      public $model;

    public function __construct()
    {
        $this->model = 'App\User' ;
        $this->blade = 'Admin.delivery_admin.' ;
        $this->route = 'delivery-admins.' ;

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
         $delivery_admins = $this->model::Role('delivery_admin')->get();


        
        return view($this->blade.'.index')->with('delivery_admins',$delivery_admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view($this->blade.__FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|string',
            'email' =>'required|email|unique:users',
            'password' =>'required|min:8',
            
        ]);
        
        $user = $this->model::create(request()->all());
    
        $role = Role::where('name','delivery_admin' )->first();
        
        $assignRole = $user->assignRole($role);

        $Permissions = $role->permissions;
            
        $user->givePermissionTo($Permissions);
        
        return redirect()->route($this->route.'index');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $delivery = $this->model::find($id);
       
        return view($this->blade.__FUNCTION__,compact("delivery"));
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
         $request->validate([
            'name' =>'required|string',
            'email' =>'required|email',
        ]);
        $delivery = $this->model::find($id);
        $delivery->update(request()->all());

        return redirect()->route($this->route.'index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $delivery_admin = User::find($id);
        if ($delivery_admin) {
            $delivery_admin->delete();
            return redirect()->route($this->route.'index');
        }else{
            return redirect()->route($this->route.'index');
        }
    }
}
