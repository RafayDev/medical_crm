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
    public function create(Request $request)
    {   
        $invoice = Invoice::find($request->invoice_id);
        $invoice->status = "accected";
        $invoice->save();
        $order = new Order();
        $order->user_id = $invoice->user_id;
        $order->invoice_id = $invoice->id;
        $order->save();
          $notification = new Notification();
          $notification->from_user_id = auth()->user()->id;
          $notification->to_user_id = $invoice->user_id;
          $notification->type = 'order';
          $notification->message = 'Your Invoice AML-'.$invoice->id.' has been accepted.Now you can track your order';
          $notification->save();
        return redirect()->back()->with('success', 'Order Created Successfully');
    }
    public function change_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->status;
        $order->tracking_no = $request->tracking_no;
        $order->courier = $request->courier;
        $order->save();
        //send notification to client
        $notification = new Notification();
        $notification->from_user_id = auth()->user()->id;
        $notification->to_user_id = $order->user_id;
        $notification->type = 'order';
        $notification->message = 'Your order status has been changed to '.$request->status.' Invoive No. is AML-'.$order->invoice_id;
        $notification->save();
        return redirect()->back()->with('success', 'Order Status Changed Successfully');
    }
}