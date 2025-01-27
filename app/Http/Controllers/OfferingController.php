<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Offering;
use Illuminate\Http\Request;
use App\Models\OfferingApproval;
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
}
