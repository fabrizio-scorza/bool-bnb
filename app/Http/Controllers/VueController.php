<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VueController extends Controller
{
    //
    public function homepage()
    {
        $logged_user_id = Auth::user()->id;
        $houses = House::with('plans')->get();
        return view('homepage', compact('logged_user_id', 'houses'));
    }
}
