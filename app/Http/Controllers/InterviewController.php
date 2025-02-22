<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use App\Models\Resource;
use App\Models\TaksList;
use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\OfferingSalary;
use App\Models\ResourceDetail;
use App\Models\ResourceSalary;
use Illuminate\Support\Carbon;
use App\Models\InterviewDetail;
use App\Models\OfferingFasility;
use App\Models\ResourceFacility;
use App\Models\InterviewProgress;
use Illuminate\Support\Facades\Auth;


class InterviewController extends Controller
{
    public function view()
    {
        $interview = Interview::orderByRaw('COALESCE(updated_date, created_date) DESC')
            ->paginate(5)
            ->withQueryString();

        return view('wawancara/interview', compact('interview'));
    }

    public function addInterview(Request $request)
    {
        $resource = Resource::where('id', $request->requestName)->first();
        $resourceDetail = ResourceDetail::where('id', $request->position)->first();
        $candidate = Candidate::where('id', $request->candidate)->first();

        $newInterview = new Interview();
        $newInterview->candidate_id = $request->candidate;
        $newInterview->resource_id = $resource->id;
        $newInterview->resource_detail_id = $resourceDetail->id;
        $newInterview->name = $candidate->name;
        $newInterview->position = $resourceDetail->position;
        $newInterview->qualification = $resourceDetail->qualification;
        $newInterview->project = $resource->project;
        $newInterview->status = "Baru";
        $newInterview->created_date = Carbon::now('Asia/Jakarta');
        $newInterview->created_id = Auth::user()->id;
        $newInterview->created_by = Auth::user()->name;
        $newInterview->save();

        $interview_type = 1;
        //interviewDetail
        $interviewProgress = InterviewProgress::where('resource_id', $resource->id)->get();
        foreach ($interviewProgress as $data) {
            $newInterviewDetail = new InterviewDetail();
            $newInterviewDetail->interview_id = $newInterview->id;
            $newInterviewDetail->interview_type_id = $interview_type;
            $newInterviewDetail->name_progress = $data->name_progress;
            $newInterviewDetail->interview_status =  $interview_type == 1 ? "Baru" : null;
            $newInterviewDetail->created_date = Carbon::now('Asia/Jakarta');
            $newInterviewDetail->created_id = Auth::user()->id;
            $newInterviewDetail->created_by = Auth::user()->name;
            $newInterviewDetail->save();
            $interview_type++;
        }

        $tasklist = TaksList::where('resource_id', $resource->id)->get();
        foreach ($tasklist as $data) {
            $data->status = "Diproses";
            $data->save();
        }


        return redirect('interview');
    }

    public function detailInterview($id)
    {
        $interview = Interview::find($id);

        $candidate = Candidate::where('id', $interview->candidate_id)->first();
        $resource = Resource::where('id', $interview->resource_id)->first();
        $resourceDetail = ResourceDetail::where('id', $interview->resource_detail_id)->first();

        $salary = ResourceSalary::where('resource_id', $resource->id)->first();
        $fasilitas = ResourceFacility::where('resource_id', $resource->id)->get();

        $interviewProgress = InterviewProgress::where('resource_id', $resource->id)->get();

        $interviewDetail = InterviewDetail::where('interview_id', $interview->id)->get();

        $lastInterviewDetail = InterviewDetail::where('interview_id', $interview->id)
        ->latest('id')
        ->first();

        $offering = Offering::where('candidate_id', $candidate->id)
        ->where('resource_id', $resource->id)
        ->pluck('status')
        ->first();

        return view('wawancara.detailInterview', compact('interview', 'interviewDetail', 'candidate', 'resource', 'resourceDetail', 'salary', 'fasilitas', 'interviewProgress','lastInterviewDetail','offering'));
    }

    public function updateInterview($id)
    {
        $interview = Interview::find($id);

        $candidate = Candidate::where('id', $interview->candidate_id)->first();
        $resource = Resource::where('id', $interview->resource_id)->first();
        $resourceDetail = ResourceDetail::where('id', $interview->resource_detail_id)->first();

        $salary = ResourceSalary::where('resource_id', $resource->id)->first();
        $fasilitas = ResourceFacility::where('resource_id', $resource->id)->get();

        $interviewProgress = InterviewProgress::where('resource_id', $resource->id)->get();

        $interviewDetail = InterviewDetail::where('interview_id', $interview->id)->get();

        $lastInterviewDetail = InterviewDetail::where('interview_id', $interview->id)
        ->latest('id')
        ->first();

        $offering = Offering::where('candidate_id', $candidate->id)
        ->where('resource_id', $resource->id)
        ->pluck('status')
        ->first();

        return view('wawancara.updateInterview', compact('interview', 'interviewDetail', 'candidate', 'resource', 'resourceDetail', 'salary', 'fasilitas', 'interviewProgress','lastInterviewDetail','offering'));
    }

    public function saveInterview(Request $request, $id)
    {
        $interviewId = $request->input('interviewId');
        $interviewDetailId = $request->input('interviewDetailId');
        $status = $request->input('interview_status');
        $date = $request->input('interview_date');
        $time = $request->input('interview_time');
        $user = $request->input('interview_user');
        $file = $request->input('interview_file');
        $link = $request->input('interview_link');

        $interviewId = Interview::where('id', $interviewId)->first();
        $interviewDetail = InterviewDetail::where('id', $interviewDetailId)->first();
        $interviewNextStepId = InterviewDetail::where('id', $interviewDetailId + 1)->first();

        $interviewDetail->interview_date = $date;
        $interviewDetail->interview_time = $time;
        $interviewDetail->user = $user;
        $interviewDetail->file = $file;
        $interviewDetail->url = $link;
        $interviewDetail->updated_date = Carbon::now('Asia/Jakarta');
        $interviewDetail->updated_id = Auth::user()->id;
        $interviewDetail->updated_by = Auth::user()->name;
        $interviewDetail->save();

        $interviewId->interview_progress = $interviewDetail->name_progress;
        $interviewId->interview_date = $date;
        $interviewId->status = "Diproses";
        $interviewId->updated_date = Carbon::now('Asia/Jakarta');
        $interviewId->updated_id = Auth::user()->id;
        $interviewId->updated_by = Auth::user()->name;
        $interviewId->save();

        if($status == "Diterima" && $interviewId->interview_progress == "Wawancara Final"){
            $interviewId->status = "Selesai";
            $interviewId->updated_date = Carbon::now('Asia/Jakarta');
            $interviewId->updated_id = Auth::user()->id;
            $interviewId->updated_by = Auth::user()->name;
            $interviewId->save();

            $interviewDetail->interview_status = "Diterima";
            $interviewDetail->updated_date = Carbon::now('Asia/Jakarta');
            $interviewDetail->updated_id = Auth::user()->id;
            $interviewDetail->updated_by = Auth::user()->name;
            $interviewDetail->save();

            return redirect('/interview');
        }

        if ($status == "Setuju") {
            $interviewId->interview_progress = $interviewNextStepId->name_progress;
            $interviewId->interview_date = null;
            $interviewId->updated_date = Carbon::now('Asia/Jakarta');
            $interviewId->updated_id = Auth::user()->id;
            $interviewId->updated_by = Auth::user()->name;
            $interviewId->save();

            $interviewDetail->interview_status = "Diterima";
            $interviewDetail->updated_date = Carbon::now('Asia/Jakarta');
            $interviewDetail->updated_id = Auth::user()->id;
            $interviewDetail->updated_by = Auth::user()->name;
            $interviewDetail->save();

            $interviewNextStepId->interview_status = "Baru";
            $interviewNextStepId->updated_date = Carbon::now('Asia/Jakarta');
            $interviewNextStepId->updated_id = Auth::user()->id;
            $interviewNextStepId->updated_by = Auth::user()->name;
            $interviewNextStepId->save();

        }elseif($status == "Diterima"){

            $interviewId->interview_progress = "Wawancara Final";
            $interviewId->interview_date = null;
            $interviewId->updated_date = Carbon::now('Asia/Jakarta');
            $interviewId->updated_id = Auth::user()->id;
            $interviewId->updated_by = Auth::user()->name;
            $interviewId->save();

            $interviewDetail->interview_status = "Diterima";
            $interviewDetail->updated_date = Carbon::now('Asia/Jakarta');
            $interviewDetail->updated_id = Auth::user()->id;
            $interviewDetail->updated_by = Auth::user()->name;
            $interviewDetail->save();

            $lastInterviewDetail = InterviewDetail::where('interview_id', $id)
            ->latest('id')
            ->pluck('interview_type_id')
            ->first();

            $interviewType =  $lastInterviewDetail + 1;

            $newInterviewDetail = new InterviewDetail();
            $newInterviewDetail->interview_id = $id;
            $newInterviewDetail->interview_type_id = $interviewType;
            $newInterviewDetail->name_progress = "Wawancara Final";
            $newInterviewDetail->interview_status = "Baru";
            $newInterviewDetail->created_date = Carbon::now('Asia/Jakarta');
            $newInterviewDetail->created_id = Auth::user()->id;
            $newInterviewDetail->created_by = Auth::user()->name;
            $newInterviewDetail->save();

            $newOffering = new Offering();
            $newOffering->candidate_id = $interviewId->candidate_id;
            $newOffering->resource_id = $interviewId->resource_id;
            $newOffering->resource_detail_id = $interviewId->resource_detail_id;
            $newOffering->interview_id = $interviewId->id;
            $newOffering->name = $interviewId->name;
            $newOffering->position = $interviewId->position;
            $newOffering->qualification = $interviewId->qualification;
            $newOffering->project = $interviewId->project;
            $newOffering->interview_progress = "Offering";
            $newOffering->status = "Baru";
            $newOffering->created_date = Carbon::now('Asia/Jakarta');
            $newOffering->created_id = Auth::user()->id;
            $newOffering->created_by = Auth::user()->name;
            $newOffering->save();

            $resourceSalary = ResourceSalary::where('resource_id', $interviewId->resource_id)
            ->where('resource_detail_id',$interviewId->resource_detail_id)
            ->first();
            $resourceFacility = ResourceFacility::where('resource_id', $interviewId->resource_id)
            ->where('resource_detail_id',$interviewId->resource_detail_id)
            ->get();

            $newOfferingSalary = new OfferingSalary();
            $newOfferingSalary->offering_id = $newOffering->id;
            // $newOfferingSalary->salary =    
            //$newOfferingSalary->ket_salary = 
            $newOfferingSalary->pph21 = $resourceSalary->pph21;
            $newOfferingSalary->ket_pph21 = $resourceSalary->ket_pph21;
            $newOfferingSalary->bpjs_ket = $resourceSalary->bpjs_ket;
            $newOfferingSalary->ket_bpjsket = $resourceSalary->ket_bpjsket;
            $newOfferingSalary->bpjs_kes = $resourceSalary->bpjs_kes;
            $newOfferingSalary->ket_bpjskes = $resourceSalary->ket_bpjskes;
            $newOfferingSalary->created_date = Carbon::now('Asia/Jakarta');
            $newOfferingSalary->created_id = Auth::user()->id;
            $newOfferingSalary->created_by = Auth::user()->name;
            $newOfferingSalary->save();

            foreach($resourceFacility as $data){
                $newOfferingFacility = new OfferingFasility();
                $newOfferingFacility->offering_id = $newOffering->id;
                $newOfferingFacility->fasilitas_name = $data->fasilitas_name;
                $newOfferingFacility->ket_fasilitas = $data->ket_fasilitas;
                $newOfferingFacility->created_date = Carbon::now('Asia/Jakarta');
                $newOfferingFacility->created_id = Auth::user()->id;
                $newOfferingFacility->created_by = Auth::user()->name;
                $newOfferingFacility->save();
            }
        }

         

        return redirect('/interview');
    }
}
