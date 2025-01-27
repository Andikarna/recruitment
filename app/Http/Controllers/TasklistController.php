<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\TaksList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasklistController extends Controller
{
    public function tasklist(){
        $userId = Auth::user()->id;
        $tasklist = TaksList::with('resource','resource_detail')
        ->where('user_id',$userId)
        ->orderByRaw('COALESCE(updated_date, created_date) DESC')
        ->paginate(5)
        ->withQueryString();

        return view('daftartugas.tasklist', compact('tasklist'));
    }
}
