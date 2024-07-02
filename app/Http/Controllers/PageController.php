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
        $messages = Message::where();
        return view('admin.messages.index', compact('messages'));
    }
}
