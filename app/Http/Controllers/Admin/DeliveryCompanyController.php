<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\DeliveryCompany;
use App\Models\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeliveryCompanyController extends Controller
{
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
            "name_ar" => "required",
            "name_en" => "required",
            "email" => ["required", "email", 'unique:delivery_companies'],
            "phone_number.0" => "required|digits:11",
            "commission" => "required|integer",
            //"branch_id" => "required"
        ]);

        $request_data = $request->all();
        // $request_data['phone_number'] = array_filter($request->phone_number);

        // $company = DeliveryCompany::create($request_data);
        // $company->branches()->sync($request_data["branch_id"]);
        $this->storeCompanyClient($request);
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
            $delivery = DeliveryCompany::find($id);
            $delivery->delete();
            return redirect()->route("delivery-companies.index")->withStatus("deleted");
        } catch (\Exception $e) {
            return redirect()->route("delivery-companies.index")->withStatus("Something Went Wrong");
        }
    }

    private function storeCompanyClient($request)
    {   
        
       Client::updateOrCreate([
            'name' => $request->name_en,
            'email' => $request->email,
            'password' => $request->phone_number[0],
            'verify' => 0,
            'comany_topic' => $request->name_en,
       ]);
    }
}
