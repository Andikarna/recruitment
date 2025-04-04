<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Resource;
use App\Models\TaksList;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\ResourceDetail;
use Illuminate\Support\Facades\Auth;

class DatabaseCandidateController extends Controller
{
    public function candidateDatabase()
    {
        $candidate  = Candidate::orderByRaw('COALESCE(updated_date, created_date) DESC')
            ->paginate(5)
            ->withQueryString();

        $userId = Auth::user()->id;
        $tasklist = TaksList::where('user_id', $userId)->pluck('resource_id');
        $tasklistDetail = TaksList::where('user_id', $userId)->pluck('resource_detail_id');
        $resource = Resource::whereIn('id', $tasklist)->get();
        $resourceDetail = ResourceDetail::whereIn('id', $tasklistDetail)->get();
        return view('databasecandidate.candidateDatabase', compact('userId', 'candidate', 'resource', 'resourceDetail'));
    }
    public function addCandidate(Request $request)
    {
        $newCandidate = new Candidate();

        //generateUniqCode
        $bulanDibuat = date('m');
        $tahunDibuat = date('Y');
        $count = Candidate::count();
        $uniqCode = 'CND/' . $bulanDibuat . $tahunDibuat . str_pad($count + 1, 4, '0', STR_PAD_LEFT); // Menambahkan ID 

        $newCandidate->uniq_code = $uniqCode;
        $newCandidate->name = $request->name;
        $newCandidate->position = $request->position;
        $newCandidate->qualification = $request->qualification;
        $newCandidate->education = $request->education;
        $newCandidate->experience = $request->experience;
        $newCandidate->status = "Kandidat";
        $newCandidate->gender = $request->gender;
        $newCandidate->major = $request->major;
        $newCandidate->source = $request->source;
        $newCandidate->url = $request->url;
        $newCandidate->isSpecial = $request->special_candidate == "yes" ? true : false;
        $newCandidate->isFavoriteId = Auth::id();
        $newCandidate->isFavoriteName = Auth::user()->name;
        $newCandidate->created_date = Carbon::now('Asia/Jakarta');
        $newCandidate->created_id = Auth::id();
        $newCandidate->created_by = Auth::user()->name;
        $newCandidate->save();

        return redirect('candidateDatabase');
    }

    public function detailCandidate($id)
    {
        $candidate = Candidate::where('id', $id)->first();
        return view('databasecandidate.detailCandidate', compact('candidate'));
    }

    public function updateCandidate($id)
    {
        $candidate = Candidate::where('id', $id)->first();
        return view('databasecandidate.editCandidate', compact('candidate'));
    }

    public function saveCandidate(Request $request, $id)
    {
        $existCandidate = Candidate::where('id', $id)->first();
        $existCandidate->name = $request->name;
        $existCandidate->position = $request->position;
        $existCandidate->qualification = $request->qualification;
        $existCandidate->education = $request->education;
        $existCandidate->experience = $request->experience;
        $existCandidate->gender = $request->gender;
        $existCandidate->major = $request->major;
        $existCandidate->source = $request->source;
        $existCandidate->url = $request->url;
        $existCandidate->isSpecial = $request->special_candidate == "yes" ? true : false;

        $existCandidate->updated_date = Carbon::now('Asia/Jakarta');
        $existCandidate->updated_id = Auth::id();
        $existCandidate->updated_by = Auth::user()->name;
        $existCandidate->save();

        return redirect('candidateDatabase');
    }

    public function inFavouriteCandidate($id)
    {
        $candidate = Candidate::where('id', $id)->first();
        $candidate->isFavoriteId = Auth::id();
        $candidate->isFavoriteName = Auth::user()->name;
        $candidate->save();
        return redirect('candidateDatabase');
    }

    public function unFavouriteCandidate($id)
    {
        $candidate = Candidate::where('id', $id)->first();
        $candidate->isFavoriteId = null;
        $candidate->isFavoriteName = null;
        $candidate->save();
        return redirect('candidateDatabase');
    }

    public function getPositionsByResource(Request $request)
    {
        $resourceId = $request->input('resource_id');
        $positions = ResourceDetail::where('resource_id', $resourceId)->pluck('position', 'id');
        return response()->json($positions);
    }

    public function requestCandidate($id)
    {
        $candidate = Candidate::find($id);

        $existNotification = Notifications::where('action_id', $id)
        ->where('type','Request')
        ->first();
        
        if ($existNotification == null) {
            $notification = new Notifications();
            $notification->type = "Request";
            $notification->user_id = $candidate->isFavoriteId;
            $notification->user_name = $candidate->isFavoriteName;
            $notification->action_id = $id;
            $notification->title = "Request Kandidat";
            $notification->description = Auth::user()->name . " ingin meminta kandidat bernama " . $candidate->name;
            $notification->isRead = false;
            $notification->status = "Baru";
            $notification->created_date = Carbon::now('Asia/Jakarta');
            $notification->created_id = Auth::user()->id;
            $notification->created_by = Auth::user()->name;
            $notification->save();
        }


        return redirect('candidateDatabase');
    }
}
