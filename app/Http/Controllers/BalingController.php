<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalingController extends Controller
{
    // Game Baling Craftverse (3D)
    public function index()
    {
        return view('peribahasa.baling');
    }
}
