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
        $this->route = 'offer.' ;

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
    {   
        $request->validate([
            'type' =>'required',
            'start_date' =>'required|min:8',
            'end_date' =>'required|min:8',
            'banner' =>'required|min:8',
        ]);

        $request_data = $request->all();

        switch ($request->type) {
            case 'promocode':
               $this->createPromocode($request_data);
                break;

            case 'product Offer':
               $this->createProductOffer($request_data);
                break;

            case 'free product':
               $this->createFreeProduct($request_data);
                break;

            case 'point':
               $this->createPoint($request_data);
                break;    
            
            default:
                # code...
                break;
        }
       
            
        return redirect()->route($this->route.'index');
    }

   
    /**
     * Display the specified resource.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    private function createPromocode($request)
    {  
        $request_data = collect($request)->except('branch_id');
        
        $create_promocode =   $this->model::create($request_data->toArray());

        if ($request['source'] == 'Branch') {
        
            $get_branches = Branch::WhereIn('id',$request['branch_id'])->get();

            foreach ($get_branches as  $branch) {

             $update_offer = $branch->update(['offer_id'=> $create_promocode->id]);
            }

        }else{
            $allBranches =  Branch::all(); 
            foreach ($allBranches as  $allBranche) {
                
                $update_offer = $allBranche->update(['offer_id'=> $create_promocode->id]);
            }
        }
    }
    /**
    * Display the specified resource.
    *
    * @param  array  $request
    * @return \Illuminate\Http\Response
    */
    private function createProductOffer($request)
    {
        $create_promocode = $this->model::create($request);
    }
    /**
    * Display the specified resource.
    *
    * @param  array  $request
    * @return \Illuminate\Http\Response
    */
    private function createFreeProduct($request)
    {
        $create_promocode = $this->model::create($request);
    }
    /**
    * Display the specified resource.
    *
    * @param  array  $request
    * @return \Illuminate\Http\Response
    */
    private function createPoint($request)
    {
        $request_data     = collect($request)->except('branch_id');

        $create_promocode =   $this->model::create($request_data->toArray());

        $get_branches = Branch::WhereIn('id',$request['branch_id'])->get();

        foreach ($get_branches as  $branch) {

         $update_offer = $branch->update(['offer_id'=> $create_promocode->id]);
         
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
          $offer = $this->model::find($id);
        if ($offer) {
            $offer->delete();
            return redirect()->route($this->route.'index')->withStatus(__('Deleted Successfully'));;
        }else{
            return redirect()->route($this->route.'index')->withStatus(__(' This Id Not Found '));;
        }
    }

    public function changeStatus(Request $request)
    {
        $request_data = $request->status;
        $offer  = $this->model::find($request->id);
        $offer->update(['status' => $request_data == 0 ? 1 :0 ]);

        return redirect()->route($this->route.'index')->withStatus(__('status Changed Successfully')); 
    }
}
