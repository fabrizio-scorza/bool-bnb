<?php

namespace App\Http\Controllers;


use App\Models\House;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class VueController extends Controller
{
    //
    public function homepage()
    {
        $logged_user_id = null;
        if (Auth::user() != null) {
            $logged_user_id = Auth::user()->id;
        }

        $houses = House::with('plans', 'services')->get();
        return view('homepage', compact('logged_user_id', 'houses'));
    }
    public function advancedSearch()
    {
        
        $logged_user_id = null;
        if (Auth::user() != null) {
            $logged_user_id = Auth::user()->id;
        }

        $houses = House::with('plans', 'services')->get();
        $services = Service::all();
        return view('advancedSearch', compact('logged_user_id', 'houses', 'services'));
    }

    public function sponsoredHouses(Request $request)
    {
        $houses = House::whereHas('plans', function ($query) {
            // $query->where('expires_at', '>=', now());
        })
            ->paginate(3);
        // ->paginate(9);

        return $houses;
    }

    public function publicHouseShow(House $house){

        $logged_user_id = null;
        if (Auth::user() != null) {
            $logged_user_id = Auth::user()->id;
        }
        

        return view('publicHouseShow', compact('logged_user_id', 'house'));
    }

    
}
