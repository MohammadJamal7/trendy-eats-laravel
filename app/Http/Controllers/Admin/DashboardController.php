<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $placeCount = Place::count();
        $categoryCount = Category::count();

        return view('admin.dashboard', compact('userCount', 'placeCount', 'categoryCount'));
    }
}
