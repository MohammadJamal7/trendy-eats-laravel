<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with(['country', 'category'])->latest()->paginate(10);
        return view('admin.places.index', compact('places'));
    }

    public function create()
    {
        $categories = Category::all();
        $countries = Country::all();
        return view('admin.places.create', compact('categories', 'countries'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('places', 'public');
            $data['image'] = $path;
        }

        // Set category_name if category_id is provided
        if (isset($data['category_id'])) {
            $category = Category::find($data['category_id']);
            if ($category) {
                $data['category_name'] = $category->name;
            }
        }

        Place::create($data);
        return redirect()->route('admin.places.index')->with('success', 'Place created successfully.');
    }

    public function edit(Place $place)
    {
        $categories = Category::all();
        $countries = Country::all();
        return view('admin.places.edit', compact('place', 'categories', 'countries'));
    }

    public function update(Request $request, Place $place)
    {
        $data = $this->validateRequest($request, $place);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($place->image) {
                Storage::disk('public')->delete($place->image);
            }
            $path = $request->file('image')->store('places', 'public');
            $data['image'] = $path;
        }

        // Set category_name if category_id is provided
        if (isset($data['category_id'])) {
            $category = Category::find($data['category_id']);
            if ($category) {
                $data['category_name'] = $category->name;
            }
        }

        $place->update($data);
        return redirect()->route('admin.places.index')->with('success', 'Place updated successfully.');
    }

    public function destroy(Place $place)
    {
        if ($place->image) {
            Storage::disk('public')->delete($place->image);
        }
        $place->delete();
        return redirect()->route('admin.places.index')->with('success', 'Place deleted successfully.');
    }
    
    protected function validateRequest(Request $request, Place $place = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'country_id' => 'required|exists:countries,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($place) {
            // Update
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } else {
            // Create
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        
        return $request->validate($rules);
    }
}
