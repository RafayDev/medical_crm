<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
//use hash
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = User::where('user_type', 'client')->get();
        $data = compact('clients');
        return view('clients.index')->with($data);
    }
    public function create(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // die;
        $company = new Company();
        $company->name = $request->company_name;
        $company->address = $request->client_address;
        $company->save();
        $user = new User();
        $user->name = $request->client_name;
        $user->email = $request->client_email;
        $user->password = Hash::make($request->password);
        $user->user_type = 'client';
        $user-> company_id = $company->id;
        $user->save();
        return redirect()->route('clients');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $company = Company::find($user->company_id);
        $company->delete();
        $user->delete();
        return redirect()->route('clients');
    }
}
