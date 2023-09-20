<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Type;
use App\Models\CategoryType;
use Illuminate\Support\Str;

class CatagoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $data = compact('categories');
        return view('catagories.index')->with($data);
    }
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);
        $imageName = time() . '.' . $request->image->extension();
        //store in storage folder
        $request->image->storeAs('public/categories', $imageName);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->image = $imageName;
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
        $request->validate([
            'name' => 'required|min:3|max:50',
            'image' => 'image|mimes:jpg,jpeg,png,gif'
        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            //store in storage folder
            $request->image->storeAs('public/categories', $imageName);
            $category->image = $imageName;
        }
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
        if ($request->types) {
            foreach ($request->types as $type) {
                $category_type = new CategoryType();
                $category_type->category_id = $request->category_id;
                $category_type->type_id = $type;
                $category_type->save();
            }
        }
        return redirect('/catagories')->with('success', 'Types Assigned Successfully');
    }
}
