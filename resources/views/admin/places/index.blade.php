@extends('admin.layouts.app')

@section('title', 'Manage Places')
@section('page-title', 'Places')

@section('content')
<div class="flex justify-end mb-4">
    <a href="{{ route('admin.places.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Place</a>
</div>
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Image</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Country</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($places as $place)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    @if($place->image)
                        <img src="{{ url('images/' . $place->image) }}" alt="{{ $place->name }}" class="w-16 h-16 object-cover rounded">
                    @else
                        <span class="text-gray-500">No Image</span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $place->name }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $place->category_name ?? 'N/A' }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $place->country->name ?? 'N/A' }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <a href="{{ route('admin.places.edit', $place) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <form action="{{ route('admin.places.destroy', $place) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Are you sure you want to delete this place?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
        {{ $places->links() }}
    </div>
</div>
@endsection 