<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $clients = Client::orderBy('id', 'desc')->get();

        return view('Admin.clients.index',compact('clientss'));
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
        $rules = [
            'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable()), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
            'password' => ['required', 'min:8', 'confirmed','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
            'password_confirmation' => ['required', 'min:8'],
            'address' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
            'mobile_number' => 'required|regex:/(01)[0-9]{9}/'
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
            'mobile_number' => $mobile_number
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

        $client = Client::find($id);

        $rules = [
            'name' => ['required','min:2','max:60','not_regex:/([%\$#\*<>]+)/'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable()), 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,3}$/'],
            'password' => ['required', 'min:8', 'confirmed','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
            'password_confirmation' => ['required', 'min:8'],
            'address' => ['min:2','not_regex:/([%\$#\*<>]+)/'],
            'mobile_number' => 'required|regex:/(01)[0-9]{9}/'
        ];

        $this->validate($request,$rules);

        $name = $request->input('name');

        $email = $request->input('email');

        $password = Hash::make($request->input('password'));

        $address = $request->input('address');

        $mobile_number = $request->input('mobile_number');

        if($client)
        {
            $client->update([

                'name' => $name,
                'email' => $email,
                'password' => $password,
                'address' => $address,
                'mobile_number' => $mobile_number
            ]);

            return redirect('/admin/clients')->withStatus('client information successfully updated.');
        }
        else
        {
            return redirect('/admin/clients')->withStatus('no client exist');
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
