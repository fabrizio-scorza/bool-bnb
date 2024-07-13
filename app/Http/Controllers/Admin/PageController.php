<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Message;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function plans(Request $request)
    {
        $plans = Plan::all();
        $logged_user_id = Auth::user()->id;
       
        $houses = House::where('user_id', $logged_user_id)->where(function ($query) {
            $query->whereHas('plans', function ($subQuery) {
                $subQuery->where('expires_at', '<', Carbon::now());
            })->orDoesntHave('plans');
        })->with('plans')->get();

        $house_id = $request->input('house_id');

        return view('admin.plans.index', compact('plans', 'houses', 'house_id'));
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
