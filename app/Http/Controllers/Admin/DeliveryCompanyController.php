<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DeliveryCompany;
use App\Models\Client;
use App\Models\City;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeliveryCompanyController extends Controller
{   


    //  function __construct()
    // {
    //     $this->middleware('permission:deliveryCompany-list', ['only' => ['index']]);
    //     $this->middleware('permission:deliveryCompany-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:deliveryCompany-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:deliveryCompany-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return Factory|\Illuminate\View\View
     */
    public function index()
    {
        $deliveryCompanies = DeliveryCompany::paginate();
        return view("Admin.delivery_companies.index", compact("deliveryCompanies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|\Illuminate\View\View
     */
    public function create()
    {
        $branches = Branch::WhereDoesntHave('companies')->get();
      
        return view("Admin.delivery_companies.create", compact("branches"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            "name_ar"        => "required",
            "name_en"        => "required",
            "email"          => "required|email|unique:delivery_companies,email",
            "phone_number.0" => "required|digits:11|unique:delivery_companies,phone_number",
            "commission"     => "required|integer",
            //"branch_id" => "required"
        ]);

        $request_data = $request->all();
        $request_data['phone_number'] = array_filter($request->phone_number);

        $company = DeliveryCompany::create($request_data);

        $company->branches()->sync($request_data["branch_id"]);
        $this->storeCompanyClient($request, $company->id);
        return redirect()->route("delivery-companies.index");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branches = Branch::all();
        $delivery = DeliveryCompany::find($id);
        return view("Admin.delivery_companies.edit", compact("branches", "delivery"))->withStatus("success");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = DeliveryCompany::find($id);

        $request->validate([
            "name_ar" => "required",
            "name_en" => "required",
            'email' => 'required|email|unique:delivery_companies,email,' . $company->id,
            "phone_number.0" => "required|digits:11",
            "commission" => "required|integer",
            "branch_id" => "required|exists:branches,id"
        ]);

        $request_data = $request->all();
        $request_data['phone'] = array_filter($request->phone_number);

        $company->update($request_data);
        $company->branches()->sync($request_data["branch_id"]);
        return redirect()->route("delivery-companies.index")->withStatus("updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $company = DeliveryCompany::find($id);
            $company->delete();
            return redirect()->route("delivery-companies.index")->withStatus("deleted");
        } catch (\Exception $e) {
            return redirect()->route("delivery-companies.index")->withStatus("Something Went Wrong");
        }
    }

    private function storeCompanyClient($request,$company_id)
    {   
        
       Client::updateOrCreate([
            'name' => $request->name_en,
            'email' => $request->email,
            'password' => $request->password,
            'mobile_number' => $request->phone_number[0],
            'company_topic' => $request->name_en,
            'company_id' => $company_id,
            'verify' => 1,
       ]);
    }

    public function get_city_branches(Request $request)
    {
        $branches  = Branch::WhereDoesntHave('companies')->Where('city_id', $request->city_id)->get();
        $countArea = City::Where('id', $request->city_id)->first()->areaList->count();
        $areas = City::Where('id', $request->city_id)->first()->areaList;
    
        return Response()->json(['branches'=>$branches, 'areaCount'=>$countArea, 'areas'=> $areas]);
    }
}
