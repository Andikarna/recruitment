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
            ->where('status','Baru')
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
            ->select('username', 'user_id') // Ambil username dan user_id
            ->get();

        $recruiterData = [];
        $recruiterProgress = [];

        foreach ($tasklist as $task) {
            $recruiterData[] = $task->username;
            $onboarding = Onboarding::where('resource_id', $resourceId)
                ->where('status', "Selesai")
                ->where('created_id', $task->user_id)
                ->count();

            $recruiterProgress[] = $onboarding;
        }

        $resultData = [
            'labels' => $recruiterData,
            'data' => $recruiterProgress,
            'max' => $maxQuantity
        ];

        return response()->json($resultData);
    }
}
