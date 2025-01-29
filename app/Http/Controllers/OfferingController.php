<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\InterviewDetail;
use App\Models\InterviewProgress;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Offering;
use Illuminate\Http\Request;
use App\Models\OfferingApproval;
use App\Models\OfferingFasility;
use App\Models\OfferingSalary;
use App\Models\Resource;
use App\Models\ResourceDetail;
use App\Models\ResourceFacility;
use App\Models\ResourceSalary;
use Illuminate\Support\Facades\Auth;

class OfferingController extends Controller
{
    public function offering(){
        
        $offeringList = Offering::orderByRaw('COALESCE(updated_date, created_date) DESC')
        ->paginate(5)
        ->withQueryString();

        $userManagement = User::where('role_id',4)->get();

        return view('offering.offering', compact('offeringList','userManagement'));
    }

    public function addApproval(Request $request, $id){

        $offeringDetail = Offering::where('id', $id)->first();

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

        return redirect('/offering');
    }

    public function detailOffering($id){
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

        $offeringApproval = OfferingApproval::where('offering_id', $id)->get();

        return view('offering.detailOffering', compact('offering','candidate','salary','resource','resourceDetail','fasilitas','interviewDetail','offeringApproval','offeringSalary','offeringFasilitas'));
    }

    public function updatedOffering(Request $request, $id){
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

        $offeringApproval = OfferingApproval::where('offering_id', $id)->get();

        return view('offering.updateOffering', compact('offering','candidate','salary','resource','resourceDetail','fasilitas','interviewDetail','offeringApproval','offeringSalary','offeringFasilitas'));
    }
}
