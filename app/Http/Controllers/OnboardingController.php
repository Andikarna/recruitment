<?php

namespace App\Http\Controllers;

use view;
use Carbon\Carbon;
use App\Models\Skill;
use App\Models\Family;
use App\Models\Offering;
use App\Models\Resource;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\Languange;
use App\Models\Reference;
use App\Models\Onboarding;
use Illuminate\Http\Request;
use App\Models\OfferingSalary;
use App\Models\ResourceDetail;
use App\Models\ResourceSalary;
use App\Models\EducationFormal;
use App\Models\EmergencyContact;
use App\Models\OfferingApproval;
use App\Models\OfferingFasility;
use App\Models\WorkingExperience;
use App\Models\EducationNonFormal;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalInformation;

class OnboardingController extends Controller
{
    public function onboarding()
    {
        $onboarding  = Onboarding::with('resource', 'resourceDetail')
            ->orderByRaw('COALESCE(updated_date, created_date) DESC')
            ->paginate(5)
            ->withQueryString();

        $userId = Auth::user()->id;

        return view('onboarding.onboarding', compact('onboarding'));
    }

    public function addOnboarding(Request $request, $id)
    {

        $interview = Interview::where('id', $id)->first();
        $candidate = Candidate::where('id', $interview->candidate_id)->first();
        $offering = Offering::where('interview_id', $interview->id)->first();
        $offeringApproval = OfferingApproval::where('offering_id', $offering->id)->get();

        $asset = $request->asset_laptop != null ?  $request->asset_laptop : null;

        $newOnboarding = new Onboarding();
        $newOnboarding->candidate_id = $interview->candidate_id;
        $newOnboarding->interivew_id = $id;
        $newOnboarding->resource_id = $interview->resource_id;
        $newOnboarding->resource_detail_id = $interview->resource_detail_id;
        $newOnboarding->name = $interview->name;
        $newOnboarding->laptop = $asset;
        $newOnboarding->gender = $candidate->gender;
        $newOnboarding->join_date = $request->join_date;
        $newOnboarding->start_contract = $request->start_contract;
        $newOnboarding->end_contract = $request->end_contract;
        $newOnboarding->description = $request->ket_onboarding;
        $newOnboarding->status = "Baru";
        $newOnboarding->created_date = Carbon::now('Asia/Jakarta');
        $newOnboarding->created_id = Auth::user()->id;
        $newOnboarding->created_by = Auth::user()->name;

        $newOnboarding->save();

        //updated status
        $interview->status = "Onboard";
        $interview->updated_date = Carbon::now('Asia/Jakarta');
        $interview->updated_id = Auth::user()->id;
        $interview->updated_by = Auth::user()->name;
        $interview->save();

        $offering->status = "Onboard";
        $offering->updated_date = Carbon::now('Asia/Jakarta');
        $offering->updated_id = Auth::user()->id;
        $offering->updated_by = Auth::user()->name;
        $offering->save();


        foreach ($offeringApproval as $data) {
            $data->status = "Onboard";
            $data->updated_date = Carbon::now('Asia/Jakarta');
            $data->updated_id = Auth::user()->id;
            $data->updated_by = Auth::user()->name;
            $data->save();
        }

        return redirect('onboarding');
    }

    public function detailOnboarding($id)
    {
        $onboarding = Onboarding::find($id);
        $resource = Resource::where('id', $onboarding->resource_id)->first();
        $candidate = Candidate::where('id', $onboarding->candidate_id)
            ->with('emergencyContact')
            ->with('family')
            ->with('education_formal')
            ->with('education_nonformal')
            ->with('skill')
            ->with('languange')
            ->with('working_experience')
            ->with('reference')
            ->with('additional_information')
            ->first();
        $offering = Offering::where('interview_id', $onboarding->interivew_id)->first();

        $offeringSalary = OfferingSalary::where('offering_id', $offering->id)->first();
        $offeringFasilitas = OfferingFasility::where('offering_id', $offering->id)->get();

        $family = $candidate->family?->get() ?? collect();;
        $education_formal = $candidate->education_formal?->get() ?? collect();
        $education_nonformal = $candidate->education_nonformal?->get() ?? collect();
        $skill = $candidate->skill?->get() ?? collect();
        $languange = $candidate->languange?->get() ?? collect();
        $working_experience = $candidate->working_experience?->get() ?? collect();

        return view('onboarding.detailonboarding', compact('onboarding', 'offeringSalary', 'offeringFasilitas', 'candidate', 'resource', 'family', 'education_formal', 'education_nonformal', 'skill', 'languange','working_experience'));
    }

    public function updateOnboarding($id)
    {
        $onboarding = Onboarding::find($id);
        $resource = Resource::where('id', $onboarding->resource_id)->first();
        $candidate = Candidate::where('id', $onboarding->candidate_id)
            ->with('emergencyContact')
            ->with('family')
            ->with('education_formal')
            ->with('education_nonformal')
            ->with('skill')
            ->with('languange')
            ->with('working_experience')
            ->with('reference')
            ->with('additional_information')
            ->first();
        $offering = Offering::where('interview_id', $onboarding->interivew_id)->first();

        $offeringSalary = OfferingSalary::where('offering_id', $offering->id)->first();
        $offeringFasilitas = OfferingFasility::where('offering_id', $offering->id)->get();

        $family = $candidate->family?->get() ?? collect();;
        $education_formal = $candidate->education_formal?->get() ?? collect();
        $education_nonformal = $candidate->education_nonformal?->get() ?? collect();
        $skill = $candidate->skill?->get() ?? collect();
        $languange = $candidate->languange?->get() ?? collect();
        $working_experience = $candidate->working_experience?->get() ?? collect();

        return view('onboarding.updateOnboarding', compact('onboarding', 'offeringSalary', 'offeringFasilitas', 'candidate', 'resource', 'family', 'education_formal', 'education_nonformal', 'skill', 'languange','working_experience'));
    }

    public function saveOnboarding(Request $request, $id)
    {
        //dd($request);
        $onboarding = Onboarding::find($id);

        $onboarding->address = $request->address;
        $onboarding->country = $request->country;
        $onboarding->province = $request->province;
        $onboarding->city = $request->city;
        $onboarding->zipcode = $request->zipcode;
        $onboarding->place_of_birth = $request->place_of_birth;
        $onboarding->date_of_birth = $request->date_of_birth;
        $onboarding->blood_type = $request->blood_type;
        $onboarding->religion = $request->religion;
        $onboarding->home_phone = $request->home_phone;
        $onboarding->mobile_phone = $request->mobile_phone;
        $onboarding->number_id = $request->number_id;
        $onboarding->number_tax = $request->number_tax;
        $onboarding->laptop = $request->asset_laptop;
        $onboarding->join_date = $request->join_date;
        $onboarding->start_contract = $request->start_contract;
        $onboarding->end_contract = $request->end_contract;
        // $onboarding->description = $request->description;
        $onboarding->status = "Pengecekan";
        $onboarding->updated_date = Carbon::now('Asia/Jakarta');
        $onboarding->updated_id = Auth::user()->id;
        $onboarding->updated_by = Auth::user()->name;

        //kontakdarurat
        $emergencyContact = EmergencyContact::where('candidate_id', $onboarding->candidate_id)->first();
        if ($emergencyContact != null) {
            $emergencyContact->name = $request->name_emergency;
            $emergencyContact->number = $request->number_emergency;
            $emergencyContact->relation = $request->relation_emergency;
            $emergencyContact->updated_date = Carbon::now('Asia/Jakarta');
            $emergencyContact->updated_id =  Auth::user()->id;
            $emergencyContact->updated_by =  Auth::user()->name;
            $emergencyContact->save();
        } else {
            $newEmeregency = new EmergencyContact();
            $newEmeregency->candidate_id = $onboarding->candidate_id;
            $newEmeregency->name =  $request->name_emergency;
            $newEmeregency->number = $request->number_emergency;
            $newEmeregency->relation =  $request->relation_emergency;
            $newEmeregency->created_date =  Carbon::now('Asia/Jakarta');
            $newEmeregency->created_id = Auth::user()->id;
            $newEmeregency->created_by =  Auth::user()->name;
            $newEmeregency->save();
        }

        //family
        $family = [];
        $family_id = $request->input('familiId');
        $familyName = $request->input('name_family');
        $familyGender = $request->input('gender_family');
        $familyWorking  = $request->input('work_family');
        $familyEducation  = $request->input('education_family');

        $countFasilitas = count($family_id);

        for ($i = 0; $i < $countFasilitas; $i++) {
            $family[] = [
                'id' => $family_id[$i],
                'name' => $familyName[$i],
                'gender' => $familyGender[$i],
                'working' => $familyWorking[$i],
                'education' => $familyEducation[$i]
            ];
        };

        if ($family != null) {

            $idFamily = array_map(function ($data): mixed {
                return $data['id'];
            }, array: $family);

            $familyDelete = Family::whereNotIn('id', values: $idFamily)
                ->get();

            foreach ($familyDelete as $familys) {
                $familys->delete();
            }

            foreach ($family as $data) {
                if ($data['id'] != 0) {
                    $existFamily = Family::where('id', $data['id'])->first();
                    $existFamily->name = $data['name'];
                    $existFamily->gender = $data['gender'];
                    $existFamily->working = $data['working'];
                    $existFamily->education = $data['education'];
                    $existFamily->updated_date = Carbon::now('Asia/Jakarta');
                    $existFamily->updated_id = Auth::user()->id;
                    $existFamily->updated_by = Auth::user()->name;
                    $existFamily->save();
                } else {
                    $newFamily = new Family();
                    $newFamily->candidate_id = $onboarding->candidate_id;
                    $newFamily->name = $data['name'];
                    $newFamily->gender = $data['gender'];
                    $newFamily->working = $data['working'];
                    $newFamily->education = $data['education'];
                    $newFamily->created_date = Carbon::now('Asia/Jakarta');
                    $newFamily->created_id = Auth::user()->id;
                    $newFamily->created_by = Auth::user()->name;
                    $newFamily->save();
                }
            }
        }

        //educationformal
        $educationformal = [];
        $educationformal_id = $request->input('educationformalId');
        $educationformal_name = $request->input('name_institusi_educationformal');
        $educationformal_city = $request->input('city_educationformal');
        $educationformal_major  = $request->input('major_educationformal');
        $educationformal_gpa  = $request->input('gpa_educationformal');
        $educationformal_start  = $request->input('start_educationformal');
        $educationformal_end = $request->input('end_educationformal');

        $countEducationFormal = count($educationformal_id);

        for ($i = 0; $i < $countEducationFormal; $i++) {
            $educationformal[] = [
                'id' => $educationformal_id[$i],
                'name' => $educationformal_name[$i],
                'city' => $educationformal_city[$i],
                'major' => $educationformal_major[$i],
                'gpa' => $educationformal_gpa[$i],
                'start' => $educationformal_start[$i],
                'end' => $educationformal_end[$i]
            ];
        };

        if ($educationformal != null) {

            $idEducationFormal = array_map(function ($data): mixed {
                return $data['id'];
            }, array: $educationformal);

            $eduFormalDelete = EducationFormal::whereNotIn('id', values: $idEducationFormal)
                ->get();

            foreach ($eduFormalDelete as $eduFormal) {
                $eduFormal->delete();
            }

            foreach ($educationformal as $data) {
                if ($data['id'] != 0) {
                    $exisEduFormal = EducationFormal::where('id', $data['id'])->first();
                    $exisEduFormal->name = $data['name'];
                    $exisEduFormal->city = $data['city'];
                    $exisEduFormal->major = $data['major'];
                    $exisEduFormal->gpa = $data['gpa'];
                    $exisEduFormal->start_date = $data['start'];
                    $exisEduFormal->end_date = $data['end'];
                    $exisEduFormal->updated_date =  Carbon::now('Asia/Jakarta');
                    $exisEduFormal->updated_id = Auth::user()->id;
                    $exisEduFormal->updated_by = Auth::user()->name;
                    $exisEduFormal->save();
                } else {
                    $newEduFormal = new EducationFormal();
                    $newEduFormal->candidate_id = $onboarding->candidate_id;
                    $newEduFormal->name = $data['name'];
                    $newEduFormal->city = $data['city'];
                    $newEduFormal->major = $data['major'];
                    $newEduFormal->gpa = $data['gpa'];
                    $newEduFormal->start_date = $data['start'];
                    $newEduFormal->end_date = $data['end'];
                    $newEduFormal->created_date =  Carbon::now('Asia/Jakarta');
                    $newEduFormal->created_id = Auth::user()->id;
                    $newEduFormal->created_by = Auth::user()->name;
                    $newEduFormal->save();
                }
            }
        }

        //nonformal
        $nonformal = [];
        $nonformall_id = $request->input('educationNonformalId');
        $nonformal_name = $request->input('name_educationNonformal');
        $nonformal_year = $request->input('year_educationNonformal');
        $nonformal_duration  = $request->input('duration_educationNonformal');
        $nonformal_certirficate  = $request->input('certificate_educationNonformal');

        $countNonFormal = count($nonformall_id);

        for ($i = 0; $i < $countNonFormal; $i++) {
            $nonformal[] = [
                'id' => $nonformall_id[$i],
                'name' => $nonformal_name[$i],
                'year' => $nonformal_year[$i],
                'duration' => $nonformal_duration[$i],
                'certificate' => $nonformal_certirficate[$i],
            ];
        };

        if ($nonformal != null) {

            $idNonFormal = array_map(function ($data): mixed {
                return $data['id'];
            }, array: $nonformal);

            $eduNonFormalDelete = EducationNonFormal::whereNotIn('id', values: $idNonFormal)
                ->get();

            foreach ($eduNonFormalDelete as $eduNonFormal) {
                $eduNonFormal->delete();
            }

            foreach ($nonformal as $data) {
                if ($data['id'] != 0) {
                    $existNonFormal = EducationNonFormal::where('id', $data['id'])->first();
                    $existNonFormal->name = $data['name'];
                    $existNonFormal->year = $data['year'];
                    $existNonFormal->duration = $data['duration'];
                    $existNonFormal->certificate = $data['certificate'];
                    $existNonFormal->updated_date =  Carbon::now('Asia/Jakarta');
                    $existNonFormal->updated_id = Auth::user()->id;
                    $existNonFormal->updated_by = Auth::user()->name;
                    $existNonFormal->save();
                } else {
                    $newEduNonFormal = new EducationNonFormal();
                    $newEduNonFormal->candidate_id = $onboarding->candidate_id;
                    $newEduNonFormal->name = $data['name'];
                    $newEduNonFormal->year = $data['year'];
                    $newEduNonFormal->duration = $data['duration'];
                    $newEduNonFormal->certificate = $data['certificate'];
                    $newEduNonFormal->created_date =  Carbon::now('Asia/Jakarta');
                    $newEduNonFormal->created_id = Auth::user()->id;
                    $newEduNonFormal->created_by = Auth::user()->name;
                    $newEduNonFormal->save();
                }
            }
        }

        //skill
        $skill = [];
        $skill_id = $request->input('skillId');
        $skill_name = $request->input('name_skill');
        $skill_level = $request->input('level_skill');


        $countSkill = count($skill_id);

        for ($i = 0; $i < $countSkill; $i++) {
            $skill[] = [
                'id' => $skill_id[$i],
                'name' => $skill_name[$i],
                'level' => $skill_level[$i],
            ];
        };

        if ($skill != null) {

            $idSkill = array_map(function ($data): mixed {
                return $data['id'];
            }, array: $skill);

            $skillDelete = Skill::whereNotIn('id', values: $idSkill)
                ->get();

            foreach ($skillDelete as $skills) {
                $skills->delete();
            }

            foreach ($skill as $data) {
                if ($data['id'] != 0) {
                    $existSkill = Skill::where('id', $data['id'])->first();
                    $existSkill->name = $data['name'];
                    $existSkill->level = $data['level'];
                    $existSkill->updated_date =  Carbon::now('Asia/Jakarta');
                    $existSkill->updated_id = Auth::user()->id;
                    $existSkill->updated_by = Auth::user()->name;
                    $existSkill->save();
                } else {
                    $newSkill = new Skill();
                    $newSkill->candidate_id = $onboarding->candidate_id;
                    $newSkill->name = $data['name'];
                    $newSkill->level = $data['level'];
                    $newSkill->created_date =  Carbon::now('Asia/Jakarta');
                    $newSkill->created_id = Auth::user()->id;
                    $newSkill->created_by = Auth::user()->name;
                    $newSkill->save();
                }
            }
        }

        //bahasa
        $languange = [];
        $languange_id = $request->input('langaungeId');
        $languange_name = $request->input('name_languange');
        $languange_write = $request->input('write_languange');
        $languange_speak  = $request->input('speak_languange');
        $languange_read  = $request->input('read_languange');

        $countLanguange = count($languange_id);

        for ($i = 0; $i < $countLanguange; $i++) {
            $languange[] = [
                'id' => $languange_id[$i],
                'name' => $languange_name[$i],
                'write' => $languange_write[$i],
                'speak' => $languange_speak[$i],
                'read' => $languange_read[$i],
            ];
        };

        if ($languange != null) {

            $idlanguange = array_map(function ($data): mixed {
                return $data['id'];
            }, array: $languange);

            $languangeDelete = Languange::whereNotIn('id', values: $idlanguange)
                ->get();

            foreach ($languangeDelete as $languanges) {
                $languanges->delete();
            }

            foreach ($languange as $data) {
                if ($data['id'] != 0) {
                    $existLanguange = Languange::where('id', $data['id'])->first();
                    $existLanguange->name_languange = $data['name'];
                    $existLanguange->write = $data['write'];
                    $existLanguange->speak = $data['speak'];
                    $existLanguange->read = $data['read'];
                    $existLanguange->updated_date =  Carbon::now('Asia/Jakarta');
                    $existLanguange->updated_id = Auth::user()->id;
                    $existLanguange->updated_by = Auth::user()->name;
                    $existLanguange->save();
                } else {
                    $newLanguange = new Languange();
                    $newLanguange->candidate_id = $onboarding->candidate_id;
                    $newLanguange->name_languange = $data['name'];
                    $newLanguange->write = $data['write'];
                    $newLanguange->speak = $data['speak'];
                    $newLanguange->read = $data['read'];
                    $newLanguange->created_date =  Carbon::now('Asia/Jakarta');
                    $newLanguange->created_id = Auth::user()->id;
                    $newLanguange->created_by = Auth::user()->name;
                    $newLanguange->save();
                }
            }
        }

        //working
        $workingExperience = [];
        $workingExperience_id = $request->input('workingId');
        $workingExperience_company = $request->input('company_name_working');
        $workingExperience_industry = $request->input('industry_working');
        $workingExperience_address  = $request->input('address_working');
        $workingExperience_status  = $request->input('status_working');
        $workingExperience_start  = $request->input('start_working');
        $workingExperience_end  = $request->input('end_working');
        $workingExperience_description  = $request->input('description_working');
        $workingExperience_allowance  = $request->input('allowance_working');
        $workingExperience_salary  = $request->input('salary_working');
        $workingExperience_project  = $request->input('project_working');
        $workingExperience_reason  = $request->input('reason_working');
        $countExperience = count($workingExperience_id);

        for ($i = 0; $i < $countExperience; $i++) {
            $workingExperience[] = [
                'id' => $workingExperience_id[$i],
                'company' => $workingExperience_company[$i],
                'industry' => $workingExperience_industry[$i],
                'address' => $workingExperience_address[$i],
                'status' => $workingExperience_status[$i],
                'start' => $workingExperience_start[$i],
                'end' => $workingExperience_end[$i],
                'description' => $workingExperience_description[$i],
                'allowance' => $workingExperience_allowance[$i],
                'salary' => $workingExperience_salary[$i],
                'project' => $workingExperience_project[$i],
                'reason' => $workingExperience_reason[$i],
            ];
        };


        if ($workingExperience != null) {

            $idWorking = array_map(function ($data): mixed {
                return $data['id'];
            }, array: $workingExperience);

            $workingDelete = WorkingExperience::whereNotIn('id', values: $idWorking)
                ->get();

            foreach ($workingDelete as $workings) {
                $workings->delete();
            }

            foreach ($workingExperience as $data) {
                if ($data['id'] != 0) {
                    $existWorkingExperience = WorkingExperience::where('id', $data['id'])->first();
                    $existWorkingExperience->name =  $data['company'];
                    $existWorkingExperience->industry = $data['industry'];
                    $existWorkingExperience->address =  $data['address'];
                    $existWorkingExperience->status =  $data['status'];
                    $existWorkingExperience->start_date =  $data['start'];
                    $existWorkingExperience->end_date =  $data['end'];
                    $existWorkingExperience->description =  $data['description'];
                    $existWorkingExperience->allowence =  $data['allowance'];
                    $existWorkingExperience->salary =  $data['salary'];
                    $existWorkingExperience->reason =  $data['reason'];
                    $existWorkingExperience->project =  $data['project'];
                    $existWorkingExperience->updated_date = Carbon::now('Asia/Jakarta');
                    $existWorkingExperience->updated_id =  Auth::user()->id;
                    $existWorkingExperience->updated_by = Auth::user()->name;
                    $existWorkingExperience->save();


                } else {

                    $workingExperience = new WorkingExperience();
                    $workingExperience->candidate_id = $onboarding->candidate_id;
                    $workingExperience->name =  $data['company'];
                    $workingExperience->industry = $data['industry'];
                    $workingExperience->address =  $data['address'];
                    $workingExperience->status =  $data['status'];
                    $workingExperience->start_date =  $data['start'];
                    $workingExperience->end_date =  $data['end'];
                    $workingExperience->description =  $data['description'];
                    $workingExperience->allowence =  $data['allowance'];
                    $workingExperience->salary =  $data['salary'];
                    $workingExperience->reason =  $data['reason'];
                    $workingExperience->project =  $data['project'];
                    $workingExperience->created_date = Carbon::now('Asia/Jakarta');
                    $workingExperience->created_id =  Auth::user()->id;
                    $workingExperience->created_by = Auth::user()->name;
                    $workingExperience->save();
                }
            }
        }


        //refrensi
        $referensi = Reference::where('candidate_id', $onboarding->candidate_id)->first();
        if($referensi != null){
            $referensi->name = $request->source_refrences;
            $referensi->number = $request->phone_refrences;
            $referensi->position = $request->position_refrences;
            $referensi->relation = $request->relation_refrences;
            $referensi->updated_date = Carbon::now('Asia/Jakarta');
            $referensi->updated_id = Auth::user()->id;
            $referensi->updated_by = Auth::user()->name;
            $referensi->save();
        }else{
            $newReference = new Reference();
            $newReference->candidate_id = $onboarding->candidate_id;
            $newReference->name = $request->source_refrences;
            $newReference->number = $request->phone_refrences;
            $newReference->position = $request->position_refrences;
            $newReference->relation = $request->relation_refrences;
            $newReference->created_date = Carbon::now('Asia/Jakarta');
            $newReference->created_id = Auth::user()->id;
            $newReference->created_by = Auth::user()->name;
            $newReference->save();
        }


        //aditional
        $additional = AdditionalInformation::where('candidate_id', $onboarding->candidate_id)->first();
        if($additional != null){
            $additional->source = $request->source_aditional;
            $additional->been_treated = $request->been_treated_aditional;
            $additional->disease = $request->been_treated;
            $additional->strength = $request->strength_aditional;
            $additional->weakness =  $request->weakness_aditional;  
            $additional->against_weakness = $request->against_weakness_aditional;
            $additional->updated_date = Carbon::now('Asia/Jakarta');
            $additional->updated_id = Auth::user()->id;
            $additional->updated_by = Auth::user()->name;
            $additional->save();
        }else{
            $newAdditional = new AdditionalInformation();
            $newAdditional->candidate_id = $onboarding->candidate_id;
            $newAdditional->source = $request->source_aditional;
            $newAdditional->been_treated = $request->been_treated_aditional;
            $newAdditional->disease = $request->been_treated;
            $newAdditional->strength = $request->strength_aditional;
            $newAdditional->weakness =  $request->weakness_aditional;  
            $newAdditional->against_weakness = $request->against_weakness_aditional;
            $newAdditional->created_date = Carbon::now('Asia/Jakarta');
            $newAdditional->created_id = Auth::user()->id;
            $newAdditional->created_by = Auth::user()->name;
            $newAdditional->save();
        }

        $onboarding->save();


        return redirect('onboarding');
    }

    public function cancelOnboarding($id){
        $onboarding = Onboarding::find($id);
        $onboarding->status = "Cancel";
        $onboarding->save();

        return redirect('/onboarding');
    }

    public function sendHrm($id){

        $onboarding = Onboarding::find($id);
        $onboarding->status = "Selesai";
        $onboarding->updated_date = Carbon::now('Asia/Jakarta');
        $onboarding->updated_id = Auth::user()->id;
        $onboarding->updated_by = Auth::user()->name;
        $onboarding->save();

        $interview = Interview::where('id', $onboarding->interivew_id)->first();
        $interview->status = "Selesai";
        $interview->updated_date = Carbon::now('Asia/Jakarta');
        $interview->updated_id = Auth::user()->id;
        $interview->updated_by = Auth::user()->name;
        $interview->save();

        $offering = Offering::where('interview_id',$interview->id)->first();
        $offering->status = "Selesai";
        $offering->updated_date = Carbon::now('Asia/Jakarta');
        $offering->updated_id = Auth::user()->id;
        $offering->updated_by = Auth::user()->name;
        $offering->save();

        $resourceDetail = ResourceDetail::where('id', $onboarding->resource_detail_id)
        ->where('resource_id', $onboarding->resource_id)->first();
        $resourceDetail->fulfilled = ($resourceDetail->fulfilled ?? 0) + 1;
        $resourceDetail->save();

        return redirect('/onboarding');
    }
}
