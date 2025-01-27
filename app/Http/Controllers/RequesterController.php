<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Resource;
use App\Models\TaksList;
use Illuminate\Http\Request;
use App\Models\ResourceDetail;
use App\Models\ResourceSalary;
use App\Models\ResourceFacility;
use App\Models\InterviewProgress;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Pail\ValueObjects\Origin\Console;
use Symfony\Component\Console\Logger\ConsoleLogger;

class RequesterController extends Controller
{
    public function requester()
    {
        $resource = Resource::orderByRaw('COALESCE(updated_date, created_date) DESC')
            ->paginate(5)
            ->withQueryString();

        $stages = Session::get('stages', []);
        $recruiter = TaksList::all();
        
        return view('requester', compact('resource', 'stages', 'recruiter'));
    }

    public function addResource(Request $request)
    {

        try {
            //addResource
            $newRequest = new Resource();
            $newRequest->name = $request->name;
            $newRequest->client = $request->client;
            $newRequest->project = $request->project;
            $newRequest->level_priority = $request->level_priority;
            $newRequest->target_date = $request->target_date;
            $newRequest->requirment = $request->requirment;
            $newRequest->status = "Baru";
            $newRequest->created_by = Auth::user()->name;
            $newRequest->created_id = Auth::user()->id;
            $newRequest->created_date = Carbon::now('Asia/Jakarta');
            $newRequest->save();

            //addResourceDeatail
            $newResourceDetail = new ResourceDetail();
            $newResourceDetail->resource_id = $newRequest->id;
            $newResourceDetail->position = $request->position;
            $newResourceDetail->skill = $request->skill;
            $newResourceDetail->quantity = $request->quantity;
            $newResourceDetail->education = $request->education;
            $newResourceDetail->qualification = $request->qualification;
            $newResourceDetail->experience = $request->experience;
            $newResourceDetail->contract = $request->contract;
            $newResourceDetail->description = $request->description;
            $newResourceDetail->created_date = Carbon::now('Asia/Jakarta');
            $newResourceDetail->created_by = Auth::user()->name;
            $newResourceDetail->created_id = Auth::user()->id;
            $newResourceDetail->save();


            //addWawancaraProgress
            $datas = [];

            $interviewStages = $request->input('interview_stage');
            $description = $request->input('isDescription');
            $isClients = $request->input('isClient');

            $count = count($interviewStages);


            for ($i = 0; $i < $count; $i++) {
                $datas[] = [
                    'description' => $description[$i],
                    'interview_stage' => $interviewStages[$i],
                    'isClient' => $isClients[$i]
                ];
            }

            if ($datas != null) {
                foreach ($datas as $data) {
                    try {
                        $newWawancaraProgress = new InterviewProgress();
                        $newWawancaraProgress->resource_id = $newRequest->id;
                        $newWawancaraProgress->resource_detail_id = $newResourceDetail->id;
                        $newWawancaraProgress->name_progress = $data['interview_stage'];
                        $newWawancaraProgress->isClient = intval($data['isClient']);
                        $newWawancaraProgress->description = $data['description'];
                        $newWawancaraProgress->created_by = Auth::user()->name;
                        $newWawancaraProgress->created_id = Auth::user()->id;
                        $newWawancaraProgress->created_date = Carbon::now('Asia/Jakarta');
                        $newWawancaraProgress->save();
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => 'Error processing data',
                            'error' => $e->getMessage(),
                        ], 500);
                    }
                }
            }

            return redirect('/requester')->with(['message' => 'Data berhasil ditambahkan!'], 200);
        } catch (\Exception $e) {
            dd([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
        }
    }

    public function detailRequester($id)
    {
        $resourceDetail = Resource::find($id);
        if (!$resourceDetail) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
        }
        $positionDetail = ResourceDetail::where('resource_id', $resourceDetail->id)->first();
        $interviewDetail = InterviewProgress::where('resource_id', operator: $resourceDetail->id)->get();
        
        $user = User::where('role_id', 3)->get();
        $tasklist = TaksList::where('resource_id', $id)->get();

        $salary = ResourceSalary::where('resource_id', $resourceDetail->id)->first();
        $fasilitas = ResourceFacility::where('resource_id', $resourceDetail->id)->get();

        return view('request.detailRequester', compact('resourceDetail', 'positionDetail', 'interviewDetail','user','tasklist', 'fasilitas','salary'));
    }

    public function updateRequester($id)
    {
        $resourceDetail = Resource::find($id);
        if (!$resourceDetail) {
            return redirect()->back()->with('error', 'Permintaan tidak ditemukan.');
        }
        $positionDetail = ResourceDetail::where('resource_id', $resourceDetail->id)->first();
        $interviewDetail = InterviewProgress::where('resource_id', $resourceDetail->id)->get();

        $user = User::where('role_id', 3)->get();
        $tasklist = TaksList::where('resource_id', $id)->get();

        $salary = ResourceSalary::where('resource_id', $resourceDetail->id)->first();
        $fasilitas = ResourceFacility::where('resource_id', $resourceDetail->id)->get();

        return view('request.updateRequester', compact('user', 'resourceDetail', 'positionDetail', 'interviewDetail', 'tasklist', 'fasilitas','salary'));
    }

    public function saveRequester($id, Request $request)
    {
        $resource = Resource::find($id);
        $resourceDetail = ResourceDetail::where('resource_id', $id)->first();
        $salary = ResourceSalary::where('resource_id', $resource->id)->first();

        //salary
        if($salary != null){
           $salary->min_salary = $request->input('min_salary');
           $salary->max_salary = $request->input('max_salary');
           $salary->ket_salary = $request->input('ket_salary');
           $salary->pph21 = $request->input('pph21') == "on" ? true : false;
           $salary->ket_pph21 = $request->input('ket_pph21');
           $salary->bpjs_ket = $request->input('bpjs_ket') == "on" ? true : false;
           $salary->ket_bpjsket = $request->input('ket_bpjsket');
           $salary->bpjs_kes = $request->input('bpjs_kes')  == "on" ? true : false;
           $salary->ket_bpjskes = $request->input('ket_bpjskes');
           $salary->updated_date = Carbon::now('Asia/Jakarta');
           $salary->updated_id = Auth::user()->id;
           $salary->updated_by = Auth::user()->name;
           $salary->save();            
        }else{
            $newSalary = new ResourceSalary();
            $newSalary->resource_id = $resource->id;
            $newSalary->resource_detail_id = $resourceDetail->id;
            $newSalary->min_salary = $request->input('min_salary');
            $newSalary->max_salary = $request->input('max_salary');
            $newSalary->ket_salary = $request->input('ket_salary');
            $newSalary->pph21 = $request->input('pph21') == "on" ? true : false;
            $newSalary->ket_pph21 = $request->input('ket_pph21');
            $newSalary->bpjs_ket = $request->input('bpjs_ket') == "on" ? true : false;
            $newSalary->ket_bpjsket = $request->input('ket_bpjsket');
            $newSalary->bpjs_kes = $request->input('bpjs_kes')  == "on" ? true : false;
            $newSalary->ket_bpjskes = $request->input('ket_bpjskes');
            $newSalary->created_date = Carbon::now('Asia/Jakarta');
            $newSalary->created_id = Auth::user()->id;
            $newSalary->created_by = Auth::user()->name;

            $newSalary->save();
        };

        //tasklist
        if ($request->tasklist != null) {
            foreach ($request->tasklist as $task) {
                $user = User::find($task);

                $newTask = TaksList::firstOrNew([
                    'resource_id' => $resource->id,
                    'resource_detail_id' => $resourceDetail->id,
                    'user_id' => $user->id,
                ]);

                if (!$newTask->exists) {
                    $newTask = new TaksList();
                    $newTask->resource_id = $resource->id;
                    $newTask->resource_detail_id = $resourceDetail->id;
                    $newTask->user_id = $user->id;
                    $newTask->username = $user->name;
                    $newTask->status = "Baru";
                    $newTask->created_by = Auth::user()->name;
                    $newTask->created_id = Auth::user()->id;
                    $newTask->created_date = Carbon::now('Asia/Jakarta');
                    $newTask->save();
                }
            }

            $tasksToDelete = TaksList::where('resource_id', $resource->id)
                ->where('resource_detail_id', $resourceDetail->id)
                ->whereNotIn('user_id', $request->tasklist)
                ->get();

            foreach ($tasksToDelete as $taskToDelete) {
                $taskToDelete->delete();
            }
        } else {
            TaksList::where('resource_id', $resource->id)
                ->where('resource_detail_id', $resourceDetail->id)
                ->delete();
        }

        //resource
        if ($resource != null) {

            $resource->name = $request->name;
            $resource->client = $request->client;
            $resource->project = $request->project;
            $resource->level_priority = $request->level_priority;
            $resource->target_date = $request->target_date;
            $resource->requirment = $request->requirment;

            $existingTasks = TaksList::where('resource_id', $resource->id)
                ->where('resource_detail_id', $resourceDetail->id)
                ->get();

            $resource->status = $existingTasks != null  ? "Penugasan" : "Baru";

            $resource->updated_by = Auth::user()->name;
            $resource->updated_id = Auth::user()->id;
            $resource->updated_date = Carbon::now('Asia/Jakarta');

            $resource->save();
        }

        //postiion
        if ($resourceDetail != null) {
            $resourceDetail->position = $request->position;
            $resourceDetail->skill = $request->skill;
            $resourceDetail->quantity = $request->quantity;
            $resourceDetail->education = $request->education;
            $resourceDetail->qualification = $request->qualification;
            $resourceDetail->experience = $request->experience;
            $resourceDetail->contract = $request->contract;
            $resourceDetail->description = $request->description;
            $resourceDetail->updated_date = Carbon::now('Asia/Jakarta');
            $resourceDetail->updated_by = Auth::user()->name;
            $resourceDetail->updated_id = Auth::user()->id;
            $resourceDetail->save();
        }

        //fasilitas
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

            $fasilitasDelete = ResourceFacility::whereNotIn('id', values: $idFasilitas)
                ->get();

            foreach ($fasilitasDelete as $fasilitas) {
                $fasilitas->delete();
            }

            foreach ($fasilitasDatas as $data) {

                if ($data['id'] != 0) {
                    $existFasilitas = ResourceFacility::where('id', $data['id'])->first();
                    $existFasilitas->fasilitas_name = $data['fasilitas_name'];
                    $existFasilitas->ket_fasilitas = $data['ket_fasilitas'];
                    $existFasilitas->updated_date = Carbon::now('Asia/Jakarta');
                    $existFasilitas->updated_id = Auth::user()->id;
                    $existFasilitas->updated_by = Auth::user()->name;
                    $existFasilitas->save();
                } else {
                    $newFasilitas = new ResourceFacility();
                    $newFasilitas->resource_id = $resource->id;
                    $newFasilitas->resource_detail_id = $resourceDetail->id;
                    $newFasilitas->fasilitas_name = $data['fasilitas_name'];
                    $newFasilitas->ket_fasilitas = $data['ket_fasilitas'];
                    $newFasilitas->created_date = Carbon::now('Asia/Jakarta');
                    $newFasilitas->created_id = Auth::user()->id;
                    $newFasilitas->created_by = Auth::user()->name;
                    $newFasilitas->save();
                }
            }
        }

        //interviewProgress
        $datas = [];
        $interviewId = $request->input('interviewProgress_id');
        $interviewStages = $request->input('interview_stage');
        $description = $request->input('isDescription');
        $isClients = $request->input('isClient');

        $count = count($interviewStages);

        for ($i = 0; $i < $count; $i++) {
            $datas[] = [
                'id' => $interviewId[$i],
                'description' => $description[$i],
                'interview_stage' => $interviewStages[$i],
                'isClient' => $isClients[$i]
            ];
        }

        if ($datas != null) {

            $idsInData = array_map(function ($data) {
                return $data['id'];
            }, $datas);

            $InterviewProgressDelete = InterviewProgress::whereNotIn('id', $idsInData)
                ->get();

            foreach ($InterviewProgressDelete as $interview) {
                $interview->delete();
            }

            foreach ($datas as $data) {

                if ($data['id'] != 0) {
                    $exisInterviewProgress = InterviewProgress::where('id', $data['id'])->first();
                    $exisInterviewProgress->name_progress = $data['interview_stage'];
                    $exisInterviewProgress->isClient = intval($data['isClient']);
                    $exisInterviewProgress->description = $data['description'];
                    $exisInterviewProgress->updated_by = Auth::user()->name;
                    $exisInterviewProgress->updated_id = Auth::user()->id;
                    $exisInterviewProgress->updated_date = Carbon::now('Asia/Jakarta');
                    $exisInterviewProgress->save();
                } else {
                    $newWawancaraProgress = new InterviewProgress();
                    $newWawancaraProgress->resource_id = $resource->id;
                    $newWawancaraProgress->resource_detail_id = $resourceDetail->id;
                    $newWawancaraProgress->name_progress = $data['interview_stage'];
                    $newWawancaraProgress->isClient = intval($data['isClient']);
                    $newWawancaraProgress->description = $data['description'];
                    $newWawancaraProgress->created_by = Auth::user()->name;
                    $newWawancaraProgress->created_id = Auth::user()->id;
                    $newWawancaraProgress->created_date = Carbon::now('Asia/Jakarta');
                    $newWawancaraProgress->save();
                }
            }
        }

        return redirect('/requester')->with(['message' => 'Data berhasil ditambahkan!'], 200);
    }
}
