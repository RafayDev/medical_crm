<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Type;
use App\Models\User;
class ProductController extends Controller
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
        
        $categories = Category::all();
        $types = Type::all();
        $products = Product::paginate(50);
        if(auth()->user()->user_type == 'client')
        {
            $user = User::find(auth()->user()->id);
            $user_categories = $user->user_categories;
            $products = Product::whereIn('category_id', $user_categories->pluck('category_id'))->paginate(50);
            $data = compact('categories', 'types', 'products');
            return view('products.index')->with($data);
        }
        $data = compact('categories', 'types', 'products');
        return view('products.index')->with($data);
    }
    public function create(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->type_id = $request->type;
        $product->sku = $request->sku;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time(). '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $image_name);
            $product->image = $image_name;
        }
        $product->save();
        
        return redirect()->back()->with('success', 'Product Added Successfully');
    }
    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time(). '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/products', $image_name);
            $product->image = $image_name;
        }
        $product->category_id = $request->category;
        $product->type_id = $request->type;
        $product->sku = $request->sku;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
        return redirect()->back()->with('success', 'Product Updated Successfully');
    }
    public function search(Request $request)
    {
        $categories = Category::all();
        $types = Type::all();
        $search = $request->search;
        //put seacrh in session
        if($request->search != '')
        {
        session(['search' => $search]);
        }
        if($search == '')
        {
            $search = session('search');
        }

        $products = Product::where('name', 'LIKE', '%'.$search.'%')->orWhere('sku', 'LIKE', '%'.$search.'%')->get();
        $data = compact('categories', 'types', 'products', 'search');
        return view('products.search')->with($data);
    }
}
