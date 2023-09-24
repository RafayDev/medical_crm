<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Query;
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
    public function approve($id)
    {
        $query = Query::find($id);
        $query->status = 'approved';
        $query->save();
        $notification = new Notification();
        $notification->from_user_id = auth()->user()->id;
        $notification->to_user_id = $query->user_id;
        $notification->query_id = $query->id;
        $notification->type = 'query';
        $notification->message = 'Your query has been approved.';
        $notification->save();
        return redirect()->route('queries')->with('success', 'Query approved successfully.');
    }
}
