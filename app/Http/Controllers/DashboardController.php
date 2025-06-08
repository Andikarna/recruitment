<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Offering;
use App\Models\Resource;
use App\Models\TaksList;
use App\Models\Interview;
use App\Models\AssignTodo;
use App\Models\Onboarding;
use App\Models\ResourceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $dateNow = Carbon::now('Asia/Jakarta');
        $newCandidate = Onboarding::with('candidate', 'resourceDetail')
            ->where('status', 'Selesai')
            ->where('join_date', '>', $dateNow)
            ->get();

        $interviewNew = Interview::whereIn('status', ['Baru'])->count();

        $interview = Interview::whereIn('status', ['Diproses', 'Approve'])->count();

        $offering = Offering::whereIn('status', ['Diproses', 'Baru'])->count();

        $onboarding = Onboarding::whereIn('status', ['Baru', 'Pengecekan'])->count();

        $assignTodo = AssignTodo::where('user_id', Auth::user()->id)
            ->where('status', 'Baru')
            ->orderByDesc('created_date')
            ->get();

        return view('dashboard.dashboardHr', compact('newCandidate', 'interviewNew', 'interview', 'offering', 'onboarding', 'assignTodo'));
    }

    public function getResource()
    {
        $requests = Resource::where('status', '!=', 'Selesai')
            ->get(['id', 'name', 'status']);

        $requestLast = Resource::where('status', '!=', 'Selesai')
            ->orderByDesc('created_date')
            ->select('id')
            ->first();

        $result = [
            'requests' => $requests,
            'lastId' => $requestLast
        ];

        return response()->json($result);
    }


    public function getDashboardHr($resourceId)
    {
        $maxQuantity = ResourceDetail::where('resource_id', $resourceId)
            ->sum('quantity');

        $tasklist = TaksList::where('resource_id', $resourceId)
            ->select('username', 'user_id')
            ->get();

        $recruiterData = [];
        $recruiterProgress = [];
        $offering = [];
        $interview = [];

        foreach ($tasklist as $task) {
            $interviewData = Interview::where('resource_id', $resourceId)
                ->whereNotIn('interview_progress', ["Wawancara Final"])
                ->where('status', '!=', "Selesai")
                ->where('created_id', $task->user_id)
                ->count();

            $offeringData = Offering::where('resource_id', $resourceId)
                ->whereNotIn('status', ["Approve", "Reject", "Selesai"])
                ->where('created_id', $task->user_id)
                ->count();

            $onboarding = Onboarding::where('resource_id', $resourceId)
                ->where('status', "Selesai")
                ->where('created_id', $task->user_id)
                ->count();

            if ($interviewData === 0 && $offeringData === 0 && $onboarding === 0) {
                continue;
            }
            
            $recruiterData[] = $task->username;
            $interview[] = $interviewData;
            $offering[] = $offeringData;
            $recruiterProgress[] = $onboarding;
        }

        $resultData = [
            'labels' => $recruiterData,
            'interview' => $interview,
            'offering' => $offering,
            'data' => $recruiterProgress,
            'max' => $maxQuantity
        ];

        return response()->json($resultData);
    }

    public function dashboardrecruiter()
    {
        $dateNow = Carbon::now('Asia/Jakarta');
        $newCandidate = Onboarding::with('candidate', 'resourceDetail')
            ->where('created_id', Auth::user()->id)
            ->where('status', 'Selesai')
            ->where('join_date', '>', $dateNow)
            ->get();

        $interviewNew = Interview::whereIn('status', ['Baru'])->count();

        $interview = Interview::whereIn('status', ['Diproses', 'Approve'])->count();

        $offering = Offering::whereIn('status', ['Diproses', 'Baru'])->count();

        $onboarding = Onboarding::whereIn('status', ['Baru', 'Pengecekan'])->count();

        $assignTodo = Interview::where('created_id', Auth::user()->id)
            ->whereNotIn('status', ['Onboard', 'Selesai', 'Cancel', 'Reject'])
            ->whereDate('interview_date', Date::now()->toDateString())
            ->orderBy('interview_date', 'asc')
            ->get();

        $tasklist = TaksList::where('user_id', Auth::user()->id)->pluck('resource_id');
        $resource = Resource::with('resource_detail')
            ->orderByDesc('updated_date')
            ->whereIn('id', $tasklist)
            ->get();

        return view('dashboard.dashboardRecruiter', compact('newCandidate', 'interviewNew', 'interview', 'offering', 'onboarding', 'assignTodo', 'resource'));
    }

    public function getResourceRecruiter()
    {
        $tasklist = TaksList::where('user_id', Auth::user()->id)->pluck('resource_id');

        $requests = Resource::where('status', '!=', 'Selesai')
            ->whereIn('id', $tasklist)
            ->get(['id', 'name', 'status']);

        $requestLast = Resource::where('status', '!=', 'Selesai')
            ->orderByDesc('created_date')
            ->select('id')
            ->first();

        $result = [
            'requests' => $requests,
            'lastId' => $requestLast
        ];

        return response()->json($result);
    }

    public function getPosition($resourceId)
    {
        $resouceDetail = ResourceDetail::where('resource_id', $resourceId)->first();

        $maxQuantity = ResourceDetail::where('resource_id', $resourceId)
            ->sum('quantity');

        $tasklist = TaksList::where('resource_id', $resourceId)
            ->select('username', 'user_id') // Ambil username dan user_id
            ->get();

        $resultData = [
            'labels' => $resouceDetail->position,
            'data' => $resouceDetail->fulfilled,
            'max' => $maxQuantity
        ];

        return response()->json($resultData);
    }


    public function dashboardmanagement()
    {
        $dateNow = Carbon::now('Asia/Jakarta');
        $newCandidate = Onboarding::with('candidate', 'resourceDetail')
            ->where('status', 'Selesai')
            ->where('join_date', '>', $dateNow)
            ->get();

        $interviewNew = Interview::whereIn('status', ['Baru'])->count();

        $interview = Interview::whereIn('status', ['Diproses', 'Approve'])->count();

        $offering = Offering::whereIn('status', ['Diproses', 'Baru'])->count();

        $onboarding = Onboarding::whereIn('status', ['Baru', 'Pengecekan'])->count();

        $assignTodo = AssignTodo::where('user_id', Auth::user()->id)
            ->where('status', 'Baru')
            ->orderByDesc('created_date')
            ->get();

        return view('dashboard.dashboardManagement', compact('newCandidate', 'interviewNew', 'interview', 'offering', 'onboarding', 'assignTodo'));
    }
}
