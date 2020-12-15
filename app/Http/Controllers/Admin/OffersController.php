<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Supermarket;
class OffersController extends Controller
{


    public $model;
    public $blade;
    public $route;

    public function __construct()
    {
        $this->model = 'App\Models\Offer' ;
        $this->blade = 'Admin.offers.' ;
        $this->route = 'offers.' ;

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
         $offers = $this->model::orderBy('id', 'desc')->get();
        
        return view($this->blade.'.index')->with('offers',$offers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supermarkets = Supermarket::Where('status', 'active')->get();
        $products_offer = Product::Where('flag', 1)->Where('status','active')->get();
        $branches  = Branch::Where('status','active')->get();
        return view($this->blade.__FUNCTION__,compact('supermarkets', 'products_offer', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   dd(collect($request->all())->keys());
        $request->validate([
            'source' =>'required|string',
            'supermarket_id' =>'required|email|unique:users',
            'branch_id' =>'required|min:8',
            'promocode_name' =>'required|min:8',
            'promocode_type' =>'required|min:8',
            'discount_on' =>'required|min:8',
            'value' =>'required|min:8',
            'start_offer_date' =>'required|min:8',
            'end_offer_date' =>'required|min:8',
            'banner' =>'required|min:8',
            
        ]);
        
        $user = $this->model::create(request()->all());
    
        $role = Role::where('name','delivery_admin' )->first();
        
        $assignRole = $user->assignRole($role);

        $Permissions = $role->permissions;
            
        //$user->givePermissionTo($Permissions);
        
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

        $request_data = $request->all();
        
        if ($request->password == null) {
             $request_data = $request->except('password');
         }

        $delivery = $this->model::find($id);
        $delivery->update($request_data);

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
