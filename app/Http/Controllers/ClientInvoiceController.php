<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientInvoices;
use App\Models\ClientInvoiceProduct;
use Barryvdh\DomPDF\Facade\Pdf;
class ClientInvoiceController extends Controller
{
    public function index()
    {
        $invoices = ClientInvoices::orderBy('created_at', 'desc')->paginate(50);
        $data = compact('invoices');
        return view('client_invoices.index')->with($data);
    }
    public function view($id)
    {
        $invoice = ClientInvoices::find($id);
        $data = compact('invoice');
        $pdf = PDF::loadView('pdf.client_invoice', $data);
        return $pdf->stream();
    }
    public function delete($id)
    {
        ClientInvoices::find($id)->delete();
        return redirect()->back()->with('success', 'Invoice deleted successfully!');
    }
}
