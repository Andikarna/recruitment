<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function user(){
        $data = User::all();
        return response()->json($data,200);
    }
    
    public function view()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            session(['user' => $user]);

            $user = User::where('id',Auth::user()->id)->pluck('role_id')->first();
            $ridirect = 'dashboard';
            if($user == 2){
                $ridirect = 'dashboard';
            }
            if($user == 3){
                $ridirect = 'dashboardrecruiter';
            }
            if($user == 4){
                $ridirect = 'dashboardmanagement';
            }
            if($user == 5){
                $ridirect = 'requester';
            }

            return redirect()->route($ridirect)
                ->with('success', 'Kamu berhasil login')
                ->with('user', $user);
        } else {
            return redirect()->back()->withErrors(['email' => 'Email atau Password yang dimasukan salah!'])->withInput();
        }
    }

    public function Logout(Request $request)
    {
        session()->forget('user');
        Auth::logout();
        return redirect(to: '/')->with('success', 'Kamu berhasil logout');
    }
}
