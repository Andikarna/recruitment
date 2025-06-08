<?php

namespace App\Http\Controllers;

use App\Models\AssignTodo;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Offering;
use App\Models\Resource;
use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\OfferingSalary;
use App\Models\ResourceDetail;
use App\Models\ResourceSalary;
use App\Models\InterviewDetail;
use App\Models\OfferingApproval;
use App\Models\OfferingFasility;
use App\Models\ResourceFacility;
use App\Models\InterviewProgress;
use Illuminate\Support\Facades\Auth;

class OfferingManagmentController extends Controller
{
    public function offeringManagement(){
        
        $offeringList = Offering::orderByRaw('COALESCE(updated_date, created_date) DESC')
        ->paginate(5)
        ->withQueryString();

        $offeringApproval = OfferingApproval::orderByRaw('COALESCE(updated_date, created_date) DESC')
        ->with('offering')
        ->where('manajemen_id',Auth::user()->id)
        ->paginate(5)
        ->withQueryString();

        $userManagement = User::where('role_id',4)->get();

        return view('offeringManagement.offeringManagement', compact('offeringApproval','offeringList','userManagement'));
    }

    public function addApproval(Request $request, $id){

        $offeringDetail = Offering::where('id', $id)->first();
        $user = User::where('id',$request->userManajemen)->first();

        $newOfferingApproval = new OfferingApproval();
        $newOfferingApproval->offering_id = $id;
        $newOfferingApproval->resource_id = $offeringDetail->resource_id;
        $newOfferingApproval->manajemen_id = $request->userManajemen;
        $newOfferingApproval->message = $request->description;
        $newOfferingApproval->feedback = null;
        $newOfferingApproval->status = "Baru";
        $newOfferingApproval->created_date = Carbon::now('Asia/Jakarta');
        $newOfferingApproval->created_id = Auth::user()->id;
        $newOfferingApproval->created_by = Auth::user()->name;
        $newOfferingApproval->save();

        //notification
        $notification = new Notifications();
        $notification->type = "Notification";
        $notification->user_id =  $request->userManajemen;
        $notification->user_name = $user->name;
        $notification->action_id = $id;
        $notification->title = "Offering Management";
        $notification->description = Auth::user()->name . " meminta persetujuan offering untuk kandidat bernama ". $offeringDetail->name;
        $notification->isRead = false;
        $notification->status = "Baru";
        $notification->created_date = Carbon::now('Asia/Jakarta');
        $notification->created_id = Auth::user()->id;
        $notification->created_by = Auth::user()->name;
        $notification->save();


        $assignTodo = new AssignTodo();
        $assignTodo->type = "Approval";
        $assignTodo->user_id = $request->userManajemen;
        $assignTodo->user_name = User::where('id',$request->userManajemen)->pluck('name')->first();
        $assignTodo->action_id = $id;
        $assignTodo->title = "Permintaan Offering Approval";
        $assignTodo->description = $offeringDetail->name . " | " . $offeringDetail->position;
        $assignTodo->status = "Baru";
        $assignTodo->created_date =  Carbon::now('Asia/Jakarta');
        $assignTodo->created_id = Auth::user()->id;
        $assignTodo->created_by = Auth::user()->name;
        $assignTodo->save();
        
        return redirect('/offering');
    }

    public function detailOfferingManagement($id){
        $offering = Offering::find($id);

        $candidate = Candidate::where('id', $offering->candidate_id)->first();
        $resource = Resource::where('id', $offering->resource_id)->first();
        $resourceDetail = ResourceDetail::where('id', $offering->resource_detail_id)->first();

        $salary = ResourceSalary::where('resource_id', $resource->id)->first();
        $fasilitas = ResourceFacility::where('resource_id', $resource->id)->get();

        $offeringSalary = OfferingSalary::where('offering_id', $id)->first();
        $offeringFasilitas = OfferingFasility::where('offering_id', $id)->get();

        $InterviewProgress = InterviewProgress::where('resource_id', $resource->id)->get();

        $interviewDetail = InterviewDetail::where('interview_id', $offering->interview_id)->get();

        $offeringApproval = OfferingApproval::where('offering_id', $id)
            ->where('manajemen_id',"!=",Auth::user()->id)
            ->get();

        return view('offeringManagement.detailOffering', compact('offering','candidate','salary','resource','resourceDetail','fasilitas','interviewDetail','offeringApproval','offeringSalary','offeringFasilitas'));
    }

    public function updatedOfferingManagement(Request $request, $id){
        $offering = Offering::find($id);

        $candidate = Candidate::where('id', $offering->candidate_id)->first();
        $resource = Resource::where('id', $offering->resource_id)->first();
        $resourceDetail = ResourceDetail::where('id', $offering->resource_detail_id)->first();

        $salary = ResourceSalary::where('resource_id', $resource->id)->first();
        $fasilitas = ResourceFacility::where('resource_id', $resource->id)->get();

        $offeringSalary = OfferingSalary::where('offering_id', $id)->first();
        $offeringFasilitas = OfferingFasility::where('offering_id', $id)->get();

        $InterviewProgress = InterviewProgress::where('resource_id', $resource->id)->get();

        $interviewDetail = InterviewDetail::where('interview_id', $offering->interview_id)->get();

        $offeringApproval = OfferingApproval::where('offering_id', $id)
            ->where('manajemen_id',"!=",Auth::user()->id)
            ->get();

        $offeringApprovalMe = OfferingApproval::where('offering_id', $id)
            ->where('manajemen_id',Auth::user()->id)
            ->first();

        return view('offeringManagement.updateOffering', compact('offering','candidate','salary','resource','resourceDetail','fasilitas','interviewDetail','offeringApproval','offeringSalary','offeringFasilitas','offeringApprovalMe'));
    }

    public function saveOfferingManagement(Request $request, $id){
        $offering = Offering::where('id',$id)->first();

        $offeringApproval = OfferingApproval::where('offering_id', $id)
            ->where('manajemen_id',Auth::user()->id)
            ->first();

        $offeringApproval->feedback = $request->feedback;
        $offeringApproval->status = $request->approval;

        $offeringApproval->updated_date = Carbon::now('Asia/Jakarta');
        $offeringApproval->updated_id = Auth::user()->id;
        $offeringApproval->updated_by = Auth::user()->name;
        $offeringApproval->save();

        $assignTodo = AssignTodo::where('type','Approval')
            ->where('action_id',$id)
            ->where('user_id',Auth::user()->id)
            ->first();

        $assignTodo->status = "Selesai";
        $assignTodo->updated_date =  Carbon::now('Asia/Jakarta');
        $assignTodo->updated_id = Auth::user()->id;
        $assignTodo->updated_by = Auth::user()->name;
        $assignTodo->save();

        //getUserManager 
        $userManager = User::where('role_id',2)->get();

        //notification
        foreach($userManager as $user){
            $notification = new Notifications();
            $notification->type = "Notification";
            $notification->user_id = $user->id;
            $notification->user_name = $user->name;
            $notification->action_id = $id;
            $notification->title = "Offering";
            $notification->description = Auth::user()->name . " telah me ". $request->approval . " kandidat bernama ". $offering->name;
            $notification->isRead = false;
            $notification->status = "Baru";
            $notification->created_date = Carbon::now('Asia/Jakarta');
            $notification->created_id = Auth::user()->id;
            $notification->created_by = Auth::user()->name;
            $notification->save();
        }

        return redirect('/offeringManagement');
    }
}
