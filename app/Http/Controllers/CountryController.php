<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Place;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::withCount('places')->get();
        
        // Transform the data to include places_count
        $countries->transform(function ($country) {
            return [
                'id' => $country->id,
                'name' => $country->name,
                'places_count' => $country->places_count,
                'created_at' => $country->created_at,
                'updated_at' => $country->updated_at,
            ];
        });
        
        return response()->json($countries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // You can add validation here if needed
        $country = Country::create($request->all());
        return response()->json($country, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $country = Country::findOrFail($id);
        return response()->json($country);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->all());
        return response()->json($country, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Country::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    /**
     * Get all places for a specific country.
     */
    public function places(int $countryId)
    {
        $country = Country::with('places')->findOrFail($countryId);
        return response()->json($country->places);
    }
}
