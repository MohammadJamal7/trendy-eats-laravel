@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Total Users -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $userCount }}</p>
    </div>

    <!-- Total Places -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700">Total Places</h3>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $placeCount }}</p>
    </div>

    <!-- Total Categories -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700">Total Categories</h3>
        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $categoryCount }}</p>
    </div>
</div>
@endsection 