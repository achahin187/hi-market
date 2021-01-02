<?php

namespace App\Http\Controllers\Admin;


use App\Models\Financial;
use App\Models\Payable;
use App\Models\Receivable;
use App\Models\Order;
use App\Models\Branch;
use App\Models\DeliveryCompany;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Flash;
use Response;

class FinancialController extends Controller
{
    public $model;
    public $blade;
    public $route;

    public function __construct()
    {
        $this->model = 'App\Models\Financial' ;
        $this->blade = 'Admin.financials.' ;
        $this->route = 'financials.' ;

        $this->middleware('permission:delivery-list', ['only' => ['index']]);
        $this->middleware('permission:delivery-create', ['only' => ['create','store']]);
        $this->middleware('permission:delivery-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:delivery-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the Financial.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $branches = Branch::WhereHas('orders')->get();
        $companies = DeliveryCompany::WhereHas('orders')->get();

         return view($this->blade.__FUNCTION__, compact('branches', 'companies'));
      
    }

    /**
     *  Display a listing of the Company Orders.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\
     */
    public function ShowCompanyOrders($id)
    {
        $orders  = Order::where('company_id', $id)->whereIn('status', [5,4])->get();
        $company = DeliveryCompany::find($id);
        return view('Admin.financials.company_details', compact('orders', 'company') );
    }

    /**
     * Show the form for creating a new Financial.
     *
     * @return Response
     */
    public function create()
    {
        return view('Admin.financials.create');
    }

    /**
     * Store a newly created Financial in storage.
     *
     * @param CreateFinancialRequest $request
     *
     * @return Response
     */
    public function store(CreateFinancialRequest $request)
    {
        $input = $request->all();

        $financial = $this->financialRepository->update($input,$request->restaurant_id);

        Flash::success(__('messages.saved', ['model' => __('models/financials.singular')]));

        return redirect(route('Admin.financials.index'));
    }

    /**
     * Display the specified Financial.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $financial = $this->financialRepository->find($id);

        if (empty($financial)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financials.singular')]));

            return redirect(route('financials.index'));
        }

        return view('Admin.financials.show')->with('financial', $financial);
    }

    /**
     * Show the form for editing the specified Financial.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $financial = $this->financialRepository->find($id);

        if (empty($financial)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financials.singular')]));

            return redirect(route('financials.index'));
        }

        return view('Admin.financials.edit')->with('financial', $financial);
    }

    /**
     * Update the specified Financial in storage.
     *
     * @param int $id
     * @param UpdateFinancialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFinancialRequest $request)
    {
        $financial = $this->financialRepository->find($id);

        if (empty($financial)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financials.singular')]));

            return redirect(route('financials.index'));
        }

        $financial = $this->financialRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/financials.singular')]));

        return redirect(route('financials.index'));
    }

    /**
     * Remove the specified Financial from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $financial = $this->financialRepository->find($id);

        if (empty($financial)) {
            Flash::error(__('messages.not_found', ['model' => __('models/financials.singular')]));

            return redirect(route('financials.index'));
        }

        $this->financialRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/financials.singular')]));

        return redirect(route('financials.index'));
    }

   
}
