<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Query;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\QueryProduct;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class QueryController extends Controller
{
    public function index()
    {
        $queries = Query::orderBy('created_at', 'desc')->paginate(50);
        if(auth()->user()->user_type == 'client')
        {
            $queries = Query::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(50);
        }
        $data = compact('queries');
        return view('queries.index')->with($data);
    }
    public function view($id)
    {
        $query = Query::find($id);
        $data = compact('query');
        $pdf = PDF::loadView('pdf.query', $data);
        return $pdf->stream();
    }
    public function approve(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // die;
        $query = Query::find($request->query_id);
        $query->status = 'approved';
        $query->save();
        //create invoice
        $invoice = new Invoice();
        $invoice->query_id = $query->id;
        $invoice->user_id = $query->user_id;
        $invoice->sales_tax = $request->sales_tax;
        $invoice->freight_charges = $request->freight_charges;
        $invoice->payment_proof = $request->payment_proof;
        $invoice->save();
        $product_ids = $request->product_id;
        $quantities = $request->quantity;
        $price_per_units = $request->price_per_unit;
        $total_prices = $request->total_price;
        foreach($product_ids as $key =>$product_id)
        {
            $invoice_product = new InvoiceProduct();
            $invoice_product->invoice_id = $invoice->id;
            $invoice_product->product_id = $product_id;
            $invoice_product->quantity = $quantities[$key];
            $invoice_product->price_per_unit = $price_per_units[$key];
            $invoice_product->total_price = $total_prices[$key];
            $invoice_product->save();
        }
        $total_prices = $request->total_price;
        $notification = new Notification();
        $notification->from_user_id = auth()->user()->id;
        $notification->to_user_id = $query->user_id;
        $notification->query_id = $query->id;
        $notification->type = 'query';
        $notification->message = 'Your query has been approved.';
        $notification->save();
        return redirect()->route('queries')->with('success', 'Query approved successfully.');
    }
    public function get_query_products($id)
    {
        $query_products = QueryProduct::where('query_id', $id)->get();
        $html= '';
        $count = 1;
        $total= 0;
        foreach($query_products as $query_product)
        {
            $html .= '<tr>';
            $html .= '<td>'.$count.'</td>';
            $html .= '<td>'.$query_product->product->name.'</td>';
            $html .= '<td>'.$query_product->product->sku.'</td>';
            $html .= '<td>'.$query_product->product->size.'</td>';
            $html .= '<td>'.$query_product->quantity.'</td>';
            $html .= '<td><input type="text" name="price_per_unit[]" onkeyup="calculate_total_price(this.value, '.$query_product->quantity.', '.$count.')" class="form-control" value="'.$query_product->product->price.'"/></td>';
            $html .= '<td id="total-price-col'.$count.'">'.$query_product->product->price*$query_product->quantity.'$</td>';
            $total += $query_product->product->price*$query_product->quantity;
            $html .= '</tr>';
            $html .= '<input type="hidden" name="product_id[]" value="'.$query_product->product->id.'"/>';
            $html .= '<input type="hidden" name="quantity[]" value="'.$query_product->quantity.'"/>';
            // $html .= '<input type="hidden" name="price_per_unit[]" value="'.$query_product->product->price.'"/>';
            $html .= '<input type="hidden" name="total_price[]" value="'.$query_product->product->price*$query_product->quantity.'"/>';
            $count++;
        }
        $html .= '<tr>';
        $html .= '<td colspan="6" class="text-right"><strong>Total($)</strong></td>';
        $html .= '<td id="full-total">'.$total.'$</td>';
        $html .= '</tr>';
        return $html;
    }
    public function delete($id)
    {
        $query = Query::find($id);
        $query->delete();
        return redirect()->back()->with('success', 'Query deleted successfully!');
    }
}
