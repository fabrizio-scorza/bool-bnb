<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\Category;
use App\Models\House;
use App\Models\Service;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('trash')) {
            $logged_user_id = Auth::user()->id;
            $houses = House::onlyTrashed()->where('user_id', $logged_user_id)->get();
        } else {
            $logged_user_id = Auth::user()->id;
            $houses = House::where('user_id', $logged_user_id)->get();
        }

        $trashed = House::onlyTrashed()->count();

        return view('admin.houses.index', compact('houses', 'trashed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $services = Service::all();
        $categories = Category::all();

        return view('admin.houses.create', compact('services', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHouseRequest $request)
    {
        //
        $form_data = $request->validated();
        $form_data['slug'] = House::getSlug($form_data['title']);
        $form_data['user_id'] = Auth::user()->id;

        //controllo se il file è stato inviato
        if ($request->hasFile('thumb')) {
            $image_path = Storage::disk('public')->put('thumb_images', $request->thumb);
            // dd($image_path);
            //andiamo a salvare la nostra thumb
            $form_data['thumb'] = $image_path;
        }


        // $form_data['latitude'] = 41.85698;
        // $form_data['longitude'] = 14.85698;

        if ($request->has('category')) {
            $form_data['category_id'] = $request->category;
        }

        // dd($form_data);

        $new_house = House::create($form_data);

        if ($request->has('services')) {
            $new_house->services()->attach($request->services);
        }



        return to_route('admin.houses.show', $new_house);
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        //
        if ($house->user_id !== Auth::id()) {
            return to_route('admin.houses.index');
        }

        return view('admin.houses.show', compact('house'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        //

        if ($house->user_id !== Auth::id()) {
            return to_route('admin.houses.index');
        }

        $house->load(['services']);
        $services = Service::all();
        $categories = Category::all();

        return view('admin.houses.edit', compact('house', 'services', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHouseRequest $request, House $house)
    {
        //


        $form_data = $request->validated();
        $form_data['slug'] = House::getSlug($form_data['title']);
        // $form_data['latitude'] = 41.85698;
        // $form_data['longitude'] = 14.85698;

        if ($request->has('category')) {
            $form_data['category_id'] = $request->category;
        }

        $house->update($form_data);

        if ($request->has('services')) {
            $house->services()->sync($request->services);
        } else {
            $house->services()->detach();
        }

        return to_route('admin.houses.show', $house);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        //
        $house->delete();

        return to_route('admin.houses.index');
    }

    public function restore($id)
    {

        $house = House::withTrashed()->find($id);

        if ($house->trashed()) {
            $house->restore();
        }

        return back();
    }

    // public function forceDestroy($id)
    // {
    //     // dd($id);
    //     $house = House::withTrashed()->find($id);
    //     if ($house->trashed()) {
    //         $house->forceDelete();
    //         return back();
    //     }
    // }

}
