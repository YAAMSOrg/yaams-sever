<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AirlineMembership;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        return view('auth.login');
    }

    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!auth()->attempt($request->only('email', 'password'), $request->remember)) {
             return back()->with('status', 'Invalid login details');
        }

        // If the user is new and has no airlines yet, redirect him to the lobby.
        if(auth()->user()->airlines()->count() == 0) {
            return redirect()->route('userlounge');
        }

        // Set the first airline found for the user in the DB as the active airline.
        $firstAirlineFound = auth()->user()->airlines()->first();

        $request->session()->put('activeairline', $firstAirlineFound);

        return redirect()->route('dashboard');
    }
}
