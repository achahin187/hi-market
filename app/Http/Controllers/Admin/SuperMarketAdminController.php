<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
class SuperMarketAdminController extends Controller
{

    public $model;

    public function __construct()
    {
        $this->model = 'App\User' ;
        $this->blade = 'Admin.supermarket_admin.' ;
        $this->route = 'supermarket-admins.' ;

        $this->middleware('permission:supermarket-list', ['only' => ['index']]);
        $this->middleware('permission:supermarket-create', ['only' => ['create','store']]);
        // $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supermarket_admins = $this->model::Role('supermarket admin')->get();

    
        return view('Admin.supermarket_admin.index')->with('supermarket_admins',$supermarket_admins);
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
            'email' =>'required|email',
            'password' =>'required|min:8',
            
        ]);
        
        $user = $this->model::create(request()->all());
    
        $role = Role::where('name','supermarket admin' )->first();

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
        $supermarket = $this->model::find($id);
        return view($this->blade.__FUNCTION__,compact("supermarket"));
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
        ]);;
        $supermarket = $this->model::find($id);
        $supermarket->update(request()->all());

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
        $supermarket_admin = User::find($id);
        if ($supermarket_admin) {
            $supermarket_admin->delete();
            return redirect()->route($this->route.'index');
        }else{
            return redirect()->route($this->route.'index');
        }
    }
}
