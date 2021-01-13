<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Supermarket;
use App\Notifications\SendNotification;
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

        $this->middleware('permission:offer-list', ['only' => ['index']]);
        $this->middleware('permission:offer-create', ['only' => ['create','store']]);
        $this->middleware('permission:offer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:offer-delete', ['only' => ['destroy']]);
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
            'start_date' =>'required|after:yesterday',
            'end_date' =>'required|after:start_date',
            'banner' =>'required',
            'promocode_name' =>'unique:offers,promocode_name',
           // 'banner2' =>'required',
            
        ]);

        $request_data = $request->all();
          if ($request->banner) {
                #Store Banner to DataBase banner...
                $filename = $request->banner->getClientOriginalName();
                $fileextension = $request->banner->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                $request->banner->move('offer_images', $file_to_store);

                $request_data['banner'] = $file_to_store;
                
          }//end if

          if ($request->banner2) {
           
                #Store Banner to DataBase banner2...
                $filename2 = $request->banner2->getClientOriginalName();
                $fileextension2= $request->banner2->getClientOriginalExtension();
                $file_to_store2 = time() . '_' . explode('.', $filename2)[0] . '_.' . $fileextension2;

                $request->banner2->move('offer_images', $file_to_store2);
         
                $request_data['banner2'] = $file_to_store2;

          }//end if


         


        switch ($request->type) {
            case 'promocode':

                    if($request['promocode_type'] == 'Percentage' && ($request['value'] > 100 
                      ||  $request['value'] <= 0))
                      {
                          return redirect()->route($this->route.'index')->withStatus("Percentage value must be between 0 : 100");
                      }else{

                         $this->createPromocode($request_data);

                      }

                break;

            case 'product Offer':
               $this->createProductOffer($request_data);
                break;

            case 'free delivery':
               $this->createFreeProduct($request_data);
                //new SendNotification('topics', '', $data);  
                break;

            case 'point':
               $this->createPoint($request_data);
                //new SendNotification('topics', '', $data);  
                break;    
            
            default:
                # code...
                break;
        }
     
               
             // new SendNotification('topics', '', $data);  
        return redirect()->route($this->route.'index')->withStatus(__('admin.created_successfully'));
    }

   
    /**
     * Display the specified resource.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    private function createPromocode($request, $data)
    {    
        $request_data = collect($request)->except('branch_id');

        $create_promocode =   $this->model::create($request_data->toArray());
                
        $data =  [
          "type" => "Deal",
          "product_id" => $request_data['product_id'] ?? null,
          "superMarket_id" => $request_data['branch_id']??null,
        ];
        

        if ($request['source'] == 'Branch') {

            $create_promocode->branches()->attach($request['branch_id']);

            foreach ($request['branch_id'] as $branch) {
              $branch_name = Branch::Where('id',$branch)->first();
              $topic = $branch_name->area->polygon->first()->topic;
                if ($topic) {
                  new SendNotification($topic, '', $data, 'Topic'); 
                }
             } 

        }else{
           new SendNotification('Deals', '', $data); 
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
    * free delivery 
    * @param  array  $request
    * @return \Illuminate\Http\Response
    */
    private function createFreeProduct($request)
    {   
        $free_delivery = $this->model::where('type', 'free delivery')->first();
        if ($free_delivery) {
            $free_delivery->update($request);
         }else{
            $create_promocode = $this->model::create($request);
         } 
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
        if ($request['source'] == 'Branch') {
              $create_promocode->branches()->attach($request['branch_id']);
          
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
         $offer         = $this->model::find($id);
         $supermarkets  = Supermarket::all();
         $branches      = Branch::all();
         $products      = Product::all();
       
        return view($this->blade.__FUNCTION__,compact("offer", 'supermarkets', 'branches', 'products'));
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
            'type' =>'required',
            'start_date' =>'required',
            'end_date' =>'required',
           
        ]);

        $offer = $this->model::find($id);

        $request_data = $request->all();
        
          if ($request->banner) {
            if ($offer->banner != $request->banner) {
                unlink( base_path('public/offer_images/'.$offer->banner) );
               
            }

                #Store Banner to DataBase...
                $filename = $request->banner->getClientOriginalName();
                $fileextension = $request->banner->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                $request->banner->move('offer_images', $file_to_store);

                $request_data['banner'] = $file_to_store;
          }

          if ($request->banner2) {
            if ($offer->banner2 != $request->banner2) {
              //dd( base_path('offer_images/'.$offer->banner2) );
                unlink( base_path('public/offer_images/'.$offer->banner2) );
               
            }

                #Store Banner to DataBase...
                $filename2 = $request->banner2->getClientOriginalName();
                $fileextension2 = $request->banner2->getClientOriginalExtension();
                $file_to_store2 = time() . '_' . explode('.', $filename2)[0] . '_.' . $fileextension2;

                $request->banner2->move('offer_images', $file_to_store2);

                $request_data['banner2'] = $file_to_store2;
          }


           

        switch ($request->type) {
            case 'promocode':
               $this->editPromocode($request_data, $offer);
                break;

            case 'product Offer':
               $this->editProductOffer($request_data, $offer);
                break;

            case 'free product':
               $this->editFreeProduct($request_data, $offer);
                break;

            case 'point':
               $this->editPoint($request_data, $offer);
                break;    
            
            default:
                # code...
                break;
        }
     
                $data =  [
                  "type" => "Deal",
                  "product_id" => $request_data['product_id'] ?? null,
                  "superMarket_id" => $request_data['branch_id']??null,
                 ];

           
         new SendNotification('topics', '', $data);  
        return redirect()->route($this->route.'index')->withStatus(__('admin.update_successfully'));;
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $request
     * @return \Illuminate\Http\Response
     */
    private function editPromocode($request, $offer)
    {   
        
        $request_data = collect($request)->except('branch_id');
        
        $create_promocode =   $offer->update($request_data->toArray());

        if ($request['source'] == 'Branch') {
          
            $offer->branches()->sync($request['branch_id']);
            // $get_branches = Branch::WhereIn('id',$request['branch_id'])->get();
            // foreach ($get_branches as  $branch) {
            //  $update_offer = $branch->update(['offer_id'=> $create_promocode->id]);
            // }

         } //else{

        //     //$create_promocode->attach()
        //     $allBranches =  Branch::all(); 
        //     foreach ($allBranches as  $allBranche) {
        //         $update_offer = $allBranche->update(['offer_id'=> $offer->id]);
        //     }
        // }
    }
    /**
    * Display the specified resource.
    *
    * @param  array  $request
    * @return \Illuminate\Http\Response
    */
    private function editProductOffer($request, $offer)
    {
        $create_promocode = $offer->update($request);
    }
    /**
    * Display the specified resource.
    *
    * @param  array  $request
    * @return \Illuminate\Http\Response
    */
    private function editFreeProduct($request, $offer)
    {
        $create_promocode = $offer->update($request);
    }
    /**
    * Display the specified resource.
    *
    * @param  array  $request
    * @return \Illuminate\Http\Response
    */
    private function editPoint($request, $offer)
    { 
        $request_data     = collect($request)->except('branch_id');
        $create_promocode =   $offer->update($request_data->toArray());
        if ($request['source'] == 'Branch') {
      
              $offer->branches()->sync($request['branch_id']);
            // $get_branches = Branch::WhereIn('id',$request['branch_id'])->get();

            //     foreach ($get_branches as  $branch) {
            //      $update_offer = $branch->update(['offer_id'=> $create_promocode->id]);
            //     }
         }//else{
        //     $allBranches =  Branch::all(); 
        //     foreach ($allBranches as  $allBranche) {
                
        //         $update_offer = $allBranche->update(['offer_id'=> $offer->id]);
        //     }  
        // }      


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
            return redirect()->route($this->route.'index')->withStatus(__('Deleted Successfully'));

        }else{
            
            return redirect()->route($this->route.'index')->withStatus(__(' This Id Not Found '));
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
