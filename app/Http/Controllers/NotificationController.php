<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;

class NotificationController extends Controller
{
    public function get_unread_notifications()
    {
        $notifications = Notification::where('to_user_id', Auth::user()->id)->where('is_read', 0)->get();
        $notification_count = Notification::where('to_user_id', Auth::user()->id)->where('is_read', 0)->count();
        $html = '';
        foreach($notifications as $notification)
        {
            $url = '#';
            if($notification->type == 'query')
            {
            // $url = route('queries');
            }
            $html .= '<a href="'.$url.'" class="dropdown-item">
                                    <h6 class="fw-normal mb-0">'.$notification->message.'</h6>
                                    <small>'.$notification->created_at->diffForHumans().'</small>
                                </a>
                                <hr class="dropdown-divider">';
        }
        if($notification_count > 0)
        {
            $html .= '<a href="'.route('mark-as-read').'" class="dropdown-item text-center">Mark all as read</a>';
        }
        else{
            $html .= '<a href="#" class="dropdown-item text-center">No new notifications</a>';
        }
        $count ='<span class="badge bg-danger rounded-pill">'.$notification_count.'</span>';
        return response()->json(['html' => $html, 'notification_count' => $count]);
    }
    public function mark_as_read()
    {
        Notification::where('to_user_id', Auth::user()->id)->where('is_read', 0)->update(['is_read' => 1]);
        return redirect()->back();
    }
}