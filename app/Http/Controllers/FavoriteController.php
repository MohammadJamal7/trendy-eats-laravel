<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Add a place to user's favorites
    public function store($placeId)
    {
        $user = Auth::user();
        $place = Place::findOrFail($placeId);
        $user->favoritePlaces()->syncWithoutDetaching([$place->id]);
        return response()->json(['message' => 'Place added to favorites.']);
    }

    // Remove a place from user's favorites
    public function destroy($placeId)
    {
        $user = Auth::user();
        $place = Place::findOrFail($placeId);
        $user->favoritePlaces()->detach($place->id);
        return response()->json(['message' => 'Place removed from favorites.']);
    }

    // List all favorite places for the authenticated user
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favoritePlaces()->with(['country', 'category'])->get();
        return response()->json($favorites);
    }
}
