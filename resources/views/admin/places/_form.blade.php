@csrf
@if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">There were some problems with your input.</span>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $place->name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
    </div>
    <div class="mb-4">
        <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
        <input type="text" name="address" id="address" value="{{ old('address', $place->address ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
    </div>
    {{-- Hidden latitude and longitude fields --}}
    <input type="hidden" name="latitude" value="0">
    <input type="hidden" name="longitude" value="0">
    <div class="mb-4">
        <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
        <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $place->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <label for="country_id" class="block text-gray-700 text-sm font-bold mb-2">Country:</label>
        <select name="country_id" id="country_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id', $place->country_id ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4 md:col-span-2">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
        <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>{{ old('description', $place->description ?? '') }}</textarea>
    </div>
    <div class="mb-4 md:col-span-2">
        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Place Image:</label>
        <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
        @if(isset($place) && $place->image)
            <img src="{{ url('images/' . $place->image) }}" alt="{{ $place->name }}" class="w-32 h-32 object-cover rounded mt-4">
        @endif
    </div>
</div>
<div class="flex items-center justify-between mt-6">
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        {{ $buttonText ?? 'Create' }}
    </button>
    <a href="{{ route('admin.places.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
        Cancel
    </a>
</div> 