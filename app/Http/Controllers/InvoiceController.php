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
        $invoice->sales_tax = $request->sales_tax;
        $invoice->freight_charges = $request->freight_charges;
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
            $html .= '<td>'.$invoice_product->product->price.'$</td>';
            $html .= '<td>'.$invoice_product->product->price*$invoice_product->quantity.'$</td>';
            $total += $invoice_product->product->price*$invoice_product->quantity;
            $html .= '</tr>';
            $html .= '<input type="hidden" name="product_id[]" value="'.$invoice_product->product->id.'"/>';
            $html .= '<input type="hidden" name="quantity[]" value="'.$invoice_product->quantity.'"/>';
            $html .= '<input type="hidden" name="price_per_unit[]" value="'.$invoice_product->product->price.'"/>';
            $html .= '<input type="hidden" name="total_price[]" value="'.$invoice_product->product->price*$invoice_product->quantity.'"/>';
            $count++;
        }
        $html .= '<tr>';
        $html .= '<td colspan="4" class="text-right"><strong>Total($)</strong></td>';
        $html .= '<td>'.$total.'$</td>';
        $html .= '</tr>';
        return $html;
    }
}
