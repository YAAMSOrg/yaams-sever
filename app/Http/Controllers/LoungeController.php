<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoungeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('lounge.index');
    }
}
