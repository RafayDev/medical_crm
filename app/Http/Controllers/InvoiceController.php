<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->paginate(50);
        if(auth()->user()->user_type == 'client')
        {
            $invoices = Invoice::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(50);
        }
        $data = compact('invoices');
        return view('invoices.index')->with($data);
    }
    public function view($id)
    {
        $invoice = Invoice::find($id);
        $data = compact('invoice');
        $pdf = PDF::loadView('pdf.invoice', $data);
        return $pdf->stream();
    }
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $invoice_product = InvoiceProduct::where('invoice_id', $invoice->id)->get();
        foreach($invoice_product as $invoice_product)
        {
            $invoice_product->delete();
        }
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
        $invoice->sales_tax = $request->sales_tax;
        $invoice->freight_charges = $request->freight_charges;
        $invoice->payment_proof = $request->payment_proof;
        $invoice->save();
        return redirect()->back()->with('success', 'Invoice updated successfully!');
    }
    public function delete($id)
    {
        $invoice = Invoice::find($id);
        $orders = Order::where('invoice_id', $invoice->id)->get();
        if(count($orders) > 0)
        {
            return redirect()->back()->with('error', 'You can not delete this invoice because it has orders!');
        }
        $invoice->delete();
        return redirect()->back()->with('success', 'Invoice deleted successfully!');
    }
    public function get_invoice_products($id)
    {
        $invoice_products = InvoiceProduct::where('invoice_id', $id)->get();
        $html= '';
        $count = 1;
        $total= 0;
        foreach($invoice_products as $invoice_product)
        {
            $html .= '<tr>';
            $html .= '<td>'.$count.'</td>';
            $html .= '<td>'.$invoice_product->product->name.'</td>';
            $html .= '<td>'.$invoice_product->quantity.'</td>';
            $html .= '<td><input type="text" name="price_per_unit[]" onkeyup="calculate_total_price(this.value, '.$invoice_product->quantity.', '.$count.')" class="form-control" value="'.$invoice_product->price_per_unit.'"/></td>';
            $html .= '<td id="total-price-col'.$count.'">'.$invoice_product->price_per_unit*$invoice_product->quantity.'$</td>';
            $total += $invoice_product->price_per_unit*$invoice_product->quantity;
            $html .= '</tr>';
            $html .= '<input type="hidden" name="product_id[]" value="'.$invoice_product->product->id.'"/>';
            $html .= '<input type="hidden" name="quantity[]" value="'.$invoice_product->quantity.'"/>';
            $html .= '<input type="hidden" name="price_per_unit[]" value="'.$invoice_product->price_per_unit.'"/>';
            $html .= '<input type="hidden" name="total_price[]" value="'.$invoice_product->price_per_unit*$invoice_product->quantity.'"/>';
            $count++;
        }
        $html .= '<tr>';
        $html .= '<td colspan="4" class="text-right"><strong>Total($)</strong></td>';
        $html .= '<td id="full-total">'.$total.'$</td>';
        $html .= '</tr>';
        return $html;
    }
}
// foreach($query_products as $query_product)
// {
//     $html .= '<tr>';
//     $html .= '<td>'.$count.'</td>';
//     $html .= '<td>'.$query_product->product->name.'</td>';
//     $html .= '<td>'.$query_product->product->sku.'</td>';
//     $html .= '<td>'.$query_product->product->size.'</td>';
//     $html .= '<td>'.$query_product->quantity.'</td>';
//     $html .= '<td><input type="text" name="price_per_unit[]" onkeyup="calculate_total_price(this.value, '.$query_product->quantity.', '.$count.')" class="form-control" value="'.$query_product->product->price.'"/></td>';
//     $html .= '<td id="total-price-col'.$count.'">'.$query_product->product->price*$query_product->quantity.'$</td>';
//     $total += $query_product->product->price*$query_product->quantity;
//     $html .= '</tr>';
//     $html .= '<input type="hidden" name="product_id[]" value="'.$query_product->product->id.'"/>';
//     $html .= '<input type="hidden" name="quantity[]" value="'.$query_product->quantity.'"/>';
//     // $html .= '<input type="hidden" name="price_per_unit[]" value="'.$query_product->product->price.'"/>';
//     $html .= '<input type="hidden" name="total_price[]" value="'.$query_product->product->price*$query_product->quantity.'"/>';
//     $count++;
// }
// $html .= '<tr>';
// $html .= '<td colspan="6" class="text-right"><strong>Total($)</strong></td>';
// $html .= '<td id="full-total">'.$total.'$</td>';
// $html .= '</tr>';
// return $html;