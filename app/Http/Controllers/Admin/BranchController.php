<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Supermarket;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\Category;
class BranchController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:branches-list', ['only' => ['index','supermarketbranches']]);
        $this->middleware('permission:branches-create', ['only' => ['create','store']]);
        $this->middleware('permission:branches-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:branches-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $branches = Branch::orderBy('id', 'desc')->has("city")->get();
        return view('Admin.branches.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($supermarket_id = null)
    {
        //
        if($supermarket_id != null) {


            return view('Admin.branches.create',compact('supermarket_id'));
        }
        else {
            return view('Admin.branches.create');
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$supermarket_id = null)
    {   
     

        $request->validate([
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'status' => ['required','string'],
            'supermarket_id' => ['required ',' integer','min:0'],
            'image' => ['required','image ',' mimes:jpeg,png,jpg','max:2048'],
            'logo_image'  => ['required','image ',' mimes:jpeg,png,jpg','max:2048'],
            'commission' => ['required','min:0','numeric'],
            'categories' => ['required','array'],
            'rating' => ['required','min:1','max:5'],
            'priority' => ['required','min:1','integer'],
            'area_id' => ['integer','min:0'],
            'city_id' => ['integer','min:0'],
            'country_id' => ['integer','min:0'],
            'start_time' => ['required','string','different:end_time'],
            'end_time' => ['required','string','different:start_time'],        
        ]);

        $arab_name = $request->input('name_ar');

        $eng_name = $request->input('name_en');

        $status = $request->input('status');

        $supermarket = $request->input('supermarket_id');


        $commission = $request->input('commission');

        $priority = $request->input('priority');


        if($image = $request->file('image'))
        {
            $filename = $image->getClientOriginalName();
            $fileextension = $image->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

        
            $image->move('branche_image', $file_to_store);
        }
        
        if($logoimage = $request->file('logo_image'))
        {

            $filename = $logoimage->getClientOriginalName();
            $fileextension = $logoimage->getClientOriginalExtension();
            $logo = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

            $logoimage->move('branche_image', $logo);

        }

            $branch = Branch::create([

                'name_ar'        => $arab_name,
                'name_en'        => $eng_name,
                'status'         => $status,
                'supermarket_id' => $supermarket,
                'image'          => $file_to_store,
                'logo'           => $logo,
                'priority'       => $priority,
                'commission'     => $commission,
                'start_time'     => $request->start_time,
                'end_time'       => $request->end_time,
                'area_id'        => $request->area_id,
                'city_id'        => $request->city_id,
                'rating'         => $request->rating,
               
            ]);

            $branch->categories()->sync($request->categories);
        
      

        if($branch)
        {
            if($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus(__('supermarket branch created successfully'));
            }
            else
            {
                return redirect('admin/branches')->withStatus(__('branch created successfully'));
            }
        }
        else
        {

            if ($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus(__('supermarket branch not created'));
            }
            else
            {
                return redirect('admin/branches')->withStatus(__('something wrong happened in branch creation '));
            }
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
    public function edit($id,$supermarket_id = null)
    {
       
        $branch = Branch::find($id);

        if($branch)
        {

            $supermarket = Branch::find($id);
            $category_ids = [];
            foreach ($supermarket->categories as $category)
            {
                $category_ids[] = $category->id;
            }


            if($supermarket_id != null)
            {
                return view('Admin.branches.create', compact('branch','supermarket_id'));
            }
            else {
                return view('Admin.branches.create', compact('branch','category_ids'));
            }
        }
        else
        {
            if($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus('no branch have this id');
            }
            else {
                return redirect('admin/branches')->withStatus('no branch have this id');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$supermarket_id = null)
    {   
        //dd($request->all());
        
           $request->validate([
            'name_ar' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'name_en' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'status' => ['required','string'],
            'supermarket_id' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'logo_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'commission' => ['required','min:1','numeric'],
            'categories' => ['required'],
            'rating' => ['required','min:1','max:5'],
            'priority' => ['required','min:1','integer'],
            'area_id' => 'integer|min:0',
            'city_id' => 'integer|min:0',
            'country_id' => 'integer|min:0',
             'start_time' => ['required','string','different:end_time'],
            'end_time' => ['required','string','different:start_time'], 

        ]);

    

        $branch = Branch::find($id);

        if($branch) {

            if ($file = $request->file('image')) {

               

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

                if ($file->move('branche_image', $file_to_store)) {
                    if ($branch->image != null) {

                        unlink('branche_image/' . $branch->image);
                    }
                }
                $branch->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'supermarket_id' => $request->supermarket_id,
                'image' => $file_to_store,
                'priority' => $request->priority,
                'status' => $request->status,
                'commission' => $request->commission,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'rating' => $request->rating,
                'city_id' => $request->city_id,
                'area_id' => $request->area_id,
              
            ]);

                   $branch->categories()->sync($request->categories);

            } else {

                if ($request->has('checkedimage')) {
                    $branch->update([
                        'name_ar' => $request->name_ar,
                        'name_en' => $request->name_en,
                        'supermarket_id' => $request->supermarket_id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'image' => $request->input('checkedimage'),
                        'city_id' => $request->city_id,
                        'area_id' => $request->area_id,
                    ]);
                       $branch->categories()->sync($request->categories);
                } else {
                    if ($branch->image != null) {
                        unlink('branche_image/' . $branch->image);
                    }
                    $branch->update([
                        'name_ar' => $request->name_ar,
                        'name_en' => $request->name_en,
                        'supermarket_id' => $request->supermarket_id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'city_id' => $request->city_id,
                        'area_id' => $request->area_id,
                        'image' => null]);
                       $branch->categories()->sync($request->categories);
                }
            }

            /*logo*/
            if ($logoimage = $request->file('logo_image') ) {

                 $filename = $logoimage->getClientOriginalName();
                $fileextension = $logoimage->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' . $fileextension;

             if ($logoimage->move('branche_image', $file_to_store)) {
                    if ($branch->logo != null) {

                        unlink('branche_image/' . $branch->logo);
                    }
                }

                $branch->update([
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'supermarket_id' => $request->supermarket_id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'logo' => $file_to_store,
                    'city_id' => $request->city_id,
                    'area_id' => $request->area_id,
            ]);
                   $branch->categories()->sync($request->categories);
              }else {

                if ($request->has('checkedlogo')) {

                    $branch->update([
                        'name_ar' => $request->name_ar,
                        'name_en' => $request->name_en,
                        'supermarket_id' => $request->supermarket_id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'logo' => $request->input('checkedlogo'),
                        'city_id' => $request->city_id,
                        'area_id' => $request->area_id,
                 ]);
                       $branch->categories()->sync($request->categories);
                } else {
                    if ($branch->logo != null) {
                        unlink('branche_image/' . $branch->logo);
                    }
                    $branch->update([
                        'name_ar' => $request->name_ar,
                        'name_en' => $request->name_en,
                        'supermarket_id' => $request->supermarket_id,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time,
                        'logo' => null,
                        'city_id' => $request->city_id,
                        'area_id' => $request->area_id,
                ]);
                       $branch->categories()->sync($request->categories);
                }
            }

                if($supermarket_id != null)
                {
                    return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus('supermarket branch updated successfully');
                }
                else {
                    return redirect('admin/branches')->withStatus('branch updated successfully');
                }
        }


        else
        {
            if($supermarket_id != null)
            {
                return redirect('admin/supermarkets/branches/'.$supermarket_id)->withStatus('no branch have this id');
            }
            else {
                return redirect('admin/branches')->withStatus('no branch have this id');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$supermarket_id = null)
    {
        //
        $branch = Branch::find($id);

        if($branch)
        {

            if($branch->image != null) {
                unlink('branche_image/' . $branch->image);
            }

            $branch->delete();

            if($supermarket_id != null)
            {
                return redirect()->back()->withStatus(__('supermarket branch deleted successfully'));
            }
            else {
                return redirect()->back()->withStatus(__('branch deleted successfully'));
            }
        }
        else {
            if ($supermarket_id != null) {
                return redirect()->back()->withStatus(__('no branch with this id in the supermarket'));
            }
            else {
                return redirect()->back()->withStatus(__('no branch with this id'));
            }
        }
    }

    public function status(Request $request,$id)
    {

        $branch = Branch::find($id);

        if($branch)
        {
            if($branch->status == 'active') {
                $branch->update(['status' => 'inactive']);
            }
            else
            {
                $branch->update(['status' => 'active']);
            }
            return redirect()->back()->withStatus(__('branch status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }

    public function supermarketbranches($supermarket_id)
    {
        
        $branches = Branch::where('supermarket_id',$supermarket_id)->orderBy('id', 'desc')->get();
        return view('Admin.branches.index',compact('branches','supermarket_id'));
    }

    public function getVendorCategories(Request $request)
    {
        $categories = Vendor::WhereHas('categories', function ($q) use($request){

            $q->Where('category_id',$request->vendor_id);

        })->get();
        
        return response()->json($categories);
    }
}
