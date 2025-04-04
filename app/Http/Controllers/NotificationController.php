<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Candidate;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read_all()
    {

        $notification = Notifications::where('user_id', Auth::user()->id)->get();

        foreach ($notification as $data) {
            $data->isRead = true;
            $data->save();
        }

        return redirect()->back();
    }

    public function accept($id)
    {
        $candidate = Candidate::find($id);
        $existNotification = Notifications::where('action_id', $id)->where('type','Request')->first();
        $existNotification->description = "Kamu telah menerima permintaan ". $existNotification->created_by . " untuk kandidat bernama ". $candidate->name ;
        $existNotification->type = "Notification";
        $existNotification->isRead = true;
        $existNotification->save();

        $candidate->isFavoriteId = $existNotification->created_id;
        $candidate->isFavoriteName = $existNotification->created_by;
        $candidate->updated_by = Auth::user()->name;
        $candidate->updated_id = Auth::user()->id;
        $candidate->updated_date = Carbon::now('Asia/Jakarta');
        $candidate->save();
        
        $notification = new Notifications();
        $notification->type = "Notification";
        $notification->user_id = $existNotification->created_id;
        $notification->user_name = $existNotification->created_by;
        $notification->action_id = $id;
        $notification->title = "Request Kandidat";
        $notification->description = Auth::user()->name . " telah menerima permintaan kandidat bernama " . $candidate->name;
        $notification->isRead = false;
        $notification->status = "Baru";
        $notification->created_date = Carbon::now('Asia/Jakarta');
        $notification->created_id = Auth::user()->id;
        $notification->created_by = Auth::user()->name;
        $notification->save();

       

        return redirect()->back();
    }

    public function reject($id)
    {
        $candidate = Candidate::find($id);
        $existNotification = Notifications::where('action_id', $id)->where('type','Request')->first();

        $notification = new Notifications();
        $notification->type = "Notification";
        $notification->user_id = $existNotification->created_id;
        $notification->user_name = $existNotification->created_by;
        $notification->action_id = $id;
        $notification->title = "Request Kandidat";
        $notification->description = Auth::user()->name . " telah menolak permintaan kandidat bernama " . $candidate->name;
        $notification->isRead = false;
        $notification->status = "Baru";
        $notification->created_date = Carbon::now('Asia/Jakarta');
        $notification->created_id = Auth::user()->id;
        $notification->created_by = Auth::user()->name;
        $notification->save();

        $existNotification->type = "Notification";
        $existNotification->description = "Kamu telah menolak permintaan ". $existNotification->created_by . " untuk kandidat bernama ". $candidate->name ;
        $existNotification->isRead = true;
        $existNotification->save();

        return redirect()->back();
    }
}
