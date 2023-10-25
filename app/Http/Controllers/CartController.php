<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Query;
use App\Models\QueryProduct;
use App\Models\User;
use App\Models\Notification;
use Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return view('carts.index', compact('carts'));
    }
    public function add_to_cart(Request $request)
    {
        if(Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->exists())
        {
            $cart = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
            $cart->quantity = $cart->quantity + $request->quantity;
            $cart->save();
        }
        else{
        $cart = new Cart;
        $cart->user_id = $request->user_id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->save();
        }
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function delete($id)
    {
        Cart::find($id)->delete();
        return redirect()->back()->with('success', 'Product deleted from cart successfully!');
    }
    public function send_query($user_id)
    {
        $carts = Cart::where('user_id', $user_id)->get();
        $query = new Query;
        $query->user_id = $user_id;
        $query->save();
        foreach($carts as $cart)
        {
            $query_product = new QueryProduct;
            $query_product->query_id = $query->id;
            $query_product->product_id = $cart->product_id;
            $query_product->quantity = $cart->quantity;
            $query_product->save();
        }
        Cart::where('user_id', $user_id)->delete();
        //send notification to admin and internal
        $users = User::where('user_type', 'admin')->orWhere('user_type', 'internal')->get();
        foreach($users as $user)
        {
            $notification = new Notification;
            $notification->from_user_id = $user_id;
            $notification->to_user_id = $user->id;
            $notification->message = 'New inquiry has been sent by '.User::find($user_id)->name;
            $notification->type = 'query';
            $notification->query_id = $query->id;
            
            $notification->save();
        }

        return redirect()->back()->with('success', 'Inquiry sent successfully!');
    }
    public function cart_count()
    {
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        $count ='<span class="badge bg-danger rounded-pill">'.$cart_count.'</span>';
        return $count;
    }
}