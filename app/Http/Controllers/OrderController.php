<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        if(auth()->user()->user_type == 'client')
        {
            $orders = Order::where('user_id', auth()->user()->id)->paginate(50);
        }
        else
        {
            $orders = Order::paginate(50);
        }
        $data = compact('orders');
        return view('orders.index')->with($data);
    }
    public function create($invoice_id)
    {   
        $invoice = Invoice::find($invoice_id);
        $invoice->status = "accected";
        $invoice->save();
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->invoice_id = $invoice_id;
        $order->save();
        //send notification to admins
        $admins = User::where('user_type', 'admin')->get();
        foreach($admins as $admin)
        {
          $notification = new Notification();
          $notification->from_user_id = auth()->user()->id;
          $notification->to_user_id = $admin->id;
          $notification->type = 'order';
          $notification->message = auth()->user()->name.' has accept the Invoice a new order created.';
          $notification->save();
        }
        return redirect()->back()->with('success', 'Order Created Successfully');
    }
}