<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Category;
use Illuminate\Support\Str;


class TypeController extends Controller
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
        $types = Type::all();
        $categories = Category::all();
        $data = compact('types','categories');
        return view('types.index')->with($data);
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);
        $imageName = time() . '.' . $request->image->extension();
        //store in storage folder
        $request->image->storeAs('public/types', $imageName);
        $type = new Type();
        $type->name = $request->name;
        $type->slug = Str::slug($request->name, '-');
        $type->image = $imageName;
        $type->category_id = $request->category;
        $type->save();
        return redirect()->back()->with('success', 'type Added Successfully');
    }
    public function delete($id)
    {
        $type = Type::find($id);
        $type->delete();
        return redirect()->back()->with('success', 'type Deleted Successfully');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'image' => 'image|mimes:jpg,jpeg,png,gif'
        ]);
        $type = Type::find($id);
        $type->name = $request->name;
        $type->slug = Str::slug($request->name, '-');
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            //store in storage folder
            $request->image->storeAs('public/categories', $imageName);
            $type->image = $imageName;
        }
        $type->category_id = $request->category;
        $type->save();
        return redirect()->back()->with('success', 'type Updated Successfully');
    }
}
