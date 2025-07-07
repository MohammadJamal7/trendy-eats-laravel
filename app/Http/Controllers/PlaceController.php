<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::with(['country', 'category'])->latest()->paginate(10);
        
        // Add full image URL to each place
        $places->getCollection()->transform(function ($place) {
            if ($place->image) {
                $place->image_url = url('images/' . $place->image);
            }
            return $place;
        });
        
        return $places;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'country_id' => 'required|exists:countries,id',
            'category_id' => 'required|exists:categories,id',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();
        
        // Set category_name if category_id is provided
        if (isset($data['category_id'])) {
            $category = \App\Models\Category::find($data['category_id']);
            if ($category) {
                $data['category_name'] = $category->name;
            }
        }

        $place = Place::create($data);
        
        // Add full image URL to response
        if ($place->image) {
            $place->image_url = url('images/' . $place->image);
        }

        return response()->json($place, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        $place->load(['country', 'category']);
        
        // Add full image URL to response
        if ($place->image) {
            $place->image_url = url('images/' . $place->image);
        }
        
        return $place;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'address' => 'string|max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'country_id' => 'exists:countries,id',
            'category_id' => 'exists:categories,id',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $data = $request->all();
        
        // Set category_name if category_id is provided
        if (isset($data['category_id'])) {
            $category = \App\Models\Category::find($data['category_id']);
            if ($category) {
                $data['category_name'] = $category->name;
            }
        }

        $place->update($data);

        return response()->json($place);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return response()->json(null, 204);
    }
}
