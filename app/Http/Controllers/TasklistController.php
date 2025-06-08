<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\TaksList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasklistController extends Controller
{
    public function tasklist(Request $request){
        $userId = Auth::user()->id;
        $tasklist = TaksList::with('resource','resource_detail')
        ->orderByRaw('COALESCE(updated_date, created_date) DESC');
      
        if ($request->filled('search')) {
            $search = $request->search;
            $tasklist->WhereHas('resource', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('client', 'LIKE', "%{$search}%")
                        ->orWhere('project', 'LIKE', "%{$search}%")
                        ->orWhere('created_by', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('resource_detail', function ($q) use ($search) {
                    $q->where('quantity', 'LIKE', "%{$search}%");
                });
        }

        $tasklist =  $tasklist
        ->where('user_id',$userId)
        ->paginate(5)
        ->withQueryString();

        return view('daftartugas.tasklist', compact('tasklist'));
    }
}
