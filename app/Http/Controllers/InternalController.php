<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCategory;
use App\Models\Category;
//use hash
use Illuminate\Support\Facades\Hash;

class InternalController extends Controller
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
        $clients = User::where('user_type', 'internal')->orwhere('user_type', 'tracker')->get();
        $data = compact('clients','categories');
        return view('internals.index')->with($data);
    }
    public function create(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // die;
        $user = new User();
        $user->name = $request->client_name;
        $user->email = $request->client_email;
        $user->password = Hash::make($request->password);
        $user->user_type = $request->role;
        $user->save();
        return redirect()->route('internals')->with('success', 'User created successfully.');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('internals')->with('success', 'User deleted successfully.');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->client_name;
        $user->email = $request->client_email;
        if($request->password)
        {
        $user->password = Hash::make($request->password);
        }
        $user->user_type = $request->role;
        $user->save();
        return redirect()->route('internals')->with('success', 'User updated successfully.');
    }
}