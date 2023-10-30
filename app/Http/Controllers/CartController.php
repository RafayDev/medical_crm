<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Query;
use App\Models\QueryProduct;
use App\Models\User;
use App\Models\Notification;
use App\Models\ClientInvoices;
use App\Models\ClientInvoiceProduct;
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
    public function get_cart_products($id)
    {
        $carts = Cart::where('user_id', $id)->get();
        $html= '';
        $count = 1;
        $total= 0;
        foreach($carts as $cart)
        {
            $html .= '<tr>';
            $html .= '<td>'.$count.'</td>';
            $html .= '<td>'.$cart->product->name.'</td>';
            $html .= '<td>'.$cart->product->sku.'</td>';
            $html .= '<td>'.$cart->product->size.'</td>';
            $html .= '<td>'.$cart->quantity.'</td>';
            $html .= '<td><input type="text" name="price_per_unit[]" onkeyup="calculate_total_price(this.value, '.$cart->quantity.', '.$count.')" class="form-control" value="'.$cart->product->price.'"/></td>';
            $html .= '<td id="total-price-col'.$count.'">'.$cart->product->price*$cart->quantity.'$</td>';
            $total += $cart->product->price*$cart->quantity;
            $html .= '</tr>';
            $html .= '<input type="hidden" name="product_id[]" value="'.$cart->product->id.'"/>';
            $html .= '<input type="hidden" name="quantity[]" value="'.$cart->quantity.'"/>';
            // $html .= '<input type="hidden" name="price_per_unit[]" value="'.$cart->product->price.'"/>';
            $html .= '<input type="hidden" name="total_price[]" value="'.$cart->product->price*$cart->quantity.'"/>';
            $count++;
        }
        $html .= '<tr>';
        $html .= '<td colspan="6" class="text-right"><strong>Total($)</strong></td>';
        $html .= '<td id="full-total">'.$total.'$</td>';
        $html .= '</tr>';
        return $html;
    }
    public function create_client_invoice(Request $request)
    {
        $invoice = new ClientInvoices();
        $invoice->user_id = $request->user_id;
        $invoice->sales_tax = $request->sales_tax;
        $invoice->freight_charges = $request->freight_charges;
        $invoice->save();
        $product_ids = $request->product_id;
        $quantities = $request->quantity;
        $price_per_units = $request->price_per_unit;
        $total_prices = $request->total_price;
        foreach($product_ids as $key =>$product_id)
        {
            $invoice_product = new ClientInvoiceProduct();
            $invoice_product->client_invoice_id = $invoice->id;
            $invoice_product->product_id = $product_id;
            $invoice_product->quantity = $quantities[$key];
            $invoice_product->price_per_unit = $price_per_units[$key];
            $invoice_product->total_price = $total_prices[$key];
            $invoice_product->save();
        }
        //clear cart
        Cart::where('user_id', $request->user_id)->delete();
        return redirect()->route('client-invoices')->with('success', 'Invoice created successfully.');
    }
}