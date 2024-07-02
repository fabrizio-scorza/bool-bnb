<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PageController extends Controller
{
    public function plans()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }
}
