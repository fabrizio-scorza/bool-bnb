<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function plans()
    {
        $plans = Plan::all();

        return view('admin.plans.index', compact('plans'));
    }

    public function messages()
    {
        $logged_user_id = Auth::user()->id;
        $houses = House::where('user_id', $logged_user_id)->get();
        $house_ids = $houses->pluck('id');
        $messages = Message::whereIn('house_id', $house_ids)->get();



        return view('admin.messages.index', compact('messages'));
    }
}
