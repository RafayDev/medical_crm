<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
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
}
