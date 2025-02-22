<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Offering;
use App\Models\Resource;
use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Http\Request;
use App\Models\OfferingSalary;
use App\Models\ResourceDetail;
use App\Models\ResourceSalary;
use App\Models\InterviewDetail;
use App\Models\OfferingApproval;
use App\Models\OfferingFasility;
use App\Models\ResourceFacility;
use App\Models\InterviewProgress;
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

    public function saveOffering(Request $request, $id){
        $offering = Offering::find($id);
        $offeringSalary = OfferingSalary::where('offering_id',$id)->first();

        $offeringSalary->salary = $request->offeringSalary;
        $offeringSalary->ket_salary = $request->ket_salary;
        $offeringSalary->pph21 = $request->pph21 == "on" ? true : false;
        $offeringSalary->ket_pph21 = $request->ket_pph21;
        $offeringSalary->bpjs_ket = $request->bpjs_ket == "on" ? true : false;
        $offeringSalary->ket_bpjsket = $request->ket_bpjsket;
        $offeringSalary->bpjs_kes = $request->bpjs_kes == "on" ? true : false;
        $offeringSalary->ket_bpjskes = $request->ket_bpjskes;
        $offeringSalary->updated_date = Carbon::now('Asia/Jakarta');
        $offeringSalary->updated_id = Auth::user()->id;
        $offeringSalary->updated_by = Auth::user()->name;
        $offeringSalary->save();


        // fasilitas
        $fasilitasDatas = [];
        $fasilitas_id = $request->input('fasilitas_id');
        $fasilitasName = $request->input('fasilitas');
        $fasilitasKet = $request->input('ket_fasilitas');

        $countFasilitas = count($fasilitasName);
        for ($i = 0; $i < $countFasilitas; $i++) {
            $fasilitasDatas[] = [
                'id' => $fasilitas_id[$i],
                'fasilitas_name' => $fasilitasName[$i],
                'ket_fasilitas' => $fasilitasKet[$i]
            ];
        };

        if ($fasilitasDatas != null) {

            $idFasilitas = array_map(function ($data): mixed {
                return $data['id'];
            }, array: $fasilitasDatas);

            $fasilitasDelete = OfferingFasility::whereNotIn('id', values: $idFasilitas)
                ->get();

            foreach ($fasilitasDelete as $fasilitas) {
                $fasilitas->delete();
            }

            foreach ($fasilitasDatas as $data) {
                if ($data['id'] != 0) {
                    $existFasilitas = OfferingFasility::where('id', $data['id'])->first();
                    $existFasilitas->fasilitas_name = $data['fasilitas_name'];
                    $existFasilitas->ket_fasilitas = $data['ket_fasilitas'];
                    $existFasilitas->updated_date = Carbon::now('Asia/Jakarta');
                    $existFasilitas->updated_id = Auth::user()->id;
                    $existFasilitas->updated_by = Auth::user()->name;
                    $existFasilitas->save();
                } else {
                    $newFasilitas = new OfferingFasility();
                    $newFasilitas->offering_id = $offering->id;
                    $newFasilitas->fasilitas_name = $data['fasilitas_name'];
                    $newFasilitas->ket_fasilitas = $data['ket_fasilitas'];
                    $newFasilitas->created_date = Carbon::now('Asia/Jakarta');
                    $newFasilitas->created_id = Auth::user()->id;
                    $newFasilitas->created_by = Auth::user()->name;
                    $newFasilitas->save();
                }
            }
        }

        $approval = $request->approval;
        if($approval != null){
            $offering->status = $approval;
            $offering->updated_date = Carbon::now('Asia/Jakarta');
            $offering->updated_id = Auth::user()->id;
            $offering->updated_by = Auth::user()->name;
            $offering->save();

            $interview = Interview::where('id',$offering->interview_id)->first();
            $interview->status = $approval;
            $interview->updated_date = Carbon::now('Asia/Jakarta');
            $interview->updated_id = Auth::user()->id;
            $interview->updated_by = Auth::user()->name;
            $interview->save();

        }else{
            $offering->status = "Diproses";
            $offering->updated_date = Carbon::now('Asia/Jakarta');
            $offering->updated_id = Auth::user()->id;
            $offering->updated_by = Auth::user()->name;
            $offering->save();
        }

        return redirect('/offering');
    }
}
