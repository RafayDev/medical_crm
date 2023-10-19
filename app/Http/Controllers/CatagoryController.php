<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Type;
use App\Models\SubType;
use App\Models\CategoryType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class CatagoryController extends Controller
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
        if(auth()->user()->user_type == 'client')
        {
            $user = User::find(auth()->user()->id);
            $user_categories = $user->user_categories;
            $categories = Category::whereIn('id', $user_categories->pluck('category_id'))->get();
            $data = compact('categories');
            return view('catagories.index')->with($data);
        }
        $categories = Category::all();
        $data = compact('categories');
        return view('catagories.index')->with($data);
    }
    public function create(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->save();
        return redirect()->back()->with('success', 'Category Added Successfully');
    }
    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category Deleted Successfully');
    }
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        // if ($request->hasFile('image')) {
        //     $imageName = time() . '.' . $request->image->extension();
        //     //store in storage folder
        //     $request->image->storeAs('public/categories', $imageName);
        //     $category->image = $imageName;
        // }
        $category->save();
        return redirect()->back()->with('success', 'Category Updated Successfully');
    }
    public function assigned_type($id)
    {
        $types = Type::all(); 
        $category = Category::find($id);
        $category_types = CategoryType::where('category_id', $id)->get();
        $data = compact('types', 'category', 'category_types');
        return view('catagories.assigned_type')->with($data);
    }
    public function assign_type(Request $request)
    {
        $category_types = CategoryType::where('category_id', $request->category_id)->get();
        foreach ($category_types as $category_type) {
            $category_type->delete();
        }
        if ($request->subtypes) {
            foreach ($request->subtypes as $subtype) {
                $category_type = new CategoryType();
                $category_type->category_id = $request->category_id;
                $subtypeModel = SubType::find($subtype);
                $category_type->type_id = $subtypeModel->type_id;
                $category_type->sub_type_id = $subtype;
                $category_type->save();
            }
        }
        return redirect('/catagories')->with('success', 'Types Assigned Successfully');
    }
    public function category_types($id)
    {
        $category = Category::find($id);
        $category_types = Type::where('category_id', $id)->get();
        $data = compact('category', 'category_types');
        return view('catagories.category_types')->with($data);
    }
    public function category_type_products($category_id, $type_id)
    {
        $category = Category::find($category_id);
        $type = Type::find($type_id);
        $products = Product::where('category_id', $category_id)->where('type_id', $type_id)->get();
        $data = compact('category', 'type', 'products');
        return view('catagories.category_type_products')->with($data);
    }
    public function get_type_by_category($id)
    {
        $types = Type::where('category_id', $id)->get();
        return response()->json($types);
    }
}