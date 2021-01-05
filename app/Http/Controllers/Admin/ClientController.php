<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:client-list', ['only' => ['index']]);
        $this->middleware('permission:client-create', ['only' => ['create','store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $clients = Client::orderBy('id', 'desc')->get();

        return view('Admin.clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $user = auth()->user();

        $rules = [
            'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'email' => ['required', 'email', Rule::unique((new Client)->getTable()), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'min:8'],
            'address' => ['required'],
            'mobile_number' => 'required|unique:clients|numeric|digits:11|regex:/(01)[0-9]{9}/',
            //'area_id' => ['required'],
            'status' => ['required','boolean'],
        ];

        $this->validate($request,$rules);

        $name = $request->input('name');

        $email = $request->input('email');

        $password = Hash::make($request->input('password'));

        $address = $request->input('address');

        $mobile_number = $request->input('mobile_number');

        $client = Client::create([

            'name' => $name,
            'email' => $email,
            'password' => $password,
            'address' => $address,
            'mobile_number' => $mobile_number,
            //'area' => $request->area_id,
            'status' => $request->status,
            'created_by' => $user->id
        ]);

        if($client)
        {
            return redirect('/admin/clients')->withStatus('client information successfully created.');
        }
        else
        {
            return redirect('/admin/clients')->withStatus('client information successfully updated.');
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
        //
        $client = Client::find($id);

        if($client)
        {
            return view('Admin.clients.create', compact('client'));
        }
        else
        {
            return redirect('admin/clients')->withStatus('no client have this id');
        }
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
        //
        $user = auth()->user();

        $client = Client::find($id);

        if($client) {

            if ($request->input('password') == null) {

                $rules = [
                    'name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
                    'email' => ['required', 'email', Rule::unique((new Client)->getTable())->ignore($client->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
                    'address' => ['required', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                    'mobile_number' => 'required|regex:/(01)[0-9]{9}/',
                   
                  
                ];

                $this->validate($request, $rules);


                $client->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'mobile_number' => $request->mobile_number,
                    'updated_by' => $user->id
                ]);

                return redirect('/admin/clients')->withStatus('client information successfully updated.');
            }
            else {
                $rules = [
                    'name' => ['required', 'min:2', 'max:60', 'not_regex:/([%\$#\*<>]+)/'],
                    'email' => ['required', 'email', Rule::unique((new Client)->getTable())->ignore($client->id), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
                    'password' => ['required', 'min:8', 'confirmed'],
                    'address' => ['required', 'min:2', 'not_regex:/([%\$#\*<>]+)/'],
                    'mobile_number' => 'required|regex:/(01)[0-9]{9}/',
                   
                   
                ];

                $this->validate($request, $rules);


                $password = password_hash($request->password, PASSWORD_DEFAULT);

                $client->update([

                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'mobile_number' => $request->mobile_number,
                    'password' => $password, 
                    'updated_by' => $user->id

                ]);
                return redirect('/admin/clients')->withStatus('admin information successfully updated.');
            }

        }
        else{
            return redirect('admin/admins')->withStatus('no admin with this id');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $client = Client::find($id);

        if($client)
        {
            $client->delete();
            return redirect('/admin/clients')->withStatus(__('client successfully deleted.'));
        }
        else {
            return redirect('/admin/clients')->withStatus(__('this id is not in our database'));
        }
    }

    public function status(Request $request,$client_id)
    {

        $client = Client::find($client_id);

        if($client)
        {
            if($client->status == 1) {

                $client->update(['status' => 0]);
            }
            else
            {
                $client->update(['status' => 1]);
            }
            return redirect()->back()->withStatus(__('clients status successfully updated.'));
        }
        return redirect()->back()->withStatus(__('this id is not in our database'));
    }

    public function clientorders($client_id)
    {
        $setting = Setting::all()->first();

        $orders = Order::where('client_id',$client_id)->orderBy('id', 'desc')->paginate(20);
        return view('Admin.orders.index',compact('orders','setting'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new AdminExport , 'admins.csv');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $rules = [
            'images' => 'image|mimes:csv|max:277'
        ];
        Excel::import(new AdminImport ,request()->file('file'));

        return back();
    }
}
