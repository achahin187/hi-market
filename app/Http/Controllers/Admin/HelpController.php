<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Help;
class HelpController extends Controller
{
    public $model;
    public $blade;
    public $route;

    public function __construct()
    {
        $this->model = 'App\Models\Help' ;
        $this->blade = 'Admin.helps.' ;
        $this->route = 'helps.' ;

        // $this->middleware('permission:delivery-list', ['only' => ['index']]);
        // $this->middleware('permission:delivery-create', ['only' => ['create','store']]);
        // $this->middleware('permission:delivery-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:delivery-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $helps = $this->model::all();
        
        return view($this->blade.'.index')->with('helps',$helps);
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
            'title_ar' =>'required|string',
            'title_en' =>'required|string',
            'description_ar' =>'required',
            'description_en' =>'required',
            'image' =>'required',
            
        ]);
        $request_data  = $request->except('image');

        if ($request->image) {
            
            $filename = $logoimage->getClientOriginalName();
            $fileextension = $logoimage->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;
            $logoimage->move('help_images', $file_to_store);  
            $request_data['image'] = $file_to_store;         
        }        
        $user = $this->model::create($request_data);
        
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
         $help = $this->model::find($id);
       
        return view($this->blade.__FUNCTION__,compact("help"));
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
            'title' =>'required|string',
            'describtion' =>'required',
            'image' =>'required',
            
        ]);

        $help = $this->model::find($id);
        $request_data = $request->except('image');
        
        if ($request->image) {
             if ($help->image != null) {

                    unlink('help_images/' . $help->image);
                }
            $request_data['image'] = $request->image;
           
         }

        $help->update($request_data);

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
          $help = $this->model::find($id);
        if ($help) {
            $help->delete();
            return redirect()->route($this->route.'index');
        }else{
            return redirect()->route($this->route.'index');
        }
    }
}
