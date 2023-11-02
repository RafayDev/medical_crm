<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCategory;
use App\Models\Category;
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
        $categories = Category ::all();
        $clients = User::where('user_type', 'client')->get();
        $data = compact('clients','categories');
        return view('clients.index')->with($data);
    }
    public function create(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // die;
        if($request->category[0] == "Choose...")
        {
            return redirect()->route('clients')->with('error', 'Please Select Category');
        }
        $company = new Company();
        $company->name = $request->company_name;
        $company->address = $request->client_address;
        $company->quotation_series = $request->quotation_series;
        if ($request->hasFile('stamp')) {
            $image = $request->file('stamp');
            $image_name = time(). '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/stamps', $image_name);
            $company->stamp = $image_name;
        }
        $company->save();
        $user = new User();
        $user->name = $request->client_name;
        $user->email = $request->client_email;
        $user->password = Hash::make($request->password);
        $user->user_type = 'client';
        $user-> company_id = $company->id;
        $user->phone = $request->client_phone;
        //add logo of user
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $image_name = time(). '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/logos', $image_name);
            $user->logo = $image_name;
        }
        $user->save();
        $categories = $request->category;
        foreach($categories as $category)
        {
            $user_category = new UserCategory();
            $user_category->user_id = $user->id;
            $user_category->category_id = $category;
            $user_category->save();
        }
        return redirect()->route('clients')->with('success', 'Client Create Successfully');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $company = Company::find($user->company_id);
        $categories = UserCategory::where('user_id', $id)->get();
        $company->delete();
        $user->delete();
        foreach($categories as $category)
        {
            $category->delete();
        }
        return redirect()->route('clients')->with('success', 'Client Delete Successfully');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $company = Company::find($user->company_id);
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // die;
        $categories = UserCategory::where('user_id', $id)->get();
        $company->name = $request->company_name;
        $company->address = $request->client_address;
        $company->quotation_series = $request->quotation_series;
        if ($request->hasFile('stamp')) {
            $image = $request->file('stamp');
            $image_name = time(). '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/stamps', $image_name);
            $company->stamp = $image_name;
        }
        $company->save();
        $user->name = $request->client_name;
        $user->email = $request->client_email;
        if($request->password)
        {
        $user->password = Hash::make($request->password);
        }
        $user->user_type = 'client';
        $user-> company_id = $company->id;
        $user->phone = $request->client_phone;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $image_name = time(). '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/logos', $image_name);
            $user->logo = $image_name;
        }
        $user->save();
        foreach($categories as $category)
        {
            $category->delete();
        }
        $categories = $request->category;
        if($categories)
        {
        foreach($categories as $category)
        {
            $user_category = new UserCategory();
            $user_category->user_id = $user->id;
            $user_category->category_id = $category;
            $user_category->save();
        }
    }
        return redirect()->route('clients')->with('success', 'Client Update Successfully');
    }
}
